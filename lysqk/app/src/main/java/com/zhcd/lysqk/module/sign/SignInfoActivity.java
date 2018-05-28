package com.zhcd.lysqk.module.sign;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.text.TextUtils;
import android.view.View;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.pda.hf.HFReader;
import com.pda.hf.ISO15693CardInfo;
import com.pda.hf.demo.Tools;
import com.sanjieke.datarequest.network.RequestManager;
import com.sanjieke.datarequest.neworkWrapper.BaseData;
import com.sanjieke.datarequest.neworkWrapper.IDataResponse;
import com.zhcd.lysqk.R;
import com.zhcd.lysqk.base.BaseActivity;
import com.zhcd.lysqk.module.sign.entity.ActionSignInfoEntity;
import com.zhcd.lysqk.module.sign.entity.NewestSignUserInfoEntity;
import com.zhcd.lysqk.module.sign.entity.UserSignEntity;
import com.zhcd.lysqk.net.ServiceProvider;
import com.zhcd.lysqk.tool.HFRFIDTool;
import com.zhcd.lysqk.tool.ImageLoaderUtils;
import com.zhcd.lysqk.tool.ImagePathUtil;
import com.zhcd.utils.T;
import com.zhcd.utils.TimeUtils;

import java.util.List;

public class SignInfoActivity extends BaseActivity {

    private static final String SignInfoEntity = "signInfoEntity";
    private TextView signNumDec, signedNumDec, tvUserName, tvSignTime, tvDescription;
    private TextView takeSignStatus, allSignRecords;
    private ImageView ivQR, ivUserHeard;
    private RelativeLayout userSignInfo;
    private ActionSignInfoEntity signInfoEntity;
    private boolean signFlag;
    private SignThread signThread;
    private HFReader hfReader;
    private boolean running = false;
    private Thread hfThread;
    private String icCardNum = "";

    @Override
    protected int getLayoutResId() {
        return R.layout.activity_sign_info;
    }

    public static void start(Context context, ActionSignInfoEntity signInfoEntity) {
        if (context != null) {
            Intent intent = new Intent(context, SignInfoActivity.class);
            intent.putExtra(SignInfoEntity, signInfoEntity);
            context.startActivity(intent);
        }
    }

