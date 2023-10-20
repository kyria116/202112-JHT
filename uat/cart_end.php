<?
// ini_set('display_errors','1');
// error_reporting(E_ALL);
  header("Content-Type:text/html; charset=utf-8");

  require_once ("global_include_file.php");
  require_once ("login_admin/library/function_portal.php");

  $session_ID=$_POST['session_ID'];
  $invoice_type_arr = array("b-1"=>"雲端發票","b-2"=>"紙本發票-二聯式","b-3"=>"紙本發票-三聯式");
  $pay_type_arr = array("p-1"=>"信用卡付款","p-2"=>"ATM繳費","p-3"=>"超商代碼","p-4"=>"超商條碼","p-5"=>"貨到付款","p-6"=>"中租零卡分期");

  session_id($session_ID);
  session_start();
  $kol_info = array();
  #沒有POST值就直接GG
  if(!$_POST['FO_pay_type'] && !$_POST['FO_invoice_type']){
	  exit;
  }
  backup_log_from_arr("REQUEST",$_REQUEST);
  $ARR_Update=array();
  foreach ($_POST as  $Rfield => $Rvalue)
 	{
 	   if (substr($Rfield,0,3)=="FO_") {
       	    $Rfield = str_replace ("FO_", "", $Rfield);
       	    if (!get_magic_quotes_gpc()) {
                   $Rvalue = AddSlashes($Rvalue);
            }
                $ARR_Update[$Rfield] = $Rvalue;
 	   }
 	}
 	$ARR_Update['member_userid'] = trim($_COOKIE['member_userid']);
 	if($ARR_Update['recipient_address_2'])	$ARR_Update['recipient_address'] = $ARR_Update['recipient_address_2'];
 	unset($ARR_Update['recipient_address_2']);
 	if($ARR_Update['invoice_type'])	$ARR_Update['invoice_type'] = $invoice_type_arr[$ARR_Update['invoice_type']];
 	if($ARR_Update['pay_type'])	$ARR_Update['pay_type'] = $pay_type_arr[$ARR_Update['pay_type']];
 	$where_clause="uniqid_str = '".$_SESSION['uniqid_str']."' and order_num='".$_SESSION['order_num']."'  ";
  $tbl_name=$MYSQL_TABS['portal_y100'];
  update_data($tbl_name, $where_clause, $ARR_Update);
  // show_array($ARR_Update);

//    print $session_ID."<hr>";

