package com.zhcd.lysqk.module.action;

import android.content.Context;
import android.content.Intent;

import com.zhcd.lysqk.R;
import com.zhcd.lysqk.base.BaseActivity;

public class ActionDetailActivity extends BaseActivity {
    @Override
    protected int getLayoutResId() {
        return R.layout.activity_action_detail;
    }

    public static void start(Context context) {
        if (context != null) {
            Intent intent = new Intent(context, ActionDetailActivity.class);
            context.startActivity(intent);
        }
    }
}
