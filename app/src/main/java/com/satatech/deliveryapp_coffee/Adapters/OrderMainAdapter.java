package com.satatech.deliveryapp_coffee.Adapters;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.Dialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.icu.text.RelativeDateTimeFormatter;
import android.net.Uri;
import android.os.AsyncTask;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.RelativeLayout;
import android.widget.Toast;
import com.balram.library.FotButton;
import com.balram.library.FotTextView;
import com.github.ornolfr.ratingview.RatingView;
import com.satatech.deliveryapp_coffee.R;
import com.satatech.deliveryapp_coffee.utils.ConnectionClass;
import com.satatech.deliveryapp_coffee.utils.Constants;
import com.satatech.deliveryapp_coffee.utils.Functions;
import com.satatech.deliveryapp_coffee.utils.SharePrefsEntry;
import org.json.JSONArray;
import org.json.JSONObject;
import java.util.List;

import static com.satatech.deliveryapp_coffee.utils.Constants.DEF_CURRENCY;

public class OrderMainAdapter extends RecyclerView.Adapter<OrderMainAdapter.ViewHolder>{


    List<JSONObject> items;
    Dialog details;
    Activity context;
    Functions function;
    ConnectionClass cc;
    SharePrefsEntry sp;
    String status;

    public OrderMainAdapter(Activity context, List<JSONObject> items, String s) {
        this.items = items;
        details             = new Dialog(context,android.R.style.Theme_Translucent_NoTitleBar);
        details.setCanceledOnTouchOutside(false);
        details.setCancelable(true);
        details.setContentView(R.layout.dialog_order_details);
        this.context = context;
        cc   =  new ConnectionClass(context);
        sp   =  new SharePrefsEntry(context);
        status = s;
    }

