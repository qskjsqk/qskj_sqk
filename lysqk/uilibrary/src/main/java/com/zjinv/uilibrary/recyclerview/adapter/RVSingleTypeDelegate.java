package com.zjinv.uilibrary.recyclerview.adapter;


import com.zjinv.uilibrary.recyclerview.zhy.base.ItemViewDelegate;

public abstract class RVSingleTypeDelegate<T> implements ItemViewDelegate<T>
{

    @Override
    public boolean isForViewType(T item, int position)
    {
        //只有一种Item 返回true
        return true;
    }

}
