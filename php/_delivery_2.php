<?php
ini_set("display_errors", "1");
error_reporting(E_ERROR);

ini_set('date.timezone', 'Asia/Riyadh');

define("SERVER_URL", "http://touran.sa/watch2you/");
define("CATEGORIES_BASE", "images/categories/");
define("STORE_BASE", "images/stores/");
define("ITEMS_BASE", "images/products/");
define("LOC_IMAGE", "images/locations/");
define("NOIMG", "no_image.gif");
define("AVATAR_PATH", "images/");
define("IMG_URL", SERVER_URL . "");
define("THRESHOLD_MILES", 40);
define("DEL_STOREID","1");
define("DEL_LOCID","1");
define("ANDROID_KEY","AAAArnLJCa4:APA91bHTeon1MNyZJXz8I9Qvq7R_2R7i_-FU_NVitQ1C4jstuOEjgjC0pFVI9Hh19QtTdMI3vDaBx2wZrtHqk2SROU9Uu5bwyHtlcqWah4-EEdQc1GiOolga_DndMu2JRshilMD_TS3Dv7aNCiSTs3NnsZu-JqqXaw");
define("NEW_ORDER_TXT","You have new order with orderid [ORDERID]");
define("NEW_ORDER","New Order");
define("NOTIFICATION","1");

$headers = getAllheaders();
$headers = array_change_key_case($headers, CASE_LOWER);

if($headers['language'] == "ar")
{
	
	define("NEW_PASSWORD","كلمة المرور الجديدة");
	define("APP_NAME","تمويناتي");
	define("ERROR_IN_DELETION","حدث خطأ في الحذف");
	define("DELETED_SUCCESSFULLY","تمت عملية الحذف بنجاح");
	define("ERROR_IN_RATING","خطأ في المصادقة");
	define("RATED_SUCCESSFULLY","حدث خطأ في تحميل صورة الملف الشخصي الى الخادم");
	define("USERNAME_TAKEN","اسم المستخدم موجود مسبقا");
	define("USERNAME_AVAILABLE","اسم المستخدم متاح");
	define("SERVER_DOWN","الخوادم لا تعمل الآن يرجى إعادة المحاولة");
	define("ERROR_IN_LOGIN","فشل في عملية الدخول،تأكد من صحة اسم المستخدم وكلمة المرور");
	define("PASSWORD_EMAILED"," تم تغيير كلمة المرور بنجاح، التعليمات تم ارسالها إلى بريدك الالكتروني");
	define("EMAIL_RESET","<b>[NAME]</b><br>لقد طلبت تغيير كلمة المرور لحسابك في تمويناتي تفضل كلمة المرو الجديدة<br><b>[PASSWORD]</b><br>شكرا<br>Tamwinati Support Team");
	define("EMAIL_INCORRECT","من فضلك ادخل البريد الالكتروني الصحيح");
	define("CONTACT_ADMIN","الرجاء الاتصال بمدير النظام");	
	define("EMAIL_ALREADY_TAKEN","هذا البريد الالكتروني مستخدم");
	define("EMAIL_AVAILABLE","البريد الالكتروني متاح");
	define("REGISTRATION_SUCCESSFUL","تمت عملية التسجيل بنجاح");
	define("ERROR_IN_CREATIN_ACCOUNT","حدث خطأ في إنشاء الحساب");	
	define("AUTHENTICATION_ERROR","خطأ في المصادقة");
	define("ERROR_UPLOADING_PROFILE_PIC","حدث خطأ في تحميل الصورة");
	define("ERROR_IN_UPDATING","حدث خطأ في تحديث الملف الشخصي");
	
	define("ERROR_IN_STATUS_CHANGE","حدث خطأ في تحديث الحالة");
	
	define("DELIVERY_AWAITING_TIME_EXPIRED","التسليم في انتظار الوقت انتهت");
	define("EXPIRED","منتهية الصلاحية");
	define("ORDER_DELIVERED","أجل تسليم");
	define("DELIVERED","تم التوصيل");
}
else
{
	define("EMAIL_ALREADY_TAKEN","Email already taken");
	define("EMAIL_AVAILABLE","Email available");
	define("NEW_PASSWORD","Your new password");
	define("APP_NAME","Watch To You");
	define("EMAIL_RESET","Hello <b>[NAME]</b>,<br/> Recently you have requested to reset the password of your WatchToYou account. <br/>Here is the new password <b>[PASSWORD]</b> <br />Thanks<br /><b>mano Support Team</b>");
	define("ERROR_IN_LOGIN","Unable to login please check login credentials");
	define("PASSWORD_EMAILED","Password reset instructions have been mailed to you. Please check your email.");
	define("SERVER_DOWN","Servers are down. Please try again later.");
	define("EMAIL_INCORRECT","Please enter correct email.");
	define("CONTACT_ADMIN","Please contact admin.");
	define("ERROR_IN_DELETION","Error in deletion");
	define("DELETED_SUCCESSFULLY","Deleted successfully");
	define("ERROR_IN_RATING","Authentication error");
	define("RATED_SUCCESSFULLY","Error uploading the profile pic on server");
	define("AUTHENTICATION_ERROR","Authentication error");
	define("ERROR_UPLOADING_PROFILE_PIC","Error uploading the profile pic on server");
	define("ERROR_IN_UPDATING","Error in updating the profile");
	define("USERNAME_TAKEN","Userid already taken");
	define("USERNAME_AVAILABLE","Userid available");
	define("REGISTRATION_SUCCESSFUL","Registration successful");
	define("ERROR_IN_CREATIN_ACCOUNT","Error in creating the account");
	
	
	define("ERROR_IN_STATUS_CHANGE","Error changing status");
	//define("DELIVERY_ACCEPTED_SUCCESSFULLY","Delivery accepted"); 
	//define("DELIVERY_REJECTED","Delivery rejected"); 
	//define("REJECTED","rejected"); 
	//define("ACCEPTED","accepted"); 
	//define("DEL_REQUEST","Delivery request for [ORDERID] [STATUS] by [NAME]"); 
	define("DELIVERY_AWAITING_TIME_EXPIRED","Delivery Awaiting Time Expired");
	define("EXPIRED","expired");
	define("ORDER_DELIVERED","Order Delivered");
	define("DELIVERED","Delivered");
}



define("DELIVERY_ACCEPTED_SUCCESSFULLY","قبلت التسليم"); 
define("DELIVERY_REJECTED","رفض التسليم"); 
define("REJECTED","مرفوض"); 
define("ACCEPTED","قبلت"); 
define("DEL_REQUEST","طلب التسليم [ORDERID] [STATUS] [NAME]"); 


//////////////////////////////  receiving function /////////////////////

define("usertime", $headers['currentdate']);

$data = $_POST['txt'];
for ($i = 0; $i < 10; $i++) {
    $data = base64_decode($data);
}
$data = json_decode($data, true);
$_POST = $data;
//////////////////////////////  receiving function /////////////////////


$function = trim($_POST['caller']);


if ($function != "") {
    $controller = new controller();
    $out = $controller->$function();
    echo $out;
}

$funcEx = trim($_REQUEST['explicit_function']);
if ($funcEx) {
    $controller = new controller();
    echo $out = $controller->$funcEx();
}


class controller
{

    protected $pageQuantity = 5;


    public function __construct()
    {
        require_once("db.conn.php");
    }
    
