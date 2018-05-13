package com.zhcd.lysqk.module.action;


import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.resource.drawable.GlideDrawable;
import com.bumptech.glide.request.animation.GlideAnimation;
import com.bumptech.glide.request.target.GlideDrawableImageViewTarget;
import com.zhcd.lysqk.R;
import com.zjinv.uilibrary.photoview.PhotoViewAttacher;

public class PictureSlideFragment extends Fragment {
    private String url;
    private PhotoViewAttacher mAttacher;
    private ImageView imageView;

    public static PictureSlideFragment newInstance(String url) {
        PictureSlideFragment f = new PictureSlideFragment();
        Bundle args = new Bundle();
        args.putString("url", url);
        f.setArguments(args);

        return f;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        url = getArguments() != null ? getArguments().getString("url") : "http://c.hiphotos.baidu.com/baike/pic/item/91529822720e0cf3dd2b51cc0646f21fbe09aa2c.jpg";

    }

    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View v = inflater.inflate(R.layout.fragment_picture_slide, container, false);

        imageView = (ImageView) v.findViewById(R.id.iv_main_pic);
        mAttacher = new PhotoViewAttacher(imageView);

        Glide.with(getActivity()).load(url).crossFade().into(new GlideDrawableImageViewTarget(imageView) {
            @Override
            public void onResourceReady(GlideDrawable resource, GlideAnimation<? super GlideDrawable> animation) {
                super.onResourceReady(resource, animation);
                mAttacher.update();
            }
        });
        return v;
    }
}
