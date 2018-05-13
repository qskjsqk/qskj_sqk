package com.zhcd.lysqk.module.action;

import android.content.Context;
import android.content.Intent;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentStatePagerAdapter;
import android.support.v4.view.ViewPager;
import android.text.TextUtils;
import android.widget.TextView;

import com.alibaba.fastjson.JSON;
import com.zhcd.lysqk.R;
import com.zhcd.lysqk.base.BaseActivity;
import com.zhcd.lysqk.net.ServiceProvider;

import java.util.List;


public class PictureSlideActivity extends BaseActivity {
    private static final String ListJson = "listJson";
    private static final String Position = "position";
    private List<String> photoList;
    private ViewPager viewPager;
    private TextView tv_indicator;
    private int currPosition;

    public static void start(Context context, String listJson, int position) {
        if (context != null) {
            Intent intent = new Intent(context, PictureSlideActivity.class);
            intent.putExtra(ListJson, listJson);
            intent.putExtra(Position, position);
            context.startActivity(intent);
        }
    }

    @Override
    protected int getLayoutResId() {
        return R.layout.activity_action_picture_slide;
    }

    @Override
    protected void initView() {
        super.initView();
        hideCommonBaseTitle();
        Intent intent = getIntent();
        if (intent.hasExtra(ListJson)) {
            String json = intent.getStringExtra(ListJson);
            if (!TextUtils.isEmpty(json)) {
                try {
                    photoList = JSON.parseArray(json, String.class);
                } catch (Exception e) {
                }
            }
        }
        currPosition = intent.getIntExtra(Position, 0);
        viewPager = (ViewPager) findViewById(R.id.viewpager);
        tv_indicator = (TextView) findViewById(R.id.tv_indicator);
        viewPager.setAdapter(new PictureSlidePagerAdapter(getSupportFragmentManager()));
        viewPager.addOnPageChangeListener(new ViewPager.OnPageChangeListener() {
            @Override
            public void onPageScrolled(int position, float positionOffset, int positionOffsetPixels) {
                if (photoList != null && photoList.size() > position) {
                    tv_indicator.setText(String.valueOf(position + 1) + "/" + photoList.size());
                }
            }

            @Override
            public void onPageSelected(int position) {
            }

            @Override
            public void onPageScrollStateChanged(int state) {

            }
        });
        viewPager.setCurrentItem(currPosition);
    }

    private class PictureSlidePagerAdapter extends FragmentStatePagerAdapter {

        public PictureSlidePagerAdapter(FragmentManager fm) {
            super(fm);
        }

        @Override
        public Fragment getItem(int position) {
            if (photoList != null && photoList.size() > position) {
                String url = ServiceProvider.getImageBaseUrl() + photoList.get(position);
                return PictureSlideFragment.newInstance(url);
            } else {
                return null;
            }
        }

        @Override
        public int getCount() {
            if (photoList != null) {
                return photoList.size();
            }
            return 0;
        }
    }
}
