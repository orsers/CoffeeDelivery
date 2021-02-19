package com.satatech.deliveryapp_coffee;

import android.content.Intent;
import android.graphics.Color;
import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.TextView;

import com.balram.library.FotButton;
import com.github.mikephil.charting.animation.Easing;
import com.github.mikephil.charting.charts.PieChart;
import com.github.mikephil.charting.data.PieData;
import com.github.mikephil.charting.data.PieDataSet;
import com.github.mikephil.charting.data.PieEntry;
import com.github.mikephil.charting.utils.ColorTemplate;
import com.satatech.deliveryapp_coffee.Adapters.OrdersStatusAdapter;
import com.satatech.deliveryapp_coffee.utils.EndlessAdapter;
import com.satatech.deliveryapp_coffee.utils.FetchDataTask;
import com.satatech.deliveryapp_coffee.utils.IItemsReadyListener;

import org.json.JSONObject;

import java.util.ArrayList;

import pl.droidsonroids.gif.GifImageView;

public class DashActivity extends BaseActivity {

    PieChart pieChart;
    int deliver,accept,pending;
    ArrayList<JSONObject> list;
    GifImageView loader;
    EndlessLoading adapter;
    FotButton but;
    TextView noOrder;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_dash);
        pieChart = findViewById(R.id.piechart_1);
        loader = findViewById(R.id.loader2);
        pieChart.setVisibility(View.GONE);
        loader.setVisibility(View.VISIBLE);
        noOrder = findViewById(R.id.noOrders);
        noOrder.setVisibility(View.GONE);
        findViewById(R.id.refresh).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                recreate();
            }
        });

        but = findViewById(R.id.showorders);
        but.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent i = new Intent(DashActivity.this, OrdersActivity.class);
                i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                callActivity(DashActivity.this,i);
                DashActivity.this.finish();
            }
        });
        but.setVisibility(View.GONE);
        list = new ArrayList<>();
        getData();
    }

    private void getData() {
        deliver = 0;
        accept = 0;
        pending = 0;
        adapter = new EndlessLoading();
        adapter.cacheInBackground();
    }

    class EndlessLoading extends EndlessAdapter implements IItemsReadyListener {
        EndlessLoading()
        {
            super(getBaseActivity(),new OrdersStatusAdapter(DashActivity.this, list), R.layout.row_orders);
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
                    JSONObject jobjGlobal 						= d.get(i);
                    Log.d("orsers",jobjGlobal.toString());
                    if(jobjGlobal.getString("status").equals("2") && jobjGlobal.getString("del_accepted").equals("0"))
                        pending++;
                    else if(jobjGlobal.getString("status").equals("2") && jobjGlobal.getString("del_accepted").equals("1"))
                        accept++;
                    else if(jobjGlobal.getString("status").equals("4"))
                        deliver++;
                }catch (Exception e){}
            }
            if (pending==0 && accept==0 && deliver==0){
                pieChart.setVisibility(View.GONE);
                but.setVisibility(View.GONE);
                loader.setVisibility(View.GONE);
                noOrder.setVisibility(View.VISIBLE);
            }
            else{
                setPieChart();
            }
        }

        @Override
        protected void appendCachedData() {

        }
    }

    public void setPieChart() {
        pieChart.setVisibility(View.VISIBLE);
        but.setVisibility(View.VISIBLE);
        loader.setVisibility(View.GONE);
//        this.pieChart = pieChart;
        pieChart.setUsePercentValues(true);
        pieChart.getDescription().setEnabled(false);
        pieChart.setExtraOffsets(5,10,5,5);
        pieChart.setDragDecelerationFrictionCoef(0.9f);
        pieChart.setTransparentCircleRadius(61f);
        pieChart.setHoleColor(Color.WHITE);
        pieChart.animateY(5000, Easing.EasingOption.EaseInOutCubic);
        ArrayList<PieEntry> yValues = new ArrayList<>();
        yValues.add(new PieEntry(deliver,"Delivered"));
        yValues.add(new PieEntry(accept,"Accepted"));
        yValues.add(new PieEntry(pending,"Pending"));

        PieDataSet dataSet = new PieDataSet(yValues, "Orders Status");
                dataSet.setSliceSpace(3f);
        dataSet.setSelectionShift(5f);
        dataSet.setColors(ColorTemplate.COLORFUL_COLORS);
        PieData pieData = new PieData((dataSet));
        pieData.setValueTextSize(10f);
        pieData.setValueTextColor(Color.YELLOW);
        pieChart.setData(pieData);
        //PieChart Ends Here
    }
}
