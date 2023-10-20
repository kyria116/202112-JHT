<?
#信件內容
function get_mail_html_content_new($mail_title,$mail_arr){
	$return_html = '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>'.$mail_title.'</title>

</head>';
	$return_html .= '<body>
    <div
        style="width: 370px; background: #f2f2f2; padding: 30px;font-size: 14px; margin: 200px auto; font-family: Microsoft JhengHei;">
        <h3>'.$mail_title.'</h3>
        <hr>';
    foreach($mail_arr as $key => $val){
	    if($val){
		    $return_html .= '<p><b>'.$key.'：</b></p>
	        <p>'.$val.'</p>';
        }
    }
    $return_html .= '</div>';
    if(substr_count($mail_title,"訂單成立")>=1){
    	$return_html .= "<br><br><br>本公司保留接受訂單與否的權利，若因交易條件有誤、商品無庫存或有其他本公司無法接受訂單之情形，本公司將以email通知您訂單不成立/取消訂單。";
    }    
	$return_html .= '</body>

</html>';
	return $return_html;
}

#信件內容
function get_mail_html_content($mail_title,$order_info,$show_order = ""){
	global $MYSQL_VARS,$dblink,$MYSQL_TABS,$global_website_url;
    $order_id = $order_info['Fmain_id'];

    $order_info=array();
    $where_clause="Fmain_id = '$order_id'";
    $tbl_name="sys_portal_y100";
    get_data($tbl_name, $where_clause, $order_info);
    //show_array($order_info);


	$pay_customer = "";
    if($order_info['pay_type'] == "ATM繳費"){
	    $pay_customer = "銀行代碼/名稱：".$order_info['vmatm_bankcode']."/".$order_info['vmatm_bankname']."。銀行帳戶：".$order_info['vmatm_account']."。繳款期限：".$order_info['vmatm_pay_expired']."。";
    }
    else if($order_info['pay_type'] == "超商代碼"){
	    $pay_customer = "代碼：".$order_info['PaymentNo']."。繳款期限：".$order_info['vmatm_pay_expired']."。";
    }
    else if($order_info['pay_type'] == "超商條碼"){

        // $bar_code1 = bar_code_new($order_info['Barcode1'],$order_info['order_num']."-1.gif");
        // $bar_code2 = bar_code_new($order_info['Barcode2'],$order_info['order_num']."-2.gif");
        // $bar_code3 = bar_code_new($order_info['Barcode3'],$order_info['order_num']."-3.gif");

        // $pay_customer = "條碼1：<img src='".$bar_code1."'><br>";
        // $pay_customer.= "條碼2：<img src='".$bar_code2."'><br>";
        // $pay_customer.= "條碼3：<img src='".$bar_code3."'><br>";
        $pay_customer.= "繳款期限：".$order_info['vmatm_pay_expired']."。";
    }
    else if($order_info['pay_type'] == "信用卡付款" && $order_info['credit_card_split']){
	    $pay_customer = "分期期數：".$order_info['credit_card_split']."。";
    }
	$mail_data = array("訂單編號"=>$order_info['order_num'],"訂單金額"=>$order_info['sum_total'],"訂購日期"=>$order_info['order_complate_time'],"付款方式"=>$order_info['pay_type'],"付款資訊"=>$pay_customer,"備註"=>$order_info['send_note']);
	$return_html = '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>'.$mail_title.'</title>

</head>';
	$return_html .= '<body>
    <div
        style="width: 370px; background: #f2f2f2; padding: 30px;font-size: 14px; margin: 200px auto; font-family: Microsoft JhengHei;">
        <h3>'.$mail_title.'</h3>
        <hr>';
    foreach($mail_data as $key => $val){
	    if($val){
		    $return_html .= '<p><b>'.$key.'：</b></p>
	        <p>'.$val.'</p>';
        }
    }
    $return_html .= '</div>';
    if($show_order){
//	    $url = "http://hueiyeh.mak66design2.com/login_admin/manager_portal_y100_cnt.php?Pact=manager_portal_y100_cnt&portal_y100_id=".$show_order."&clear=1&chk=1";
	    $url = $global_website_url."login_admin/manager_portal_y100_cnt.php?Pact=manager_portal_y100_cnt&portal_y100_id=".$show_order."&clear=1&chk=1";
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($curl);
		curl_close($curl);
		$result_arr = explode("<span class='cut'></span>", $result);
		$return_html .= $result_arr[0].$result_arr[2];
    }
    if(substr_count($mail_title,"訂單成立")>=1){
    	$return_html .= "<br><br><br>本公司保留接受訂單與否的權利，若因交易條件有誤、商品無庫存或有其他本公司無法接受訂單之情形，本公司將以email通知您訂單不成立/取消訂單。";
    }
	$return_html .= '</body>

</html>';
	return $return_html;
}