    function login()
    {
        $email = strtolower(urldecode(trim($_POST['email'])));
        $password = md5(urldecode(trim($_POST['password'])));
        $device_type = $_POST['device_type'];
        $push_noti = $_POST['push_noti'];
        $deviceid = $_POST['deviceid'];
        $extra_info = $_POST['extra_info'];
        $emailOut = $email;

        if ($email == '' || $password == '') {
            $json['status'] = '1';
            $json['message'] = ERROR_IN_LOGIN;
            $json['success'] = 0;

            return json_encode($json);
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if (substr($email, 0, 1) !== '@')
                $email = "@" . $email;
        }

        $query = "SELECT * FROM delivery_guys where (email = '$email' or username = '$email' or email = '$emailOut' or username = '$emailOut') and password = '$password'";
        $res = mysql_query($query) or die(mysql_error());
        $data = mysql_fetch_array($res);
        unset($data['header']);
        $num = mysql_num_rows($res);
        if ($num > 0) {
            
            $update = "update delivery_guys SET push_notification='$push_noti' WHERE id='" . $data['id'] . "'";
            mysql_query($update);
            
            $time = date("Y-m-d H:i:s");
            $header = print_r($_SERVER, true);
            $appversion = $_SERVER['HTTP_USER_AGENT'];
            $sql = "update 	delivery_guys set extra_info='$extra_info',last_signin='$time',header='$header',app_version='$appversion',	device_id='$deviceid',	push_notification 	= '$push_noti',device_type 		= '$device_type' WHERE 	id = '" . $data['id'] . "'";
            mysql_query($sql);

            $query1 = "SELECT * FROM `delivery_guys` WHERE id='" . $data['id'] . "'";
            $res1 = mysql_query($query1);
            $data1 = mysql_fetch_assoc($res1);
            $num1 = mysql_num_rows($res1);
            if ($num1 == 1) {

                if ($data1['profilepic'] != "") {
                    if (!(strpos($data1['profilepic'], 'http') === 0))
                        $data1['profilepic'] = $data1['profilepic'];
                }
                
            

                $json['message'] = "";
                $json['data'] = $data1;
            } else
                $json['message'] = "";
            $json['status'] = '1';
            $json['success'] = 1;


            $title = "-1";
            $message = "-1";

            $payload = array();
            $payload['loginid'] = $data['id'];
            $payload['deviceid'] = $deviceid;

            //$rse = $this->sendNotificationToAndroid($title,$message,$payload,'',ADMIN_NOTIFICATION);
        } else {
            $json['status'] = '1';
            $json['message'] = ERROR_IN_LOGIN;
            $json['success'] = 0;
        }

		
        return json_encode($json);
        exit();
    }


    function resetPassword()
    {
        $email = trim($_POST['email']);
        $json = array();

        if (!empty($email)) {
            $sql = "select 	id, name from 	delivery_guys where 	email = '" . $email . "'";
            $query = mysql_query($sql);
            $result = mysql_fetch_assoc($query);
            $resultCount = mysql_num_rows($query);

            if ($resultCount == 1) {
                $time = substr(time(),3,6);
                $refernce_code = md5($time);


                $sql = "update 	delivery_guys set 	password 	= '" . $refernce_code . "', forgot_flag = 'Y' where id = " . $result['id'];
                mysql_query($sql);
                
                $to = $email;
                $subject = NEW_PASSWORD;
                $password = $refernce_code;
                $company_name = APP_NAME;
                $company_support = "support@touran.sa";
                $app_email_id = "";
                $message 	= str_replace(EMAIL_RESET,"[NAME]",$result['name']);
                $message	= str_replace($message,"[PASSWORD]",$time);

                $headers = 'From: ' . $company_name . ' <' . $company_support . '>' . " \r\n" .
                    'MIME-Version: 1.0' . "\r\n" .
                    'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                $mail_res = mail($to, $subject, $message, $headers);


                if ($mail_res) {
                    $json['success'] = "1";
                    $json['message'] = PASSWORD_EMAILED;
                } else {
                    $json['success'] = "0";
                    $json['message'] = SERVER_DOWN;
                }
            } else if ($resultCount == 0) {
                $json['success'] = "0";
                $json['message'] = EMAIL_INCORRECT;
            } else {
                $json['success'] = "0";
                $json['message'] = CONTACT_ADMIN;
            }



            echo json_encode($json);
        }
    }


    function ajax()
    {
        $email = strtolower(urldecode(trim($_POST['email'])));
        $myid = intval($_POST['myid']);


        $query = "SELECT id FROM delivery_guys WHERE email='$email'";
        if ($myid > 0) {

            $query = "SELECT social_type FROM delivery_guys WHERE id='$myid'";
            $res = mysql_query($res);
            $data = mysql_fetch_assoc($res);
            $soc = intval($data['social_type']);
            $query = "SELECT id FROM delivery_guys WHERE email='$email' AND id !='$myid' AND social_type='$soc'";
        }


        $res = mysql_query($query);
        $num = mysql_num_rows($res);
        $json = array();

        if ($num) {
            $json['status'] = '1';
            $json['err'] = 1;
            $json['message'] = EMAIL_ALREADY_TAKEN;
            $json['success'] = '0';
        } else {
            $json['status'] = '1';
            $json['type'] = 1;
            $json['message'] = EMAIL_AVAILABLE;
            $json['success'] = '1';
        }



        return json_encode($json);
    }
    
    
    function ajaxUsername()
    {
        $uname = trim($_POST['username']);
        $uname = trim($uname, "@");
        $uname = strtolower($uname);


        $query = "SELECT id FROM delivery_guys WHERE username='$uname' AND social_type='0'";
        $res = mysql_query($query);
        $num = mysql_num_rows($res);
        $json = array();


        if ($num && $uname != "") {
            $json['status'] = '1';
            $json['err'] = 2;
            $json['message'] = str_replace("[USERNAME]", $uname, USERNAME_TAKEN);
            $json['success'] = '0';
        } else {
            $json['status'] = '1';
            $json['type'] = 2;
            $json['message'] = str_replace("[USERNAME]", $uname, USERNAME_AVAILABLE);
            $json['success'] = '1';
        }
        return json_encode($json);
    }

	


    function register()
    {
        $json = array();
        
       
       
        //$_POST = json_decode(file_get_contents("add.txt"),true);
        $email = strtolower(trim($_POST['email']));
        $name = urldecode($_POST['name']);
        $customAdd = $_POST['customAdd'];
        $password = md5($_POST['password']);
        $device_type = $_POST['device_type'];
        $push_noti = $_POST['push_noti'];
        $mobile = $_POST['mobile'];
        $address        = json_decode($_POST['address'],true);
        $latitude       = $address['latitude'];
        $longitude      = $address['longitude'];
        $addD           = rawurlencode($address['address']);
        $addName        = rawurlencode($address['name']);
        
        
        
    

        $query = "SELECT id FROM delivery_guys WHERE email='$email'";
        $res = mysql_query($query);
        $num = mysql_num_rows($res);
        if ($num) {
            $json['status'] = '1';
            $json['err'] = 1;
            $json['message'] = EMAIL_ALREADY_TAKEN;
            $json['success'] = '0';
            echo json_encode($json);
            exit();
        }


        $server = print_r($_SERVER, true);
        $ipaddress = $_SERVER['REMOTE_ADDR'];
        $query = "INSERT INTO `delivery_guys` (`name`,`password`, `email`, push_notification, device_type,contact,ipaddress,header) VALUES ('$name',  '$password','$email','$push_noti', '$device_type', '$mobile','$ipaddress','$server')";

        $res = mysql_query($query) or die(mysql_error());
        if ($res) {
            $json['status'] = '1';
            $json['message'] = REGISTRATION_SUCCESSFUL;
            $json['success'] = '1';

            $userid = mysql_insert_id();

           
            $query1 = "SELECT * FROM `delivery_guys` WHERE id='" . $userid . "'";
            $res1 = mysql_query($query1);
            $data1 = mysql_fetch_assoc($res1);
            unset($data1['header']);
            $num1 = mysql_num_rows($res1);
            if ($num1 == 1) {

            

                if ($data1['profilepic'] != "") {
                    if (!(strpos($data1['profilepic'], 'http') === 0))
                        $data1['profilepic'] = $data1['profilepic'];
                }
                
                
            
                $json['data'] = $data1;
            } else
                $json['data'] = "";

        } else {
            $json['status'] = '1';
            $json['err'] = 3;
            $json['message'] = ERROR_IN_CREATIN_ACCOUNT;
            $json['success'] = '0';
        }

        return json_encode($json);

        exit();
    }

