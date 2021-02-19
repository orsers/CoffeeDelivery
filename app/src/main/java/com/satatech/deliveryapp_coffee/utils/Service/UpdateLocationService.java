package com.satatech.deliveryapp_coffee.utils.Service;

import android.app.Service;
import android.content.Context;
import android.content.Intent;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.IBinder;
import android.os.Looper;
import android.util.Log;

import com.satatech.deliveryapp_coffee.utils.ConnectionClass;

import org.json.JSONObject;
import java.util.Timer;
import java.util.TimerTask;

import static com.satatech.deliveryapp_coffee.BaseActivity.sp;

public class UpdateLocationService extends Service {

    private final int INTERVAL = 5 * 60 * 1000;
    private Timer timer = new Timer();
    static String latitude, longitude;
    protected LocationManager locationManager;
    private ConnectionClass cc;
    LocationListener locationListener;

    @Override
    public IBinder onBind(Intent intent) {
        // TODO Auto-generated method stub
        return null;
    }

    @Override
    public void onCreate() {
        // TODO Auto-generated method stub
        super.onCreate();
        locationManager = (LocationManager) getSystemService(Context.LOCATION_SERVICE);
        locationListener = new LocationListener() {
            @Override
            public void onLocationChanged(Location location) {
                latitude = String.valueOf(location.getLatitude());
                longitude = String.valueOf(location.getLongitude());
//                Log.d("orsers", latitude + longitude);
            }

            @Override
            public void onStatusChanged(String provider, int status, Bundle extras) {

            }

            @Override
            public void onProviderEnabled(String provider) {

            }

            @Override
            public void onProviderDisabled(String provider) {

            }
        };
        updateLocation();
    }

    @Override
    public int onStartCommand(Intent intent, int flags, int startId) {
        timer.scheduleAtFixedRate(new TimerTask() {
            @Override
            public void run() {
                if (Looper.myLooper() == null){
                    Looper.prepare();
                }
                cc = new ConnectionClass(getBaseContext());
                if(latitude !=null && longitude != null){
                    new AsyncTask<Void,Void,String>()
                    {
                        @Override
                        protected String doInBackground(Void... voids) {
                            String res  = null;
                            try
                            {
                                JSONObject jobj         = new JSONObject();
                                jobj.put("latitude",latitude);
                                jobj.put("longitude",longitude);
                                jobj.put("myid", sp.getUid());
                                jobj.put("caller","updateMyLocation");
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
                        }

                        @Override
                        protected void onPreExecute() {
                            super.onPreExecute();
                            updateLocation();
                        }
                    }.executeOnExecutor(AsyncTask.THREAD_POOL_EXECUTOR);
                }
            }
        }, 0, INTERVAL);
        return super.onStartCommand(intent, flags, startId);
    }


    @Override
    public void onDestroy() {
        // Display the Toast Message
        if (timer != null) {
            timer.cancel();
        }
        super.onDestroy();
    }

    void updateLocation(){
        locationManager.requestLocationUpdates(LocationManager.GPS_PROVIDER, 0, 0, locationListener);
        locationManager.requestLocationUpdates(LocationManager.NETWORK_PROVIDER, 0,0, locationListener);
    }
}
