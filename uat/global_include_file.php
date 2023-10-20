<?


       //require_once ("login_admin/initial/mysql_vars.ini");
       require_once ("login_admin/initial/mysql_vars_web.ini");  // 前台使用
       require_once ("login_admin/initial/mysql_tables.ini");
       require_once ("login_admin/initial/acl_functions.ini");
       require_once ("login_admin/initial/acl_menu.ini");
       require_once ("login_admin/initial/mail.ini");
       require_once ("login_admin/initial/msg_log.ini");
       require_once ("login_admin/initial/html.ini");
       require_once ("login_admin/initial/replaces.ini");
       require_once ("login_admin/initial/system.ini");
       require_once ("login_admin/initial/list_fields_uploaded.ini");
       require_once ("login_admin/library/auth.inc");
       require_once ("login_admin/library/system.inc");
       require_once ("login_admin/library/access_DB.inc");
//        require_once ("login_admin/library/PDO_access_DB.inc");
       require_once ("login_admin/library/web_page_class.php");
       require_once ("login_admin/library/utf8_substr.php");
       require_once ("login_admin/library/function_portal.php");
       require_once ("login_admin/library/mail.php");
       require_once ("login_admin/email_validation.php");
       require_once ("login_admin/library/inputfilter.class.php");   // 字元過濾
       require_once ("global_var.php");   // 取得版型應有的變數
       require_once ("global_ui.php");    // 取得版型各種ui樣式
       require_once ("global_overwrite_ui.php");   // overwrite ui class
       require_once ("global_function.php");   // 其他用到的function
       require_once ("global_shopcar.php");   // 購物車用到的function



       // 取得使用裝置   mobile  tablet  desktop
       $global_ua=userAgent($_SERVER['HTTP_USER_AGENT']);

       session_start();
       $session_ID = session_id();



       foreach($_COOKIE as $get_key=>$get_val){

           if($get_key == "layout_id")
           {
               if($get_val != "")
               {
                  if(!is_numeric($get_val))
                     exit;
               }
           }

           if($get_key == "global_website_language_id")
           {
               if($get_val != "")
               {
                  if(!is_numeric($get_val))
                     $_COOKIE[$get_key]="1";
               }
           }


           $_COOKIE[$get_key] = str_replace("\"", "", $_COOKIE[$get_key]);
       	   $_COOKIE[$get_key] = str_replace("'", "", $_COOKIE[$get_key]);
       	   $_COOKIE[$get_key] = str_replace(";", "", $_COOKIE[$get_key]);
       	   $_COOKIE[$get_key] = str_replace(">", "", $_COOKIE[$get_key]);
       	   $_COOKIE[$get_key] = str_replace("<", "", $_COOKIE[$get_key]);
       	   $_COOKIE[$get_key] = str_replace("script", "", $_COOKIE[$get_key]);
       	   $_COOKIE[$get_key] = str_replace("(", "", $_COOKIE[$get_key]);
       	   $_COOKIE[$get_key] = str_replace(")", "", $_COOKIE[$get_key]);
       	   $_COOKIE[$get_key] = str_replace("[", "", $_COOKIE[$get_key]);
       	   $_COOKIE[$get_key] = str_replace("]", "", $_COOKIE[$get_key]);
       	   $_COOKIE[$get_key] = str_replace("%", "", $_COOKIE[$get_key]);
//       	   $_COOKIE[$get_key] = str_replace("+", "", $_COOKIE[$get_key]);
       	   $_COOKIE[$get_key] = str_replace("select", "", $_COOKIE[$get_key]);
       	   $_COOKIE[$get_key] = str_replace("SELECT", "", $_COOKIE[$get_key]);
       	   $_COOKIE[$get_key] = str_replace("deletc", "", $_COOKIE[$get_key]);
       	   $_COOKIE[$get_key] = str_replace("DELETE", "", $_COOKIE[$get_key]);
       	   $_COOKIE[$get_key] = str_replace("update", "", $_COOKIE[$get_key]);
       	   $_COOKIE[$get_key] = str_replace("UPDATE", "", $_COOKIE[$get_key]);
       	   $_COOKIE[$get_key] = str_replace("sysdate", "", $_COOKIE[$get_key]);
       	   $_COOKIE[$get_key] = str_replace("sleep", "", $_COOKIE[$get_key]);
       	   $_COOKIE[$get_key] = str_replace("%20", "", $_COOKIE[$get_key]);
       	   $_COOKIE[$get_key] = str_replace("%27", "", $_COOKIE[$get_key]);
       	   $_COOKIE[$get_key] = str_replace("%2527", "", $_COOKIE[$get_key]);
       	   $_COOKIE[$get_key] = str_replace("xml", "", $_COOKIE[$get_key]);
       	   $_COOKIE[$get_key] = str_replace("{", "", $_COOKIE[$get_key]);
       	   $_COOKIE[$get_key] = str_replace("}", "", $_COOKIE[$get_key]);
       	   $_COOKIE[$get_key] = str_replace("*", "", $_COOKIE[$get_key]);

       }


       foreach($_GET as $get_key=>$get_val){





         if($get_key == "cnt_id")
         {
            if($get_val != "")
            {
               if(!is_numeric($get_val))
                  exit;
            }
         }

         if($get_key == "folder_id")
         {
            if($get_val != "")
            {
               if(!is_numeric($get_val))
                  exit;
            }
         }



         if($get_key == "page")
         {
            if($get_val != "")
            {
               if(!is_numeric($get_val))
                  exit;
            }
         }





     	   if($get_key == "now_url")
         {
              $_GET[$get_key] = str_replace("\"", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("'", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace(";", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace(">", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("<", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("script", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("(", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace(")", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("[", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("]", "", $_GET[$get_key]);
//          	   $_GET[$get_key] = str_replace("%", "", $_GET[$get_key]);
//          	   $_GET[$get_key] = str_replace("+", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("select", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("SELECT", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("deletc", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("DELETE", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("update", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("UPDATE", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("sysdate", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("sleep", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("%20", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("%27", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("%2527", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("xml", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("{", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("}", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("*", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("mouseover", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("%3", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("%2", "", $_GET[$get_key]);
         }
         else
         {
              $_GET[$get_key] = str_replace("\"", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("'", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace(";", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace(">", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("<", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("script", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("(", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace(")", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("[", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("]", "", $_GET[$get_key]);
//          	   $_GET[$get_key] = str_replace("%", "", $_GET[$get_key]);
//          	   $_GET[$get_key] = str_replace("+", "", $_GET[$get_key]);
//          	   $_GET[$get_key] = str_replace("/", "", $_GET[$get_key]);
//          	   $_GET[$get_key] = str_replace("=", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("select", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("SELECT", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("deletc", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("DELETE", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("update", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("UPDATE", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("sysdate", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("sleep", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("%20", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("%27", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("%2527", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("xml", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("{", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("}", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("*", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("mouseover", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("%3", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("%2", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("UNION", "", $_GET[$get_key]);
          	   $_GET[$get_key] = str_replace("union", "", $_GET[$get_key]);


         }
     	 }

     	 foreach($_POST as $get_key=>$get_val)
     	 {
     	     $_POST[$get_key] = str_replace("\"", "", $_POST[$get_key]);
       	   $_POST[$get_key] = str_replace("'", "", $_POST[$get_key]);
       	   $_POST[$get_key] = str_replace(";", "", $_POST[$get_key]);
       	   $_POST[$get_key] = str_replace(">", "", $_POST[$get_key]);
       	   $_POST[$get_key] = str_replace("<", "", $_POST[$get_key]);
       	   $_POST[$get_key] = str_replace("script", "", $_POST[$get_key]);
       	   $_POST[$get_key] = str_replace("(", "", $_POST[$get_key]);
       	   $_POST[$get_key] = str_replace(")", "", $_POST[$get_key]);
       	   $_POST[$get_key] = str_replace("select", "", $_POST[$get_key]);
       	   $_POST[$get_key] = str_replace("SELECT", "", $_POST[$get_key]);
       	   $_POST[$get_key] = str_replace("deletc", "", $_POST[$get_key]);
       	   $_POST[$get_key] = str_replace("DELETE", "", $_POST[$get_key]);
       	   $_POST[$get_key] = str_replace("update", "", $_POST[$get_key]);
       	   $_POST[$get_key] = str_replace("UPDATE", "", $_POST[$get_key]);
       	   $_POST[$get_key] = str_replace("sysdate", "", $_POST[$get_key]);
       	   $_POST[$get_key] = str_replace("sleep", "", $_POST[$get_key]);
       	   $_POST[$get_key] = str_replace("%20", "", $_POST[$get_key]);
       	   $_POST[$get_key] = str_replace("%27", "", $_POST[$get_key]);
       	   $_POST[$get_key] = str_replace("%2527", "", $_POST[$get_key]);
       	   $_POST[$get_key] = str_replace("xml", "", $_POST[$get_key]);
       	   $_POST[$get_key] = str_replace("{", "", $_POST[$get_key]);
       	   $_POST[$get_key] = str_replace("}", "", $_POST[$get_key]);
       	   $_POST[$get_key] = str_replace("*", "", $_POST[$get_key]);

       }

	   #接收LINE購物提供LINE用戶身份識別碼	$_GET['utm_source']=="lineshopping" && $_GET['utm_medium']=="partnership"
	   session_start();
	   $session_ID = session_id();
	   if( $_GET['ecid']){
		   setcookie("ecid",$_GET['ecid'],time() + 60*60*24);
		   $_COOKIE['ecid'] = $_GET['ecid'];
		   $_SESSION['ecid'] = $_GET['ecid'];
//		   print_r($_COOKIE);
	   }



	   // 取得使用裝置   mobile  tablet  desktop
    $global_ua=userAgent($_SERVER['HTTP_USER_AGENT']);










?>