    function updateProfile()
    {
        $uid = $_POST['uid'];
        $name = urldecode($_POST['name']);
        $uname = $_POST['uname'];
        $email = $_POST['email'];
        $img = $_POST['userthumb'];
        $password = $_POST['password'];
        $phone = $_POST['phone'];
        $oldPwd = $_POST['currentpwd'];
        $address        = json_decode($_POST['address'],true);
        $latitude       = $address['latitude'];
        $longitude      = $address['longitude'];
        $addD           = rawurlencode($address['address']);
        $addName        = rawurlencode($address['name']);
        $imgMd5 = md5($_SERVER['REMOTE_ADDR'] . "_" . rand(0, 300) . "_" . time());
        $imgName = $imgMd5 . ".jpg";
        $json = array();
        


        if ($name == "") {
            $name = "User X";
        }

        $query = "SELECT social_type FROM users WHERE id='$uid'";
        $res = mysql_query($query);
        $data = mysql_fetch_assoc($res);
        $soc = intval($data['social_type']);


        if ($soc == 0) {
            if (isset($_POST['currentpwd'])) {
                $oldpassword = md5(trim($oldPwd));
                $query = "SELECT id FROM delivery_guys WHERE id='$uid' AND password='$oldpassword'";

                $res = mysql_query($query);
                $num = mysql_num_rows($res);
                if (!$num) {
                    $json['status'] = '1';
                    $json['message'] = AUTHENTICATION_ERROR;
                    $json['success'] = '0';
                    echo json_encode($json);
                    exit();
                }
            }
        }
        $usernameUpdateQueryConcat = "";
        if ($uname != "") {
            if (substr($uname, 0, 1) === '@') {
                $uname = substr($uname, 1);
            }
            if (preg_match('/[^A-Za-z0-9._]/', $uname)) {
                $json['status'] = '1';
                $json['message'] = "Your User ID must only contain alphanumeric characters (a-z, A-Z, 0-9) from the English alphabet. You must not use any special character other than the underscore(_), and the period(.), or any other character from any other language. Please retry.";
                $json['success'] = '0';
                echo json_encode($json);
                exit();
            }
            $query = "SELECT id FROM delivery_guys WHERE username='$uname' AND id!='$uid' AND social_type ='$soc'";
            $res = mysql_query($query);
            $num = mysql_num_rows($res);
            if ($num) {
                $json['status'] = '1';
                $json['err'] = 1;
                $json['message'] = USERNAME_ALREADY_TAKEN;
                $json['success'] = '0';
                echo json_encode($json);
                exit();
            }
            $usernameUpdateQueryConcat = ",username='$uname'";
        }

        $query = "SELECT id FROM delivery_guys WHERE email='$email' AND id!='$uid' AND social_type ='$soc'";
        $res = mysql_query($query);
        $num = mysql_num_rows($res);
        if ($num) {
            $json['status'] = '1';
            $json['err'] = 1;
            $json['message'] = EMAIL_ALREADY_TAKEN;
            $json['success'] = '0';
            echo json_encode($json);
            exit();
        }

        if ($img != "") {
            $fname = AVATAR_PATH . $imgName;
            $imgUp = base64_decode($img);
            file_put_contents($fname, $imgUp);
            if (file_exists($fname)) {
                $fUrl = "$imgName";
                $img = " ,profilepic='$fUrl' ";

                $query = "SELECT  profilepic FROM delivery_guys WHERE id='$uid'";
                $res = mysql_query($query);
                $data = mysql_fetch_array($res);
                $pp = $data['profilepic'];
                $pp = str_replace(SERVER_URL_AVATAR, "", $pp);
            } else {
                $json['status'] = '1';
                $json['message'] = ERROR_UPLOADING_PROFILE_PIC;
                $json['success'] = '0';
                echo json_encode($json);
                exit();
                $img = "";
            }
        }

        if ($password != "")
            $pass = " , password=MD5('$password') ";

        $query = "UPDATE `delivery_guys` SET contact='$phone',email='$email',`name`='$name'$usernameUpdateQueryConcat $img $pass WHERE id='$uid'";
        $res = mysql_query($query) or die(mysql_error());

        if ($res) {
            @unlink(AVATAR_PATH . $pp);
            $json['status'] = '1';
            $json['success'] = '1';
            
            
            
            $query1 = "SELECT * FROM `delivery_guys` WHERE id='" . $uid . "'";
            $res1 = mysql_query($query1);
            $data1 = mysql_fetch_assoc($res1);
            
            
            if ($data1['profilepic'] == "")
                $data1['profilepic'] = "default_user_profile_img.png";
            else if (!file_exists("images/" . $data1['profilepic']))
                $data1['profilepic'] = "default_user_profile_img.png";

            $data1['fullthumb'] = SERVER_URL . "images/" . $data1['profilepic'];
            $data1['profilepic'] = $data1['fullthumb'];

            unset($data1['header']);
            $num1 = mysql_num_rows($res1);
            if ($num1 == 1) {
                $json['message'] = $data1;
            } else {
                $json['message'] = "";
            }
        } else {
            $json['status'] = '1';
            $json['message'] = ERROR_IN_UPDATING;
            $json['success'] = '0';
        }

        echo json_encode($json);
        exit();
    }
    
    
    function updateMyLocation()
    {
    		$myid		= intval($_POST['myid']);
    		$latitude	= floatval($_POST['latitude']);
    		$longitude	= floatval($_POST['longitude']);
    		
    		if($myid > 0 )
    		{
    			$query		= "UPDATE delivery_guys SET last_lati='$latitude' , last_longi='$longitude' , last_updated=NOW() WHERE id='$myid'";
    			mysql_query($query);
    		}
    		
    }
    
    
    function getDelOrders()
    {
    		$myid		= intval($_POST['myid']);
    		$types		= intval($_POST['type']);// 1 pending 2 current 3 history
    		$lastid		= intval($_POST['lastid']);
    		
    		$response	= array();
    		
    		$total		= 0;
    		if($types == 1)
    			$query 	= "SELECT * FROM orders WHERE del_id='$myid' AND del_type='1' AND status='2' AND dated >=(NOW() - INTERVAL 1 MONTH) AND del_accepted='1'  GROUP BY threadid  ORDER BY dated DESC";
    		else if($types == 2)
    			$query 	= "SELECT * FROM orders WHERE del_id='$myid' AND del_type='1' AND status='3' AND dated >=(NOW() - INTERVAL 1 MONTH) AND del_accepted='1'  GROUP BY threadid  ORDER BY dated DESC";
    		else if($types == 3)
    			$query 	= "SELECT * FROM orders WHERE del_id='$myid' AND del_type='1' AND status='4' AND dated >=(NOW() - INTERVAL 1 MONTH) AND del_accepted='1'  GROUP BY threadid  ORDER BY dated DESC";
    		else if($types == 4)
    			$query 	= "SELECT * FROM orders WHERE del_id='$myid' AND del_type='1' AND status='2' AND dated >=(NOW() - INTERVAL 1 MONTH) AND del_accepted='0'  GROUP BY threadid  ORDER BY dated DESC";
    		$res		= mysql_query($query);
    		while($data	= mysql_fetch_assoc($res))
    		{
    		
    			$total					= 0;
    			$data['orderid']		= "#".$data['orderid'];
    			$query					= "SELECT sl.title_en,sl.title_ar,sl.latitude,sl.address,sl.longitude,s.title_en as store_en,s.title_ar as store_ar,s.phonenumber FROM store_locations sl LEFT JOIN stores s ON s.id=sl.storeid WHERE sl.id='$data[locid]'";
    			$resloc					= mysql_query($query);
    			$dataloc				= mysql_fetch_assoc($resloc);
    			$data['store_details'] 	= $dataloc;
    			
    			$data['storname_en'] 	= $dataloc['store_en'];
    			$data['storname_ar'] 	= $dataloc['store_ar'];
    			$data['loc_en'] 		= $dataloc['title_en'];
    			$data['loc_ar'] 		= $dataloc['title_ar'];
    			$data['phonenumber'] 	= $dataloc['phonenumber'];
    			
    			
    			$query					= "SELECT name,contact FROM users WHERE id='$data[uid]'";
    			$resusr					= mysql_query($query);
    			$datausr				= mysql_fetch_assoc($resusr);
    			$data['username'] 		= $datausr['name'];
    			$data['cuscontact'] 	= $datausr['contact'];
    			
    			$query					= "SELECT address,latitude,longitude,name FROM user_address WHERE id='$data[delid]' AND uid='$data[uid]'";
    			$resusradd				= mysql_query($query);
    			$datausradd				= mysql_fetch_assoc($resusradd);
    			$data['address'] 		= $datausradd;
    			
    			$query					= "SELECT COUNT(id) AS cnt FROM orders WHERE threadid='$data[threadid]'";
    			$rescount				= mysql_query($query);
    			$datacount				= mysql_fetch_assoc($rescount);
    			
    			$data['itemcount']		= $datacount['cnt'];
    			
    			$resps					= array();
    			$query					= "SELECT psid,pid,qty,product_cost,total_price,orignal_price FROM orders WHERE threadid='$data[threadid]'";
    			$resstore				= mysql_query($query);
    			while($dataprods		= mysql_fetch_assoc($resstore))
    			{
    			
    				$query					= "SELECT title_en,title_ar,images FROM products WHERE id='$dataprods[pid]'";
    				$resprd					= mysql_query($query);
    				$dataprd				= mysql_fetch_assoc($resprd);
    			
    				$resp					= array();
    				$resp['qty_total']		= $dataprods['total_price'];
    				$resp['product_cost']	= $dataprods['product_cost'];
    				$resp['orignal_price']	= $dataprods['orignal_price'];
    				$resp['qty']			= $dataprods['qty'];
    				$resp['title_en']		= $dataprd['title_en'];
    				$resp['title_ar']		= $dataprd['title_ar'];
    				
                	$total                  = $total+floatval($resp['qty_total']);
    				
    				if(file_exists(ITEMS_BASE.$dataprd['img']))
    					$resp['images']		= SERVER_URL.ITEMS_BASE.$dataprd['images'];
    				else
    					$resp['images']		= SERVER_URL.ITEMS_BASE.NOIMG;
    				
    				$resps[]				= $resp;
    			}
    		
    			$data['total']				= $total;
    			$data['details']			= $resps;
    			$response[]					= $data;
    		}
    		
    		file_put_contents("delivery.txt",json_encode($response));
    		return json_encode($response);
    }
    
    
    function toggleStatus()
    {
    	$myid		= intval($_POST['myid']);
    	
    	$query		= "SELECT status FROM delivery_guys WHERE id='$myid'";
    	$resusr		= mysql_query($query);
    	$datausr	= mysql_fetch_assoc($resusr);
    	
    	if($datausr['status'] == "1")
    		$status	= "0";
    	else
    		$status	= "1";
    		
    		
    	$query 		= "UPDATE delivery_guys SET status='$status' WHERE id='$myid'";
    	$res		= mysql_query($query);
    	if($res)
    	{
    		return $this->getMyStatus();
    	}
    	else
    		return json_encode(array());
    	
    	
    }
    