function bar_code_new($bar_code,$name){

    $bc = new Barcode39($bar_code);
    $bc->draw("./bar_code/".$name);

    // $barcode_url="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
    // $deal_url = explode("/", $_SERVER['PHP_SELF']);
    // $deal_url = $deal_url[count($deal_url)-1];
    // $barcode_url = str_replace($deal_url,"bar_code/".$name , $barcode_url);

//    $barcode_url = "http://hueiyeh.mak66design2.com/bar_code/".$name;
    $barcode_url = "https://www.hueiyeh.com.tw/bar_code/".$name;

    return $barcode_url;
}

function get_x100_cnt_product_info($cnt_id,$is_en){

    $today = date("Y-m-d");
    $time_sql = " and sys_start_date<='".$today."' and sys_end_date>='".$today."'";

    $each_info=array();
    $where_clause="Fmain_id='".$cnt_id."' ".$time_sql." and is_hide='2'";
    $tbl_name="sys_portal_x100_cnt";
    get_data($tbl_name, $where_clause, $each_info);
    // show_array($each_info);


    if(count($each_info)<1){
        return "";
    }

    if($is_en && $each_info['pic_field_15']!=""){
        $pic_num = explode(",", $each_info['pic_field_15'])[0];
    }else{
        $pic_num = explode(",", $each_info['pic_field_6'])[0];
    }

    $each_info['pic_path'] =  get_pic_path_2($pic_num)['pic_file'];

    $each_info['price_arr'] = get_x100_cnt_price($each_info['Fmain_id']);

    return $each_info;
}



function get_x100_cnt_price($x100_cnt_id){
    $x100_cnt_info=array();
    $where_clause="Fmain_id='".$x100_cnt_id."'";
    $tbl_name="sys_portal_x100_cnt";
    get_data($tbl_name, $where_clause, $x100_cnt_info);
    // show_array($x100_cnt_info);

    $price_arr = array();
    if($x100_cnt_info['text_field_2']!=""){//原價
        $price_arr['price_1']=$x100_cnt_info['text_field_2'];
    }

    if($_COOKIE['member_userid']!="" && $x100_cnt_info['text_field_8']!=""){ //會員價
        $price_arr['price_2']=$x100_cnt_info['text_field_8'];
    }elseif($x100_cnt_info['text_field_3']!=""){ //優惠價
        $price_arr['price_2']=$x100_cnt_info['text_field_3'];
    }


    return $price_arr;

}

function get_yt_info($url){

    $arr = array();

    $yt_id = explode("v=", $url)[1];
    $yt_id = explode("&",$yt_id)[0];

    $arr['pic_maxresdefault'] = "http://img.youtube.com/vi/".$yt_id."/maxresdefault.jpg"; //高解析度大圖（1280 × 720）
    $arr['pic_sddefault'] = "http://img.youtube.com/vi/".$yt_id."/0.jpg"; //標準清晰圖 （640 × 480）	sddefault.jpg
    $arr['pic_hqdefault'] = "http://img.youtube.com/vi/".$yt_id."/hqdefault.jpg"; //高品質縮圖（480×360）
    $arr['pic_0'] = "http://img.youtube.com/vi/".$yt_id."/0.jpg"; //播放器背景縮圖（480×360）
    $arr['pic_1'] = "http://img.youtube.com/vi/".$yt_id."/1.jpg"; //影片開始畫面縮圖（120×90）
    $arr['pic_2'] = "http://img.youtube.com/vi/".$yt_id."/2.jpg"; //影片中間片段縮圖（120×90）
    $arr['pic_3'] = "http://img.youtube.com/vi/".$yt_id."/3.jpg"; //影片結束縮圖（120×90）
    $arr['embed_vedio'] = "https://www.youtube.com/embed/".$yt_id; //崁入網址

    return $arr;
}

