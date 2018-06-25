package com.zhcd.lysqk.view;

import android.app.Dialog;
import android.content.Context;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.text.TextUtils;
import android.view.Gravity;
import android.view.View;
import android.widget.TextView;

import com.zhcd.lysqk.R;


public class CommonDialog extends Dialog {
    private TextView tvTitle;
    private TextView tvLeft;
    private TextView tvRight;
    private View lineView;

    private String title;
    private String textLeft;
    private String textRight;


    private boolean isGoneRightBtn;
    private boolean isCanceledOnTouchOutside;

    private View.OnClickListener leftListener;
    private View.OnClickListener rightListener;

    public CommonDialog(Context context) {
        this(context, R.style.white_bg_dialog_style);
    }

    public CommonDialog(Context context, int themeResId) {
        super(context, themeResId);
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.view_common_dialog);
        getWindow().setBackgroundDrawableResource(R.drawable.common_dialog_bkg);
        init();
    }

    private void init() {
        tvTitle = (TextView) findViewById(R.id.tv_title);
        tvLeft = (TextView) findViewById(R.id.tv_left);
        tvRight = (TextView) findViewById(R.id.tv_right);
        lineView = findViewById(R.id.common_dialog_line);

        tvTitle.setText(title);
        if (!TextUtils.isEmpty(title) && title.length() > 20)
            tvTitle.setGravity(Gravity.LEFT);
        tvLeft.setText(textLeft);
        tvRight.setText(textRight);
        if (isGoneRightBtn) {
            lineView.setVisibility(View.GONE);
            tvRight.setVisibility(View.GONE);
        }
        setCanceledOnTouchOutside(!isCanceledOnTouchOutside);
        tvLeft.setOnClickListener(leftListener);
        tvRight.setOnClickListener(rightListener);
    }

    public CommonDialog setTvTitle(String title) {
        this.title = title;
        return this;
    }

    public CommonDialog setIsGoneRightBtn(boolean goneRightBtn) {
        isGoneRightBtn = goneRightBtn;
        return this;
    }

    public CommonDialog isCanceledOnTouchOutside(boolean isCanceledOnTouchOutside) {
        this.isCanceledOnTouchOutside = isCanceledOnTouchOutside;
        return this;
    }

    public CommonDialog setButtonText(String leftText, String rightText) {
        this.textLeft = leftText;
        this.textRight = rightText;
        return this;
    }

    public CommonDialog setClickEvent(View.OnClickListener leftListener, View.OnClickListener rightListener) {
        this.leftListener = leftListener;
        this.rightListener = rightListener;
        return this;
    }

    private static final int SET_RIGHT_TEXT = 1;
    private static final int SET_RIGHT_COLOR = 2;
    private static final int SET_TITLE_TEXT = 3;

    public void setRightText(final String rightText) {
        if (this.isShowing()) {
            Message msg = new Message();
            msg.obj = rightText;
            msg.what = SET_RIGHT_TEXT;
            handler.sendMessage(msg);
        }
    }

    public void setTitleText(final String titleText) {
        Message msg = new Message();
        msg.obj = titleText;
        msg.what = SET_TITLE_TEXT;
        handler.sendMessage(msg);
    }

    public void setRightTextColor(int rightTextColor) {
        Message msg = new Message();
        msg.obj = rightTextColor;
        msg.what = SET_RIGHT_COLOR;
        handler.sendMessage(msg);
    }

    private Handler handler = new Handler() {
        public void handleMessage(Message msg) {
            switch (msg.what) {
                case SET_RIGHT_TEXT:
                    if (tvRight != null && TextUtils.isEmpty((String) msg.obj)) {
                        tvRight.setText((String) msg.obj);
                    }
                    break;
                case SET_RIGHT_COLOR:
                    if (tvRight != null && (Integer) msg.obj > 0) {
                        tvRight.setTextColor(getContext().getResources().getColor((Integer) msg.obj));
                    }
                    break;
                case SET_TITLE_TEXT:
                    if (tvTitle != null && !TextUtils.isEmpty((String) msg.obj)) {
                        tvTitle.setText((String) msg.obj);
                    }
                    break;
            }
            super.handleMessage(msg);
        }

    };
}