    function getMyStatus()
    {
    	$myid				= intval($_POST['myid']);
    	
    	$query				= "SELECT status FROM delivery_guys WHERE id='$myid'";
    	$resusr				= mysql_query($query);
    	$datausr			= mysql_fetch_assoc($resusr);
    	
    	$array				= array();
    	$array['status'] 	= $datausr['status'];
    	
    	return json_encode($array);
    	
    	
    }
    
    
    function changeOrderStatus()
    {
    	$_POST['orderid'] 	= str_replace("#","",$_POST['orderid']);
    	$orderid			= intval($_POST['orderid']);
    	$myid				= intval($_POST['myid']);
    	$type				= intval($_POST['type']);
    	$response			= array();
    	$response['success']= 0;
    	$response['message']= ERROR_IN_STATUS_CHANGE;
    	
    	
    	if($type == 2)
    	{
    			$query				= "UPDATE orders SET status='4' WHERE del_id='$myid' AND del_type='1' AND orderid='$orderid'";
				$res				= mysql_query($query);
				if($res)
				{
					$response['message'] 	= ORDER_DELIVERED;	
					$response				= $this->orderNotification($response,$myid,$orderid,$type);
				}
    	
    	}
    	else
    	{		
				if($type == 1)
					$updateId 		= $myid;
				else
					$updateId 		= 0;
		
				$query				= "UPDATE orders SET del_accepted='$type',del_id='$updateId' WHERE del_id='$myid' AND del_type='1' AND orderid='$orderid'";
				$res				= mysql_query($query);
				if($res)
				{
					if($type == 1)
						$response['message'] 	= DELIVERY_ACCEPTED_SUCCESSFULLY;
					else
						$response['message'] 	= DELIVERY_REJECTED;
				
					$response					= $this->orderNotification($response,$myid,$orderid,$type);
				}    	
    	}
    	
    	
    	
    	return json_encode($response);
    
    }
    
    
    function orderNotification($response,$myid,$orderid,$type)
    {
    		$STATUS					= array(REJECTED,ACCEPTED,DELIVERED);
				
			$query					= "SELECT name FROM delivery_guys WHERE id=$myid";	
			$resSt  				= mysql_query($query);
			$dataSt 				= mysql_fetch_assoc($resSt);
			$delName				= $dataSt['name'];		
		
	
			$query					= "SELECT gcmreg FROM stores WHERE id= (SELECT storeid FROM orders WHERE orderid='$orderid' LIMIT 0,1)";	
			$resSt  				= mysql_query($query);
			$dataSt 				= mysql_fetch_assoc($resSt);
	
			$regid      			= array($dataSt['gcmreg']);
			$title      			= $response['message'];
			$msg        			= str_replace("[ORDERID]","#".$orderid,DEL_REQUEST);
			$msg        			= str_replace("[STATUS]",$STATUS[$type],$msg);
			$msg        			= str_replace("[NAME]",trim(ucwords($delName)),$msg);

			$payload    			= array();
			$payload['type'] 		= "del_status";
			$payload['status'] 		= $type;
			$payload['orderid'] 	= $orderid;
			$this->sendNotificationToAndroid($title,$msg,$payload,$regid,NOTIFICATION);			
			$response['success'] = 1;
			
			return $response;
    
    }
    
    
    function checkExpired()
    {    
    		$query 		= "SELECT orderid , storeid , del_id FROM orders WHERE del_requested < DATE_SUB(NOW(),INTERVAL 2 MINUTE) AND del_type='1' AND del_id > 0 AND del_accepted='0' GROUP BY orderid";
    		$array		= array();
    		$array[]	= $query;
    		$res1		= mysql_query($query);
    		while($data1= mysql_fetch_assoc($res1))
    		{
    			$query 	= "SELECT gcmreg FROM stores WHERE id='$data1[storeid]'";
    			$res2	= mysql_query($query);
    			$data2	= mysql_fetch_assoc($res2);
    			$array[]	= $query;
    			
    			
    			$query				= "UPDATE orders SET del_accepted='0',del_id='0' WHERE del_id='$data1[del_id]' AND del_type='1' AND orderid='$data1[orderid]'";
				$array[]			= $query;
				$res				= mysql_query($query);
				if($res)
				{
					$query					= "SELECT name FROM delivery_guys WHERE id=$data1[del_id]";	
					$resSt  				= mysql_query($query);
					$dataSt 				= mysql_fetch_assoc($resSt);
					$delName				= $dataSt['name'];		
					$array[]				= $query;
			
					$query					= "SELECT gcmreg FROM stores WHERE id='$data1[storeid]'";	
					$resSt  				= mysql_query($query);
					$dataSt 				= mysql_fetch_assoc($resSt);
					$array[]				= $query;
					$regid      			= array($dataSt['gcmreg']);
					$title      			= DELIVERY_AWAITING_TIME_EXPIRED;
					$msg        			= str_replace("[ORDERID]","#".$data1['orderid'],DEL_REQUEST);
					$msg        			= str_replace("[STATUS]",EXPIRED,$msg);
					$msg        			= str_replace("[NAME]",trim(ucwords($delName)),$msg);
	
					$payload    			= array();
					$payload['type'] 		= "del_status";
					$payload['status'] 		= '0';
					$payload['orderid'] 	= $data1['orderid'];
					$this->sendNotificationToAndroid($title,$msg,$payload,$regid,NOTIFICATION);			
				}
    		
    			file_put_contents("cron.txt",print_r($array,true)." -- ".time());
    		}
    		
    		
    }    
    
