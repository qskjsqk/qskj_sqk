package com.zhcd.baseall.view;

import android.app.Dialog;
import android.content.Context;
import android.text.TextUtils;
import android.view.View;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.ImageView;
import android.widget.TextView;

import com.zhcd.baseall.R;


/**
 * 项目名称：D_Platform
 * 类名称：ProgressDialog
 * 类描述：自定义dialog
 * 创建人：shihao
 * 创建时间：2015-5-29 下午1:39:50
 * 修改备注：
 */
public class ProgressDialog extends Dialog {

    private TextView txt;

    public ProgressDialog(Context context, String content) {
        super(context, R.style.progress_dialog);

        // 加载布局文件

        View view = View.inflate(context, R.layout.progress_dialog, null);
        txt = (TextView) view.findViewById(R.id.progress_dialog_txt);
        setTitleTxt(content);
        // dialog添加视图
//        getWindow().setBackgroundDrawableResource(R.drawable.loading_bg);
        setContentView(view);
        this.setCancelable(true);
        this.setCanceledOnTouchOutside(false);
    }

    /**
     * 显示对话框
     */
    public void showProgersssDialog() {
        if (!this.isShowing()) {
            this.show();
        }
    }

    public void setTitleTxt(String title) {
        if (txt != null) {
            if (!TextUtils.isEmpty(title)) {
                txt.setText(title);
                txt.setVisibility(View.VISIBLE);
            } else {
                txt.setVisibility(View.GONE);
            }
        }
    }

    /**
     * 关闭对话框
     */
    public void closeProgersssDialog() {
        if (this.isShowing()) {
            this.dismiss();
        }
    }
}