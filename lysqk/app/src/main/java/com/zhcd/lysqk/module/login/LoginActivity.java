package com.zhcd.lysqk.module.login;


import android.content.Context;
import android.content.Intent;
import android.text.Editable;
import android.view.View;

import com.zhcd.lysqk.module.home.HomeActivity;
import com.zhcd.lysqk.R;
import com.zhcd.lysqk.base.BaseActivity;
import com.zhcd.lysqk.view.CustomizeKeyboard;
import com.zhcd.lysqk.view.PasswordInputView;


public class LoginActivity extends BaseActivity {

    private CustomizeKeyboard viewKeyboard;
    private PasswordInputView inputPwd;

    @Override
    protected int getLayoutResId() {
        return R.layout.activity_login;
    }

    public static void start(Context context) {
        if (context != null) {
            Intent intent = new Intent(context, LoginActivity.class);
            context.startActivity(intent);
        }
    }

    @Override
    protected void initView() {
        viewKeyboard = (CustomizeKeyboard) findViewById(R.id.view_keyboard);
        inputPwd = (PasswordInputView) findViewById(R.id.input_pwd);
        initListener();
    }

    private void initListener() {
        viewKeyboard.setOnClickKeyboardListener(new CustomizeKeyboard.OnClickKeyboardListener() {
            @Override
            public void onKeyClick(int position, String value) {
                if (position < 11 && position != 9) {
                    inputPwd.add(value);
                } else if (position == 11) {
                    inputPwd.remove();
                }
            }
        });
        inputPwd.setPWClickListener(new PasswordInputView.IPWClickListener() {
            @Override
            public void onViewClick(View v) {
                if (viewKeyboard.getVisibility() == View.INVISIBLE) {
                    viewKeyboard.setVisibility(View.VISIBLE);
                } else {
                    viewKeyboard.setVisibility(View.INVISIBLE);
                }
            }

            @Override
            public void afterTextChanged(Editable s) {
            }
        });
        findViewById(R.id.iv_login).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
//                if (checkPreCondition()) {
                HomeActivity.start(LoginActivity.this, HomeActivity.ACTION_TAB);
                finish();
//                }
            }
        });
        findViewById(R.id.ll_root).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (viewKeyboard != null && viewKeyboard.getVisibility() == View.VISIBLE) {
                    viewKeyboard.setVisibility(View.INVISIBLE);
                }
            }
        });

    }

    private boolean checkPreCondition() {
        String input = inputPwd.getTextString();
        if (input.length() < 6) {
            return false;
        }
        return true;
    }
}
