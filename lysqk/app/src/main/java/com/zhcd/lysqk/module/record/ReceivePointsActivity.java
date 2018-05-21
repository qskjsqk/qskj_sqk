package com.zhcd.lysqk.module.record;

import android.content.Context;
import android.content.Intent;
import android.text.TextUtils;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;

import com.sanjieke.datarequest.neworkWrapper.BaseData;
import com.sanjieke.datarequest.neworkWrapper.IDataResponse;
import com.zhcd.lysqk.R;
import com.zhcd.lysqk.base.BaseActivity;
import com.zhcd.lysqk.module.record.entity.ReceiveIntegralEntity;
import com.zhcd.lysqk.module.record.entity.ReceivePointsEntity;
import com.zhcd.lysqk.net.ServiceProvider;
import com.zhcd.utils.T;


public class ReceivePointsActivity extends BaseActivity {
    private static final String CardId = "cardId";
    private String cardId;

    private TextView tvUserName, tvDescription;
    private EditText etInputPoints;
    private ReceiveIntegralEntity pointsEntity;
    private int inputPoints;

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
        tvUserName = (TextView) findViewById(R.id.tv_user_name);
        tvDescription = (TextView) findViewById(R.id.tv_description);
        etInputPoints = (EditText) findViewById(R.id.et_input_points);
        loadCollectionIntegral(cardId);

        findViewById(R.id.tv_confirm_receive).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (checkPreCondition()) {
                    collectionIntegral(cardId, inputPoints);
                }
            }
        });
    }

    private void loadCollectionIntegral(String cardNum) {
        if (TextUtils.isEmpty(cardNum))
            return;
        showProgressDialog();
        ServiceProvider.loadCollectionIntegral(cardNum, new IDataResponse() {
            @Override
            public void onResponse(BaseData obj) {
                hideProgressDialog();
                if (ServiceProvider.errorFilter(obj)) {
                    pointsEntity = (ReceiveIntegralEntity) obj.getData();
                    setViewData();
                } else if (obj != null) {
                    T.showShort(obj.getMsg());
                }

            }
        }, ReceivePointsActivity.class.getSimpleName());
    }

    private void setViewData() {
        if (pointsEntity != null) {
            tvUserName.setText("用户名：" + pointsEntity.getUser());
            tvDescription.setText("剩余积分：" + pointsEntity.getIntegral_num());
        }
    }

    private boolean checkPreCondition() {
        String input = etInputPoints.getText().toString();
        try {
            inputPoints = Integer.parseInt(input);
            int integralNum = 0;
            if (pointsEntity != null)
                integralNum = Integer.parseInt(pointsEntity.getIntegral_num());
            if (inputPoints > integralNum) {
                T.showShort("扣除积分不能大于剩余积分");
                return false;
            }
        } catch (NumberFormatException e) {
            T.showShort("请输入正确的积分值");
            return false;
        }
        return true;
    }

    private void collectionIntegral(String cardNum, int trading_integral) {
        if (TextUtils.isEmpty(cardNum) || trading_integral <= 0)
            return;
        showProgressDialog();
        ServiceProvider.collectionIntegral(cardNum, trading_integral, new IDataResponse() {
            @Override
            public void onResponse(BaseData obj) {
                hideProgressDialog();
                if (ServiceProvider.errorFilter(obj)) {
                    ReceivePointsEntity entity = (ReceivePointsEntity) obj.getData();
                    if (entity != null) {
                        ReceiveSuccessActivity.start(ReceivePointsActivity.this, entity);
                        finish();
                    }
                } else if (obj != null) {
                    T.showShort(obj.getMsg());
                }

            }
        }, ReceivePointsActivity.class.getSimpleName());
    }
}
