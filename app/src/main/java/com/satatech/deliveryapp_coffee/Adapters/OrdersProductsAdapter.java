package com.satatech.deliveryapp_coffee.Adapters;

import android.app.Activity;
import android.app.Dialog;
import android.graphics.Paint;
import android.graphics.drawable.Drawable;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.RelativeLayout;

import com.balram.library.FotTextView;
import com.bumptech.glide.Glide;
import com.bumptech.glide.load.resource.drawable.GlideDrawable;
import com.bumptech.glide.request.animation.GlideAnimation;
import com.bumptech.glide.request.target.GlideDrawableImageViewTarget;
import com.mikhaellopez.circularimageview.CircularImageView;
import com.satatech.deliveryapp_coffee.BaseActivity;
import com.satatech.deliveryapp_coffee.R;
import com.satatech.deliveryapp_coffee.utils.ConnectionClass;
import com.satatech.deliveryapp_coffee.utils.Functions;
import com.satatech.deliveryapp_coffee.utils.SharePrefsEntry;


import org.json.JSONArray;
import org.json.JSONObject;

import static com.satatech.deliveryapp_coffee.utils.Constants.DEF_CURRENCY;


public class OrdersProductsAdapter extends ArrayAdapter<JSONObject>
{
    JSONArray list;

    Activity context;
    Functions function;
    LayoutInflater inflater;
    long currentTime;
    String defaultLang;
    SharePrefsEntry sp;
    ConnectionClass cc;
    Dialog details;
    public OrdersProductsAdapter(Activity con, JSONArray l)
    {
        super(con, R.layout.row_order_product);

        context             = con;
        list                = l;
        function            = new Functions(con);
        sp                  = new SharePrefsEntry(con);
        cc                  = new ConnectionClass(con);
        inflater 	        = context.getLayoutInflater();
        defaultLang         = BaseActivity.getDefLang(context);
    }

    @Override
    public int getCount() {
        return list.length();
    }




    public class ViewHolderItem {
        RelativeLayout parentLr;
        FotTextView product,single_total,price ,qty ,discounted;
        CircularImageView img;

    }

    @Override
    public View getView(final int paramInt, View convertView, ViewGroup parent)
    {
        try
        {
            final ViewHolderItem viewHolder;
            if(convertView==null)
            {
                convertView 				= inflater.inflate(R.layout.row_order_product, parent, false);
                viewHolder 					= new ViewHolderItem();
                viewHolder.parentLr			= (RelativeLayout)convertView.findViewById(R.id.parentLr);
                viewHolder.product          = (FotTextView)convertView.findViewById(R.id.product);
                viewHolder.single_total     = (FotTextView)convertView.findViewById(R.id.single_total);
                viewHolder.price            = (FotTextView)convertView.findViewById(R.id.price);
                viewHolder.discounted            = (FotTextView)convertView.findViewById(R.id.discounted);
                viewHolder.qty              = (FotTextView)convertView.findViewById(R.id.qty);
                viewHolder.img              = (CircularImageView)convertView.findViewById(R.id.img);
                convertView.setTag(viewHolder);
            }
            else
            {
                viewHolder 					= (ViewHolderItem) convertView.getTag();
            }


            final JSONObject productObj     = list.getJSONObject(paramInt);

            Log.d("orsers", productObj.toString());

            viewHolder.product.setText(productObj.getString("title"+defaultLang));

            if(!productObj.getString("product_cost").equals(productObj.getString("orignal_price")))
            {
                viewHolder.discounted.setVisibility(View.VISIBLE);
                viewHolder.price.setPaintFlags(viewHolder.price.getPaintFlags() | Paint.STRIKE_THRU_TEXT_FLAG);
                viewHolder.price.setText(DEF_CURRENCY+productObj.getString("orignal_price"));
                viewHolder.price.setTextColor(context.getResources().getColor(R.color.red));
                viewHolder.discounted.setText(DEF_CURRENCY+productObj.getString("product_cost"));
                viewHolder.discounted.setTextColor(context.getResources().getColor(R.color.green));
            }
            else
            {
                viewHolder.single_total.setPaintFlags(viewHolder.price.getPaintFlags() & (~ Paint.STRIKE_THRU_TEXT_FLAG));
                viewHolder.discounted.setVisibility(View.GONE);
                viewHolder.price.setVisibility(View.VISIBLE);
                viewHolder.price.setText(DEF_CURRENCY+productObj.getString("product_cost"));
                viewHolder.price.setTextColor(context.getResources().getColor(R.color.green));
            }

            viewHolder.single_total.setText(DEF_CURRENCY+function.round2decimal(Float.parseFloat(productObj.getString("qty_total"))));
            viewHolder.qty.setText(productObj.getString("qty"));
            final CircularImageView img     = viewHolder.img;

            Glide.with(context)
                    .load(productObj.getString("images"))
                    .placeholder(R.mipmap.ic_launcher)
                    .into(new GlideDrawableImageViewTarget(viewHolder.img) {
                        @Override
                        public void onResourceReady(GlideDrawable resource, GlideAnimation<? super GlideDrawable> animation) {
                            super.onResourceReady(resource, animation);
                            viewHolder.img.setImageDrawable(resource);
                        }

                        @Override
                        public void onLoadFailed(Exception e, Drawable errorDrawable) {}
                    });
        }
        catch (Exception e) {
            e.printStackTrace();
        }

        return convertView;
    }
}