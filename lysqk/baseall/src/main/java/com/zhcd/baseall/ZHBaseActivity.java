package com.zhcd.baseall;

import android.os.Bundle;
import android.os.Looper;
import android.support.annotation.LayoutRes;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.View;
import android.view.ViewGroup;
import android.view.ViewStub;
import android.view.ViewTreeObserver;
import android.widget.RelativeLayout;

import com.zhcd.baseall.view.ProgressDialog;
import com.zhcd.utils.KeyBoardUtils;
import com.zhcd.utils.UIHandler;


public class ZHBaseActivity extends AppCompatActivity {

    protected final String TAG = getClass().getSimpleName();
    protected RelativeLayout toolbar;
    protected RelativeLayout root;
    protected TitleBar titleBarBuilder;

    protected ViewStub baseContainer;
    protected View content;
    protected View line;

    /**
     * Handler 消息处理
     */
    protected UIHandler uiHandler = new UIHandler(Looper.getMainLooper());


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        initSuperUI();
    }

    @Override
    public void setContentView(@LayoutRes int layoutResID) {
        baseContainer.setLayoutResource(layoutResID);
        content = baseContainer.inflate();
    }

    @Override
    protected void onPause() {
        super.onPause();
    }

    @Override
    protected void onResume() {
        super.onResume();
    }

    @Override
    protected void onDestroy() {
        //放置handler 内存泄漏
        hideProgressDialog();
        uiHandler.removeCallbacksAndMessages(null);
        super.onDestroy();
    }

    /**
     * 初始化父类UI
     */
    private void initSuperUI() {
        super.setContentView(R.layout.base_activity_base);
        baseContainer = (ViewStub) findViewById(R.id.baseContainer);
        toolbar = (RelativeLayout) findViewById(R.id.toolbar);
        titleBarBuilder = new TitleBar(this, toolbar);
        root = (RelativeLayout) findViewById(R.id.ll_root);
        root.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                KeyBoardUtils.closeKeyboard(ZHBaseActivity.this);
            }
        });
        line = findViewById(R.id.line);
    }


    /**
     * 隐藏公共title
     */
    public void hideCommonBaseTitle() {
        if (toolbar != null) {
            toolbar.setVisibility(View.GONE);
        }
        if (line != null) {
            line.setVisibility(View.GONE);
        }
    }

    /**
     * 设置隐藏状态栏高度
     */
    public void hideStatusBarHeight() {
        root.setFitsSystemWindows(false);
    }

    /**
     * 显示公共的title
     */
    public void showCommonBaseTitle() {

        if (toolbar != null) {
            toolbar.setVisibility(View.VISIBLE);
        }
    }

    protected void setToolbarTransparent(final int transparent) {
        toolbar.getViewTreeObserver().addOnGlobalLayoutListener(new ViewTreeObserver.OnGlobalLayoutListener() {

            @Override
            public void onGlobalLayout() {
                toolbar.getBackground().setAlpha(transparent);
                ViewGroup.MarginLayoutParams layoutParams = (ViewGroup.MarginLayoutParams) content.getLayoutParams();
//                layoutParams.setMargins(0, -DensityUtil.dip2px(48),0,0);
                layoutParams.setMargins(0, -toolbar.getHeight(), 0, 0);
                content.setLayoutParams(layoutParams);
                toolbar.getViewTreeObserver().removeOnGlobalLayoutListener(this);
            }
        });

    }

    protected ProgressDialog progressDialog;

    /**
     * 显示进度dialog
     *
     * @param content 提示文字内容
     */
    public void showProgressDialog(String content) {
        if (null == progressDialog) {
            progressDialog = new ProgressDialog(this, content);
            progressDialog.setCanceledOnTouchOutside(false);
        } else {
            progressDialog.setTitleTxt(content);
        }
        progressDialog.showProgersssDialog();
    }

    public void showProgressDialog() {
        showProgressDialog("");
    }

    /**
     * 隐藏进度dialog
     */
    public void hideProgressDialog() {
        if (null == progressDialog) {
            return;
        }
        if (progressDialog.isShowing()) {
            progressDialog.closeProgersssDialog();
        }
    }
}
