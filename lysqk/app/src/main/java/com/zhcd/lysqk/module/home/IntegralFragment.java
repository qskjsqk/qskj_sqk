package com.zhcd.lysqk.module.home;

import android.graphics.Bitmap;
import android.os.Bundle;
import android.text.TextUtils;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.zhcd.lysqk.R;
import com.zhcd.lysqk.base.BaseFragment;
import com.zhcd.lysqk.module.record.ReceivePointsActivity;
import com.zhcd.lysqk.module.record.TransactionRecordsActivity;
import com.zhcd.lysqk.tool.ZXingUtils;
import com.zhcd.utils.DensityUtil;


public class IntegralFragment extends BaseFragment {
    private ImageView ivQR;
    private TextView allRecords;

    @Override
    protected int getLayoutResId() {
        return R.layout.fragment_integral;
    }

    @Override
    protected void beforeViewBind() {

    }

    @Override
    protected void initView() {
        if (rootView != null) {
            ivQR = (ImageView) rootView.findViewById(R.id.iv_QR);
            allRecords = (TextView) rootView.findViewById(R.id.tv_all_transaction_records);
            allRecords.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    TransactionRecordsActivity.start(getActivity());
                }
            });
            ivQR.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    ReceivePointsActivity.start(getActivity(), "1362223113");
                }
            });
            setQR("https://www.tmall.com/?ali_trackid=2:mm_26632322_6858406_70736499:1524820216_243_614827073");
        }
    }

    private void setQR(String url) {
        if (!TextUtils.isEmpty(url) && ivQR != null) {
            Bitmap bitmap = ZXingUtils.createQRImage(url, DensityUtil.dip2px(120), DensityUtil.dip2px(120));
            ivQR.setImageBitmap(bitmap);
        }


    }

    @Override
    protected void initData(Bundle savedInstanceState) {

    }

    @Override
    protected void initListener() {

    }
}
