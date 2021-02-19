package com.satatech.deliveryapp_coffee;

import android.content.Intent;
import android.graphics.Color;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.View;
import android.widget.ImageView;

import com.balram.library.FotTextView;
import com.satatech.deliveryapp_coffee.Adapters.OrderMainAdapter;
import com.satatech.deliveryapp_coffee.Adapters.OrdersStatusAdapter;
import com.satatech.deliveryapp_coffee.utils.Constants;
import com.satatech.deliveryapp_coffee.utils.EndlessAdapter;
import com.satatech.deliveryapp_coffee.utils.FetchDataTask;
import com.satatech.deliveryapp_coffee.utils.IItemsReadyListener;
import com.satatech.deliveryapp_coffee.utils.Service.UpdateLocationService;

import org.json.JSONObject;

import java.util.ArrayList;

import pl.droidsonroids.gif.GifImageView;

public class OrdersActivity extends BaseActivity {

    public ArrayList<JSONObject> list           = new ArrayList<JSONObject>();
    public ArrayList<JSONObject> listAccepted           = new ArrayList<JSONObject>();
    public ArrayList<JSONObject> listAll           = new ArrayList<JSONObject>();
    public ArrayList<JSONObject> listDelivered           = new ArrayList<JSONObject>();
    GifImageView loader;
    EndlessLoading adapter;
    RecyclerView listView;
    OrderMainAdapter adapterNew, adapterAccepted, adapterDelivered, adapterAll;
    ImageView reload;
    FotTextView tabs[]      = new FotTextView[4];

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_orders);
        loader              = (GifImageView) findViewById(R.id.loader);
        reload              = findViewById(R.id.refresh);
        listView            = findViewById(R.id.listview2);
        tabs[0]             = (FotTextView) findViewById(R.id.neworders);
        tabs[1]             = (FotTextView) findViewById(R.id.accepted);
        tabs[2]             = (FotTextView) findViewById(R.id.delivered);
        tabs[3]             = (FotTextView) findViewById(R.id.allOrders);
        listView.setLayoutManager(new LinearLayoutManager(getBaseContext()));
        startService(new Intent(getBaseContext(), UpdateLocationService.class));
        adapterNew          = new OrderMainAdapter(this,list, Constants.NEW);
        adapterAccepted     = new OrderMainAdapter(this,listAccepted,Constants.ACCEPTED);
        adapterDelivered        = new OrderMainAdapter(this,listDelivered,Constants.DELIVERED);
        adapterAll   = new OrderMainAdapter(this,listAll,Constants.ALL);
        adapterNew.notifyDataSetChanged();

        for(int i=0;i<tabs.length;i++)
        {
            tabs[i].setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    int tag =  Integer.parseInt(v.getTag().toString());
                    selectTab(tag);
                }
            });
        }

        reload.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                recreate();
            }
        });
        getOrders();
        selectTab(0);
    }

    void selectTab(int j)
    {
        for(int i=0;i<tabs.length;i++)
        {
            if(i == j)
            {
                tabs[i].setBackgroundResource(R.drawable.rounded_cat_selected);
                tabs[i].setTextColor(Color.WHITE);
                if(i == 0)
                    listView.setAdapter(adapterNew);
                else if(i == 1)
                    listView.setAdapter(adapterAccepted);
                else if(i == 2)
                    listView.setAdapter(adapterDelivered);
                else if(i == 3)
                    listView.setAdapter(adapterAll);
            }
            else
            {
                tabs[i].setBackgroundResource(R.drawable.rounded_cat_unselected);
                tabs[i].setTextColor(getResources().getColor(R.color.orange));
            }
        }

    }

    private void getOrders() {
       adapter = new EndlessLoading();
       listView.setAdapter(adapterNew);
       list.clear();
       adapter.cacheInBackground();
    }

    void notifyDataSet(){
        adapterNew.notifyDataSetChanged();
        adapterAccepted.notifyDataSetChanged();
        adapterAll.notifyDataSetChanged();
        adapterDelivered.notifyDataSetChanged();
    }


    class EndlessLoading extends EndlessAdapter implements IItemsReadyListener {
        JSONObject jobjGlobal;

        EndlessLoading()
        {
            super(getBaseActivity(),new OrdersStatusAdapter(OrdersActivity.this, list), R.layout.row_orders);
        }

        @Override
        protected boolean cacheInBackground(){

            try
            {
                JSONObject jobj         = new JSONObject();
                jobj.put("myid",getSharePrefs().getUid());
                jobj.put("type",4);
                jobj.put("caller","getDelOrders");
                appLog("broadcast :: "+jobj);
                String encrypted        = getConnection().getEncryptedString(jobj.toString());
                FetchDataTask fetchs = new FetchDataTask(getBaseActivity(),this,list.size(),encrypted);
                fetchs.executeOnExecutor(AsyncTask.THREAD_POOL_EXECUTOR);
            }catch (Exception e){
                e.printStackTrace();
            }

            return true;
        }

        @Override
        public void onItemsReady(ArrayList<JSONObject> d) {
            loader.setVisibility(View.GONE);
            for(int i=0;i<d.size();i++)
            {
                try
                {
                    jobjGlobal 						= d.get(i);
//                    Log.d("orsers",jobjGlobal.toString());
                    if(jobjGlobal.getString("status").equals("2") && jobjGlobal.getString("del_accepted").equals("0"))
                        list.add(jobjGlobal);
                    else if(jobjGlobal.getString("status").equals("2") && jobjGlobal.getString("del_accepted").equals("1"))
                        listAccepted.add(jobjGlobal);
                    else if(jobjGlobal.getString("status").equals("4") || jobjGlobal.getString("status").equals("6"))
                        listDelivered.add(jobjGlobal);

                    listAll.add(jobjGlobal);
                }catch (Exception e){}
            }
            notifyDataSet();
        }

        @Override
        protected void appendCachedData() {

        }
    }
}
