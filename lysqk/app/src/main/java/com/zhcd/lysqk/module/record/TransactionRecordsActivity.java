package com.zhcd.lysqk.module.record;

import android.content.Context;
import android.content.Intent;

import com.zhcd.lysqk.R;
import com.zhcd.lysqk.base.BaseActivity;


public class TransactionRecordsActivity extends BaseActivity {
    @Override
    protected int getLayoutResId() {
        return R.layout.activity_transaction_records;
    }

    public static void start(Context context) {
        if (context != null) {
            Intent intent = new Intent(context, TransactionRecordsActivity.class);
            context.startActivity(intent);
        }
    }

    @Override
    protected void initView() {
        super.initView();
        titleBarBuilder.setTitleText("兑换记录");
        titleBarBuilder.setBackText("返回");
    }
}