    /////////////////////////////////
    
    
    
    

    function getStores($storeidInc = 0)
    {
        $lastdistance = floatval($_POST['lastdistance']);
        $latitude = floatval($_POST['latitude']);
        $longitude = floatval($_POST['longitude']);
        $response = array();

        if (isset($_POST['latitude']) && isset($_POST['longitude'])) {
            $distance = " (6371 * acos( cos( radians( $latitude ) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians( $longitude ) ) + sin(radians($latitude)) * sin(radians(`latitude`)) )) `distance` ";
            if ($lastdistance > -1)
                $query = "SELECT sl.radius,sl.status,sl.id as slid ,sl.latitude,sl.longitude,sl.title_ar as loc_ar , sl.title_en as loc_en,s.*,sl.image as slimage ,$distance FROM store_locations sl LEFT JOIN stores s ON s.id = sl.storeid  HAVING distance > $lastdistance ORDER BY `distance` ASC LIMIT 0,100";
            else
                $query = "SELECT sl.radius,sl.status,sl.id as slid ,sl.latitude,sl.longitude, sl.title_ar as loc_ar , sl.title_en as loc_en,s.*,sl.image as slimage  ,$distance FROM store_locations sl LEFT JOIN stores s ON s.id = sl.storeid   ORDER BY `distance` ASC LIMIT 0,100";

        } else
            $query = "SELECT * FROM stores";

        if ($storeidInc > 0) {
            $distance = " (6371 * acos( cos( radians( $latitude ) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians( $longitude ) ) + sin(radians($latitude)) * sin(radians(`latitude`)) )) `distance` ";
            $query = "SELECT sl.radius,sl.status,sl.id as slid ,sl.latitude,sl.longitude,sl.title_ar as loc_ar , sl.title_en as loc_en,s.*,sl.image as slimage  ,$distance FROM store_locations sl LEFT JOIN stores s ON s.id = sl.storeid WHERE sl.id='$storeidInc'   ORDER BY `distance` ASC LIMIT 0,100";
        }


        $res = mysql_query($query);
        while ($data = mysql_fetch_assoc($res)) {

            $storeid = $data['id'];
            $locid = $data['slid'];


            $query = "SELECT IFNULL(AVG(value),0) AS avg FROM ratings WHERE storeid='$storeid' AND locid='$locid'";
            $resA = mysql_query($query);
            $dataA = mysql_fetch_assoc($resA);


			$away				= round(floatval($data['distance']) * 1.609, 2);
			
			$data['images']		= $data['slimage'];
            $data['distance'] 	= $away;
            $data['dunit'] 		= " Km";
            $data['rating'] 	= $dataA['avg'];
            $data['locations'] = $data['slid'];
            $data['title_en'] = ucwords(strtolower($data['title_en']));
            $img = LOC_IMAGE . $data['images'];
            if (!file_exists($img) && $data['images'] == "")
                $img = LOC_IMAGE . NOIMG;


            $timingValue = array();
            $timingVisible = array();
            $timeValArray = array();


            $costArray = array();
            $query = "SELECT * FROM delivery_cost WHERE storeid='$storeid' AND locid='$locid' ORDER BY mintime ASC";
            $resIn = mysql_query($query);
            while ($dataIn = mysql_fetch_assoc($resIn)) {
                $costArray[] = $dataIn;
            }


            $query = "SELECT * FROM delivery_timing WHERE storeid='".DEL_STOREID."' AND locid='".DEL_LOCID."'";
            $resIn = mysql_query($query);
            while ($dataIn = mysql_fetch_assoc($resIn)) {

                $currentTime = strtotime(date("Y-m-d H:i:s"));
                $dated = date("Y-m-d");
                $dated = $dated . " " . $dataIn['timing'] . ":00";
                $timingVisible[] = $dated;
                $strtotime = strtotime($dated);
                $timingValue[] = $strtotime;
                $timeValArray[] = $dataIn['timing'] . ":00";

                $dated = date("Y-m-d", strtotime("+1 day", time()));
                $dated = $dated . " " . $dataIn['timing'] . ":00";
                $timingVisible[] = $dated;
                $timingValue[] = strtotime($dated);

            }


            $timingValue2 = $timingValue;
            sort($timingValue);
            $currentTiming = time();
            for ($i = 0; $i < count($timingValue); $i++) {
                if ((($timingValue[$i] - $currentTiming) / 3600) >= 0.5) {
                    $currentTiming = $timingValue[$i];
                    break;
                }
            }

            sort($timingValue2);
            $currT = time();
            $deliveryWithDate = array();
            for ($i = 0; $i < count($timingValue2); $i++) {
                if ((($timingValue2[$i] - $currT) / 3600) >= 0.5) {
                    $deliveryWithDate[] = date("Y-m-d H:i:s", $timingValue2[$i]);
                }
            }


            $data['next'] = date("d-m-Y H:i:s", $currentTiming);
            $data['time'] = date("d-m-Y H:i:s");
            $data['alldelivery'] = $timeValArray;
            $data['deltiming'] = $deliveryWithDate;
            $data['costarray'] = $costArray;
            $data['images'] = IMG_URL . $img;
            
            if(floatval($data['radius']) >= $away)
            	$response[] = $data;
        }


        return json_encode($response);
    }


    function getStoreCategories()
    {
        $response = array();
        $data = json_decode($_POST['data'], true);
        $storeid = $data['id'];
        $locId = $data['slid'];
        $myid = $_POST['myid'];
        
        
        $response2        = array();
        $query = "SELECT * FROM favorites WHERE uid='$myid' AND current_value='1' AND storeid='$storeid' AND locid='$locId'";
        $res2 = mysql_query($query);
        
        while ($data2 = mysql_fetch_assoc($res2)) {

            $productid = $data2['pid'];
            $resp       = json_decode($this->getStoreProducts($productid), true);

            $response2[] = $resp[0];
        }
        
        
        $element                = array();
        $element['id']          = "-1";
        $element['title_en']    = "";
        $element['subcat']      = array();
        $element['title_ar']    = "";
        $element['favitems']    = $response2;
        $response[]             = $element;


        $element        = array();
        $element['id'] = "0";
        $element['title_en'] = "All";
        $element['subcat'] = array();
        $element['title_ar'] = "الكل";
        $response[] = $element;

        $query = "SELECT * FROM categories WHERE id IN (SELECT catid FROM cat_stores WHERE storeid='$storeid')";
        $res = mysql_query($query) or die(mysql_error());
        while ($data = mysql_fetch_assoc($res)) {
            $data['title_en'] = ucwords(strtolower($data['title_en']));
            $img = CATEGORIES_BASE . $data['images'];
            if (!file_exists($img) || $data['images'] == "")
                $img = CATEGORIES_BASE . NOIMG;


            $data['catid'] = $data['id'];
            $data['subid'] = "0";
            $data['storeid'] = $storeid;
            $data['locid'] = $locId;

            $query = "SELECT sub.title_ar,sub.title_en,ca.subcat,ca.storeid,ca.catid,sub.id AS subid FROM subcat_stores ca LEFT JOIN subcat sub ON sub.id=ca.subcat WHERE ca.catid='$data[id]' AND ca.storeid='$storeid'";
            $res22 = mysql_query($query);
            $subCat = array();
            while ($dataSub = mysql_fetch_assoc($res22)) {
                $dataSub['catid'] = $data['id'];
                $dataSub['storeid'] = $storeid;
                $dataSub['locid'] = $locId;
                $dataSub['ca_en'] = $data['title_en'];
                $dataSub['ca_ar'] = $data['title_ar'];
                $dataSub['locid'] = $locId;
                $subCat[] = $dataSub;
            }

            $data['subcat'] = $subCat;
            $data['images'] = IMG_URL . $img;
            $response[] = $data;
        }
        
        
    

        return json_encode($response);
    }