function get_pic_path_2($file_id){
    global $MYSQL_VARS,$dblink,$MYSQL_TABS;


    if($file_id != "")
    {
        $pic_info=array();
        $where_clause="Fmain_id = '".$file_id."'";
        $tbl_name=$MYSQL_TABS['sys_file'];
        get_data($tbl_name, $where_clause, $pic_info);
        //show_array($pic_info);

        if($pic_info['file_path'] != "")
        {
            $temp_arr=array();
            $temp_arr=explode("/",$pic_info['file_path']);
            $temp_arr2=array();
            $temp_arr2=explode(".",$temp_arr[1]);

            $thumbs_picname="./login_admin/upload_file/".$temp_arr[0]."/".$temp_arr2[0]."_thumbs.".$temp_arr2[1];

            $info['pic_file']="./login_admin/upload_file/".$pic_info['file_path'];

//            if(is_file("login_admin/upload_file/$thumbs_picname"))
               $info['thumbs_pic_file']=$thumbs_picname;


            $thumbs_picname="./login_admin/upload_file/".$temp_arr[0]."/".$temp_arr2[0]."_thumbs2.".$temp_arr2[1];

            if(is_file("login_admin/upload_file/$thumbs_picname"))
            $info['thumbs2_pic_file']=$thumbs_picname;   // 縮圖560*290


            $thumbs_picname="./login_admin/upload_file/".$temp_arr[0]."/".$temp_arr2[0]."_thumbs3.".$temp_arr2[1];

            if(is_file("login_admin/upload_file/$thumbs_picname"))
            $info['thumbs3_pic_file']=$thumbs_picname;   // 縮圖220*90


            $thumbs_picname="./login_admin/upload_file/".$temp_arr[0]."/".$temp_arr2[0]."_thumbs4.".$temp_arr2[1];

//            if(is_file("login_admin/upload_file/$thumbs_picname"))
            $info['thumbs4_pic_file']=$thumbs_picname;   // 縮圖792*XX   公司banner圖



        }
    }


    return $info;



}


function get_pic_path($file_id)
{
    global $MYSQL_VARS,$dblink,$MYSQL_TABS;


    if($file_id != "")
    {
        $pic_info=array();
        $where_clause="Fmain_id = '".$file_id."'";
        $tbl_name=$MYSQL_TABS['sys_file'];
        get_data($tbl_name, $where_clause, $pic_info);
        //show_array($pic_info);

        if($pic_info['file_path'] != "")
        {
            $temp_arr=array();
            $temp_arr=explode("/",$pic_info['file_path']);
            $temp_arr2=array();
            $temp_arr2=explode(".",$temp_arr[1]);

            $thumbs_picname=$temp_arr[0]."/".$temp_arr2[0]."_thumbs.".$temp_arr2[1];

            $info['pic_file']=$pic_info['file_path'];

            if(is_file("login_admin/upload_file/$thumbs_picname"))
               $info['thumbs_pic_file']=$thumbs_picname;


            $thumbs_picname=$temp_arr[0]."/".$temp_arr2[0]."_thumbs2.".$temp_arr2[1];

            if(is_file("login_admin/upload_file/$thumbs_picname"))
            $info['thumbs2_pic_file']=$thumbs_picname;   // 縮圖560*290


            $thumbs_picname=$temp_arr[0]."/".$temp_arr2[0]."_thumbs3.".$temp_arr2[1];

            if(is_file("login_admin/upload_file/$thumbs_picname"))
            $info['thumbs3_pic_file']=$thumbs_picname;   // 縮圖220*90


            $thumbs_picname=$temp_arr[0]."/".$temp_arr2[0]."_thumbs4.".$temp_arr2[1];

//            if(is_file("login_admin/upload_file/$thumbs_picname"))
            $info['thumbs4_pic_file']=$thumbs_picname;   // 縮圖792*XX   公司banner圖



        }
    }


    return $info;



}

?>
