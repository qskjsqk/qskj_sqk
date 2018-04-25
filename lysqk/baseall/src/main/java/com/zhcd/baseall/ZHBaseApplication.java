package com.zhcd.baseall;

import android.app.Activity;
import android.app.Application;
import android.content.Context;
import android.os.Bundle;

import com.zhcd.utils.AppUtils;
import com.zhcd.utils.ContextUtil;
import com.zhcd.utils.CrashHandler;
import com.zhcd.utils.L;

/**
 * Created by bailiangjin on 16/7/29.
 */
abstract public class ZHBaseApplication extends Application implements Application.ActivityLifecycleCallbacks {

//    protected static Context appContext;

    public static Context getAppContext() {
        return ContextUtil.getAppContext();
    }
    /**
     * 退出应用程序
     */
    public void appExit() {
        try {
            L.e("app exit");
            onAppExit();
            ContextUtil.finishAllActivity();
        } catch (Exception e) {
        }
    }

    @Override
    public void onCreate() {
        super.onCreate();
        if (!AppUtils.isMainProcess(this)) {
            //非主进程直接返回
            return;
        }
        //// TODO: 17/4/18 develop setting
//        if (AppUtils.isDebug(this)) {
//            try {
//                //反射初始化app develop setting，检测摇晃手机启动设置页面
//                Class aClass = Class.forName("com.xywy.develop_settings.DevelopSettingManager");
//                Method method = aClass.getMethod("init", Application.class);
//                System.out.println(method.invoke(null, this));
//            } catch (Exception e) {
//                //Roboletric测试时leakcanary会有空指针问题
//                L.ex(e);
//            }
//        }
        if (AppUtils.isDebug(this)) {
            CrashHandler.getInstance().init(this);
        }
        ContextUtil.init(this);
        registerActivityListener();
    }

    /**
     * @param activity 作用说明 ：添加一个activity到管理里
     */
    public static void pushActivity(Activity activity) {
        ContextUtil.pushActivity(activity);
    }

    /**
     * @param activity 作用说明 ：删除一个activity在管理里
     */
    public static void popActivity(Activity activity) {
        ContextUtil.popActivity(activity);
    }

    /**
     * @return 作用说明 ：获取当前最顶部activity的实例
     */
    public static Activity getTopActivity() {

        return ContextUtil.getTopActivity();
    }

    /**
     * @return 作用说明 ：获取当前栈内页面数
     */
    public static int getActivityCount() {

        return ContextUtil.getActivityCount();
    }

    /**
     * @return 作用说明 ：获取当前最顶部的acitivity 名字
     */
    public String getTopActivityName() {
        return ContextUtil.getTopActivityName();
    }

    private void registerActivityListener() {
        registerActivityLifecycleCallbacks(this);
    }

    @Override
    public void onActivityCreated(Activity activity, Bundle savedInstanceState) {

    }

    @Override
    public void onActivityStarted(Activity activity) {

    }

    @Override
    public void onActivityResumed(Activity activity) {

    }

    @Override
    public void onActivityPaused(Activity activity) {

    }

    @Override
    public void onActivityStopped(Activity activity) {

    }

    @Override
    public void onActivitySaveInstanceState(Activity activity, Bundle outState) {

    }

    @Override
    public void onActivityDestroyed(Activity activity) {

    }

    abstract protected void onAppExit();


}
