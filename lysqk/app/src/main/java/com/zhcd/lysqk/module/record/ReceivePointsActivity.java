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


public class ReceivePointsActivity extends BaseActivity {
    private static final String CardId = "cardId";
    private String cardId;

    private ImageView ivUserHeard;
    private TextView tvUserName, tvReceiveTime, tvDescription;
    private EditText etInputPoints;

    @Override
    protected int getLayoutResId() {
        return R.layout.activity_record_receive_points;
    }

    public static void start(Context context, String cardId) {
        if (context != null) {
            Intent intent = new Intent(context, ReceivePointsActivity.class);
            intent.putExtra(CardId, cardId);
            context.startActivity(intent);
        }
    }

    @Override
    protected void initView() {
        super.initView();
        titleBarBuilder.setTitleText("社区卡收取积分");
        titleBarBuilder.setBackText("    ");
        cardId = getIntent().getStringExtra(CardId);
        ivUserHeard = (ImageView) findViewById(R.id.iv_user_heard);
        tvUserName = (TextView) findViewById(R.id.tv_user_name);
        tvReceiveTime = (TextView) findViewById(R.id.tv_receive_time);
        tvDescription = (TextView) findViewById(R.id.tv_description);
        etInputPoints = (EditText) findViewById(R.id.et_input_points);
        tvUserName.setText(cardId);
        findViewById(R.id.tv_confirm_receive).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                T.showShort("社区卡收取积分成功" + etInputPoints.getText().toString().trim());
                ReceiveSuccessActivity.start(ReceivePointsActivity.this);
                finish();
            }
        });
    }
}