//    show_array($_SESSION);


 /******************************
      檢查訂單商品單價及商品加購和贈品
  *******************************/
  $order_info=array();
 	$where_clause=" uniqid_str = '".$_SESSION['uniqid_str']."' and order_num='".$_SESSION['order_num']."' ";
 	$tbl_name=$MYSQL_TABS['portal_y100'];
 	get_data($tbl_name, $where_clause, $order_info);

  $order_cnt_info=array();
 	$where_clause=" portal_y100_id='".$order_info['Fmain_id']."' order by Fmain_id asc";
 	$tbl_name=$MYSQL_TABS['portal_y100_cnt'];
 	getall_data($tbl_name, $where_clause, $order_cnt_info);

 	if($order_info['use_code']){
	 	$code_use = code_use($order_info['use_code'],$order_info['member_userid'],$order_info['Fmain_id']);
	 	if($code_use['error']){
		 	mb_http_output ("UTF-8");
            mb_internal_encoding("UTF-8");
            ob_start ("mb_output_handler");
            print "<script>";
       	    print "alert('".$code_use['error']."');";
       	    print "window.location.href='cart.php';";
       	    print "</script>";
      		exit;
	 	}
 	}
 	if($order_info['coupon_id']){
	 	$code_use = coupon_use($order_info['coupon_id'],$order_info['member_userid'],$order_info['Fmain_id']);
	 	if($code_use['error']){
		 	mb_http_output ("UTF-8");
            mb_internal_encoding("UTF-8");
            ob_start ("mb_output_handler");
            print "<script>";
       	    print "alert('".$code_use['error']."');";
       	    print "window.location.href='cart.php';";
       	    print "</script>";
      		exit;
	 	}
 	}
 	
  for($i=0;$i<count($order_cnt_info);$i++)
  {
      $today=date("Y-m-d");
      
      if($order_cnt_info[$i]['is_addbuy'] == "2")
      {
         $product_price = get_c1_cnt_price_normal($order_cnt_info[$i]['product_id'],$order_cnt_info[$i]['size_id'],$login_userid);

         $temp_small_price=$product_price * (int)$order_cnt_info[$i]['amount'];

         if($product_price != $order_cnt_info[$i]['price'])
         {
            mb_http_output ("UTF-8");
            mb_internal_encoding("UTF-8");
            ob_start ("mb_output_handler");
            print "<script>";
       	    print "alert('請您確認商品售價，謝謝！');";
       	    print "window.location.href='cart.php';";
       	    print "</script>";
          		exit;
         }
         if($order_info['kol_id']){#檢查kol時效過了沒
			$kol_info=array(); //贈品資訊
			$where_clause=" Fmain_id = '".$order_info['kol_id']."' and (sys_start_date <= '$today' and sys_end_date >= '$today')";
			$tbl_name="sys_portal_j3";
			get_data($tbl_name, $where_clause, $kol_info);
			$all_cnt_gift_info=array(); //贈品資訊
		    $where_clause="1 and x100_cnt_id ='".$order_info['kol_id']."'";
		    $tbl_name="sys_portal_j3_gift";
		    getall_data($tbl_name, $where_clause, $all_cnt_gift_info);
			if(!$kol_info['Fmain_id']){
				$del_info = array();
				$del_info['portal_y100_id'] = $order_info['Fmain_id'];
				$del_info['Fmain_id'] = $order_cnt_info[$i]['Fmain_id'];
				$tbl_name=$MYSQL_TABS['portal_y100_cnt'];
				del_data($tbl_name, $del_info);
				mb_http_output ("UTF-8");
				mb_internal_encoding("UTF-8");
				ob_start ("mb_output_handler");
				print "<script>";
				print "alert('請您更新優惠品資訊，謝謝！');";
				print "window.location.href='cart.php';";
				print "</script>";
				exit; 
			}
			if(count($all_cnt_gift_info)>0 && !$order_cnt_info[$i]['give_text']){
				$del_info = array();
				 $del_info['portal_y100_id'] = $order_info['Fmain_id'];
				 $del_info['Fmain_id'] = $order_cnt_info[$i]['Fmain_id'];
				 $tbl_name=$MYSQL_TABS['portal_y100_cnt'];
				 del_data($tbl_name, $del_info);
				 mb_http_output ("UTF-8");
				 mb_internal_encoding("UTF-8");
				 ob_start ("mb_output_handler");
				 print "<script>";
				 print "alert('請您更新贈品資訊，謝謝！');";
				 print "window.location.href='cart.php';";
				 print "</script>";
				 exit;
			}
	      }
         if($order_cnt_info[$i]['is_give'] == "1" && $kol_info['product_id']==$order_cnt_info[$i]['product_id']){#贈品
	         $del_give = 0;
	         $kol_info=array(); //贈品資訊
			$where_clause=" Fmain_id = '".$order_info['kol_id']."' and (sys_start_date <= '$today' and sys_end_date >= '$today')";
			$tbl_name="sys_portal_j3";
			get_data($tbl_name, $where_clause, $kol_info);
	         $all_cnt_gift_info=array(); //贈品資訊
		    $where_clause="1 and x100_cnt_id ='".$order_info['kol_id']."'";
		    $tbl_name="sys_portal_j3_gift";
		    getall_data($tbl_name, $where_clause, $all_cnt_gift_info);
			 #show_array($all_cnt_gift_info);exit;
			 $give_text_arr = explode("`", $order_cnt_info[$i]['give_text']);
			 $send_name_arr = array();
			 
			 for($jj=0;$jj<count($all_cnt_gift_info);$jj++){
				 if(!in_array($all_cnt_gift_info[$jj]['product_name'], $give_text_arr) && $kol_info['gift_id'] == "2"){
					 $del_give = 1;
				 }
				 $send_name_arr[] = $all_cnt_gift_info[$jj]['product_name'];
			 }
			 
			 foreach($give_text_arr as $give_text){
				 if(!in_array($give_text, $send_name_arr)){
					 $del_give = 1;
				 }
			 }
			 if($del_give){
				 $del_info = array();
				 $del_info['portal_y100_id'] = $order_info['Fmain_id'];
				 $del_info['Fmain_id'] = $order_cnt_info[$i]['Fmain_id'];
				 $tbl_name=$MYSQL_TABS['portal_y100_cnt'];
				 del_data($tbl_name, $del_info);
				 mb_http_output ("UTF-8");
				 mb_internal_encoding("UTF-8");
				 ob_start ("mb_output_handler");
				 print "<script>";
				 print "alert('請您更新贈品資訊，謝謝！');";
				 print "window.location.href='cart.php';";
				 print "</script>";
				 exit;
			 }
         }
         else if($order_cnt_info[$i]['is_give'] == "1"){#贈品
	         $give_text_arr = explode("`", $order_cnt_info[$i]['give_text']);
	         #show_array($give_text_arr);exit;
	         foreach($give_text_arr as $give_text){
		         $all_cnt_gift_info=array(); //贈品資訊
				 $where_clause="1 and x100_cnt_id ='".$order_cnt_info[$i]['product_id']."' and product_name = '".$give_text."'";
				 $tbl_name="sys_portal_x100_cnt_gift";
				 get_data($tbl_name, $where_clause, $all_cnt_gift_info);

				 if(!$all_cnt_gift_info['Fmain_id']){				 
					 $del_info = array();
					 $del_info['portal_y100_id'] = $order_info['Fmain_id'];
					 $del_info['Fmain_id'] = $order_cnt_info[$i]['Fmain_id'];
					 $tbl_name=$MYSQL_TABS['portal_y100_cnt'];
					 del_data($tbl_name, $del_info);
					 mb_http_output ("UTF-8");
					 mb_internal_encoding("UTF-8");
					 ob_start ("mb_output_handler");
					 print "<script>";
					 print "alert('請您更新贈品資訊，謝謝！');";
					 print "window.location.href='cart.php';";
					 print "</script>";
					 exit;
				 }
			 }
         }
      }
	  else if($order_cnt_info[$i]['is_addbuy'] == "1"){#加購品
		  $s_product_info=array(); //加購產品
		  $where_clause="Fmain_id ='".$order_cnt_info[$i]['s_product_id']."'";
		  $tbl_name=$MYSQL_TABS['portal_y100_cnt'];
		  get_data($tbl_name, $where_clause, $s_product_info);
		  $all_cnt_add_buy_info=array(); //加購產品
		  $where_clause="1 and x100_cnt_id ='".$s_product_info['product_id']."' and product_name = '".$order_cnt_info[$i]['product_name']."'";
		  $tbl_name="sys_portal_x100_cnt_add_buy";
		  get_data($tbl_name, $where_clause, $all_cnt_add_buy_info);
		  
		  if(!$all_cnt_add_buy_info['Fmain_id']){
			 mb_http_output ("UTF-8");
			 mb_internal_encoding("UTF-8");
			 ob_start ("mb_output_handler");
			 print "<script>";
			 print "alert('請您更新加購品資訊，謝謝！');";
			 print "window.location.href='cart.php';";
			 print "</script>";
			 exit;
		 }
	  }
  }


	#檢查庫存開始#
	$cant_save = "";

	$order_info=array();
	$where_clause=" uniqid_str = '".$_SESSION['uniqid_str']."' and order_num='".$_SESSION['order_num']."' ";
	$tbl_name=$MYSQL_TABS['portal_y100'];
	get_data($tbl_name, $where_clause, $order_info);

 $order_cnt_info=array();
	$where_clause=" portal_y100_id='".$order_info['Fmain_id']."' and is_addbuy = '2' order by Fmain_id asc";
	$tbl_name=$MYSQL_TABS['portal_y100_cnt'];
	getall_data($tbl_name, $where_clause, $order_cnt_info);



	for($j=0;$j<count($order_cnt_info);$j++){
		$c1_cnt_info=array();
  		$where_clause="Fmain_id='".$order_cnt_info[$j]['product_id']."'";
	    $tbl_name="sys_portal_x100_cnt";
	    get_data($tbl_name, $where_clause, $c1_cnt_info);
	    if($c1_cnt_info['is_hide'] == "1" && $kol_info['product_id']!=$c1_cnt_info['Fmain_id'])	$cant_save = 1;
		else if(time()<strtotime($c1_cnt_info['sys_start_date']." 00:00:00"))	$cant_save = 1;
		else if(time()>strtotime($c1_cnt_info['sys_end_date']." 23:59:59"))	$cant_save = 1;
	    else if($c1_cnt_info['is_show_size']=="是"){

    		$size_info=array();
	        $where_clause="portal_x100_cnt_id='".$c1_cnt_info['Fmain_id']."' and Fmain_id='".$order_cnt_info[$j]['size_id']."'";
	        $tbl_name="sys_portal_x100_cnt_size";
	        get_data($tbl_name, $where_clause, $size_info);
	        // show_array($size_info);
	        if($order_cnt_info[$j]['amount'] === "0"){
		        $cant_save = 1;
	        }
	        else if($size_info['text_field_10']<$order_cnt_info[$j]['amount'] && $size_info['text_field_10']!=""){
	        	$cant_save = 1;
	        }
	        else if($size_info['text_field_10'] === "0" && $size_info['text_field_10']!=""){
		        $cant_save = 1;
	        }
        }
        else{
	        if($order_cnt_info[$j]['amount'] === "0"){
		        $cant_save = 1;
	        }
	        else if($c1_cnt_info['stock']<$order_cnt_info[$j]['amount'] && $c1_cnt_info['stock']!=""){
	        	$cant_save = 1;
	        }
	        else if($c1_cnt_info['stock'] === "0" && $c1_cnt_info['stock']!=""){
		        $cant_save = 1;
	        }
        }
	}
	if($cant_save){
	 mb_http_output ("UTF-8");
	 mb_internal_encoding("UTF-8");
	 ob_start ("mb_output_handler");
		print "<script>";
	    print " alert('請您確認商品數量，謝謝！');";
	    print " window.location.href='cart.php';";
	    print "</script>";

		exit;
	}
	#檢查庫存結束#


    $ARR_Update=array();
    foreach ($_POST as  $Rfield => $Rvalue)
   	{
   	   if (substr($Rfield,0,3)=="FO_") {
         	    $Rfield = str_replace ("FO_", "", $Rfield);
         	    if (!get_magic_quotes_gpc()) {
                     $Rvalue = AddSlashes($Rvalue);
              }
                  $ARR_Update[$Rfield] = $Rvalue;
   	   }
   	}
   	$ARR_Update['member_userid'] = trim($_COOKIE['member_userid']);
   	$ARR_Update['pay_state'] = "待付款";
   	if($_COOKIE['ecid'])	$ARR_Update['line_ecid'] = $_COOKIE['ecid'];
   	else if($_SESSION['ecid'])	$ARR_Update['line_ecid'] = $_SESSION['ecid'];
   	#$ARR_Update['is_confirm']="1";
   	$ARR_Update['order_complate_time']=date("Y-m-d H:i:s");
   	if($ARR_Update['invoice_type'])	$ARR_Update['invoice_type'] = $invoice_type_arr[$ARR_Update['invoice_type']];
   	if($ARR_Update['pay_type'])	$ARR_Update['pay_type'] = $pay_type_arr[$ARR_Update['pay_type']];
   	if($ARR_Update['recipient_address_2'])	$ARR_Update['recipient_address'] = $ARR_Update['recipient_address_2'];
 	unset($ARR_Update['recipient_address_2']);

   	$where_clause="uniqid_str = '".$_SESSION['uniqid_str']."' and order_num='".$_SESSION['order_num']."'  ";
    $tbl_name=$MYSQL_TABS['portal_y100'];
    update_data($tbl_name, $where_clause, $ARR_Update);
    // show_array($ARR_Update);
    backup_log_from_arr($tbl_name,$ARR_Update);


  	$order_info=array();
  	$where_clause=" uniqid_str = '".$_SESSION['uniqid_str']."' and order_num='".$_SESSION['order_num']."' ";
  	$tbl_name=$MYSQL_TABS['portal_y100'];
  	get_data($tbl_name, $where_clause, $order_info);
    // show_array($order_info);


	if($order_info['coupon_id']){
	 	if($order_info['pay_type'] != "信用卡付款"){
		 	$upd_info = array();
		 	$upd_info['use_date'] = date("Y-m-d H:i:s");
		 	$where_clause = " coupon_id = '".$order_info['coupon_id']."' and member_userid = '".$order_info['member_userid']."' ";
		 	$tbl_name="member_coupon_list";
		 	update_data($tbl_name, $where_clause, $upd_info);
	 	}	 	
 	}
    /********************
      檢查是不是KOL的訂單
    *********************/
    if($order_info['kol_id'] != "")
    {
       $kol_info=array();
      	$where_clause=" Fmain_id = '".$order_info['kol_id']."'";
      	$tbl_name="sys_portal_j3";
      	get_data($tbl_name, $where_clause, $kol_info);

       $order_cnt_info=array();
      	$where_clause=" portal_y100_id='".$order_info['Fmain_id']."' order by Fmain_id asc";
      	$tbl_name=$MYSQL_TABS['portal_y100_cnt'];
      	getall_data($tbl_name, $where_clause, $order_cnt_info);

      	$kol_sn=0;
      	for($r=0;$r<count($order_cnt_info);$r++)
      	{
      	   if($kol_info['product_id'] == $order_cnt_info[$r]['product_id'])
      	       $kol_sn=1;

      	}


      	if($kol_sn == 0)
      	{
      	    $update_info2=array();
           $update_info2['kol_id']="";
           $where_clause="uniqid_str = '".$_SESSION['uniqid_str']."' and order_num='".$_SESSION['order_num']."'";
           $tbl_name=$MYSQL_TABS['portal_y100'];
           update_data($tbl_name, $where_clause, $update_info2);


      	    $order_info=array();
          	$where_clause=" uniqid_str = '".$_SESSION['uniqid_str']."' and order_num='".$_SESSION['order_num']."' ";
          	$tbl_name=$MYSQL_TABS['portal_y100'];
          	get_data($tbl_name, $where_clause, $order_info);
            // show_array($order_info);
      	}




    }

