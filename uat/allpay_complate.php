<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>購物車</title>
<link href="shop.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?
    
    include_once("global_include_file.php");
    include_once("login_admin/library/function_portal.php");
    require_once ("Barcode39.php");

    $order_id=$_GET['order_id'];

    $order_info=array();
    $where_clause="Fmain_id = '$order_id'";
    $tbl_name="sys_portal_y100";
    get_data($tbl_name, $where_clause, $order_info);
    //show_array($order_info);


    // 處理歐付寶回傳值
    $MerchantID=$_REQUEST['MerchantID'];
    $MerchantTradeNo=$_REQUEST['MerchantTradeNo'];
    $RtnCode=$_REQUEST['RtnCode'];
    $RtnMsg=$_REQUEST['RtnMsg'];

    $TradeNo=$_REQUEST['TradeNo'];
    $TradeAmt=$_REQUEST['TradeAmt'];
    $PaymentDate=$_REQUEST['PaymentDate'];
    $PaymentType=$_REQUEST['PaymentType'];
    $CheckMacValue=$_REQUEST['CheckMacValue'];
    $card4no=$_REQUEST['card4no'];

    $gwsr=$_REQUEST['gwsr'];

	$get_log = "";
	// 儲存紀錄
    foreach($_REQUEST as $key => $value)
    {
        $get_log .= "&".$key."=".$value;
    }
    $update_info=array();
    $update_info['get_log']=$get_log;
    $update_info['order_id']=$order_id;
    $update_info['now_time']=date("Y-m-d H:i:s");
    $tbl_name="allpay_log";
    add_data($tbl_name,$update_info);

	#$MerchantTradeNo_arr = explode("C", $MerchantTradeNo);

    if($MerchantID == $allpay_setting['MerchantID'] and substr_count($MerchantTradeNo,$order_info['order_num'])>=1 )
    {
        if($RtnCode == "1" or $RtnCode == 1)
        {
            $check_info=$order_info;
            if(count($check_info) > 0 and $check_info['pay_state'] == "待付款")
            {      

                $update_info=array();
                $update_info['is_confirm'] = "1";
                $update_info['pay_state']="待出貨";
                $update_info['pay_ed_time']=date("Y-m-d H:i:s");
                $update_info['card4no']=$card4no;
                $update_info['gwsr']=$gwsr;
                $where_clause="Fmain_id = '$order_id'";
                $tbl_name="sys_portal_y100";
                update_data($tbl_name, $where_clause, $update_info);
                

				if($order_info['pay_type'] == "信用卡付款"){
					$mail_title = "訂單成立通知";
					set_deduct_inventory($order_id);	#扣庫存
					if($order_info['use_bonus']>=0){//使用紅利
	                  $str = "購物金折抵".$order_info['use_bonus']."元";
	                  member_bouns_control("-".$order_info['use_bonus'],$order_info['member_userid'],"system",2,$str,$order_info['order_num']); //點數 會員ID 更新者 是否為管理者 備註
	                }
	                if($order_info['coupon_id']){
					 	$upd_info = array();
					 	$upd_info['use_date'] = date("Y-m-d H:i:s");
					 	$where_clause = " coupon_id = '".$order_info['coupon_id']."' and member_userid = '".$order_info['member_userid']."' ";
					 	$tbl_name="member_coupon_list";
					 	update_data($tbl_name, $where_clause, $upd_info);					 	
				 	}
				}
				else{
						$mail_title = "付款成功通知";
				}
				$mail_content = get_mail_html_content($mail_title,$order_info,$order_id);
                //付款資訊
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
        }
        else
        {
            if( ($order_info['pay_type'] == "ATM繳費" || $order_info['pay_type'] == "超商條碼" || $order_info['pay_type'] == "超商代碼") && $order_info['is_confirm'] != "1" ){
	            $PaymentType_name_arr = array("TAISHIN"=>"台新銀行","ESUN"=>"玉山銀行","BOT"=>"台灣銀行","FUBON"=>"台北富邦","CHINATRUST"=>"中國信託","FIRST"=>"第一銀行","CATHAY"=>"國泰世華銀行","MEGA"=>"兆豐銀行","LAND"=>"台灣土地銀行","TACHONG"=>"元大銀行(原大眾)","SINOPAC"=>"永豐銀行");

// 	            $_REQUEST['ExpireDate']=str_replace("/","",$_REQUEST['ExpireDate']);
// 	            $_REQUEST['ExpireDate']=str_replace("-","",$_REQUEST['ExpireDate']);

	            $update_info=array();
	            $update_info['is_confirm'] = "1";
	            if($_REQUEST['TradeNo'])	$update_info['AllPayLogisticsID']=$_REQUEST['TradeNo'];
	            if(substr_count($_REQUEST['PaymentType'],"_")>=1){
		            $PaymentType_arr = explode("_", $_REQUEST['PaymentType']);
		            $update_info['vmatm_bankname']=$PaymentType_name_arr[$PaymentType_arr[1]];
	            }
	            if($_REQUEST['vAccount'])	$update_info['vmatm_account']=$_REQUEST['vAccount'];
	            if($_REQUEST['BankCode'])	$update_info['vmatm_bankcode']=$_REQUEST['BankCode'];
	            if($_REQUEST['ExpireDate'])	$update_info['vmatm_pay_expired']=$_REQUEST['ExpireDate'];
// 	            if($_REQUEST['ExpireDate'])	$update_info['vmatm_pay_expired']=substr($_REQUEST['ExpireDate'], 0, 4)."-".substr($_REQUEST['ExpireDate'], 4, 2)."-".substr($_REQUEST['ExpireDate'], 6, 2)." 00:00:00";
	            if($_REQUEST['Barcode1'])	$update_info['Barcode1']=$_REQUEST['Barcode1'];
	            if($_REQUEST['Barcode2'])	$update_info['Barcode2']=$_REQUEST['Barcode2'];
	            if($_REQUEST['Barcode3'])	$update_info['Barcode3']=$_REQUEST['Barcode3'];
	            if($_REQUEST['PaymentNo'])	$update_info['PaymentNo']=$_REQUEST['PaymentNo'];

	            $where_clause="Fmain_id = '$order_id'";
                $tbl_name="sys_portal_y100";
	            update_data($tbl_name, $where_clause, $update_info);
	            #show_array($update_info);
				set_deduct_inventory($order_id);	#扣庫存


				if($order_info['use_bonus']>=0){//使用紅利
      $str = "購物金折抵".$order_info['use_bonus']."元";
      member_bouns_control("-".$order_info['use_bonus'],$order_info['member_userid'],"system",2,$str,$order_info['order_num']); //點數 會員ID 更新者 是否為管理者 備註
    }



				$mail_title = "訂單成立通知";
				$mail_content = get_mail_html_content($mail_title,$order_info,$order_id);

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

	            print "1|OK";
            }
            else if($order_info['pay_type'] == "信用卡付款"  && $order_info['pay_state'] == "待付款"){
	            
	            
	            $update_info=array();
	            $update_info['is_confirm']="";
	            $update_info['pay_state']="待付款";
	            $where_clause="Fmain_id = '$order_id'";
	            $tbl_name="sys_portal_y100";
	            update_data($tbl_name, $where_clause, $update_info);
	            if($order_info['pay_type'] != "信用卡付款"){
		            set_restocking($order_id);	#庫存補回
	            }
	            
	            $y100_info = array();
				$where_clause=" Fmain_id = '".$order_id."' ";
			    $tbl_name="sys_portal_y100";
			    get_data($tbl_name, $where_clause, $y100_info);
	            // 如果有使用優惠券  優惠券退回
				if($y100_info['coupon_id'] != "")
			    {
			       $update_info=array();
			       $update_info['use_date']="0000-00-00 00:00:00";
			       $where_clause="coupon_id = '".$y100_info['coupon_id']."' and member_userid = '".$y100_info['member_userid']."'";
			       $tbl_name="member_coupon_list";
			       update_data($tbl_name, $where_clause, $update_info);
			    }

				$mail_title = "付款失敗通知";
				$mail_content = get_mail_html_content($mail_title,$order_info,$order_id);

				// 取出參數設定
			    $mail_info=array();
			    $mail_info=get_mail_info();
			//    show_array($mail_info);
			//    exit;

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
			}

        }

    }

?>
</body>
</html>