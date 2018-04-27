package com.zhcd.lysqk.module.home;

import android.content.Context;
import android.content.Intent;
import android.support.v4.app.FragmentTransaction;
import android.view.View;
import android.widget.RadioGroup;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.zhcd.lysqk.R;
import com.zhcd.lysqk.base.BaseActivity;

public class HomeActivity extends BaseActivity {
    private static final String HomeSelectedTab = "HomeSelectedTab";

    public static final int ACTION_TAB = 0;
    public static final int INTEGRAL_TAB = 1;

    private TextView tvActionTab, tvIntegralTab;
    private RadioGroup radioGroupHome;
    private RelativeLayout homeContainer;
    private ActionFragment actionFragment;
    private IntegralFragment integralFragment;

    private int onNewIntentTabIndex = -1;

    @Override
    protected int getLayoutResId() {
        return R.layout.activity_home;
    }

    public static void start(Context context, int selectedTab) {
        if (context != null) {
            Intent intent = new Intent(context, HomeActivity.class);
            intent.putExtra(HomeSelectedTab, selectedTab);
            context.startActivity(intent);
        }
    }

    @Override
    public void onNewIntent(Intent intent) {
        super.onNewIntent(intent);
        setIntent(intent);
        processExtraData();
    }

    @Override
    public void onResume() {
        super.onResume();
        if (onNewIntentTabIndex >= ACTION_TAB && onNewIntentTabIndex <= INTEGRAL_TAB) {
            setTabSelection(onNewIntentTabIndex);
        }
        onNewIntentTabIndex = -1;
    }


    private void processExtraData() {
        onNewIntentTabIndex = getIntent().getIntExtra(HomeSelectedTab, -1);
    }

    @Override
    protected void initView() {
        super.initView();
        actionFragment = new ActionFragment();
        getSupportFragmentManager().beginTransaction()
                .add(R.id.home_container, actionFragment)
                .commitAllowingStateLoss();
        tvActionTab = (TextView) findViewById(R.id.tv_action_tab);
        tvIntegralTab = (TextView) findViewById(R.id.tv_integral_tab);
        homeContainer = (RelativeLayout) findViewById(R.id.home_container);
        radioGroupHome = (RadioGroup) findViewById(R.id.radio_group_home);
        radioGroupHome.setOnCheckedChangeListener(new RadioGroup.OnCheckedChangeListener() {
            @Override
            public void onCheckedChanged(RadioGroup group, int checkedId) {
                switch (checkedId) {
                    case R.id.rb_action_tab:
                        setTabSelection(0);
                        break;
                    case R.id.rb_integral_tab:
                        setTabSelection(1);
                        break;
                }
            }
        });
    }

    /**
     * 根据传入的index参数来设置选中的tab页。
     *
     * @param index 每个tab页对应的下标。
     */
    public void setTabSelection(int index) {
        FragmentTransaction transaction = getSupportFragmentManager().beginTransaction();
        hideFragments(transaction);
        setTabBottomLine(index);
        switch (index) {
            case ACTION_TAB:
                //首页
                if (actionFragment == null) {
                    actionFragment = new ActionFragment();
                    transaction.add(R.id.home_container, actionFragment);
                } else {
                    transaction.show(actionFragment);
                }
                radioGroupHome.check(R.id.rb_action_tab);
                break;
            case INTEGRAL_TAB:
                if (integralFragment == null) {
                    integralFragment = new IntegralFragment();
                    transaction.add(R.id.home_container, integralFragment);
                } else {
                    transaction.show(integralFragment);
                }
                radioGroupHome.check(R.id.rb_integral_tab);
                break;
            default:
                break;
        }
        transaction.commitAllowingStateLoss();
    }

    private void setTabBottomLine(int index) {
        switch (index) {
            case ACTION_TAB:
                tvActionTab.setVisibility(View.VISIBLE);
                tvIntegralTab.setVisibility(View.GONE);
                break;
            case INTEGRAL_TAB:
                tvActionTab.setVisibility(View.GONE);
                tvIntegralTab.setVisibility(View.VISIBLE);
                break;
        }
    }

    /**
     * 将所有的Fragment都置为隐藏状态。
     *
     * @param transaction 用于对Fragment执行操作的事务
     */

    private void hideFragments(FragmentTransaction transaction) {
        if (actionFragment != null) {
            transaction.hide(actionFragment);
        }
        if (integralFragment != null) {
            transaction.hide(integralFragment);
        }
    }
}