    function getFavorites()
    {
        //$_POST				= json_decode(file_get_contents("prod.txt"),true);
        $myid = $_POST['myid'];
        $dataInc = json_decode($_POST['data'], true);
        $storeid = $dataInc['id'];
        $locid = $dataInc['slid'];


        $response = array();
        $query = "SELECT * FROM favorites WHERE uid='$myid' AND current_value='1' AND storeid='$storeid' AND locid='$locid'";
        $res = mysql_query($query);
        while ($data = mysql_fetch_assoc($res)) {

            $productid = $data['pid'];
            $resp = json_decode($this->getStoreProducts($productid), true);

            $response[] = $resp[0];
        }


        return json_encode($response);

    }

    function getStoreProducts($productid = 0, $isDiscounted = 0)
    {
        $response = array();
        $data = json_decode($_POST['data'], true);
        $storeid = $data['id'];
        $locId = $data['slid'];
        $myid = $_POST['myid'];

        $store_ar = $data['title_ar'];
        $store_en = $data['title_en'];
        $loc_en = $data['loc_en'];
        $loc_ar = $data['loc_ar'];
        $next = $data['next'];
        $timing = $data['time'];
        $storeimgs = $data['images'];
        $myid = $_POST['myid'];
        $alldelivery = $data['alldelivery'];
        $costarray = $data['costarray'];
        $onlyFav = intval($_POST['onlyfavorites']);
        


        if ($productid > 0)
            $productCondition = " AND ps.productid='$productid' ";
            
        if($onlyFav == 1)
            $productCondition = " AND ps.discount_price > 0 ";

        $response = array();
        $query = "SELECT p.* ,
                ps.price,ps.id as psid,ps.discount_price, IF(ps.discount_price = 0,0, 100 - ps.discount_price / ps.price * 100) discount_ratio,
                  c.id AS catid,c.title_ar as ca_ar,c.title_en as ca_en,IFNULL(s.id ,0) AS subcatid,
                  s.title_ar as s_ar,s.title_en as s_en 
                  FROM products_stores ps 
                  LEFT JOIN products p ON p.id = ps.productid 
                  LEFT JOIN categories c ON c.id = ps.catid 
                  LEFT JOIN subcat s ON s.id = ps.subcat 
                  WHERE ps.storeid = '$storeid' 
                  AND ps.store_location = '$locId' 
                  AND ps.discounted = '$isDiscounted' $productCondition";
        $res = mysql_query($query);
        while ($data = mysql_fetch_assoc($res)) {
            $data['title_en'] = ucwords(strtolower($data['title_en']));
            $img = ITEMS_BASE . $data['images'];
            if (!file_exists($img) || $data['images'] == "")
                $img = ITEMS_BASE . NOIMG;

            $data['images'] = IMG_URL . $img;
            $catid = $data['catid'];
            $subid = $data['subcatid'];

            $key = $data['id'] . "@@" . $locId . "@@" . $storeid . "@@" . $catid . "@@" . $subid;

            $query = "SELECT id,current_value FROM favorites WHERE `pid`='$data[id]' AND uid='$myid' AND locid='$locId' AND storeid='$storeid'";
            $res2 = mysql_query($query);
            $data2 = mysql_fetch_assoc($res2);
            $num2 = mysql_num_rows($res2);
            $data['currentfav'] = intval($data2['current_value']);
            $data['favorite'] = array();
            $data['key'] = $key;
            $data['storeimg'] = $storeimgs;
            $data['loc_en'] = $loc_en;
            $data['loc_ar'] = $loc_ar;
            $data['store_en'] = $store_en;
            $data['store_ar'] = $store_ar;
            $data['delivery'] = $next;
            $data['currtime'] = $timing;
            $data['alldelivery'] = $alldelivery;
            $data['costarray'] = $costarray;
            $data['storeid'] = $storeid;
            $data['locid'] = $locId;
            $response[] = $data;
        }

        return json_encode($response);
    }

    function getStoreProductsOffers()
    {
        return $this->getStoreProducts(0,1);
    }

    function getProductDetail()
    {
        $response = array();
        $catid = $_POST['catid'];
        $subid = $_POST['subid'];
        $storeid = $_POST['storeid'];
        $locid = $_POST['locid'];
        $store_ar = $_POST['store_ar'];
        $store_en = $_POST['store_en'];
        $loc_en = $_POST['loc_en'];
        $loc_ar = $_POST['loc_ar'];
        $next = $_POST['next'];
        $timing = $_POST['timing'];
        $storeimgs = $_POST['storeimgs'];
        $myid = $_POST['myid'];
        $alldelivery = json_decode($_POST['alldelivery'], true);

        $query = "SELECT p.* , ps.price,ps.id as psid,c.title_ar as ca_ar,c.title_en as ca_en,s.title_ar as s_ar,s.title_en as s_en FROM products_stores ps LEFT JOIN products p ON p.id = ps.productid LEFT JOIN categories c ON c.id =ps.catid LEFT JOIN subcat s ON s.id=ps.subcat WHERE ps.storeid='$storeid' AND ps.store_location='$locid' AND ps.catid='$catid' AND ps.subcat='$subid'";
        $res = mysql_query($query);
        while ($data = mysql_fetch_assoc($res)) {
            $data['title_en'] = ucwords(strtolower($data['title_en']));
            $img = ITEMS_BASE . $data['images'];
            if (!file_exists($img) || $data['images'] == "")
                $img = ITEMS_BASE . NOIMG;

            $data['images'] = IMG_URL . $img;

            $key = $data['id'] . "@@" . $locid . "@@" . $storeid . "@@" . $catid . "@@" . $subid;

            $query = "SELECT * FROM favorites WHERE `key`='$key' AND uid='$myid'";
            $res2 = mysql_query($query);
            $data2 = mysql_fetch_assoc($res2);
            $num2 = mysql_num_rows($res2);
            $data['currentfav'] = intval($data2['current_value']);
            $data['favorite'] = $data2['data'];
            $data['key'] = $key;
            $data['storeimg'] = $storeimgs;
            $data['loc_en'] = $loc_en;
            $data['loc_ar'] = $loc_ar;
            $data['store_en'] = $store_en;
            $data['store_ar'] = $store_ar;
            $data['storeimg'] = $storeimg;
            $data['delivery'] = $next;
            $data['currtime'] = $timing;
            $data['alldelivery'] = $alldelivery;
            $response[] = $data;
        }

        return json_encode($response);
    }

    function explicitCaller()
    {
        $var = json_decode($_REQUEST['variables'], true);
        $_POST = $var;

        $function = $_POST['caller'];
        echo $out = $this->$function();
    }


    
    
   


    function getMyAddress()
    {
        $myid = trim($_POST['myid']);

        $resP = array();
        $resP['success'] = "1";
        $response = array();
        $query = "SELECT * FROM user_address WHERE uid='$myid'";
        $res = mysql_query($query);
        while ($data = mysql_fetch_assoc($res)) {
            $data['address'] = rawurldecode($data['address']);
            $response[] = $data;
        }

        $response[] = array("address" => "-1");

        $resP['locations'] = $response;

        return json_encode($resP);


    }


