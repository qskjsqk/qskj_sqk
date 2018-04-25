package com.zhcd.lysqk.view;

import android.content.Context;
import android.support.annotation.Nullable;
import android.text.Editable;
import android.text.TextUtils;
import android.text.TextWatcher;
import android.util.AttributeSet;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.inputmethod.InputMethodManager;
import android.widget.EditText;
import android.widget.LinearLayout;

import com.zhcd.lysqk.R;

public class LoginVerifyView extends LinearLayout {
    private SixPwdListener listener;
    private EditText et1, et2, et3, et4, et5, et6;
    private String s_e1, s_e2, s_e3, s_e4, s_e5, s_e6;
    private onKeyListeners onKeyListener;

    public LoginVerifyView(Context context) {
        this(context, null);
    }

    public LoginVerifyView(Context context, @Nullable AttributeSet attrs) {
        this(context, attrs, 0);
    }

    public LoginVerifyView(Context context, @Nullable AttributeSet attrs, int defStyleAttr) {
        super(context, attrs, defStyleAttr);
        initView(context);
    }


    public void clear_edit() {
        et1.setText("");
        et2.setText("");
        et3.setText("");
        et4.setText("");
        et5.setText("");
        et6.setText("");
    }

    /**
     * 取消e6的焦点
     */
    public void clearLastFouse() {
        et6.setFocusable(false);
        et6.setFocusableInTouchMode(false);
        et6.clearFocus();
    }


    public void getLastFouse() {
        et6.setFocusable(true);
        et6.setFocusableInTouchMode(true);
        et6.requestFocus();
        et6.findFocus();
    }


    //初始化view
    private void initView(Context context) {
        LayoutInflater inflater = LayoutInflater.from(context);
        View view = inflater.inflate(R.layout.view_login_verify_view, this);
        et1 = (EditText) view.findViewById(R.id.et1);
        et2 = (EditText) view.findViewById(R.id.et2);
        et3 = (EditText) view.findViewById(R.id.et3);
        et4 = (EditText) view.findViewById(R.id.et4);
        et5 = (EditText) view.findViewById(R.id.et5);
        et6 = (EditText) view.findViewById(R.id.et6);
        onKeyListener = new onKeyListeners();
        et1.setOnKeyListener(onKeyListener);
        et2.setOnKeyListener(onKeyListener);
        et3.setOnKeyListener(onKeyListener);
        et4.setOnKeyListener(onKeyListener);
        et5.setOnKeyListener(onKeyListener);
        et6.setOnKeyListener(onKeyListener);


        et1.setCursorVisible(false);
        et2.setCursorVisible(false);
        et3.setCursorVisible(false);
        et4.setCursorVisible(false);
        et5.setCursorVisible(false);
        et6.setCursorVisible(false);
        clear_focuse();
        setAddTextChangedListener();
    }


    private void setAddTextChangedListener() {
        et1.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {
            }


            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
            }


