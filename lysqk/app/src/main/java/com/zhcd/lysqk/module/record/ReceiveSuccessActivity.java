package com.zhcd.lysqk.module.record;

import android.content.Context;
import android.content.Intent;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;

import com.zhcd.lysqk.R;
import com.zhcd.lysqk.base.BaseActivity;
import com.zhcd.utils.T;


public class ReceiveSuccessActivity extends BaseActivity {

    private TextView tvUserName, tvSuccessTime, tvPointInfo;
    private EditText etInputPoints;

    @Override
    protected int getLayoutResId() {
        return R.layout.activity_record_receive_success;
    }

    public static void start(Context context) {
        if (context != null) {
            Intent intent = new Intent(context, ReceiveSuccessActivity.class);
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
        etInputPoints = (EditText) findViewById(R.id.et_input_points);
        titleBarBuilder.setBackIconClickEvent(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });

    }
}
