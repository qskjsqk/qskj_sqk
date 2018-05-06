package com.zhcd.lysqk.view;

import android.content.Context;
import android.os.Build;
import android.support.annotation.RequiresApi;
import android.text.Editable;
import android.text.TextUtils;
import android.text.TextWatcher;
import android.text.method.PasswordTransformationMethod;
import android.util.AttributeSet;
import android.util.TypedValue;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TextView;


import com.zhcd.lysqk.R;
import com.zhcd.utils.DensityUtil;

import java.util.ArrayList;
import java.util.List;


public class PasswordInputView extends LinearLayout implements View.OnClickListener, TextWatcher {
    private Context context;
    private int itemNum = 6;
    private int backgroundColor = R.color.transparent;


    private List<View> viewList;
    private TextView[] indicatorText;
    private int itemBackground = R.mipmap.login_input_pwd_item_bg;
    private float margin = 15;
    private IPWClickListener ipwClickListener;


    private StringBuilder mPassword;

    public PasswordInputView(Context context) {
        this(context, null);
    }

    public PasswordInputView(Context context, AttributeSet attrs) {
        this(context, attrs, 0);
    }

    public PasswordInputView(Context context, AttributeSet attrs, int defStyleAttr) {
        super(context, attrs, defStyleAttr);
        this.context = context;
        initAttr(context);
        setFocusable(false);
    }

    @RequiresApi(api = Build.VERSION_CODES.LOLLIPOP)
    public PasswordInputView(Context context, AttributeSet attrs, int defStyleAttr, int defStyleRes) {
        super(context, attrs, defStyleAttr, defStyleRes);
        initAttr(context);
        setFocusable(false);
    }

    private void initAttr(Context context) {
        super.setOrientation(LinearLayout.HORIZONTAL);
        initData(context);
        setBackgroundColor(context.getResources().getColor(backgroundColor));
    }

    private void initData(Context context) {
        indicatorText = new TextView[itemNum];
        viewList = new ArrayList<>(itemNum);
        mPassword = new StringBuilder();
        for (int i = 0; i < itemNum; i++) {
            View view = LayoutInflater.from(context).inflate(R.layout.view_password_input_item, null);
            view.setBackgroundResource(R.color.white);
            ((TextView) view.findViewById(R.id.password_tv)).setBackgroundResource(itemBackground);
            viewList.add(view);
            indicatorText[i] = new TextView(context);
            if (i == 0) {
                indicatorText[i].setBackgroundResource(itemBackground);
                LayoutParams layoutParams = new LayoutParams(DensityUtil.dip2px(45), DensityUtil.dip2px(45));
                indicatorText[i].setLayoutParams(layoutParams);
            } else {
                indicatorText[i].setBackgroundResource(itemBackground);
                LayoutParams layoutParams = new LayoutParams(DensityUtil.dip2px(45), DensityUtil.dip2px(45));
                layoutParams.setMargins(DensityUtil.dip2px(margin), 0, 0, 0);
                indicatorText[i].setLayoutParams(layoutParams);
            }

            indicatorText[i].setTransformationMethod(PasswordTransformationMethod.getInstance());

            indicatorText[i].setTextSize(TypedValue.COMPLEX_UNIT_PX, getResources().getDimension(R.dimen.text_34sp));
            indicatorText[i].setGravity(Gravity.CENTER);
            indicatorText[i].setOnClickListener(this);
            indicatorText[i].addTextChangedListener(this);
            addView(indicatorText[i]);

        }
    }


    /**
     * 输入密码
     *
     * @param value
     */
    public void add(String value) {
        if (mPassword != null && mPassword.length() < itemNum) {
            mPassword.append(value);
            if (mPassword.length() == 1) {
                indicatorText[0].setText(value);
            } else if (mPassword.length() == 2) {
                indicatorText[1].setText(value);
            } else if (mPassword.length() == 3) {
                indicatorText[2].setText(value);
            } else if (mPassword.length() == 4) {
                indicatorText[3].setText(value);
            } else if (mPassword.length() == 5) {
                indicatorText[4].setText(value);
            } else if (mPassword.length() == 6) {
                indicatorText[5].setText(value);
            }
        }
    }

    /**
     * 删除密码
     */
    public void remove() {
        if (mPassword != null && mPassword.length() > 0) {
            if (mPassword.length() == 1) {
                indicatorText[0].setText("");
            } else if (mPassword.length() == 2) {
                indicatorText[1].setText("");
            } else if (mPassword.length() == 3) {
                indicatorText[2].setText("");
            } else if (mPassword.length() == 4) {
                indicatorText[3].setText("");
            } else if (mPassword.length() == 5) {
                indicatorText[4].setText("");
            } else if (mPassword.length() == 6) {
                indicatorText[5].setText("");
            }
            mPassword.deleteCharAt(mPassword.length() - 1);
        }
    }

    public String getTextString() {
        return mPassword.toString();
    }

    public void clearText() {
        for (int i = 0; i < itemNum; i++) {
            indicatorText[i].setText("");
        }
        mPassword.delete(0, mPassword.length());
    }

    @Override
    public void onClick(View v) {
        if (ipwClickListener != null) {
            ipwClickListener.onViewClick(v);
        }
    }

    @Override
    public void beforeTextChanged(CharSequence s, int start, int count, int after) {

    }

    @Override
    public void onTextChanged(CharSequence s, int start, int before, int count) {

    }

    @Override
    public void afterTextChanged(Editable s) {
        if (ipwClickListener != null) {
            if (!TextUtils.isEmpty(s.toString())) {
                ipwClickListener.afterTextChanged(s);
            }
        }
    }

    public interface IPWClickListener {
        void onViewClick(View v);

        void afterTextChanged(Editable s);
    }

    /**
     * 对外开放的方法
     */
    public void setPWClickListener(IPWClickListener ipwClickListener) {
        this.ipwClickListener = ipwClickListener;
    }
}