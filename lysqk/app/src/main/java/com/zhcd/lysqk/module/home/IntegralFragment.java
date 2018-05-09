package com.zhcd.lysqk.module.home;

import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.text.TextUtils;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.pda.hf.HFReader;
import com.pda.hf.ISO15693CardInfo;
import com.pda.hf.demo.Tools;
import com.zhcd.lysqk.R;
import com.zhcd.lysqk.base.BaseFragment;
import com.zhcd.lysqk.module.record.ReceivePointsActivity;
import com.zhcd.lysqk.module.record.TransactionRecordsActivity;
import com.zhcd.lysqk.tool.HFRFIDTool;
import com.zhcd.lysqk.tool.ImageLoaderUtils;

import java.util.List;


public class IntegralFragment extends BaseFragment {
    private ImageView ivQR;
    private TextView allRecords;
    private HFReader hfReader;
    boolean running = false;
    private Thread hfThread;

    @Override
    protected int getLayoutResId() {
        return R.layout.fragment_integral;
    }

    @Override
    protected void beforeViewBind() {

    }

    @Override
    protected void initView() {
        if (rootView != null) {
            ivQR = (ImageView) rootView.findViewById(R.id.iv_QR);
            allRecords = (TextView) rootView.findViewById(R.id.tv_all_transaction_records);
            allRecords.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    TransactionRecordsActivity.start(getActivity());
                }
            });
            setQR("https://www.tmall.com/?ali_trackid=2:mm_26632322_6858406_70736499:1524820216_243_614827073");
            hfReader = HFRFIDTool.getHfReader();
            hfThread = new Thread(readTask);
        }
    }

    private void setQR(String url) {
        if (!TextUtils.isEmpty(url) && ivQR != null) {
            ImageLoaderUtils.displayImage(getActivity(), url, ivQR);
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
                    Thread.sleep(6000);
                } catch (Exception e) {

                }
            }
        }
    };
    private final int MSG_CARD = 1101;

    //send the result to handler
    private void sendMSG(String cardUid, String cardType, int msgCode) {
        Bundle bundle = new Bundle();
        bundle.putString("uid", cardUid);
        Message msg = new Message();
        msg.setData(bundle);
        msg.what = msgCode;
        handler.sendMessage(msg);
    }

    private Handler handler = new Handler() {
        @Override
        public void handleMessage(Message msg) {
            super.handleMessage(msg);
            switch (msg.what) {
                case MSG_CARD:
                    String uid = msg.getData().getString("uid");
                    if (!TextUtils.isEmpty(uid)) {
                        int decimalUid = HFRFIDTool.changeToDecimal(uid);
                        if (decimalUid > 0) {
                            ReceivePointsActivity.start(getActivity(), String.valueOf(decimalUid));
                        }
                    }
                    break;
            }
        }
    };

    @Override
    public void onResume() {
        super.onResume();
        if (!running)
            running = true;
        if (hfThread == null)
            hfThread = new Thread(readTask);
        hfThread.start();
    }

    @Override
    public void onStop() {
        super.onStop();
        running = false;
        if (hfThread != null)
            hfThread.interrupt();
    }

    @Override
    protected void initData(Bundle savedInstanceState) {

    }

    @Override
    protected void initListener() {

    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        if (hfThread != null) {
            hfThread.interrupt();
            hfThread = null;
            readTask = null;
        }
    }
}