#訂單備份
$add_info = array();
$add_info = $order_info;
unset($add_info['Fmain_id']);
$tbl_name = "sys_portal_y100_copy";
$return_arr=add_data($tbl_name,$add_info);
#$return_id=$return_arr['newrid'];
backup_log_new("sys_portal_y100",$order_info['Fmain_id']);
$cnt_info=array();
$where_clause=" portal_y100_id = '".$order_info['Fmain_id']."' ";
$tbl_name="sys_portal_y100_cnt";
getall_data($tbl_name, $where_clause, $cnt_info);
for($j=0;$j<count($cnt_info);$j++){
	$add_info = array();
	$add_info = $cnt_info[$j];
	unset($add_info['Fmain_id']);
	$tbl_name = "sys_portal_y100_cnt_copy";
	$return_arr=add_data($tbl_name,$add_info);
	#$return_id=$return_arr['newrid'];
	backup_log_new("sys_portal_y100_cnt",$cnt_info[$j]['Fmain_id']);
}
/*
	#清除cookie
	if($_COOKIE['ecid']){
		setcookie("ecid","");
		$_COOKIE['ecid'] = "";
	}
*/


	if($order_info['pay_type'] == "信用卡付款" || $order_info['pay_type'] == "ATM繳費" || $order_info['pay_type'] == "超商條碼" || $order_info['pay_type'] == "超商代碼"){
		header("Location:auto_allpay_new.php?order_id=".$order_info['Fmain_id']);
		exit;
	}
	else if($order_info['pay_type'] == "中租零卡分期"){
		header("Location:auto_zero_card.php?order_id=".$order_info['Fmain_id']);
		exit;
	}
	else
	{

	    session_unset();
	    session_destroy();


		$update_info=array();
		$update_info['is_confirm'] = "1";
		$where_clause="Fmain_id = '".$order_info['Fmain_id']."'";
        $tbl_name="sys_portal_y100";
        update_data($tbl_name, $where_clause, $update_info);
        set_deduct_inventory($order_info['Fmain_id']);	#扣庫存

	    if($order_info['use_bonus']>=0){//使用紅利
	      $str = "購物金折抵".$order_info['use_bonus']."元";
	      member_bouns_control("-".$order_info['use_bonus'],$order_info['member_userid'],"system",2,$str,$order_info['order_num']); //點數 會員ID 更新者 是否為管理者 備註
	    }

    	if($order_info['pay_type'] == "貨到付款"){
	    		$mail_title = "訂單成立通知";
				$mail_content = get_mail_html_content($mail_title,$order_info,$order_info['Fmain_id']);

				// 取出參數設定
			    $mail_info=array();
			    $mail_info=get_mail_info();
			//    show_array($mail_info);
			//    exit;

                $service_info=array();
                $where_clause="Fmain_id = '1'";
                $tbl_name="sys_service_email";
                get_data($tbl_name, $where_clause, $service_info);
                //show_array($service_info);

			    $Pdata=array();
		        $Pdata['RecvAdd']	= $order_info['send_email'];	        // 收件人地址
		        $Pdata['RecvTi']	    = $order_info['send_man'];           // 收件者名稱
		        $Pdata['SendAdd']	= $mail_info['sendmail_email'];		    // 寄件人地址
		        $Pdata['SendTi']	    = $mail_info['sendmail_name'];		    // 寄件人名稱
		        $Pdata['Subject']	= $mail_title;			   // 主旨
		        $Pdata['MailHTML']	= $mail_content;
		        //$Pdata['Encoding']	= "big5";				            // 信件本體編碼
		        $Pdata['Encoding']	= "utf-8";

			    // 發送郵件類型
			    if($mail_info['mailserver_type'] == "sendmail")
			    {
			        $err = mail_send ($Pdata);
			    }
			    else
			    {
			        $err = mail_smtp ($Pdata);
			    }

			    $Pdata=array();
                $Pdata['RecvAdd']   = $mail_info['order_email'];            // 收件人地址
                $Pdata['RecvAdd']   = $service_info['email_3'];            // 收件人地址
		        $Pdata['RecvTi']	    = $mail_info['sendmail_name'];           // 收件者名稱
		        $Pdata['SendAdd']	= $mail_info['sendmail_email'];		    // 寄件人地址
		        $Pdata['SendTi']	    = $mail_info['sendmail_name'];		    // 寄件人名稱
		        $Pdata['Subject']	= $mail_title;			   // 主旨
		        $Pdata['MailHTML']	= $mail_content;
		        //$Pdata['Encoding']	= "big5";				            // 信件本體編碼
		        $Pdata['Encoding']	= "utf-8";

			    // 發送郵件類型
			    if($mail_info['mailserver_type'] == "sendmail")
			    {
			        $err = mail_send ($Pdata);
			    }
			    else
			    {
			        $err = mail_smtp ($Pdata);
			    }
    	}
    print "<script>";
//    print " alert('謝謝您的訂購');";
    print " window.location.href='".$pay_success_page."?order_id=".$order_info['Fmain_id']."';";
    print "</script>";
	}

?>