    function placeOrder()
    {
        //$_POST				= json_decode(file_get_contents("placessse.txt"),true);
        $delivery = json_decode($_POST['deliverylocation'], true);
        $deliveryCost = json_decode($_POST['deliverycost'], true);
        $myid = $_POST['myid'];
        $notes = $_POST['notes'];
        $dataLoc = json_decode($_POST['data'], true);
        
        $thread = md5(microtime() . "_" . rand(2, 100) . "_" . $_SERVER['REMOTE_ADDR'] . "_" . $myid);
        $delCost = $_POST['delcost'];
        $delTime = explode(" ",$_POST['deltime']);
        $delTime2 = explode("-",$delTime[0]);
        $delTime  = $delTime2[2]."-".$delTime2[1]."-".$delTime2[0]." ".$delTime[1];


        $element['success'] = "0";
        $query = "SELECT * FROM user_address WHERE latitude='$delivery[latitude]' AND longitude='$delivery[longitude]'";
        $res = mysql_query($query);
        $num = mysql_num_rows($res);
        $dataLocation = mysql_fetch_assoc($res);
        $delId = $dataLocation['id'];


        if ($num == 0) {
            $delivery[name] = rawurlencode($delivery['name']);
            $delivery[address] = rawurlencode($delivery['address']);
            $query = "INSERT INTO user_address(uid,latitude,longitude, name,address) VALUEs('$myid','$delivery[latitude]',
									'$delivery[longitude]','$delivery[name]','$delivery[address]')";

            $exe = mysql_query($query);
            $delId = mysql_insert_id();
        }

        $locid  = "";
        $storeid  = "";
        
        for ($i = 0; $i < count($dataLoc); $i++) {
            $single = $dataLoc[$i];
            $deltime = explode(" ", $single['delivery']);
            $deltime[0] = explode("-", $deltime[0]);
            $deltime[0] = $deltime[0][2] . "-" . $deltime[0][1] . "-" . $deltime[0][0];
            $deltime = $deltime[0] . " " . $deltime[1];
            $single['delivery'] = $deltime;
            $keyCost = $single[storeid] . "@@" . $single[locid];
            $cost = 0;
            for ($mm = 0; $mm < count($deliveryCost); $mm++) {
                $keysA = array_keys($deliveryCost[$mm]);
                for ($nn = 0; $nn < count($keysA); $nn++) {
                    $eKey = $keysA[$nn];
                    if ($keyCost == $eKey) {

                        $cost = str_replace("SAR", "", $deliveryCost[$mm][$eKey]);
                        $cost = str_replace("ريال", "", $cost);
                        $cost = str_replace(" ", "", $cost);
                    }
                }


            }

            $pid                = intval($single['psid']);
            $queryProduct       = "SELECT discount_price,price FROM products_stores WHERE id='$pid'";
            $resProduct         = mysql_query($queryProduct);
            $dataProduct        = mysql_fetch_assoc($resProduct);
            $discountPrice      = floatval($dataProduct['discount_price']);
            $productPrice       = floatval($dataProduct['price']);
            $productPriceOr     = $productPrice;
            if($discountPrice > 0)
                $productPrice   = $discountPrice;
            

            $totalPrice         = $productPrice * intval($single[qty]);
            $storeid = $single[storeid];
            $query = "INSERT INTO orders(pid,uid,qty,psid,threadid,delid,storeid,locid,catid,subcatid,keyvalue,deliverytime,deliverycost,notes,product_cost,total_price,orignal_price) 
								  VALUES('$single[id]','$myid','$single[qty]','$single[psid]','$thread','$delId','$single[storeid]','$single[locid]','$single[catid]','$single[subcatid]','$single[keyvalue]','$delTime','$delCost','$notes','$productPrice',$totalPrice,'$productPriceOr')";
            $exe = mysql_query($query);
            $insertID = mysql_insert_id();
            
            

            if ($exe) {
                $element['success'] = "1";
                $locid  = $single[locid];
                $storeid  = $single[storeid];
            }

        }


        if ($insertID) {
            $arrayR = array();
            $strTmp = $insertID . "";
            $strLen = strlen($strTmp);
            $balance = 6 - $strLen;
            if ($balance < 0)
                $balance = 0;

            $str = $this->generateRandomString($balance);
            $str2 = $str . $strTmp;
            $str2 = strtoupper($str2);

            $query = "UPDATE orders SET orderid='$str2' WHERE threadid='$thread'";
            mysql_query($query);
            
            $query  = "SELECT gcmreg FROM stores WHERE id='$storeid'";
            $resSt  = mysql_query($query);
            $dataSt = mysql_fetch_assoc($resSt);
            
            
            $regid = array($dataSt['gcmreg']);
			$title = NEW_ORDER;
			$msg = str_replace("[ORDERID]",$str2,NEW_ORDER_TXT);
			$payload = array();
			$payload['type'] = "new_order";
			$payload['orderid'] = $str2;
			$payload['json_data'] = array("id"=>$locid,"storeid"=>$storeid);
			$this->sendNotificationToAndroid($title,$msg,$payload,$regid,NOTIFICATION);
            
        }


