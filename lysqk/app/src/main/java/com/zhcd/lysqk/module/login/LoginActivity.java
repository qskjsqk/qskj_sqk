package com.zhcd.lysqk.module.login;


import android.content.Context;
import android.content.Intent;
import android.text.Editable;
import android.text.TextUtils;
import android.view.View;

import com.sanjieke.datarequest.network.RequestManager;
import com.sanjieke.datarequest.neworkWrapper.BaseData;
import com.sanjieke.datarequest.neworkWrapper.IDataResponse;
import com.zhcd.lysqk.manager.LoginInfoManager;
import com.zhcd.lysqk.module.home.HomeActivity;
import com.zhcd.lysqk.R;
import com.zhcd.lysqk.base.BaseActivity;
import com.zhcd.lysqk.module.login.entity.LoginEntity;
import com.zhcd.lysqk.net.ServiceProvider;
import com.zhcd.lysqk.tool.HFRFIDTool;
import com.zhcd.lysqk.view.CustomizeKeyboard;
import com.zhcd.lysqk.view.PasswordInputView;
import com.zhcd.utils.T;


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
                if (checkPreCondition()) {
                    String input = inputPwd.getTextString();
//                    checkLoginPos(input);
                    String  uid ="00e9b583";
//                    uid="30e9b583";
                    String decimalUid = HFRFIDTool.changeToDecimal(uid);
                }
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

    private void checkLoginPos(String token_num) {
        if (TextUtils.isEmpty(token_num))
            return;
        showProgressDialog();
        ServiceProvider.checkLoginPos(token_num, new IDataResponse() {
            @Override
            public void onResponse(BaseData obj) {
                hideProgressDialog();
                if (ServiceProvider.errorFilter(obj)) {
                    LoginEntity entity = (LoginEntity) obj.getData();
                    if (entity != null) {
                        LoginInfoManager.getInstance().loginSuccess(entity);
                        HomeActivity.start(LoginActivity.this, HomeActivity.ACTION_TAB);
                        finish();
                    }
                } else {
                    if (obj != null)
                        T.showShort(obj.getMsg());
                }
            }
        }, LoginActivity.class.getSimpleName());
    }


    private boolean checkPreCondition() {
        String input = inputPwd.getTextString();
        if (input.length() < 6) {
            T.showShort("请输入正确的登录");
            return false;
        }
        return true;
    }

    @Override
    protected void onDestroy() {
        RequestManager.cancelAll(LoginActivity.class.getSimpleName());
        super.onDestroy();
    }
}