    @Override
    public OrderMainAdapter.ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.row_orders,parent,false);
        return new OrderMainAdapter.ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(OrderMainAdapter.ViewHolder holder, final int position) {
        try {
            holder.name.setText(items.get(position).getString("username"));
            holder.address.setText(items.get(position).getJSONObject("store_details").getString("address"));
            holder.orderid.setText(items.get(position).getString("orderid"));
                holder.qty.setText(items.get(position).getString("qty"));
            holder.mark_accepted.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    showOrderDetails(items.get(position), context);
                }
            });

        }catch (Exception e){}
    }

    void changeOrderStatus(final int type, final JSONObject jsonObject){
        new AsyncTask<Void,Void,String>()
        {
            @Override
            protected String doInBackground(Void... voids) {
                String res  = null;
                try
                {
                    JSONObject jobj         = new JSONObject();
                    jobj.put("myid",sp.getUid());
                    jobj.put("orderid",jsonObject.getString("orderid"));
                    jobj.put("type",type);
                    jobj.put("caller","changeOrderStatus");

                    String encrypted        = cc.getEncryptedString(jobj.toString());
                    res                     = cc.sendPostData(encrypted,null);

                }catch (Exception e){
                    e.printStackTrace();
                }
                return res;
            }


            @Override
            protected void onPostExecute(String paramString) {
                super.onPostExecute(paramString);
                try
                {
                    JSONObject jobj = new JSONObject(paramString);
                    Toast.makeText(context, jobj.getString("message"), Toast.LENGTH_SHORT).show();
                    details.dismiss();
                    context.recreate();
                }catch (Exception e){
                    Toast.makeText(context, context.getString(R.string.error_network), Toast.LENGTH_SHORT).show();
                }
            }

        }.executeOnExecutor(AsyncTask.THREAD_POOL_EXECUTOR);
    }

    void showOrderDetails(final JSONObject jsonObject, final Activity context){
        try
        {
            FotTextView orderid          = (FotTextView)details.findViewById(R.id.orderid);
            FotTextView ordered_date     = (FotTextView)details.findViewById(R.id.dated);
            FotTextView usrName          = (FotTextView)details.findViewById(R.id.usrname);
            FotTextView locationname     = (FotTextView)details.findViewById(R.id.locationname);
            FotTextView deltime          = (FotTextView)details.findViewById(R.id.deliverytime);
            FotTextView deliverycost     = (FotTextView)details.findViewById(R.id.deliverycost);
            FotTextView totcost          = (FotTextView)details.findViewById(R.id.totcost);
            FotTextView qty              = (FotTextView)details.findViewById(R.id.itemcount);
            FotTextView deldate          = (FotTextView)details.findViewById(R.id.deliverydate);
            FotButton location           = (FotButton)details.findViewById(R.id.location);
            FotButton callstore          = (FotButton)details.findViewById(R.id.callstore);
            FotButton acceptorder        = (FotButton)details.findViewById(R.id.acceptOrder);
            FotTextView total            = (FotTextView)details.findViewById(R.id.total);
            ListView itemslv             = (ListView)details.findViewById(R.id.itemslv);
            RatingView usrrated          = (RatingView)details.findViewById(R.id.usrrated);
            RelativeLayout coupondiscount= details.findViewById(R.id.coupondiscount);
            FotTextView couponValue            = (FotTextView)details.findViewById(R.id.couponValue);
            coupondiscount.setVisibility(View.GONE);
            usrrated.setRating(0f);
            OrdersProductsAdapter oAdap  = new OrdersProductsAdapter(context,new JSONArray(jsonObject.getString("details")));
            itemslv.setAdapter(oAdap);
            float netTotal               = 0;
            JSONArray jsonArray     = new JSONArray(jsonObject.getString("details"));
            JSONObject jobj         = jsonArray.getJSONObject(0);
//            Log.d("orsers", jsonObject.toString());
            String uName            = jsonObject.getJSONObject("store_details").getString("title_en");
            String addNameData      = context.getString(R.string.location_name)+" : "+ jsonObject.getJSONObject("store_details").getString("address");
            String addName          = context.getString(R.string.delivery_location)+" : "+jsonObject.getJSONObject("address").getString("address");
            usrName.setText(uName);
            if(!jsonObject.getString("delid").equals("0"))
            {
                String delTiming[] = jsonObject.getString("deliverytime").split(" ");
                location.setText(addName);
                locationname.setText(addNameData);
                if (jsonObject.getInt("del_type") == 3){
                    deldate.setText("Pickup");
                    deltime.setVisibility(View.GONE);
                }
                else if (jsonObject.getInt("del_type") == 2){
                    deldate.setText("Deliver Now");
                    deltime.setVisibility(View.GONE);
                }
                else{
                    deldate.setText(context.getString(R.string.order_delivery_date)+" "+delTiming[0]);
                    deltime.setText(" "+delTiming[1]);
                    deltime.setVisibility(View.VISIBLE);
                }

                deldate.setVisibility(View.VISIBLE);
                location.setVisibility(View.VISIBLE);
                locationname.setVisibility(View.VISIBLE);
            }
            else
            {
                deldate.setVisibility(View.GONE);
                deltime.setVisibility(View.GONE);
                location.setVisibility(View.GONE);
                locationname.setVisibility(View.GONE);
            }
            if (Float.parseFloat(jsonObject.getString("deliverycost")) == 0){
                deliverycost.setText(R.string.free);
            }
            else {
                deliverycost.setText(DEF_CURRENCY+jsonObject.getString("deliverycost"));
            }
            netTotal = Float.parseFloat(jsonObject.getString("deliverycost")) + Float.parseFloat(jsonObject.getString("total"));
            if (Float.parseFloat(jsonObject.getString("coupon_discount")) > 0){
                netTotal = Float.parseFloat(jsonObject.getString("deliverycost")) + (Float.parseFloat(jsonObject.getString("total")) * ((100 - Float.parseFloat(jsonObject.getString("coupon_discount")))/100));
                coupondiscount.setVisibility(View.VISIBLE);
                couponValue.setText(jsonObject.getString("coupon_discount") + "%");
            }
            totcost.setText(DEF_CURRENCY+String.valueOf(netTotal));
            total.setText(DEF_CURRENCY+jsonObject.getString("total"));
            location.setText(context.getString(R.string.delivery_location)+" : "+jsonObject.getJSONObject("address").getString("address"));

            callstore.setText(jsonObject.getString("phonenumber"));
            orderid.setText(jsonObject.getString("orderid"));
            ordered_date.setText(context.getString(R.string.order_ordered_date)+" "+jsonObject.getString("dated"));
            qty.setText(context.getString(R.string.order_qty)+" "+jsonObject.getString("itemcount"));
            callstore.setVisibility(View.VISIBLE);

            callstore.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    try
                    {
                        Intent callIntent       = new Intent(Intent.ACTION_CALL);
                        callIntent.setData(Uri.parse("tel:" + jsonObject.getString("phonenumber")));
                        context.startActivity(callIntent);
                    }catch (Exception e){
                        e.printStackTrace();
                    }

                }
            });

            acceptorder.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    if (status.equals(Constants.ACCEPTED)){
                        AlertDialog.Builder builder = new AlertDialog.Builder(context);
                        DialogInterface.OnClickListener dialogClickListener1 = new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                switch (which){
                                    case DialogInterface.BUTTON_POSITIVE:
                                        changeOrderStatus(2, jsonObject);
                                        break;
                                    case DialogInterface.BUTTON_NEGATIVE:
                                        break;
                                }
                            }
                        };
                        builder.setMessage("Have You Delivered Order?").setPositiveButton("Yes", dialogClickListener1)
                                .setNegativeButton("No", dialogClickListener1).show();
                    }
                    else if (status.equals(Constants.NEW)){
                        AlertDialog.Builder builder = new AlertDialog.Builder(context);
                        DialogInterface.OnClickListener dialogClickListener = new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                switch (which){
                                    case DialogInterface.BUTTON_POSITIVE:
                                        changeOrderStatus(1, jsonObject);
                                        break;

                                    case DialogInterface.BUTTON_NEGATIVE:
                                        changeOrderStatus(0, jsonObject);
                                        break;
                                }
                            }
                        };
                        builder.setMessage("Accept or Reject Order").setPositiveButton("Accept", dialogClickListener)
                                .setNegativeButton("Reject", dialogClickListener).show();
                    }
                }
            });

            location.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    try
                    {
//                        Log.d("orsers", jsonObject.toString());
                        Uri.Builder builder = new Uri.Builder();
                        builder.scheme("https")
                                .authority("www.google.com").appendPath("maps").appendPath("dir").appendPath("").appendQueryParameter("api", "1")
                                .appendQueryParameter("origin", Double.parseDouble(jsonObject.getJSONObject("store_details").getString("latitude")) + "," + Double.parseDouble(jsonObject.getJSONObject("store_details").getString("longitude")))
                                .appendQueryParameter("destination", Double.parseDouble(jsonObject.getJSONObject("address").getString("latitude")) + "," + Double.parseDouble(jsonObject.getJSONObject("address").getString("longitude")) );
                        String url = builder.build().toString();
                        Log.d("Directions", url);
                        Intent i = new Intent(Intent.ACTION_VIEW);
                        i.setData(Uri.parse(url));
                        context.startActivity(i);
                    }catch (Exception e){
                        e.printStackTrace();
                    }

                }
            });

            if (status.equals(Constants.DELIVERED)){
                acceptorder.setVisibility(View.GONE);
            }
            else if (status.equals(Constants.ACCEPTED)){
                acceptorder.setVisibility(View.VISIBLE);
                acceptorder.setText(R.string.delivered);
            }else if (status.equals(Constants.NEW)){
                acceptorder.setVisibility(View.VISIBLE);
                acceptorder.setText(R.string.accept);
            }
            else if (status.equals(Constants.ALL)){
                acceptorder.setVisibility(View.GONE);
            }
            details.show();
        }catch (Exception e){
            e.printStackTrace();
        }
    }

    @Override
    public int getItemCount() {
        return items.size();
    }

    public class ViewHolder extends RecyclerView.ViewHolder{
        public FotTextView name;
        public FotTextView orderid;
        public FotTextView qty;
        public FotTextView address;
        public FotButton mark_accepted;
        public ImageView img;

        public ViewHolder(View itemView) {
            super(itemView);
            name = itemView.findViewById(R.id.name);
            orderid = itemView.findViewById(R.id.orderId);
            qty = itemView.findViewById(R.id.qty);
            address = itemView.findViewById(R.id.address);
            mark_accepted = itemView.findViewById(R.id.mark_accepted);
            img = itemView.findViewById(R.id.img);
        }
    }

}
