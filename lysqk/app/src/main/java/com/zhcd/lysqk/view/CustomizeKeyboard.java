package com.zhcd.lysqk.view;

import android.content.Context;
import android.util.AttributeSet;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.BaseAdapter;
import android.widget.GridView;
import android.widget.RelativeLayout;
import android.widget.TextView;


import com.zhcd.lysqk.R;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.Collections;
import java.util.List;

/**
 * 自定义密码键盘
 */

public class CustomizeKeyboard extends RelativeLayout {
    private Context context;
    private GridView gvKeyboard;

    private List<String> key;
    private static final String[] KEY = new String[]{
            "1", "2", "3",
            "4", "5", "6",
            "7", "8", "9",
            "", "0", "-"
    };

    private OnClickKeyboardListener onClickKeyboardListener;

    public CustomizeKeyboard(Context context) {
        this(context, null);
    }

    public CustomizeKeyboard(Context context, AttributeSet attrs) {
        this(context, attrs, 0);
    }

    public CustomizeKeyboard(Context context, AttributeSet attrs, int defStyleAttr) {
        super(context, attrs, defStyleAttr);
        this.context = context;
        init();
    }

    private List<String> shuffleNum() {
        List<Integer> list = new ArrayList<>();
        for (int i = 0; i < 10; i++)
            list.add(Integer.valueOf(i));
        Collections.shuffle(list);
        List<String> key = new ArrayList<>();
        for (int i = 0; i < 9; i++) {
            key.add(Integer.toString(list.get(i)));
        }
        key.add("");
        key.add(Integer.toString(list.get(9)));
        key.add("-");

        return key;
    }

    private void init() {
        this.key = shuffleNum();
//        this.key=KEY;
        initKeyboardView();
    }

    /**
     * 初始化键盘的点击事件
     */
    private void initEvent() {
        gvKeyboard.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                if (onClickKeyboardListener != null && position >= 0) {
                    onClickKeyboardListener.onKeyClick(position, key.get(position));
                }
            }
        });
    }

    /**
     * 初始化KeyboardView
     */
    private void initKeyboardView() {
        View view = View.inflate(context, R.layout.view_customize_keyboard, this);
        gvKeyboard = (GridView) view.findViewById(R.id.gv_keyboard);
        gvKeyboard.setAdapter(keyboardAdapter);
        initEvent();
    }

    public interface OnClickKeyboardListener {
        void onKeyClick(int position, String value);
    }

    /**
     * 对外开放的方法
     *
     * @param onClickKeyboardListener
     */
    public void setOnClickKeyboardListener(OnClickKeyboardListener onClickKeyboardListener) {
        this.onClickKeyboardListener = onClickKeyboardListener;
    }

    private BaseAdapter keyboardAdapter = new BaseAdapter() {
        private static final int KEY_DELETE = 11;
        private static final int KEY_X = 9;

        @Override
        public int getCount() {
            return key.size();
        }

        @Override
        public Object getItem(int position) {
            return key.get(position);
        }

        @Override
        public long getItemId(int position) {
            return position;
        }

        @Override
        public int getViewTypeCount() {
            return 2;
        }

        @Override
        public int getItemViewType(int position) {
            return (getItemId(position) == KEY_DELETE) ? 2 : 1;
        }

        @Override
        public View getView(int position, View convertView, ViewGroup parent) {
            ViewHolder viewHolder = null;
            if (convertView == null) {
                if (getItemViewType(position) == 1) {
                    //数字键
                    convertView = LayoutInflater.from(context).inflate(R.layout.view_item_customize_keyboard, parent, false);
                    viewHolder = new ViewHolder(convertView);
                } else {
                    //删除键
                    convertView = LayoutInflater.from(context).inflate(R.layout.view_item_customize_keyboard_delete, parent, false);
                }
            }

            if (getItemViewType(position) == 1) {
                viewHolder = (ViewHolder) convertView.getTag();
                viewHolder.tvKey.setText(key.get(position));
            }
//            if (position == KEY_X && !isIdCardView) {
//                viewHolder.tvKey.setBackgroundResource(R.drawable.selector_keyboard_key_not_press_bg);
//            }

            return convertView;
        }
    };

    /**
     * ViewHolder,view缓存
     */
    static class ViewHolder {
        private TextView tvKey;

        public ViewHolder(View view) {
            tvKey = (TextView) view.findViewById(R.id.tv_keyboard_keys);
            view.setTag(this);
        }
    }
}