    @Override
    protected void initView() {
        super.initView();
        titleBarBuilder.setTitleText("活动签到");
        titleBarBuilder.setBackText("返回");
        signNumDec = (TextView) findViewById(R.id.tv_sign_num_dec);
        signedNumDec = (TextView) findViewById(R.id.tv_signed_num_dec);
        ivQR = (ImageView) findViewById(R.id.iv_QR);
        ivUserHeard = (ImageView) findViewById(R.id.iv_user_heard);
        tvSignTime = (TextView) findViewById(R.id.tv_sign_time);
        tvUserName = (TextView) findViewById(R.id.tv_user_name);
        tvDescription = (TextView) findViewById(R.id.tv_description);
        signInfoEntity = (ActionSignInfoEntity) getIntent().getSerializableExtra(SignInfoEntity);
        allSignRecords = (TextView) findViewById(R.id.tv_all_sign_records);
        takeSignStatus = (TextView) findViewById(R.id.tv_take_sign_status);
        userSignInfo = (RelativeLayout) findViewById(R.id.rl_user_sign_info);
        allSignRecords.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (signInfoEntity != null)
                    SignRecordActivity.start(SignInfoActivity.this, signInfoEntity.getId());
            }
        });
        takeSignStatus.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (signInfoEntity != null && !signInfoEntity.getSign_status().equals("2")) {
                    setSignStatus(signInfoEntity.getId(), signInfoEntity.getSign_status());
                }
            }
        });
        setData();
    }

    private void setData() {
        if (signInfoEntity != null) {
            String url = ImagePathUtil.imageReallyUrl(signInfoEntity.getSign_qrcode_path());
            ImageLoaderUtils.displayImage(this, url, ivQR);
            signNumDec.setText("第" + signInfoEntity.getSign_num() + "次签到");
            signedNumDec.setText("已签到" + signInfoEntity.getSigned_num() + "人");
            if (signInfoEntity.getSign_status().equals("0")) {
                userSignInfo.setVisibility(View.GONE);
                takeSignStatus.setText("开启");
                takeSignStatus.setVisibility(View.VISIBLE);
                allSignRecords.setBackgroundResource(R.mipmap.default_small_btn);
            } else if (signInfoEntity.getSign_status().equals("1")) {
                takeSignStatus.setText("结束");
                takeSignStatus.setVisibility(View.VISIBLE);
                allSignRecords.setBackgroundResource(R.mipmap.default_small_btn);
            } else {
                userSignInfo.setVisibility(View.GONE);
                takeSignStatus.setVisibility(View.GONE);
                allSignRecords.setBackgroundResource(R.mipmap.default_btn);
            }
            if (isStartThread()) {
                initThread();
            }
        }
    }

    private void setSignStatus(String sign_id, final String status) {
        try {
            int signStatus = Integer.parseInt(status) + 1;
            if (signStatus > 2)
                signStatus = 2;
            showProgressDialog();
            ServiceProvider.setSignStatus(sign_id, String.valueOf(signStatus), new IDataResponse() {
                @Override
                public void onResponse(BaseData obj) {
                    hideProgressDialog();
                    if (ServiceProvider.errorFilter(obj)) {
                        if (status.equals("0")) {
                            signInfoEntity.setSign_status("1");
                            setData();
                        } else if (status.equals("1")) {
                            signInfoEntity.setSign_status("2");
                            finish();
                        }
                    } else {
                        if (obj != null)
                            T.showShort(obj.getMsg());
                    }
                }
            }, SignInfoActivity.class.getSimpleName());
        } catch (NumberFormatException e) {
            e.printStackTrace();
        }
    }

    @Override
    public void onResume() {
        super.onResume();
    }

    private void initThread() {
        signFlag = true;
        running = true;
        hfReader = HFRFIDTool.getHfReader();
        hfThread = new Thread(readTask);
        signThread = new SignThread();
        signThread.start();
        hfThread.start();
    }

    private class SignThread extends Thread {
        @Override
        public void run() {
            super.run();
            try {
                while (signFlag) {
                    if (signInfoEntity != null) {
                        getNewUserSignPos(signInfoEntity.getActivity_id(),
                                signInfoEntity.getId());
                        Thread.sleep(7000);
                    } else {
                        signFlag = false;
                    }
                }
            } catch (InterruptedException e) {
                e.printStackTrace();
            }
        }
    }

    //read thread
    private Runnable readTask = new Runnable() {
        byte[] uid14443 = null;
        List<ISO15693CardInfo> listCard15693 = null;
        byte[] uid15693 = null;

        @Override
        public void run() {
            while (running) {
                if (hfReader != null) {
                    //14443A
                    uid14443 = hfReader.search14443Acard();
                    if (uid14443 != null) {
                        sendMSG(Tools.Bytes2HexString(uid14443, uid14443.length), "14443A", MSG_CARD);
                    } else {
                        //15693
                        listCard15693 = hfReader.search15693Card();
                        if (listCard15693 != null && !listCard15693.isEmpty()) {
                            for (ISO15693CardInfo card : listCard15693) {
                                uid15693 = card.getUid();
                                sendMSG(Tools.Bytes2HexString(uid15693, uid15693.length), "15693", MSG_CARD);
                            }
                        }
                    }
                }
                try {
                    Thread.sleep(4000);
                } catch (Exception e) {
                }
            }
        }
    };

    private final int MSG_CARD = 1102;
    private Handler handler = new Handler() {
        @Override
        public void handleMessage(Message msg) {
            super.handleMessage(msg);
            switch (msg.what) {
                case MSG_CARD:
                    String uid = msg.getData().getString("uid");
                    if (!TextUtils.isEmpty(uid)) {
                        String decimalUid = HFRFIDTool.changeToDecimal(uid);
                        if (!TextUtils.isEmpty(decimalUid) && signInfoEntity != null) {
                            HFRFIDTool.playAudio(SignInfoActivity.this);
                            setUserSigninPos(signInfoEntity.getActivity_id(),
                                    signInfoEntity.getId(), decimalUid);
                        }
                    }
                    break;
            }
        }
    };

    //send the result to handler
    private void sendMSG(String cardUid, String cardType, int msgCode) {
        Bundle bundle = new Bundle();
        bundle.putString("uid", cardUid);
        Message msg = new Message();
        msg.setData(bundle);
        msg.what = msgCode;
        handler.sendMessage(msg);
    }

    @Override
    public void onStop() {
        super.onStop();
        signFlag = false;
        if (signThread != null)
            signThread.interrupt();
    }

    private void getNewUserSignPos(String activity_id, String sign_id) {
        if (TextUtils.isEmpty(activity_id) || TextUtils.isEmpty(sign_id)) {
            signFlag = false;
            return;
        }
        ServiceProvider.getNewUserSigninPos(activity_id, sign_id, new IDataResponse() {
            @Override
            public void onResponse(BaseData obj) {
                hideProgressDialog();
                if (ServiceProvider.errorFilter(obj)) {
                    List<NewestSignUserInfoEntity> infoList = (List<NewestSignUserInfoEntity>) obj.getData();
                    if (infoList != null && infoList.size() > 0) {
                        if (userSignInfo != null && userSignInfo.getVisibility() == View.GONE)
                            userSignInfo.setVisibility(View.VISIBLE);
                        NewestSignUserInfoEntity entity = infoList.get(0);
                        tvUserName.setText(entity.getRealname());
                        tvSignTime.setText("时间：" + TimeUtils.getDateYMDHM(entity.getAdd_time()));
                        tvDescription.setText("使用" + (entity.getSign_type().equals("0") ? "二维码" : "社区卡") + "签到成功");
                        signedNumDec.setText("已签到" + entity.getCount() + "人");
                        String url = ImagePathUtil.imageReallyUrl(entity.getTx_path());
                        ImageLoaderUtils.displayImage(SignInfoActivity.this, url, ivUserHeard);
                    }
                }
            }
        }, SignInfoActivity.class.getSimpleName());
    }

    private void setUserSigninPos(String activity_id, String sign_id, final String iccard_num) {
        if (TextUtils.isEmpty(activity_id) || TextUtils.isEmpty(sign_id) || TextUtils.isEmpty(iccard_num))
            return;
        if (!icCardNum.equals(iccard_num)) {
            ServiceProvider.setUserSigninPos(activity_id, sign_id, iccard_num, new IDataResponse() {
                @Override
                public void onResponse(BaseData obj) {
                    icCardNum = iccard_num;
                    if (ServiceProvider.errorFilter(obj)) {
                        UserSignEntity entity = (UserSignEntity) obj.getData();
                        if (entity != null) {
                            if (userSignInfo != null && userSignInfo.getVisibility() == View.GONE)
                                userSignInfo.setVisibility(View.VISIBLE);
                            tvUserName.setText(entity.getRealname());
                            tvSignTime.setText("时间：" + TimeUtils.getDateYMDHM(entity.getAdd_time()));
                            tvDescription.setText("使用" + (entity.getSign_type().equals("0") ? "二维码" : "社区卡") + "签到成功");
                            signedNumDec.setText("已签到" + entity.getCount() + "人");
                            String url = ImagePathUtil.imageReallyUrl(entity.getTx_path());
                            ImageLoaderUtils.displayImage(SignInfoActivity.this, url, ivUserHeard);
                        }
                        T.showShort(obj.getMsg());
                    } else if (obj != null) {
                        T.showShort(obj.getMsg());
                    }
                }
            }, SignInfoActivity.class.getSimpleName());
        }
    }

    private boolean isStartThread() {
        if (signInfoEntity != null && signInfoEntity.getSign_status().equals("1")) {
            return true;
        }
        return false;
    }

    @Override
    protected void onDestroy() {
        signFlag = false;
        running = false;
        if (signThread != null) {
            signThread = null;
        }
        if (hfThread != null) {
            hfThread.interrupt();
            hfThread = null;
            readTask = null;
        }
        RequestManager.cancelAll(SignInfoActivity.class.getSimpleName());
        super.onDestroy();
    }
}