        return json_encode($element);

    }
    
    function testGcm()
    {
            $query  = "SELECT gcmreg FROM stores WHERE id='1'";
            $resSt  = mysql_query($query);
            $dataSt = mysql_fetch_assoc($resSt);
            

            $regid = array($dataSt['gcmreg']);
			$title = NEW_ORDER;
			$msg = str_replace("[ORDERID]",$str2,NEW_ORDER_TXT);
			$payload = array();
			$payload['type'] = "new_order";
			$payload['orderid'] = $str2;
			$this->sendNotificationToAndroid($title,$msg,$payload,$regid,NOTIFICATION);
    }
    
    function sendNotificationToAndroid($title , $message ,$payload, $ids,$type )
    {
        
        
    	$push		= new Push();
    	$firebase	= new Firebase();

		$push->setTitle($title);
        $push->setMessage($message);
        $push->setImage('');
        $push->setIsBackground(FALSE);
        $push->setPayload($payload);

        $json 				= '';
        $response 			= '';

        $json 				= $push->getPush();
        if($type == "1")
        	$response 		= $firebase->sendMultiple($ids, $json);
        
        return $response;

    }

    function generateRandomString($length = 10)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    function getMyOrders()
    {

        $response = array();
        $myid = $_POST['myid'];
        $incomingvalue = trim($_POST['lastid']);
        $data = json_decode($_POST['data'], true);
        $storeid = $data['id'];
        $locid = $data['slid'];


        $query = "SELECT IFNULL(value,0) AS myrating FROM ratings WHERE storeid='$storeid' AND locid='$locid' AND uid='$myid'";
        $resA = mysql_query($query);
        $dataA = mysql_fetch_assoc($resA);

        
        $query = "SELECT DISTINCT deliverycost,storeid,locid,MAX(id) AS id,deliverytime,status,threadid,orderid,dated,notes FROM orders WHERE storeid='$storeid' AND locid='$locid' AND uid='$myid' GROUP BY threadid ORDER BY dated DESC  LIMIT 0,300";
        if ($incomingvalue != "")
            $query = "SELECT DISTINCT deliverycost,storeid,locid,MAX(id) AS id,deliverytime,status,threadid,orderid,dated,notes FROM orders WHERE storeid='$storeid' AND locid='$locid' AND uid='$myid' AND id > '$incomingvalue' GROUP BY threadid  ORDER BY dated DESC LIMIT 0,10";

        $resMain = mysql_query($query);
        while ($dataMain = mysql_fetch_assoc($resMain)) {
            $dataDetails = array();
            $threadid = $dataMain['threadid'];
            $total = 0;
            $query = "SELECT uad.address as del_address,uad.name as add_name,uad.latitude as del_lati,uad.longitude as del_longi,ps.price,
                              o.orignal_price,o.product_cost,o.total_price,o.deliverycost,o.status,o.qty,o.dated,o.deliverytime,o.id,o.threadid,o.notes,
                              p.title_en,p.title_ar,p.images,
                              s.title_en as store_en,s.phonenumber,s.title_ar as store_ar,
                              l.title_en as location_en,l.title_ar as location_ar ,l.latitude,l.longitude 
                              FROM orders o 
                              LEFT JOIN user_address uad ON uad.id=o.delid 
                              LEFT JOIN products p ON p.id=o.pid 
                              LEFT JOIN stores s ON s.id = o.storeid 
                              LEFT JOIN store_locations l ON l.id=o.locid 
                              LEFT JOIN products_stores ps ON ps.id=o.locid 
                              WHERE o.uid='$myid' 
                              AND o.storeid='$storeid' 
                              AND o.locid='$locid' 
                              AND threadid='$threadid' 
                              ORDER BY o.id ASC";
            $resIn = mysql_query($query);
            while ($dataInn = mysql_fetch_assoc($resIn)) {

                $strtotime = strtotime($dataInn['deliverytime']);
                if (time() < $strtotime)
                    $dataInn['deadlinecrossed'] = "1";
                else
                    $dataInn['deadlinecrossed'] = "0";

                $img = ITEMS_BASE . $dataInn['images'];
                if (!file_exists($img) || $dataInn['images'] == "")
                    $img = ITEMS_BASE . NOIMG;

                $dataInn['images'] = IMG_URL . $img;

                

                $dataInn['qty_total']   = floatval($dataInn['total_price']);
                $total                  = $total+floatval($dataInn['total_price']);

                $dataMain['store_longi'] = $dataInn['longitude'];
                $dataMain['store_lati'] = $dataInn['latitude'];
                $dataMain['add_name']   = $dataInn['add_name'];
                $dataMain['del_address'] = $dataInn['del_address'];
                $dataMain['del_longi'] = $dataInn['del_longi'];
                $dataMain['del_lati'] = $dataInn['del_lati'];
                $dataMain['phonenumber'] = $dataInn['phonenumber'];
                $dataMain['deadlinecrossed'] = $dataInn['deadlinecrossed'];
                $dataDetails[] = $dataInn;
            }

            $dataMain['myrating'] = intval($dataA['myrating']);
            $dataMain['total'] = $total;
            $dataMain['orderid'] = "#" . $dataMain['orderid'];
            $dataMain['itemcount'] = count($dataDetails);
            $dataMain['details'] = $dataDetails;
            $response[] = $dataMain;

        }
        
        
        return json_encode($response);
    }
    
    
    

    function rateStore()
    {
        $response = array();
        $myid = $_POST['myid'];
        $data = json_decode($_POST['data'], true);
        $storeid = $data['storeid'];
        $locid = $data['locid'];
        $rating = $_POST['rating'];

        $response['success'] = "0";
        $response['message'] = ERROR_IN_RATING;


        $query = "SELECT id FROM ratings WHERE uid='$myid' AND storeid='$storeid' AND locid='$locid'";
        $resR = mysql_query($query);
        $numR = mysql_num_rows($resR);

        if ($numR)
            $query = "UPDATE  ratings SET value='$rating' WHERE uid='$myid' AND storeid='$storeid' AND locid='$locid'";
        else
            $query = "INSERT INTO ratings(value,uid,storeid,locid) VALUES('$rating','$myid','$storeid','$locid')";

        $res = mysql_query($query);
        if ($res) {
            $response['success'] = "1";
            $response['message'] = RATED_SUCCESSFULLY;
        }

        return json_encode($response);
    }

    function cancelOrder()
    {

        $response = array();
        $myid = $_POST['myid'];
        $data = json_decode($_POST['data'], true);
        $storeid = $data['storeid'];
        $locid = $data['locid'];
        $threadid = $data['threadid'];

        $response['success'] = "0";
        $response['message'] = ERROR_IN_DELETION;


        $query = "UPDATE  orders SET status='5' WHERE uid='$myid' AND storeid='$storeid' AND locid='$locid' AND threadid='$threadid' AND status='0'";
        $res = mysql_query($query);
        if ($res) {
            $response['success'] = "1";
            $response['message'] = DELETED_SUCCESSFULLY;
        }

        return json_encode($response);
    }


    function addToFav()
    {
        $myid = $_POST['myid'];
        $data = base64_encode($_POST['data']);
        $lang = $_POST['lang'];
        $key = $_POST['key'];
        $splitted = explode("@@", $key);
        $storeid = $splitted[2];
        $locid = $splitted[1];
        $productid = $splitted[0];
        $resp = array();


        $condition = " WHERE `pid`='$productid' AND uid='$myid' AND locid='$locid' AND storeid='$storeid' ";
        $query = "SELECT * FROM favorites $condition";
        $res2 = mysql_query($query);
        $data2 = mysql_fetch_assoc($res2);
        $num2 = mysql_num_rows($res2);
        if ($num2) {
            if (intval($data2['current_value']) == 0)
                $query = "UPDATE favorites SET current_value='1' $condition";
            else
                $query = "UPDATE favorites SET current_value='0'$condition";

        } else
            $query = "INSERT INTO favorites(uid,`pid`,storeid,locid) VALUES('$myid' , '$productid','$storeid','$locid')";


        $res = mysql_query($query);

        $query = "SELECT * FROM favorites $condition";
        $res2 = mysql_query($query);
        $data2 = mysql_fetch_assoc($res2);

        $resp['status'] = "1";
        $resp['currentfav'] = $data2['current_value'];
        $resp['message'] = "Operation successful";
        return json_encode($resp);
    }


    function getOffers()
    {
        $myid = $_POST['myid'];
        $data = json_decode($_POST['data'], true);
        $storeid = $data['id'];
        $locid = $data['slid'];

        $response = array();
        $query = "SELECT * FROM offers WHERE storeid='$storeid' AND locid='$locid' ORDER BY dated DESC";
        $res = mysql_query($query);
        while ($data = mysql_fetch_assoc($res)) {

            $data['store'] = $this->getStores(intval($data['locid']));
            $response[] = $data;
        }


        return json_encode($response);

    }

    
}


class Push { private $title; private $message; private $image; private $data; private $is_background; function __construct() { } public function setTitle($title) { $this->title = $title; } public function setMessage($message) { $this->message = $message; } public function setImage($imageUrl) { $this->image = $imageUrl; } public function setPayload($data) { $this->data = $data; } public function setIsBackground($is_background) { $this->is_background = $is_background; } public function getPush() { $res = array(); $res['data']['title'] = $this->title; $res['data']['is_background'] = $this->is_background; $res['data']['message'] = $this->message; $res['data']['image'] = $this->image; $res['data']['payload'] = $this->data; $res['data']['timestamp'] = date('Y-m-d G:i:s'); return $res; } }
class Firebase { public function send($to, $message) { $fields = array( 'to' => $to, 'data' => $message, ); return $this->sendPushNotification($fields); } public function sendToTopic($to, $message) { $fields = array( 'to' => '/topics/' . $to, 'data' => $message, ); return $this->sendPushNotification($fields); } public function sendMultiple($registration_ids, $message) { $fields = array( 'registration_ids' => $registration_ids, 'data' => $message, ); return $this->sendPushNotification($fields); } private function sendPushNotification($fields) { $url = 'https://fcm.googleapis.com/fcm/send'; $headers = array( 'Authorization: key=' . ANDROID_KEY, 'Content-Type: application/json' ); $ch = curl_init(); curl_setopt($ch, CURLOPT_URL, $url); curl_setopt($ch, CURLOPT_POST, true); curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields)); $result = curl_exec($ch); if ($result === FALSE) { die('Curl failed: ' . curl_error($ch)); } curl_close($ch); return $result; } }
