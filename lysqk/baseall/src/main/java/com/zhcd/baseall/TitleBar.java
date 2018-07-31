package com.zhcd.baseall;


import android.app.Activity;
import android.content.Context;
import android.os.Build;
import android.support.annotation.RequiresApi;
import android.util.AttributeSet;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.zhcd.utils.DensityUtil;

public class TitleBar extends RelativeLayout {
    private TextView tvTitle;
    private TextView tvRight;
    private TextView tvBack;
    private LinearLayout llBack;

    public TitleBar(Context context) {
        this(context, null);
    }

    public TitleBar(Context context, AttributeSet attrs) {
        this(context, attrs, 0);
    }

    public TitleBar(Context context, AttributeSet attrs, int defStyleAttr) {
        super(context, attrs, defStyleAttr);
    }

    @RequiresApi(api = Build.VERSION_CODES.LOLLIPOP)
    public TitleBar(Context context, AttributeSet attrs, int defStyleAttr, int defStyleRes) {
        super(context, attrs, defStyleAttr, defStyleRes);
    }

    public TitleBar(final Activity activity) {
        super(activity);
        initView(activity);
    }

    public TitleBar(final Activity activity, RelativeLayout toolbar) {
        super(activity);
        tvTitle = (TextView) toolbar.findViewById(R.id.tv_title);
        tvRight = (TextView) toolbar.findViewById(R.id.tv_right);
        tvBack = (TextView) toolbar.findViewById(R.id.tv_back);

        llBack = (LinearLayout) toolbar.findViewById(R.id.ll_back);
        llBack.setOnClickListener(new OnClickListener() {

            @Override
            public void onClick(View v) {
                activity.finish();
            }
        });
    }

    private void initView(final Activity activity) {
        LayoutInflater inflater = LayoutInflater.from(activity);
        View root = inflater.inflate(R.layout.base_common_titlebar, this);
        tvTitle = (TextView) root.findViewById(R.id.tv_title);
        tvRight = (TextView) root.findViewById(R.id.tv_right);
        tvBack = (TextView) root.findViewById(R.id.tv_back);
        llBack = (LinearLayout) root.findViewById(R.id.ll_back);
        llBack.setOnClickListener(new OnClickListener() {

            @Override
            public void onClick(View v) {
                activity.finish();
            }
        });

    }

    public TitleBar setBackText(String title) {
        llBack.setVisibility(View.VISIBLE);
        tvBack.setText(title);
        return this;
    }

    public TitleBar setTitleText(String title) {
        tvTitle.setText(title);
        return this;
    }


    /**
     * 设置 标题栏北京
     *
     * @param backGroundResId
     * @return
     */
    public TitleBar setBackGround(int backGroundResId) {
        tvTitle.setBackgroundResource(backGroundResId);
        return this;
    }

    /**
     * 设置标题文字宽度
     *
     * @param width dp
     */
    public void setTitleTvWidth(int width) {
        ViewGroup.LayoutParams layoutParams = tvTitle.getLayoutParams();
        layoutParams.width = DensityUtil.dip2px(width);
        tvTitle.setLayoutParams(layoutParams);
        tvTitle.invalidate();
    }


    /**
     * 自定义返回键
     *
     * @param listener
     * @return
     */
    public TitleBar setBackIconClickEvent(final OnClickListener listener) {
        llBack.setOnClickListener(new OnClickListener() {
            @Override
            public void onClick(View v) {
                listener.onClick(v);
            }
        });
        return this;
    }

    public TitleBar setRight(String text, final OnClickListener listener) {
        tvRight.setText(text);
        tvRight.setVisibility(View.VISIBLE);
        tvRight.setOnClickListener(listener);
        return this;
    }

    public TitleBar setRight(String text, int resId, final OnClickListener listener) {
        tvRight.setText(text);
        tvRight.setBackgroundResource(resId);
        tvRight.setVisibility(View.VISIBLE);
        tvRight.setOnClickListener(listener);
        return this;
    }

    public TitleBar setRight(int color, String text, final OnClickListener listener) {
        tvRight.setTextColor(color);
        tvRight.setText(text);
        tvRight.setVisibility(View.VISIBLE);
        tvRight.setOnClickListener(listener);
        return this;
    }


    /**
     * 隐藏返回按钮
     *
     * @return
     */
    public TitleBar hideBackIcon() {
        if (llBack != null) {
            llBack.setVisibility(INVISIBLE);
        }

        return this;
    }
}
