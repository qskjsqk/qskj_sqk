package com.zhcd.lysqk.module.action.view;

import android.content.Context;
import android.text.TextUtils;
import android.util.AttributeSet;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.RelativeLayout;

import com.zhcd.lysqk.R;
import com.zhcd.lysqk.module.action.ActionDetailActivity;
import com.zhcd.lysqk.module.action.ActionDetailSignActivity;

public class ActionDetailSignBottomView extends RelativeLayout {
    private String actionId;

    public ActionDetailSignBottomView(Context context) {
        this(context,null);
    }

    public ActionDetailSignBottomView(Context context, AttributeSet attrs) {
        this(context, attrs, 0);
    }

    public ActionDetailSignBottomView(Context context, AttributeSet attrs, int defStyleAttr) {
        super(context, attrs, defStyleAttr);
        initView(context);
    }

    public void setActionId(String actionId) {
        this.actionId = actionId;
    }

    private void initView(final Context context) {
        LayoutInflater inflater = LayoutInflater.from(context);
        View root = inflater.inflate(R.layout.view_action_detail_sign_bottomview, this);
        root.findViewById(R.id.tv_look_detail).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (!TextUtils.isEmpty(actionId)) {
                    ActionDetailActivity.start(context, actionId);
                }
            }
        });

    }
}
