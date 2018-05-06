package com.zhcd.lysqk.module.sign;

import android.content.Context;
import android.content.Intent;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.sanjieke.datarequest.network.RequestManager;
import com.zhcd.lysqk.R;
import com.zhcd.lysqk.base.BaseActivity;
import com.zhcd.lysqk.module.sign.entity.ActionSignInfoEntity;
import com.zhcd.lysqk.net.ServiceProvider;
import com.zhcd.lysqk.tool.ImageLoaderUtils;

public class SignInfoActivity extends BaseActivity {

    private static final String SignInfoEntity = "signInfoEntity";
    private TextView signNumDec, signedNumDec, tvUserName, tvSignTime, tvDescription;
    private TextView takeSignStatus, allSignRecords;
    private ImageView ivQR, ivUserHeard;
    private ActionSignInfoEntity signInfoEntity;

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
        titleBarBuilder.setTitleText("活动名称");
        titleBarBuilder.setBackText("返回");
        signNumDec = (TextView) findViewById(R.id.tv_sign_num_dec);
        signedNumDec = (TextView) findViewById(R.id.tv_signed_num_dec);
        ivQR = (ImageView) findViewById(R.id.iv_QR);
        ivUserHeard = (ImageView) findViewById(R.id.iv_user_heard);
        tvSignTime = (TextView) findViewById(R.id.tv_sign_time);
        tvUserName = (TextView) findViewById(R.id.tv_user_name);
        tvDescription = (TextView) findViewById(R.id.tv_description);
        tvDescription = (TextView) findViewById(R.id.tv_take_sign_status);
        signInfoEntity = (ActionSignInfoEntity) getIntent().getSerializableExtra(SignInfoEntity);
        allSignRecords = (TextView) findViewById(R.id.tv_all_sign_records);
        takeSignStatus = (TextView) findViewById(R.id.tv_take_sign_status);
        allSignRecords.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                SignRecordActivity.start(SignInfoActivity.this);
            }
        });
        setData();
    }

    private void setData() {
        if (signInfoEntity != null) {
            String url = ServiceProvider.getImageBaseUrl() + signInfoEntity.getSign_qrcode_path();
            ImageLoaderUtils.displayImage(this, url, ivQR);
            signNumDec.setText("第" + signInfoEntity.getSign_num() + "次签到");
            signedNumDec.setText("已签到" + signInfoEntity.getSign_integral() + "人");
            if (signInfoEntity.getSign_status().equals("0")) {
                takeSignStatus.setText("开启");
                takeSignStatus.setVisibility(View.VISIBLE);
                allSignRecords.setBackgroundResource(R.mipmap.default_small_btn);
            } else if (signInfoEntity.getSign_status().equals("1")) {
                takeSignStatus.setText("结束");
                takeSignStatus.setVisibility(View.VISIBLE);
                allSignRecords.setBackgroundResource(R.mipmap.default_small_btn);
            } else {
                takeSignStatus.setVisibility(View.GONE);
                allSignRecords.setBackgroundResource(R.mipmap.default_btn);
            }
        }
    }

    @Override
    protected void onDestroy() {
        RequestManager.cancelAll(SignInfoActivity.class.getSimpleName());
        super.onDestroy();
    }
}