            @Override
            public void afterTextChanged(Editable s) {
                if (et1.getText().toString().equals("")) {
                } else {
                    s_e1 = et1.getText().toString();
                    e2_focuse();
                }
            }
        });


        et2.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {
            }


            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
            }


            @Override
            public void afterTextChanged(Editable s) {
                if (et2.getText().toString().equals("")) {
                } else {
                    s_e2 = et2.getText().toString();
                    e3_focuse();
                }
            }
        });


        et3.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {
            }


            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
            }


            @Override
            public void afterTextChanged(Editable s) {
                if (et3.getText().toString().equals("")) {
                } else {
                    s_e3 = et3.getText().toString();
                    e4_focuse();
                }
            }
        });


        et4.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {
            }


            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
            }


            @Override
            public void afterTextChanged(Editable s) {
                if (et4.getText().toString().equals("")) {
                } else {
                    s_e4 = et4.getText().toString();
                    e5_focuse();
                }
            }
        });


        et5.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {
            }


            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
            }


            @Override
            public void afterTextChanged(Editable s) {
                if (et5.getText().toString().equals("")) {
                } else {
                    s_e5 = et5.getText().toString();
                    last_focuse();
                }
            }
        });


        et6.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {
            }


            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
            }


            @Override
            public void afterTextChanged(Editable s) {
                if (et6.getText().toString().equals("")) {
                } else {
                    et6.setFocusable(false);
                    s_e6 = et6.getText().toString();
                    isFirstAllWrite();
                }
            }
        });
    }

    public void setLastFocuse() {
        et6.setFocusable(true);
        et6.setFocusableInTouchMode(true);
        et6.requestFocus();
        et6.findFocus();
    }


    public void getLockTime() {
        et1.setFocusable(false);
        et2.setFocusable(false);
        et3.setFocusable(false);
        et4.setFocusable(false);
        et5.setFocusable(false);
        et6.setFocusable(false);
    }


    String eString = "";

    private void isFirstAllWrite() {
        if (!TextUtils.isEmpty(s_e1) && !TextUtils.isEmpty(s_e2) && !TextUtils.isEmpty(s_e3) && !TextUtils.isEmpty(s_e4)
                && !TextUtils.isEmpty(s_e5) && !TextUtils.isEmpty(s_e6)) {
            eString = s_e1 + s_e2 + s_e3 + s_e4 + s_e5 + s_e6;
            if (listener != null) {
                listener.onInputComplete(eString);
            }
        }
    }

    /**
     * 点击删除按钮监听
     *
     * @author
     */
    class onKeyListeners implements android.view.View.OnKeyListener {


        @Override
        public boolean onKey(View v, int keyCode, KeyEvent event) {
            if (keyCode == KeyEvent.KEYCODE_DEL) {
                if (event.getAction() != KeyEvent.ACTION_UP) {
                    return true;
                }
                if (et6.isFocused()) {
                    if (!TextUtils.isEmpty(et6.getText())) {
                        et6.setText("");
                    } else {
                        et6.clearFocus();
                        e5_focuse();
                        et5.setText("");
                    }
                } else if (et5.isFocused()) {
                    if (!TextUtils.isEmpty(et5.getText())) {
                        et5.setText("");
                    } else {
                        et5.clearFocus();
                        e4_focuse();
                        et4.setText("");
                    }
                } else if (et4.isFocused()) {
                    if (!TextUtils.isEmpty(et4.getText())) {
                        et4.setText("");
                    } else {
                        et4.clearFocus();
                        e3_focuse();
                        et3.setText("");
                    }
                } else if (et3.isFocused()) {
                    if (!TextUtils.isEmpty(et3.getText())) {
                        et3.setText("");
                    } else {
                        et3.clearFocus();
                        e2_focuse();
                        et2.setText("");
                    }
                } else if (et2.isFocused()) {
                    if (!TextUtils.isEmpty(et2.getText())) {
                        et2.setText("");
                    } else {
                        et2.clearFocus();
                        clear_focuse();
                        et1.setText("");
                    }
                }
                return true;
            }
            return false;
        }
    }


    private void e2_focuse() {
        et2.setFocusable(true);
        et2.setFocusableInTouchMode(true);
        et2.requestFocus();
        et2.findFocus();

        et1.setFocusable(false);
        et3.setFocusable(false);
        et4.setFocusable(false);
        et5.setFocusable(false);
        et6.setFocusable(false);
    }


    public void clear_focuse() {
        et1.setFocusable(true);
        et1.setFocusableInTouchMode(true);
        et1.requestFocus();
        et1.findFocus();

        InputMethodManager inputManager = (InputMethodManager) et1.getContext().getSystemService(Context.INPUT_METHOD_SERVICE);
        inputManager.showSoftInput(et1, 0);

        et2.setFocusable(false);
        et3.setFocusable(false);
        et4.setFocusable(false);
        et5.setFocusable(false);
        et6.setFocusable(false);
    }


    private void e3_focuse() {
        et3.setFocusable(true);
        et3.setFocusableInTouchMode(true);
        et3.requestFocus();
        et3.findFocus();

        et2.setFocusable(false);
        et1.setFocusable(false);
        et4.setFocusable(false);
        et5.setFocusable(false);
        et6.setFocusable(false);
    }


    private void e4_focuse() {
        et4.setFocusable(true);
        et4.setFocusableInTouchMode(true);
        et4.requestFocus();
        et4.findFocus();

        et2.setFocusable(false);
        et3.setFocusable(false);
        et1.setFocusable(false);
        et5.setFocusable(false);
        et6.setFocusable(false);
    }


    private void e5_focuse() {
        et5.setFocusable(true);
        et5.setFocusableInTouchMode(true);
        et5.requestFocus();
        et5.findFocus();


        et2.setFocusable(false);
        et3.setFocusable(false);
        et4.setFocusable(false);
        et1.setFocusable(false);
        et6.setFocusable(false);
    }


    public void last_focuse() {
        et6.setFocusable(true);
        et6.setFocusableInTouchMode(true);
        et6.requestFocus();
        et6.findFocus();

        et2.setFocusable(false);
        et3.setFocusable(false);
        et4.setFocusable(false);
        et5.setFocusable(false);
        et1.setFocusable(false);
    }

    public void setListener(SixPwdListener listener) {
        this.listener = listener;
    }

    public interface SixPwdListener {
        void onInputComplete(String passWord);
    }
}
