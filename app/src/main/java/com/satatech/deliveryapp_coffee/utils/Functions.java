package com.satatech.deliveryapp_coffee.utils;

import android.app.ActivityManager;
import android.app.AlertDialog;
import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.res.Resources;
import android.graphics.Bitmap;
import android.graphics.Canvas;
import android.graphics.RectF;
import android.support.v4.content.LocalBroadcastManager;
import android.util.Base64;
import android.util.DisplayMetrics;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageView;

import com.satatech.deliveryapp_coffee.R;

import org.json.JSONArray;
import org.json.JSONObject;

import java.text.DecimalFormat;
import java.text.DecimalFormatSymbols;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Locale;
import java.util.Set;

import static android.graphics.Bitmap.createBitmap;
import static com.satatech.deliveryapp_coffee.BaseActivity.appLog;
import static com.satatech.deliveryapp_coffee.BaseActivity.globalLog;
import static com.satatech.deliveryapp_coffee.utils.Constants.ITEM_DELETED;

/**
 * Created by mac on 15/10/2017.
 */

public class Functions {

    Context context;
    Dialog dialog;
    public Functions(Context con)
    {
        context = con;
    }


    public void showDialog()
    {
        try
        {
            dialog = new Dialog(context,android.R.style.Theme_Translucent_NoTitleBar);
            dialog.setContentView(R.layout.dialog_loader);
            dialog.setCancelable(false);
            dialog.show();
        }catch (Exception e){
            e.printStackTrace();
        }

    }

    public void dismissDialog()
    {
        try{dialog.dismiss();}catch (Exception e){e.printStackTrace();}
    }

    public int[] getKeys(JSONObject jsonObject)
    {
            int returnArray[]       = new int[]{0,0,0,0,0};
            String keyarray[]       = new String[]{"id","storeid","locid","catid","subcatid"};

            for(int i=0;i<returnArray.length;i++)
            {
                try{returnArray[i]  = Integer.parseInt(jsonObject.getString(keyarray[i]));}catch (Exception e){}
            }

            return returnArray;
    }

    public String createKeyHashCat(int[] ids)
    {
        String key              = ids[2]+"@@"+ids[1]+"@@"+ids[3];
        return key;
    }

    public String createKeyHash(int[] ids)
    {
        String key              = ids[2]+"@@"+ids[1]+"@@"+ids[3]+"@@"+ids[4];
        return key;
    }

    public String createProductKey(int[] ids)
    {
        String key              = ids[0]+"@@"+ids[2]+"@@"+ids[1]+"@@"+ids[3]+"@@"+ids[4];
        return key;
    }



    public String createProductKey(String storeid,String locid,int productid,String catid,String subcatid)
    {
        String key              = productid+"@@"+locid+"@@"+storeid+"@@"+catid+"@@"+subcatid;
        return key;
    }






    public Bitmap scaleCenterCrop(Bitmap bmp,int newHeight, int newWidth) {
        int sourceWidth = bmp.getWidth();
        int sourceHeight = bmp.getHeight();

        // Compute the scaling factors to fit the new height and width, respectively.
        // To cover the final image, the final scaling will be the bigger
        // of these two.
        float xScale = (float) newWidth / sourceWidth;
        float yScale = (float) newHeight / sourceHeight;
        float scale = Math.max(xScale, yScale);

        // Now get the size of the source bitmap when scaled
        float scaledWidth = scale * sourceWidth;
        float scaledHeight = scale * sourceHeight;

        // Let's find out the upper left coordinates if the scaled bitmap
        // should be centered in the new size give by the parameters
        float left = (newWidth - scaledWidth) / 2;
        float top = (newHeight - scaledHeight) / 2;

        // The target rectangle for the new, scaled version of the source bitmap will now
        // be
        RectF targetRect = new RectF(left, top, left + scaledWidth, top + scaledHeight);

        // Finally, we create a new bitmap of the specified size and draw our new,
        // scaled bitmap onto it.
        Bitmap dest = createBitmap(newWidth, newHeight, bmp.getConfig());
        Canvas canvas = new Canvas(dest);
        canvas.drawBitmap(bmp, null, targetRect, null);

        return dest;
    }




    public float dpToPx(int v)
    {
        Resources resources         = context.getResources();
        DisplayMetrics metrics      = resources.getDisplayMetrics();
        float px                    = v * ((float)metrics.densityDpi / DisplayMetrics.DENSITY_DEFAULT);
        return px;
    }

    public void logout()
    {
        DialogInterface.OnClickListener dialogClickListener = new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                switch (which){
                    case DialogInterface.BUTTON_POSITIVE:
                        ((ActivityManager) context.getSystemService(Context.ACTIVITY_SERVICE)).clearApplicationUserData();
                        break;

                    case DialogInterface.BUTTON_NEGATIVE:
                        //No button clicked
                        break;
                }
            }
        };

        AlertDialog.Builder builder = new AlertDialog.Builder(context);
        builder.setMessage(context.getString(R.string.logout_from_app)).setPositiveButton(context.getString(R.string.yes), dialogClickListener)
                .setNegativeButton(context.getString(R.string.no), dialogClickListener).show();

    }

    public String getCostString(String dt , JSONArray costArray)
    {
        try
        {
            SimpleDateFormat format         = new SimpleDateFormat("dd-MM-yyyy HH:mm:ss");
            Date date                       = format.parse(dt);
            String cost                     = getCost(date,costArray);
            appLog("datedobjec :: date "+date+" -- "+dt+" -- "+cost);
            return cost;
        }catch (Exception e){
            e.printStackTrace();
        }

        return "--";
    }

    public String getCost(Date dated, JSONArray costArray)
    {
        try
        {
            long currTime               = System.currentTimeMillis();
            int minTime                 = 0;
            int maxTime                 = 0;
            long minTime2               = 0;
            long maxTime2               = 0;
            JSONObject jobj2            = null;
            float diff                  = (dated.getTime() - currTime);
            for(int j=0;j<costArray.length();j++)
            {
                jobj2                   = costArray.getJSONObject(j);

                minTime                 = Integer.parseInt(jobj2.getString("mintime"));
                minTime2                = minTime * 60 * 60 * 1000;


                maxTime                 = Integer.parseInt(jobj2.getString("maxtime"));
                maxTime2                = maxTime * 60 * 60 * 1000;


                if(diff >= minTime2 && diff < maxTime2 )
                {
                    float dde           = diff/(1000 * 60 * 60);
                    String abc          = jobj2.getString("cost");
                    appLog("timing :: "+abc+" -- "+minTime+" -- "+maxTime+" -- "+dde);
                    return abc;
                }

            }
        }catch (Exception e){
            e.printStackTrace();
        }

        return "0.00";

    }

    public float round2decimal(float nTotal) {
        nTotal                   = nTotal*100;
        nTotal                   = Math.round(nTotal);
        nTotal                   = nTotal /100;

        return  nTotal;
    }
}
