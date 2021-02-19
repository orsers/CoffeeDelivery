package com.satatech.deliveryapp_coffee.Adapters;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.Dialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.net.Uri;
import android.os.AsyncTask;
import android.support.v4.content.LocalBroadcastManager;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListView;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import com.balram.library.FotButton;
import com.balram.library.FotTextView;
import com.github.ornolfr.ratingview.RatingView;
import com.satatech.deliveryapp_coffee.R;
import com.satatech.deliveryapp_coffee.utils.ConnectionClass;
import com.satatech.deliveryapp_coffee.utils.Functions;
import com.satatech.deliveryapp_coffee.utils.SharePrefsEntry;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;



public class OrdersStatusAdapter extends ArrayAdapter<JSONObject>
{
    ArrayList<JSONObject>    list = new ArrayList<JSONObject>();

    public OrdersStatusAdapter(Activity con, ArrayList<JSONObject> l)
    {
        super(con, R.layout.row_orders);
    }

    @Override
    public int getCount() {
        return list.size();
    }


    @Override
    public View getView(final int paramInt, View convertView, ViewGroup parent)
    {

        return convertView;
    }

}