package com.zjinv.uilibrary.recyclerview.adapter;

import android.content.Context;

import com.zhcd.utils.DensityUtil;
import com.zjinv.uilibrary.R;

public class HSItemDecoration extends CommonItemDecoration {

    private static final int DEFAULT_COLOR = R.color.base_bg_color;
    private static final float DEFAULT_LINE_WIDTH = 0.5F;

    /**
     * 默认参数 无特殊要求 使用该构造参数即可
     *
     * @param context
     */
    public HSItemDecoration(Context context) {
        super(context, DEFAULT_COLOR, 0.5f);
    }

    public HSItemDecoration(Context context, int colorResId) {
        super(context, colorResId, DEFAULT_LINE_WIDTH);
    }

    public HSItemDecoration(Context context, float lineWidth) {
        super(context, DEFAULT_COLOR, lineWidth);
    }

    /**
     * @param marginLeft  marginLeft dp
     * @param marginRight marginRight dp
     */
    public HSItemDecoration(Context context, int colorResId, int marginLeft, int marginRight) {
        super(context, colorResId, DEFAULT_LINE_WIDTH, DensityUtil.dip2px(marginLeft), DensityUtil.dip2px(marginRight));
    }

    /**
     * @param lineWidth   线宽 dp
     * @param marginLeft  marginLeft dp
     * @param marginRight marginRight dp
     */
    public HSItemDecoration(Context context, int colorResId, float lineWidth, int marginLeft, int marginRight) {
        super(context, colorResId, lineWidth, DensityUtil.dip2px(marginLeft), DensityUtil.dip2px(marginRight));
    }

    /**
     * @param lineWidth 线宽 dp
     */
    public HSItemDecoration(Context context, int colorResId, float lineWidth) {
        super(context, colorResId, lineWidth);
    }
}
