package com.zhcd.lysqk.tool;


import android.content.Context;
import android.graphics.Bitmap;
import android.widget.ImageView;

import com.bumptech.glide.Glide;
import com.zhcd.lysqk.view.GlideCircleTransform;
import com.zhcd.lysqk.view.GlideRoundTransform;

import java.io.ByteArrayOutputStream;

public class ImageLoaderUtils {
    /**
     * 显示圆形图
     *
     * @param context
     * @param resourceId
     * @param view
     */
    public static void displayCircleImage(Context context, Integer resourceId, ImageView view) {
        Glide.with(context).load(resourceId)
                .transform(new GlideCircleTransform(context)).into(view);
    }

    public static void displayCircleImage(Context context, String url, int errorResourceId, ImageView view) {
        Glide.with(context).load(url).error(errorResourceId)
                .transform(new GlideCircleTransform(context)).into(view);
    }

    public static void displayCircleImage(Context context, Bitmap bitmap, int errorResourceId, ImageView view) {
        ByteArrayOutputStream baos = new ByteArrayOutputStream();
        bitmap.compress(Bitmap.CompressFormat.PNG, 100, baos);
        byte[] bytes = baos.toByteArray();

        Glide.with(context).load(bytes).error(errorResourceId)
                .transform(new GlideCircleTransform(context)).into(view);
    }

    public static void displayCircleImage(Context context, String url, ImageView view) {
        Glide.with(context).load(url)
                .transform(new GlideCircleTransform(context)).into(view);
    }

    /**
     * 显示圆角图
     * </br>默认为 4dp圆角
     *
     * @param context
     * @param resourceId
     * @param view
     */
    public static void displayCircleRoundImage(Context context, Integer resourceId, ImageView view) {
        Glide.with(context).load(resourceId)
                .transform(new GlideRoundTransform(context)).into(view);
    }

    public static void displayCircleRoundImage(Context context, String url, ImageView view) {
        Glide.with(context).load(url)
                .transform(new GlideRoundTransform(context)).into(view);
    }

    /**
     * 显示圆角图
     *
     * @param context
     * @param resourceId
     * @param view
     */
    public static void displayCircleRoundImage(Context context, Integer resourceId, int round, ImageView view) {
        Glide.with(context).load(resourceId)
                .transform(new GlideRoundTransform(context, round)).into(view);
    }

    public static void displayCircleRoundImage(Context context, String url, int round, ImageView view) {
        Glide.with(context).load(url)
                .transform(new GlideRoundTransform(context, round)).into(view);
    }

    public static void displayCircleRoundImage(Context context, int errorResourceId, String url, int round, ImageView view) {
        Glide.with(context).load(url).error(errorResourceId)
                .transform(new GlideRoundTransform(context, round)).into(view);
    }
    public static void displayCircleRoundImage(Context context, int errorResourceId, String url,ImageView view) {
        Glide.with(context).load(url).error(errorResourceId)
                .transform(new GlideRoundTransform(context)).into(view);
    }
    public static void displayImage(Context context, Integer resourceId, ImageView view) {
        Glide.with(context).load(resourceId).crossFade().into(view);
    }

    public static void displayImage(Context context, String url, ImageView view) {
        Glide.with(context).load(url).crossFade().into(view);
    }

    public static void displayImage(Context context, String url, int errorResourceId, ImageView view) {
        Glide.with(context).load(url).error(errorResourceId).crossFade().into(view);
    }
}
