package com.satatech.deliveryapp_coffee.utils;

import android.content.Context;
import android.os.AsyncTask;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;


public class FetchDataTask extends AsyncTask<Void, Void, ArrayList<JSONObject>> {
    IItemsReadyListener listener;
    int startPoint;
    String data;
    ConnectionClass cc;
    Context context;


    public FetchDataTask(Context ctx, IItemsReadyListener listener, int startPoint , String u) {
        context             =ctx;
        this.listener       =listener;
        this.startPoint     =startPoint;
        data            =u;
        cc                  =new ConnectionClass(context);
    }

    @Override
    public ArrayList<JSONObject> doInBackground(Void... params) {
        ArrayList<JSONObject> result    = new ArrayList<JSONObject>();
        try
        {
            String res          = cc.sendPostData(data,null);
            JSONArray data = new JSONArray(res);
            for (int i = 0; i < data.length(); i++) {
                result.add(data.getJSONObject(i));
            }

        }catch(Exception e){
            e.printStackTrace();
        }
        return(result);
    }

    @Override
    public void onPostExecute(ArrayList<JSONObject> result) {
        listener.onItemsReady(result);
    }

}
