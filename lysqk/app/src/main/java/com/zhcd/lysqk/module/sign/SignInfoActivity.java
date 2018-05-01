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

public class SignInfoActivity extends BaseActivity {
    private TextView tvSignInfo, tvUserName, tvSignTime, tvDescription;
    private ImageView ivQR, ivUserHeard;
    private ActionSignInfoEntity signInfoEntity;

    @Override
    protected int getLayoutResId() {
        return R.layout.activity_sign_info;
    }

    public static void start(Context context) {
        if (context != null) {
            Intent intent = new Intent(context, SignInfoActivity.class);
            context.startActivity(intent);
        }
    }

    @Override
    protected void initView() {
        super.initView();
        titleBarBuilder.setTitleText("活动名称");
        titleBarBuilder.setBackText("返回");
        tvSignInfo = (TextView) findViewById(R.id.tv_sign_info);
        ivQR = (ImageView) findViewById(R.id.iv_QR);
        ivUserHeard = (ImageView) findViewById(R.id.iv_user_heard);
        tvSignTime = (TextView) findViewById(R.id.tv_sign_time);
        tvUserName = (TextView) findViewById(R.id.tv_user_name);
        tvDescription = (TextView) findViewById(R.id.tv_description);
        findViewById(R.id.tv_all_sign_records).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                SignRecordActivity.start(SignInfoActivity.this);
            }
        });
        setData();
    }

    private void setData() {
        tvSignInfo.setText("第" + signInfoEntity.getSign_num() + "次签到   已签到人数：" + signInfoEntity.getSign_sum() + "人");
    }

    @Override
    protected void onDestroy() {
        RequestManager.cancelAll(SignInfoActivity.class.getSimpleName());
        super.onDestroy();
    }
}
