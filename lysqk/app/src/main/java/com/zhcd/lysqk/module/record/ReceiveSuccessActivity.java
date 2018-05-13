package com.zhcd.lysqk.module.record;

import android.content.Context;
import android.content.Intent;
import android.view.View;
import android.widget.TextView;

import com.zhcd.lysqk.R;
import com.zhcd.lysqk.base.BaseActivity;
import com.zhcd.lysqk.module.record.entity.ReceivePointsEntity;

public class ReceiveSuccessActivity extends BaseActivity {
    private static final String ReceivePointsEntity = "receivePointsEntity";
    private TextView tvUserName, tvSuccessTime, tvPointInfo;


    @Override
    protected int getLayoutResId() {
        return R.layout.activity_record_receive_success;
    }

    public static void start(Context context, ReceivePointsEntity entity) {
        if (context != null) {
            Intent intent = new Intent(context, ReceiveSuccessActivity.class);
            intent.putExtra(ReceivePointsEntity, entity);
            context.startActivity(intent);
        }
    }

    @Override
    protected void initView() {
        super.initView();
        titleBarBuilder.setTitleText("社区卡收取积分");
        titleBarBuilder.setBackText("    ");
        tvUserName = (TextView) findViewById(R.id.tv_user_name);
        tvSuccessTime = (TextView) findViewById(R.id.tv_success_time);
        tvPointInfo = (TextView) findViewById(R.id.tv_point_info);
        titleBarBuilder.setBackIconClickEvent(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
        Intent intent = getIntent();
        if (intent.hasExtra(ReceivePointsEntity)) {
            ReceivePointsEntity entity = (ReceivePointsEntity) intent.getSerializableExtra(ReceivePointsEntity);
            if (entity != null) {
                tvPointInfo.setText(entity.getTrading_integral() + "积分收取成功");
                tvUserName.setText(entity.getUser());
                tvSuccessTime.setText(entity.getTrading_time());
            }
        }
    }
}