package com.zhcd.lysqk.module.action;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;

import com.alibaba.fastjson.JSON;
import com.zhcd.lysqk.R;
import com.zhcd.lysqk.net.ServiceProvider;
import com.zhcd.lysqk.tool.ImageLoaderUtils;
import com.zhcd.lysqk.tool.ImagePathUtil;

import java.util.List;

public class ActionPhotoAlbumAdapter extends RecyclerView.Adapter<ActionPhotoAlbumAdapter.PhotoAlbumViewHolder> implements View.OnClickListener {
    private List<String> lists;
    private Context context;

    public ActionPhotoAlbumAdapter(Context context) {
        this.context = context;
    }

    public void setData(List<String> lists) {
        this.lists = lists;
        notifyDataSetChanged();
    }

    @Override
    public PhotoAlbumViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_action_photo_album, null, false);
        PhotoAlbumViewHolder viewHolder = new PhotoAlbumViewHolder(view);
        view.setOnClickListener(this);
        return viewHolder;
    }

    @Override
    public void onBindViewHolder(PhotoAlbumViewHolder holder, int position) {
        if (lists != null && lists.size() > position) {
            String URL = ImagePathUtil.imageReallyUrl(lists.get(position));
            ImageLoaderUtils.displayImage(context, URL, R.color.white, holder.getImageView());
            holder.itemView.setTag(position);
        }
    }

    @Override
    public int getItemCount() {
        if (lists != null) {
            return lists.size();
        }
        return 0;
    }

    @Override
    public void onClick(View v) {
        if (lists != null && lists.size() > 0) {
            try {
                PictureSlideActivity.start(context, JSON.toJSONString(lists), (int) v.getTag());
            } catch (Exception e) {
            }
        }
    }

    public class PhotoAlbumViewHolder extends RecyclerView.ViewHolder {
        private ImageView imageView;

        public PhotoAlbumViewHolder(View itemView) {
            super(itemView);
            imageView = (ImageView) itemView.findViewById(R.id.iv_photo_album);
        }

        public ImageView getImageView() {
            return imageView;
        }

    }
}
