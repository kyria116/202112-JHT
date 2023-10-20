<?php
//ini_set('display_errors','1');
//error_reporting(E_ALL);
    require_once ("global_include_file.php");
	if($_GET['test'] == "1"){
		setcookie("test",1);
		$_COOKIE['test']=1;
	}
	$kol_info = array();
    $cnt_id=$_REQUEST['cnt_id'];
    $this_price=$_POST['this_price'];
    $amount=$_POST['amount'];
    $p_size_id=$_POST['p_size_id'];
    $this_price=$_POST['this_price'];
    $product_folder_id=$_POST['product_folder_id'];
    $give_id=$_POST['give_id'];  // 贈品
    $addbuy_id_arr=$_POST['addbuy_id'];  // 加購品

    $login_userid=trim($_COOKIE['member_userid']);




	if($_SESSION['kol_id']){
        $kol_info=array();
       $where_clause="Fmain_id = '".AddSlashes($_SESSION['kol_id'])."' ";# and is_hide='2'
   //    print $where_clause;
       $tbl_name="sys_portal_j3";
       get_data($tbl_name, $where_clause, $kol_info);
       if($kol_info['product_id']==$cnt_id){
	       if($kol_info['gift_id']=="2" ){
		       $all_cnt_gift_info=array(); //贈品資訊
			   $where_clause="1 and x100_cnt_id ='".$_SESSION['kol_id']."'";
			   $tbl_name="sys_portal_j3_gift";
			   getall_data($tbl_name, $where_clause, $all_cnt_gift_info);
			   $new_give_id = array();
			   for($i=0;$i<count($all_cnt_gift_info);$i++){
				   $new_give_id[] = $all_cnt_gift_info[$i]['Fmain_id'];
			   }
	       }
	        else{
		        $new_give_id = $_POST['give_id'];
	        }
	        $give_id = "";
        }
	}

//if($_SERVER['REMOTE_ADDR']=="114.35.245.43"){
//	show_array($_COOKIE);
//}
    /******************************
    1.取得訂單編號(order_num)  識別驗證碼(uniqid_str) 變動唯一碼(owner_num_other)
  *******************************/
    $_SESSION['owner_num_other'] = new_d12_owner_num_other($global_website_userid); //變動唯一碼


    $is_new = true;
    if($_SESSION['uniqid_str'] && $_SESSION['order_num'])
    {

      //如果is_confirm=1 就清 SESSION
      $check_info=array();
      $where_clause="uniqid_str = '".$_SESSION['uniqid_str']."' and order_num='".$_SESSION['order_num']."'  ";
//      print $where_clause;
//      exit;
      $tbl_name=$MYSQL_TABS['portal_y100'];
      get_data($tbl_name, $where_clause, $check_info);
      //show_array($check_info);


      // print "數量：".count($check_info);

      if(count($check_info)>0){
        if($check_info['is_confirm'] != "1"){
          $is_new = false;
        }else{


          $order_num=new_d12_ordernum(); //取得訂單編號
          $uniqid_str=new_d12_uniqid_str(); //識別驗證碼

          $_SESSION['order_num'] = $order_num;
          $_SESSION['uniqid_str'] = $uniqid_str;
        }
      }

      if($check_info['is_confirm'] != "1" && count($check_info)>0){
        $is_new = false;
      }


    }
    else
    {


      $order_num=new_d12_ordernum(); //取得訂單編號

      $uniqid_str=new_d12_uniqid_str(); //識別驗證碼
      $_SESSION['order_num'] = $order_num;
      $_SESSION['uniqid_str'] = $uniqid_str;
    }

//    $is_new = true;
//    $_SESSION['order_num'] = new_d12_ordernum();
//    $_SESSION['uniqid_str'] = new_d12_uniqid_str();


    if($is_new){
      $add_info=array();
      $add_info['userid']="";
      if(trim($login_userid) != ""){
        $add_info['member_userid']=$login_userid;
      }
      $add_info['website_language_id']="1";
      $add_info['owner_num_other']=$_SESSION['owner_num_other'];

      $add_info['uniqid_str']=$_SESSION['uniqid_str'];
      $add_info['order_num']=$_SESSION['order_num'];

      $add_info['order_time']=date("Y-m-d H:i:s");
      $add_info['pay_state']="未入帳";
      //  $add_info['product_state']="處理中";
      $add_info['product_state']="訂單確認中";
      $add_info['kol_id']=$_SESSION['kol_id'];
      $add_info['ip']=get_ip();
      $tbl_name=$MYSQL_TABS['portal_y100'];
      $return_arr=array();
      $return_arr=add_data($tbl_name,$add_info);
      $id=$return_arr['newrid'];
    }else{

      $update_info=array();
      $update_info['owner_num_other']=$_SESSION['owner_num_other'];
      if($kol_info['product_id']==$cnt_id){
      	$update_info['kol_id']=$_SESSION['kol_id'];
      }
      if(trim($login_userid) != ""){
        $update_info['member_userid']=$login_userid;
      }
      $where_clause="uniqid_str = '".$_SESSION['uniqid_str']."' and order_num='".$_SESSION['order_num']."'  ";
      $tbl_name=$MYSQL_TABS['portal_y100'];
      update_data($tbl_name, $where_clause, $update_info);
    }
    /******************************
      取得會員資訊
    *******************************/
      $member_info=array();
      $where_clause="text_field_0 = '".$login_userid."'";
      $tbl_name="sys_portal_g2";
      get_data($tbl_name, $where_clause, $member_info);
      // show_array($member_info);


    /******************************
      取得訂單資訊
    *******************************/
      $order_info=array();
      $where_clause="uniqid_str = '".$_SESSION['uniqid_str']."' and order_num='".$_SESSION['order_num']."'  ";
//      print $where_clause;
      $tbl_name=$MYSQL_TABS['portal_y100'];
      get_data($tbl_name, $where_clause, $order_info);
      //show_array($order_info);
	  if($order_info['coupon_id']){
		  $coupon = coupon_use($order_info['coupon_id'],$login_userid,$order_info['Fmain_id']);
		  if($coupon['error']){
			$update_info=array();
			$update_info['coupon_money']="";
			$update_info['use_coupon']="";
			$update_info['coupon_id']="";
			$update_info['coupon_product_id']="";
			$where_clause="Fmain_id='".$order_info['Fmain_id']."'";
			$tbl_name="sys_portal_y100";
			update_data($tbl_name, $where_clause, $update_info);
			$order_info=array();
			$where_clause=" Fmain_id='".$order_info['Fmain_id']."' ";
			//      print $where_clause;
			$tbl_name=$MYSQL_TABS['portal_y100'];
			get_data($tbl_name, $where_clause, $order_info);
		  }
	  }
	  if($order_info['use_code']){
		  $coupon = code_use($order_info['use_code'],$login_userid,$order_info['Fmain_id']);
		  if($coupon['error']){
			$update_info=array();
			$update_info['code_money']="";
			$update_info['code_name']="";
			$update_info['use_code']="";
			$update_info['code_id']="";
			$update_info['code_product_id']="";
			$where_clause="Fmain_id='".$order_info['Fmain_id']."'";
			$tbl_name="sys_portal_y100";
			update_data($tbl_name, $where_clause, $update_info);
			$order_info=array();
			$where_clause=" Fmain_id='".$order_info['Fmain_id']."' ";
			//      print $where_clause;
			$tbl_name=$MYSQL_TABS['portal_y100'];
			get_data($tbl_name, $where_clause, $order_info);
		  }
	  }

    /******************************
      處理商品資訊
    *******************************/

    $product_info=array();
    $where_clause=" Fmain_id='".$cnt_id."'";
    $tbl_name="sys_portal_x100_cnt";
    get_data($tbl_name, $where_clause, $product_info);#show_array($product_info);
    if($product_info['gift_id'] == "2"){
	    $all_cnt_gift_info=array(); //贈品資訊
	    $where_clause="1 and x100_cnt_id ='".$cnt_id."'";
	    $tbl_name="sys_portal_x100_cnt_gift";
	    getall_data($tbl_name, $where_clause, $all_cnt_gift_info);
	    $give_id = array();
	    for($iii=0;$iii<count($all_cnt_gift_info);$iii++){
		    $give_id[] = $all_cnt_gift_info[$iii]['Fmain_id'];
	    }
    }
    #show_array($give_id);
//exit;
	if($p_size_id){
		$add_sql .= " and size_id = '".$p_size_id."' ";
	}

    $check_cnt_info=array();
    $where_clause=" portal_y100_id='".$order_info['Fmain_id']."' and product_id='".$product_info['Fmain_id']."' $add_sql ";
    $tbl_name=$MYSQL_TABS['portal_y100_cnt'];
    get_data($tbl_name, $where_clause, $check_cnt_info);
//     show_array($check_cnt_info);
//exit;

    //----------------------- 產品價格數量處理 ----------------------------
    $product_price = "";
    $normal_price = get_c1_cnt_price_normal($product_info['Fmain_id'],"",$login_userid);
    if($this_price!="" && $normal_price!=$this_price){ //指定價
      $product_price = $this_price;
    }else{



      if($p_size_id!=""){

        $product_price = get_c1_cnt_price_normal($product_info['Fmain_id'],$p_size_id,$login_userid);
      }elseif($p_sizecolor_id!=""){
        $product_price = get_c1_cnt_price_normal($product_info['Fmain_id'],$p_sizecolor_id,$login_userid);
      }else{
        $product_price = $normal_price;
      }


      $this_price = $product_price;

    }




    if($amount == "0" or $amount == ""){
      $amount="1";
    }
    $small_price = (int)($amount*$this_price);

//    print $small_price;
//    exit;

    // 贈品處理
    if($give_id)
    {
       if(is_array($give_id))	$new_give_id_arr = $give_id;
	   else $new_give_id_arr[] = $give_id;
       $give_info_arr=array();#show_array($new_give_id_arr);
       $give_info_arr=get_give_info($new_give_id_arr);

    }
    #show_array($give_info_arr);
    if($new_give_id){
	    $give_info_arr=array();
	    $new_give_id_arr = array();
	    if(is_array($new_give_id))	$new_give_id_arr = $new_give_id;
	    else $new_give_id_arr[] = $new_give_id;
	    $give_info_arr=get_j3_give_info($new_give_id_arr);
    }


    // 加購品處理
    if(count($addbuy_id_arr) > 0)
    {
       $addbuy_info_arr=array();
       $addbuy_info_arr=get_addbuy_info($addbuy_id_arr);

    }


    //------------------------

    if(count($product_info)>0){


      if(count($check_cnt_info)>0){ //商品已在購物車
        $update_info=array();
        $update_info['pic_file']=AddSlashes($product_info['pic_field_6']);


        $update_info['price']=AddSlashes($this_price);
        $update_info['amount']=AddSlashes($check_cnt_info['amount']+$amount);
        $update_info['small_price'] = AddSlashes($small_price);

        $update_info['product_num']=AddSlashes($product_info['text_field_1']);
        $update_info['product_name']=AddSlashes($product_info['text_field_0']);
		if($product_info['radio_field_16'] == "預購")	$update_info['send_time']=AddSlashes($product_info['text_field_11']);
        $update_info['small_price'] = AddSlashes($small_price);

        if($p_size_id != "")
        {
          $update_info['size_id']=$p_size_id;

          $size_id_text="";
          if($p_size_id != "")
          {
              $size_id_text = get_size_id_text($p_size_id);
              $update_info['size_id_text']=AddSlashes($size_id_text);
              $size_id_number = get_size_id_number($p_size_id);
              if($size_id_number)	$update_info['product_num'] = $size_id_number;
          }
        }

        if($addbuy_id!=""){ //加購品
          $update_info['addbuy_price'] = $product_price;
          $update_info['is_addbuy'] = "1";
          $update_info['s_product_id'] = $addbuy_id; //這個加購商品是跟著哪個商品的
        }

        if(($give_id != "" || $new_give_id != "" ) && AddSlashes($give_info_arr['give_text']))  // 贈品
        {
          $update_info['is_give'] = "1";
          $update_info['give_text'] = AddSlashes($give_info_arr['give_text']);
          $update_info['give_text_pic'] = AddSlashes($give_info_arr['give_text_pic']);
          $update_info['give_num'] = AddSlashes($give_info_arr['give_num']);
        }

        $where_clause="Fmain_id='".$check_cnt_info['Fmain_id']."'";
        $tbl_name=$MYSQL_TABS['portal_y100_cnt'];
        update_data($tbl_name, $where_clause, $update_info);
        $d12_cnt_id = $check_cnt_info['Fmain_id'];
//        print "update";
//        show_array($update_info);
//        exit;

      }
      else
      {
        //新增商品
        $add_info=array();
        $add_info['pic_file']=AddSlashes($product_info['pic_field_6']);
        $add_info['portal_y100_id']=$order_info['Fmain_id'];

        $add_info['price']=AddSlashes($this_price);
        $add_info['amount']=AddSlashes($amount);
        $add_info['small_price'] = AddSlashes($small_price);

        $add_info['product_folder_id']=AddSlashes($product_folder_id);



        if(($give_id != "" || $new_give_id != "") && AddSlashes($give_info_arr['give_text']))  // 贈品
        {
          $add_info['is_give'] = "1";
          $add_info['give_text'] = AddSlashes($give_info_arr['give_text']);
          $add_info['give_text_pic'] = AddSlashes($give_info_arr['give_text_pic']);
          $add_info['give_num'] = AddSlashes($give_info_arr['give_num']);

        }


        $add_info['product_num']=AddSlashes($product_info['text_field_1']);
        $add_info['product_name']=AddSlashes($product_info['text_field_0']);
        $add_info['product_id']=AddSlashes($cnt_id);
        $add_info['now_time']=date("Y-m-d H:i:s");
		if($product_info['radio_field_16'] == "預購")	$add_info['send_time']=AddSlashes($product_info['text_field_11']);

        if($p_size_id != "")
        {
          $add_info['size_id']=$p_size_id;

          $size_id_text="";
          if($p_size_id != "")
          {
              $size_id_text = get_size_id_text($p_size_id);
              $add_info['size_id_text']=AddSlashes($size_id_text);
              $size_id_number = get_size_id_number($p_size_id);
              if($size_id_number)	$add_info['product_num'] = $size_id_number;
          }
        }
        if($p_sizecolor_id != "")
          $add_info['sizecolor_id']=$p_sizecolor_id;



        $add_info['sizecolor_id_text']=AddSlashes($sizecolor_id_text);

        $add_info['price']=AddSlashes($this_price);
        $add_info['amount']=AddSlashes($amount);
        $add_info['small_price'] = AddSlashes($small_price);



        $tbl_name=$MYSQL_TABS['portal_y100_cnt'];
        $return_arr=array();

        $return_arr=add_data($tbl_name,$add_info);
        $d12_cnt_id=$return_arr['newrid'];
//        show_array($add_info);
//        //print $d12_cnt_id;
//        exit;
        $check_go_2 = 1;


        // show_array($add_info);
      }

    }


    if(AddSlashes($cnt_id)!=""){
      // 加購品
      $where_val=array();
      $where_val['s_product_id']=AddSlashes($d12_cnt_id);
      $where_val['portal_y100_id']=$order_info['Fmain_id'];
      $where_val['is_addbuy']="1";
      $tbl_name=$MYSQL_TABS['portal_y100_cnt'];
      del_data($tbl_name, $where_val);


      if(count($addbuy_info_arr) > 0)
      {
         for($k=0;$k<count($addbuy_info_arr);$k++)
         {

           $add_info=array();
           $add_info['portal_y100_id']=$order_info['Fmain_id'];
           $add_info['pic_file']=$addbuy_info_arr[$k]['product_pic'];
           $add_info['price']=AddSlashes($addbuy_info_arr[$k]['add_money']);
           $add_info['amount']="1";
           $add_info['small_price'] = AddSlashes($addbuy_info_arr[$k]['add_money']);
  //         $add_info['product_id']=AddSlashes($cnt_id);
           $add_info['product_name']=AddSlashes($addbuy_info_arr[$k]['addbuy_text']);
           $add_info['product_num']=AddSlashes($addbuy_info_arr[$k]['addbuy_num']);
           $add_info['is_addbuy'] = "1";
           $add_info['s_product_id'] = AddSlashes($d12_cnt_id); //這個加購商品是跟著哪個商品的
           $add_info['now_time']=date("Y-m-d H:i:s");
           $tbl_name=$MYSQL_TABS['portal_y100_cnt'];
           add_data($tbl_name,$add_info);
         }
      }
    }



    /******************************
      取得訂單資訊
    *******************************/
      $order_info=array();
      $where_clause="uniqid_str = '".$_SESSION['uniqid_str']."' and order_num='".$_SESSION['order_num']."'  ";
//      print $where_clause;
      $tbl_name=$MYSQL_TABS['portal_y100'];
      get_data($tbl_name, $where_clause, $order_info);
//      show_array($order_info);


      $order_cnt_info=array();
     	$where_clause=" portal_y100_id='".$order_info['Fmain_id']."'";
     	$tbl_name=$MYSQL_TABS['portal_y100_cnt'];
     	getall_data($tbl_name, $where_clause, $order_cnt_info);


    /******************************
      取得更新訂單商品單價
    *******************************/
    for($i=0;$i<count($order_cnt_info);$i++)
    {
        if($order_cnt_info[$i]['is_addbuy'] == "2")
        {
           $product_price = get_c1_cnt_price_normal($order_cnt_info[$i]['product_id'],$order_cnt_info[$i]['size_id'],$login_userid);

           $temp_small_price=$product_price * (int)$order_cnt_info[$i]['amount'];

           $update_info=array();
           $update_info['price']=AddSlashes($product_price);
           $update_info['small_price']=AddSlashes($temp_small_price);
           $where_clause="Fmain_id = '".AddSlashes($order_cnt_info[$i]['Fmain_id'])."' and portal_y100_id='".AddSlashes($order_info['Fmain_id'])."'";
           $tbl_name=$MYSQL_TABS['portal_y100_cnt'];
           update_data($tbl_name, $where_clause, $update_info);
        }

    }

    $order_cnt_info=array();
   	$where_clause=" portal_y100_id='".$order_info['Fmain_id']."'";
   	$tbl_name=$MYSQL_TABS['portal_y100_cnt'];
   	getall_data($tbl_name, $where_clause, $order_cnt_info);


    /******************************
      KOL資訊
    *******************************/
    #先檢查有kol的商品還在不在
    if($order_info['kol_id'] != "")
    {
	    if(!chk_have_kol($order_info['Fmain_id'])){
		    #print "清kol_id";
		    $order_info=array();
			$where_clause=" Fmain_id = '".$order_id."' ";
			$tbl_name=$MYSQL_TABS['portal_y100'];
			get_data($tbl_name, $where_clause, $order_info);
	    }
	    else{
		    #print "KOL_ID".$order_info['kol_id'];
	    }
    }

    if($order_info['kol_id'] != "")
    {
        $kol_info=array();
        $where_clause="Fmain_id = '".AddSlashes($order_info['kol_id'])."' ";# and is_hide='2'
    //    print $where_clause;
        $tbl_name="sys_portal_j3";
        get_data($tbl_name, $where_clause, $kol_info);
        //show_array($kol_info);

        $order_cnt_info=array();
       	$where_clause=" portal_y100_id='".$order_info['Fmain_id']."' order by Fmain_id asc";
       	$tbl_name=$MYSQL_TABS['portal_y100_cnt'];
       	getall_data($tbl_name, $where_clause, $order_cnt_info);

        $s_order_cnt_info=array();
        $s_order_cnt_info=$order_cnt_info;
        $order_cnt_info=array();

       	$s=0;
       	for($r=0;$r<count($s_order_cnt_info);$r++)
       	{
       	   if($kol_info['product_id'] != $s_order_cnt_info[$r]['product_id'])
       	   {
       	      $order_cnt_info[$s]=$s_order_cnt_info[$r];

       	      $s++;
       	   }

       	}

    }

    /******************************
      滿件優惠
    *******************************/
//    if($order_info['kol_id'] == "")
//    {
       $get_set_product_sale_amount_title="";
       $get_set_product_sale_amount_title=get_set_product_sale_amount($order_info,$order_cnt_info);
//    }
//    else
//    {
//       $get_set_product_sale_amount_title="";
//       $get_set_product_sale_amount_title=get_set_product_sale_amount_kol($order_info,$order_cnt_info);

       if($get_set_product_sale_amount_title == "")
       {
          $update_info=array();
         	$update_info['amount_sale_info_money']="";
         	$update_info['amount_sale_info_money_give_name']="";
         	$where_clause="uniqid_str = '".$_SESSION['uniqid_str']."' and order_num='".$_SESSION['order_num']."'";
         	$tbl_name="sys_portal_y100";
         	update_data($tbl_name, $where_clause, $update_info);
      	}
//    }


    /******************************
      滿額優惠
    *******************************/
//    if($order_info['kol_id'] == "")
//    {
       $get_set_product_sale_title="";
       if($get_set_product_sale_amount_title)	$get_set_product_sale_title .= "<br>";
       $get_set_product_sale_title.=get_set_product_sale($order_info,$order_cnt_info);
//    }
//    else
//    {
//       $get_set_product_sale_title="";
//       $get_set_product_sale_title=get_set_product_sale_kol($order_info,$order_cnt_info);

       if($get_set_product_sale_title == "")
       {
           $update_info=array();
          	$update_info['sale_info_money']="";
          	$update_info['sale_info_give_name']="";
          	$where_clause="uniqid_str = '".$_SESSION['uniqid_str']."' and order_num='".$_SESSION['order_num']."'";
          	$tbl_name="sys_portal_y100";
          	update_data($tbl_name, $where_clause, $update_info);
      	}
//    }

    $order_cnt_info=array();
    $order_cnt_info=$s_order_cnt_info;


    /******************************
      優惠金額 => 滿件優惠或者滿額優惠
    *******************************/
    $order_info=array();
    $where_clause="uniqid_str = '".$_SESSION['uniqid_str']."' and order_num='".$_SESSION['order_num']."'  ";
//      print $where_clause;
    $tbl_name=$MYSQL_TABS['portal_y100'];
    get_data($tbl_name, $where_clause, $order_info);
//      show_array($order_info);


    $all_sale_money=(int)$order_info['sale_info_money']+(int)$order_info['amount_sale_info_money'];






    /******************************
      取得免運費資訊
    *******************************/
    $set_shop_info2=array();
   	$where_clause=" Fmain_id = '2'";
   	$tbl_name="sys_portal_j5";
   	get_data($tbl_name, $where_clause, $set_shop_info2);
    // show_array($set_shop_info2);

    $free_traffic_money=0;
    $free_traffic_money=$set_shop_info2['text_field_1'];

    $free_traffic_money_str="";
    if((int)$free_traffic_money > 0)
       $free_traffic_money_str="滿".$free_traffic_money."免運";



   	/******************************
  		取得產品細項
	  *******************************/
    	$order_cnt_info=array();
    	$where_clause=" portal_y100_id='".$order_info['Fmain_id']."' and is_addbuy = '2' order by Fmain_id asc";
    	$tbl_name=$MYSQL_TABS['portal_y100_cnt'];
    	getall_data($tbl_name, $where_clause, $order_cnt_info);
    	// show_array($order_cnt_info);

      // 更新總價
    	$order_info['sum_total'] = update_d12_total($order_info['Fmain_id']);//更新d12價格


    /******************************
      取得運費並更新
    *******************************/
    $traffic_money=0;
    $traffic_money=get_traffic_money($order_info,$order_cnt_info);

//    print $traffic_money;
//    exit;



    include "quote/template/head.php";
    include "quote/template/css.php";

#GA事件追蹤碼
$ga_even_js="";
$ga_even_js.="<script>";
$ga_even_js.="  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){";
$ga_even_js.="  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),";
$ga_even_js.="  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)";
$ga_even_js.=" })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');\n";
$ga_even_js.="  ga('create', '".$google_analytics_id."', 'auto');\n";
$ga_even_js.="  ga('send', 'pageview');\n";
$ga_even_js.="  ga('require', 'ec');\n";
$ga_even_js.="</script>";
if(trim($google_analytics_id) != "")
{
	$ga_even_js.="<script>\n";
	for($j=0;$j<count($order_cnt_info);$j++)
	{
	    $ga_even_js.="ga('ec:addProduct',{\n";
	    $ga_even_js.="  'id':'".$order_cnt_info[$j]['product_num']."',\n";
	    $ga_even_js.="  'name':'".$order_cnt_info[$j]['product_name']."',\n";;
	    $ga_even_js.="  'price':'".$order_cnt_info[$j]['small_price']."',\n";
	    $ga_even_js.="  'quantity':'".$order_cnt_info[$j]['amount']."'\n";
	    $ga_even_js.="});\n";
	}
	$ga_even_js.="ga('ec:setAction','add');\n";
	$ga_even_js.="ga('ec:setAction','checkout',{'step':1});\n";
	$ga_even_js.="ga('send','pageview');\n";
	$ga_even_js.="</script>\n";
}
print $ga_even_js;

?>
<?
// FB 追蹤碼
$FB_Pixel_Code = "624100515352258";
if(trim($FB_Pixel_Code) != "")
{
?>
    <!-- Facebook Pixel Code -->
	<script>
	!function(f,b,e,v,n,t,s)
	{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	n.callMethod.apply(n,arguments):n.queue.push(arguments)};
	if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
	n.queue=[];t=b.createElement(e);t.async=!0;
	t.src=v;s=b.getElementsByTagName(e)[0];
	s.parentNode.insertBefore(t,s)}(window, document,'script',
	'https://connect.facebook.net/en_US/fbevents.js');
	fbq('init', '<?=trim($FB_Pixel_Code)?>');
	fbq('track', 'PageView');
	fbq('track', 'AddToCart');
	</script>
	<noscript><img height="1" width="1" style="display:none"
	src="https://www.facebook.com/tr?id=<?=trim($FB_Pixel_Code)?>&ev=PageView&noscript=1"
	/></noscript>
	<!-- End Facebook Pixel Code -->

<?
}
?>
<script>
// Email
function checkEmail(string) {
  re = /^.+@.+\..{2,3}$/;
  if (re.test(string))
   return true;
 }

// 數字
function checkNumber(string) {
  re = /^\d+$/;
  if (re.test(string))
   return true;
 }

function form_submit(){

 var error_sn=0;
 var the_alert = "";
 if($("input[name=FO_send_man]").size() > 0)
 {
	 if($("input[name=FO_send_man]").val() == "")
	 {
	     $("#FO_send_man_alert").css("visibility","visible");
	     error_sn=1;
	     the_alert += "姓名必填！\n";
	 }
	 else{
		 $("#FO_send_man_alert").css("visibility","hidden");
	 }
 }

 if($("input[name=FO_send_email]").size() > 0)
 {
	 if($("input[name=FO_send_email]").val() == "")
	 {
	     $("#FO_send_email_alert").css("visibility","visible");
	     error_sn=1;
	     the_alert += "Email必填！\n";
	 }
	 else
	 {
	     var email_str=$("input[name=FO_send_email]").val();

	     if(!checkEmail(email_str)){
	        $("#FO_send_email_alert").html("*請輸入正確格式Email");
	        $("#FO_send_email_alert").css("visibility","visible");
	        error_sn = 1;
	        the_alert += "請輸入正確格式Email！\n";
	    }
	    else{
			 $("#FO_send_email_alert").css("visibility","hidden");
		 }

	 }
 }

if($("input[name='FO_send_handphone']").val()=="" ){ //手機
    $("#FO_send_handphone_alert").css("visibility","visible");
    error_sn = 1;
    the_alert += "手機必填！\n";
}else{

    var a=$("input[name='FO_send_handphone']").val();
	var b=a.slice(0,2);

    if(b != "09")
    {
        error_sn = 1;
        the_alert += "手機格式錯誤，請輸入09開頭的十碼數字！\n";
        $("#FO_send_handphone_alert").html("*格式錯誤，請輸入09開頭的十碼數字");
        $("#FO_send_handphone_alert").css("visibility","visible");
    }
    else if(!checkNumber($("input[name='FO_send_handphone']").val()) || $("input[name='FO_send_handphone']").val().length<10 ){
        $("#FO_send_handphone_alert").html("*格式錯誤，請輸入09開頭的十碼數字");
        $("#FO_send_handphone_alert").css("visibility","visible");
        error_sn = 1;
        the_alert += "手機格式錯誤，請輸入09開頭的十碼數字！\n";
    }
	else{
		 $("#FO_send_handphone_alert").css("visibility","hidden");
	 }
}

 if(1)
 {
	 if($("input[name=FO_send_address]").val() == ""|| $("select[name='FO_send_city']").find(":selected").val()=="" || $("select[name='FO_send_area']").find(":selected").val()=="" )
	 {
	     $("#FO_send_address_alert").css("visibility","visible");
	     error_sn=1;
	     the_alert += "地址必填！\n";
	 }
	 else{
		 $("#FO_send_address_alert").css("visibility","hidden");
	 }
 }

 var invoice_type_str = $('input[name=FO_invoice_type]:checked').val();

 if(invoice_type_str == "紙本發票-三聯式" || invoice_type_str =="b-3")
 {
     if($("input[name=FO_recipient_address]").size() > 0)
     {
	     if($("input[name=FO_recipient_address]").val() == "")
	     {
	         $("#FO_recipient_address_alert").css("visibility","visible");
	         error_sn=1;
	         the_alert += "發票地址必填！\n";
	     }
	     else{
			 $("#FO_recipient_address_alert").css("visibility","hidden");
		 }
     }

     if($("input[name=FO_unification_num]").size() > 0)
     {
	     if($("input[name=FO_unification_num]").val() == "")
	     {
	         $("#FO_unification_num_alert").css("visibility","visible");
	         error_sn=1;
	         the_alert += "公司統編必填！\n";
	     }
	     else{
			 $("#FO_unification_num_alert").css("visibility","hidden");
		 }
     }

     if($("input[name=FO_invoice_title]").size() > 0)
     {
	     if($("input[name=FO_invoice_title]").val() == "")
	     {
	         $("#FO_invoice_title_alert").css("visibility","visible");
	         error_sn=1;
	         the_alert += "公司抬頭必填！\n";
	     }
	     else{
			 $("#FO_invoice_title_alert").css("visibility","hidden");
		 }
     }

 }
 if(invoice_type_str == "紙本發票-二聯式")
 {
     if($("input[name=FO_recipient_address]").size() > 0)
     {
	     if($("input[name=FO_recipient_address]").val() == "")
	     {
	         $("#FO_recipient_address_alert").css("visibility","visible");
	         error_sn=1;
	         the_alert += "發票地址必填！\n";
	     }
	     else{
			 $("#FO_recipient_address_alert").css("visibility","hidden");
		 }
     }

 }


 if(error_sn == 1){
	 alert(the_alert);
	 return false;
 }


 if($("input[name='FO_pay_type']:checked").val() == "信用卡付款"){
	 alert("刷卡過程中請耐心等候，請避免於離開付款頁面或重整網頁，以避免交易失敗或遺失付款紀錄！");
 }

 if(error_sn==0)
 {
    $(".fmbtn").hide();
    $("#show_load").show();
    document.buy_form.submit();
 }

}
</script>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/registration.css">
</head>

<body class="cartPage">
    <?php
        include "quote/template/added.php";
        include "quote/template/nav.php";
    ?>
    <div id="Wrapper">
        <main role="main">
            <div class="sh-banner">
                <img class="pc" src="dist/images/cart/line_1_pc.png">
                <img class="mo" src="dist/images/cart/line_1_mb.png">
                <div class="container">
                    <h2>
                        <div class="e-ti">CART</div>
                        <div class="t-ti">購物車</div>
                    </h2>
                </div>
            </div>
            <?
            $have_hide = 0;
            if(count($order_cnt_info) <= 0)
            {
            ?>
            <div style="text-align:center">
               購物車目前沒有任何商品
            </div>
            <?
            }
            else
            {
            ?>
            <form name="buy_form" method="post" action="cart_end.php">
            <section class="item1">
                <div class="container">
                    <div class="it1-bx">
                        <div class="b-ti">
                            購物清單
                        </div>
                        <div class="ti-bx">
                            <div class="d1">購買產品</div>
                            <div class="d2">規格</div>
                            <div class="d3">數量</div>
                            <div class="d4">單價</div>
                            <div class="d5">小計</div>
                            <div class="d6">移除</div>
                        </div>
                        <ul class="cart-list">
                        <?
                        for($i=0;$i<count($order_cnt_info);$i++)
                        {
                            // 取加購商品
                            $addbuy_info=array();
                            $where_clause="portal_y100_id = '".$order_info['Fmain_id']."' and s_product_id='".$order_cnt_info[$i]['Fmain_id']."' and is_addbuy = '1'";
                            $tbl_name=$MYSQL_TABS['portal_y100_cnt'];
                            getall_data($tbl_name, $where_clause, $addbuy_info);
                            //show_array($addbuy_info);


                            $each_info=array();
                            $where_clause="Fmain_id = '".$order_cnt_info[$i]['product_id']."'";
                            $tbl_name="sys_portal_x100_cnt";
                            get_data($tbl_name, $where_clause, $each_info);
                            // show_array($each_info); //is_show_size

                            // 取的商品圖片
                            $pic_file_arr=array();
                            $pic_file_arr=explode(",",$order_cnt_info[$i]['pic_file']);
                            $pic_url="";
                            $pic_url = get_pic_path_2($pic_file_arr[0]);


                            // 取得所有商品規格
                            $size_info=array();
                            $where_clause=" portal_x100_cnt_id='".$order_cnt_info[$i]['product_id']."' order by Fmain_id asc ";
                            $tbl_name="sys_portal_x100_cnt_size";
                            getall_data($tbl_name, $where_clause, $size_info);
                            // show_array($size_info);

                            // 取得該商品規格
                            $this_size_info=array();
                            $where_clause=" portal_x100_cnt_id='".$order_cnt_info[$i]['product_id']."' and Fmain_id = '".$order_cnt_info[$i]['size_id']."' ";
                            $tbl_name="sys_portal_x100_cnt_size";
                            get_data($tbl_name, $where_clause, $this_size_info);
                            // show_array($this_size_info);


                            // 取得該規格數量
                            $max_amount=0;
                            if(strlen($this_size_info['text_field_10'])>0)
                               $max_amount=$this_size_info['text_field_10'];
                            else if(count($this_size_info))
                               $max_amount=10;
                            else if(strlen($each_info['stock'])>0)
                            	$max_amount=$each_info['stock'];
                        	else
                        		$max_amount=10;

							if($max_amount > 10)	$max_amount = 10;

							$hide = 0;
							if($max_amount == 0)	$hide = 1;
							else if($each_info['is_hide'] == "1" && $kol_info['product_id']!=$each_info['Fmain_id'] )	$hide = 1;
							else if(time()<strtotime($each_info['sys_start_date']." 00:00:00"))	$hide = 1;
							else if(time()>strtotime($each_info['sys_end_date']." 23:59:59"))	$hide = 1;
							if($hide){
								$max_amount = 0;
								$have_hide = 1;
								$order_cnt_info[$i]['amount'] = 0;
								$order_cnt_info[$i]['small_price'] = 0;
							}
							else if($order_cnt_info[$i]['amount'] == 0){
								$order_cnt_info[$i]['amount'] = 1;
								$order_cnt_info[$i]['small_price'] = $order_cnt_info[$i]['price'];
							}

                        ?>
                            <li>
                                <div class="t-flexbx">
                                    <div class="d1">
                                        <div class="img-bx">
                                            <a href="product-detail.php?num=<?=$each_info['text_field_1']?>"><img src="<?=$pic_url['pic_file']?>" alt=""></a>
                                        </div>
                                        <div class="des-bx">
                                            <div class="num"><a href="product-detail.php?num=<?=$each_info['text_field_1']?>"><?=$order_cnt_info[$i]['product_num']?></a></div>
                                            <div class="name"><a href="product-detail.php?num=<?=$each_info['text_field_1']?>"><?=$order_cnt_info[$i]['product_name']?></a></div>
                                            <div class="act">
                                        <?
		                                $sale_amount_log_2_arr = explode("@@@", $order_info['sale_amount_log_1']."@@@".$order_info['sale_amount_log_2']);	#滿件折扣log
	                                    foreach($sale_amount_log_2_arr as $sale_amount_log_2){
		                                    $sale_amount_log_1 = explode("`", $sale_amount_log_2);
			                                if($sale_amount_log_1[2]){
												$if_print = 0;
												if(substr_count($sale_amount_log_1[2],",")>=1){
													 $product_id_arr = explode(",", $sale_amount_log_1[2]);
													 if(in_array($order_cnt_info[$i]['product_id'], $product_id_arr)){
													 	$if_print = 1;
												   	 }
												 }
												 else if($sale_amount_log_1[2]==$order_cnt_info[$i]['product_id']){
													 $if_print = 1;
												 }
												if($if_print){
												?>
												<span><?=$sale_amount_log_1[0]?></span>
												<?
												}
											}
	                                    }

	                                    $sale_amount_log_2_arr = explode("@@@", $order_info['sale_money_log_1']."@@@".$order_info['sale_money_log_2']);	#滿額折扣log
	                                    foreach($sale_amount_log_2_arr as $sale_amount_log_2){
		                                    $sale_amount_log_1 = explode("`", $sale_amount_log_2);
			                                if($sale_amount_log_1[2]){
												$if_print = 0;
												if(substr_count($sale_amount_log_1[2],",")>=1){
													 $product_id_arr = explode(",", $sale_amount_log_1[2]);
													 if(in_array($order_cnt_info[$i]['product_id'], $product_id_arr)){
													 	$if_print = 1;
												   	 }
												 }
												 else if($sale_amount_log_1[2]==$order_cnt_info[$i]['product_id']){
													 $if_print = 1;
												 }
												if($if_print){
												?>
												<span><?=$sale_amount_log_1[0]?></span>
												<?
												}
											}
	                                    }

		                                #折價券log
										$product_id_arr = explode(",", $order_info['coupon_product_id']);
										if(in_array($order_cnt_info[$i]['product_id'], $product_id_arr)){
											$if_print = 1;
										}
										if($if_print){
										?>
										<span><?=$order_info['use_coupon']?></span>
										<?
										}

										#折扣碼log
										$product_id_arr = explode(",", $order_info['code_product_id']);
										if(in_array($order_cnt_info[$i]['product_id'], $product_id_arr)){
											$if_print = 1;
										}
										?>
										<span><?=(($if_print)?$order_info['code_name']:"")?></span>
										<?


	                                    ?>
<!--                                                 <span>七夕情人節優惠活動<i>77</i>折</span> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d2">
                                    <?if($each_info['is_show_size']=="是"){?>
                                        <div class="mo moti">
                                            規格
                                        </div>
                                        <select id="show_size_<?=$order_cnt_info[$i]['Fmain_id']?>" onchange="change_size_or_color('<?=$order_cnt_info[$i]['Fmain_id']?>',this.value);">
                                    <?for($j=0;$j<count($size_info);$j++){
                                        $selected="";
                                        $disabled ="";
                                        if($order_cnt_info[$i]['size_id'] == $size_info[$j]['Fmain_id']){
                                          $selected="selected";
                                        }

                                        if($size_info[$j]['text_field_10']=="0"){
                                          $size_info[$j]['size_name'] = $size_info[$j]['size_name']."(已完售)";
                                          $disabled = "disabled";
                                        }
                                    ?>
                                        <option value="<?=$size_info[$j]['Fmain_id']?>" <?=$selected?> <?=$disabled?> ><?=$size_info[$j]['size_name']?></option>
                                    <?}?>
                                        </select>
                                    <?}?>
                                    </div>
                                    <div class="d3">
                                        <div class="mo moti">
                                            數量
                                        </div>
                                        <select id="12_cnt_<?=$order_cnt_info[$i]['Fmain_id']?>" onchange="add_or_sub('<?=$order_cnt_info[$i]['Fmain_id']?>',this.value,'<?=$order_cnt_info[$i]['product_id']?>');" >
                                        <?
	                                    for($j=1;$j<=$max_amount;$j++)
	                                    {
	                                        $selected="";
	                                        if($j == $order_cnt_info[$i]['amount'])
	                                           $selected="selected";

	                                    ?>
	                                        <option value="<?=$j?>" <?=$selected?>><?=$j?></option>
	                                    <?
	                                    }
	                                    if($max_amount == 0)	print "<option value=''>已售完</option>";
	                                    ?>
                                        </select>
                                    </div>
                                    <div class="d4">
                                        <div class="price-bx">
                                            <div class="mo moti">
                                                單價
                                            </div>
                                            <div class="f20">
                                                <span id="price_<?=$order_cnt_info[$i]['Fmain_id']?>"><?=number_format($order_cnt_info[$i]['price'])?></span>
                                            </div>
                                        </div>
                                        <div class="total-bx">
                                            <div class="mo moti">
                                                小計
                                            </div>
                                            <div class="f20">
                                                <span id="sub_price_<?=$order_cnt_info[$i]['Fmain_id']?>"><?=number_format($order_cnt_info[$i]['small_price'])?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d5">
                                        <a class="remove-btn" href="javascript:del_d12_cnt('<?=$order_cnt_info[$i]['Fmain_id']?>','<?=$order_cnt_info[$i]['product_id']?>');">
                                            <div class="ar"></div>
                                        </a>
                                    </div>
                                </div>
                                <div class="bot-item"><!-- noshow -->
                                    <?
		                            if(count($addbuy_info) > 0){

		                              for($j=0;$j<count($addbuy_info);$j++){
		                                // 取的商品圖片
		                                $pic_file_arr=array();
		                                $pic_file_arr=explode(",",$addbuy_info[$j]['pic_file']);
		                                $pic_url="";
		                                $pic_url = get_pic_path_2($pic_file_arr[0]);
		                                if($hide)	$addbuy_info[$j]['small_price'] = 0;

		                            ?>
                                    <div class="p-item">
                                        <div class="tag">加購產品</div>
                                        <div class="p1">
                                            <div class="simg-bx">
                                                <img src="<?=$pic_url['pic_file']?>" alt="">
                                            </div>
                                            <div class="tx-bx">
                                                <div class="name"><?=$addbuy_info[$j]['product_name']?></div>
                                                <div class="f20">
                                                    <span><?=number_format($addbuy_info[$j]['price'])?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d5">
                                            <a class="remove-btn" href="javascript:del_d12_cnt_add('<?=$addbuy_info[$j]['Fmain_id']?>','<?=$addbuy_info[$j]['s_product_id']?>');">
                                                <div class="ar"></div>
                                            </a>
                                        </div>
                                    </div>
                                    <?
		                                }
		                            }
		                            ?>
		                            <?
		                            if($order_cnt_info[$i]['is_give'] == "1")
		                            {
		                                $give_num_arr = explode("`", $order_cnt_info[$i]['give_num']);
										$give_text_arr = explode("`", $order_cnt_info[$i]['give_text']);
										$give_text_pic_arr = explode("`", $order_cnt_info[$i]['give_text_pic']);
										foreach($give_text_arr as $give_text_key => $give_text_val){
		                                // 取的商品圖片
		                                $pic_file_arr=array();
		                                $pic_file_arr=explode(",",$give_text_pic_arr[$give_text_key]);
		                                $pic_url="";
		                                $pic_url = get_pic_path_2($pic_file_arr[0]);
		                            ?>
                                    <div class="p-item">
                                        <div class="tag">贈品</div>
                                        <div class="p1">
                                            <div class="simg-bx">
                                                <img src="<?=$pic_url['pic_file']?>" alt="">
                                            </div>
                                            <div class="tx-bx">
                                                <div class="name"><?=$give_text_val?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <?
			                          	}
			                          }
		                          ?>
                                </div>
                            </li>
                        <?
                        }
                        ?>

                        </ul>
                    </div>
                </div>
            </section>
            <section class="item2">
                <div class="container">
                    <div class="it2-bx">
                        <div class="l-bx">
                            <?if($login_userid!="")
                          {
                              if((int)$member_info['bonus_num'] < 0)
                                 $member_info['bonus_num']=0;

                              #購物金折抵上限
							$up_bonus = "";
							$set_shop_info3=array();
							$where_clause=" Fmain_id = '3'";
							$tbl_name="sys_portal_j5";
							get_data($tbl_name, $where_clause, $set_shop_info3);
							$small_total= 0;
							for($iii=0;$iii<count($order_cnt_info);$iii++){
								$small_total += $order_cnt_info[$iii]['small_price'];
							}
							if(strlen($set_shop_info3['text_field_1'])>0){
								$total = $small_total; //商品合計
								$total -= $order_info['amount_sale_info_money'];      // 滿件優惠費用
								#$total -= $order_info['coupon_money'];	#折價券
								#$total -= $order_info['code_money'];	#折扣碼
								#$total -= $order_info['sale_info_money'];  // 滿額優惠費用
								$up_bonus = floor($total*intval($set_shop_info3['text_field_1'])/100);		#無條件捨去
							}

                              if((int)$member_info['bonus_num'] >= 0)
                              {
                          ?>
                            <div class="car-pricebx">
                                <div class="blue">
                                    <div class="ti f18">使用購物金</div>
                                    <input type="number" id="use_bonus" name="use_bonus" value="<?=$order_info['use_bonus']?>" max="<?=$member_info['bonus_num']?>">
                                </div>
                                <div class="white">
                                    <div class="ti f18">可用購物金</div>
                                    <div class="tx f18"><?=number_format($member_info['bonus_num'])?></div>
                                </div>
                                <?
	                                if($up_bonus){
                                ?>
                                <!--<div class="white">
                                    <div class="ti f18" style="color:#a5a5a5;font-size:14px;">購物金折抵上限</div>
                                    <div class="tx f18" id="sp_bonus_limit" style="font-size:14px;"><?=number_format($up_bonus)?></div>
                                </div>-->
                                <div class="white white_2">
                                    <div class="ti f18">購物金折抵上限</div>
                                    <div class="tx f18" id="sp_bonus_limit"><?=number_format($up_bonus)?></div>
                                </div>
                                <?
	                                }
                                ?>
                            </div>
                            <?
                             }
                          }
                          ?>
                            <div class="use-bx">
                                <div class="ti f18">使用折扣碼</div>
                                <div class="input-bx">
                                    <input type="text" name="use_code" id="use_code" value="<?=$order_info['use_code']?>">
                                    <div id="code_err" class="used"></div>
                                </div>
                            </div>
                            <div class="promo-bx">
                                <div class="ti f18">優惠活動</div>
                                <div class="tx-bx">
                                    <div><?=$get_set_product_sale_amount_title?><?=$get_set_product_sale_title?></div>
                                    <div id="traffic_str" <?=(($traffic_money>0)?" style='color:#333;'":" style='font-weight:bold;'")?>><?=(($traffic_money==0)?$free_traffic_money_str:"")?></div>
<!--
                                    <div class="g-tx">
                                        滿一件送好禮贈送黑金刮痧按摩椅(不適用)
                                    </div>
-->
                                </div>
                            </div>
                        </div>
                        <div class="r-bx">
                            <ul>
                                <li>
                                    <div>總計</div>
                                    <div id="show_total"><?=number_format(explode("_",update_d12_total($order_info['Fmain_id'],1))[1])?></div>
                                </li>
                                <li>
                                    <div>優惠折抵</div>
                                    <div id="discount_amount">-<?=number_format((($order_info['amount_sale_info_money'])?$order_info['amount_sale_info_money']:0))?></div>
                                </li>
                                <li>
                                    <div>購物金折抵</div>
                                    <div id="discount_bonus">-<?=number_format((($order_info['use_bonus'])?$order_info['use_bonus']:0))?></div>
                                </li>
                                <li>
                                    <div>折扣碼折抵</div>
                                    <div id="discount_code">-<?=number_format((($order_info['code_money'])?$order_info['code_money']:0))?></div>
                                </li>
                                <li>
                                    <div>滿額優惠折抵</div>
                                    <div id="discount_sale">-<?=number_format((($order_info['sale_info_money'])?$order_info['sale_info_money']:0))?></div>
                                </li>
                                <li>
                                    <div>運費</div>
                                    <div id="traffic_money"><?=number_format($traffic_money)?></div>
                                </li>
                                <li>
                                    <div>應付金額</div>
                                    <div id="total"><?=number_format($order_info['sum_total'])?></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <section class="item3">
                <div class="container">
                    <div class="form-bx">
                        <form>
                            <div class="form-tibx">
                                <div class="form-ti f24">收件人資料</div>
                                <div class="checkbox">
                                    <input id="the_same" type="checkbox" name="" onclick="the_samemember();">
                                    <label for="the_same">
                                        <p>同會員資料</p>
                                    </label>
                                </div>
                            </div>
                    <script type="text/javascript">
                      function the_samemember(){
                        if($("#the_same").prop("checked")){
                          $("input[name='FO_send_man']").val("<?=$member_info['text_field_2']?>");
                          $("input[name='FO_send_email']").val("<?=$member_info['text_field_0']?>");
                          $("input[name='FO_recipient_tel']").val("<?=$member_info['text_field_6_1']?>");
                          $("input[name='FO_send_tel']").val("<?=(($member_info['text_field_6_2'])?$member_info['text_field_6_2']:$member_info['text_field_6'])?>");
                          $("input[name='FO_send_handphone']").val("<?=$member_info['text_field_5']?>");
                          $("input[name='FO_send_address']").val("<?=(($member_info['text_field_7_3'])?$member_info['text_field_7_3']:$member_info['text_field_7'])?>");
						  $("#twzipcode").twzipcode('set', {
							    'county': '<?=$member_info['text_field_7_1']?>',
							    'district': '<?=$member_info['text_field_7_2']?>'
							});
                        }
                      }
                    </script>
                            <div class="flex-bx">
                                <div class="form-group">
                                    <label for=""><span>*</span>姓名</label>
                                    <input type="text" name="FO_send_man" placeholder="請輸入真實姓名" value="<?=$order_info['send_man']?>">
                                    <div id="FO_send_man_alert" style="visibility:hidden" class="help-block with-errors">必填</div>
                                </div>
                                <div class="form-group">
                                    <label for=""><span>*</span>手機</label>
                                    <input type="tel" name="FO_send_handphone" placeholder="請輸入手機號碼：例0912345678" value="<?=$order_info['send_handphone']?>" pattern="[0-9]{10}" maxlength="10">
                                    <div id="FO_send_handphone_alert" style="visibility:hidden" class="help-block with-errors">必填</div>
                                </div>
                            </div>
                            <div class="flex-bx">
                                <div class="form-group">
                                    <label for="">市內電話</label>
                                    <div class="tel-bx">
                                        <input type="tel" name="FO_recipient_tel" placeholder="區域號碼"  pattern="[0-9]{2,3}" value="<?=$order_info['recipient_tel']?>">
										<input type="tel" name="FO_send_tel" placeholder="請輸入市內電話"  pattern="[0-9]{6,10}" value="<?=$order_info['send_tel']?>">
                                    </div>
                                    <div id="FO_send_tel_alert" style="visibility:hidden" class="help-block with-errors">必填</div>
                                </div>
                               <div class="form-group">
                                    <label for=""><span>*</span>Email</label>
                                    <input type="email" name="FO_send_email" placeholder="請輸入常用Email"  required value="<?=$order_info['send_email']?>" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,5}$">
                                    <div id="FO_send_email_alert" style="visibility:hidden" class="help-block with-errors">請輸入正確格式Email</div>
                                </div>
                            </div>
                            <div class="flex-bx">
                                <div class="form-group ad-group">
                                    <label for=""><span>*</span>地址</label>
                                    <div class="flex">
                                        <div id="twzipcode"></div>
					                    <input type="text" name="FO_send_address" placeholder="請輸入地址" value="<?=$order_info['send_address']?>">
                                        <div id="FO_send_address_alert" style="visibility:hidden" class="help-block with-errors">必填</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">備註</label>
                                    <input type="text" name="FO_send_note" placeholder="請輸入備註" value="<?=$order_info['send_note']?>">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="flex-bx">
                                <div class="form-group radio-group billgroup">
                                    <label for=""><span>*</span>發票資訊</label>
                                    <div class="radio-flex">
                                        <div class="form-radio">
                                            <input type="radio" required="" value="b-1" id="b-1" name="FO_invoice_type" <?=(($order_info['invoice_type']=="雲端發票" || !$order_info['invoice_type'])?" checked":"")?>>
                                            <label for="b-1">
                                                雲端發票
                                            </label>
                                        </div>
                                        <div class="form-radio">
                                            <input type="radio" required="" value="b-2" id="b-2" name="FO_invoice_type" <?=(($order_info['invoice_type']=="紙本發票-二聯式")?" checked":"")?>>
                                            <label for="b-2">
                                                紙本發票-二聯式
                                            </label>
                                        </div>
                                        <div class="form-radio">
                                            <input type="radio" required="" value="b-3" id="b-3" name="FO_invoice_type" <?=(($order_info['invoice_type']=="紙本發票-三聯式")?" checked":"")?>>
                                            <label for="b-3">
                                                紙本發票-三聯式
                                            </label>
                                        </div>
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group bill-adr <?=(($order_info['invoice_type']=="紙本發票-二聯式" || $order_info['invoice_type']=="紙本發票-三聯式")?" open":"")?>">
                                    <label for=""><span>*</span>發票地址</label>
                                    <input type="text" name="FO_recipient_address" placeholder="請輸入發票地址" value="<?=$order_info['send_address']?>">
                                    <div id="FO_recipient_address_alert" style="visibility:hidden" class="help-block with-errors">必填</div>
                                </div>
                            </div>
                            <div class="flex-bx">
                                <div class="form-group c-lett <?=(($order_info['invoice_type']=="紙本發票-三聯式")?" open":"")?>">
                                    <label for=""><span>*</span>公司抬頭</label>
                                    <input type="text" name="FO_invoice_title" placeholder="請輸入公司抬頭" value="<?=$order_info['invoice_title']?>">
                                    <div id="FO_invoice_title_alert" style="visibility:hidden" class="help-block with-errors">必填</div>
                                </div>
                                <div class="form-group c-edit <?=(($order_info['invoice_type']=="紙本發票-三聯式")?" open":"")?>">
                                    <label for=""><span>*</span>公司統編</label>
                                    <input type="text" name="FO_unification_num" placeholder="請輸入公司統編" value="<?=$order_info['unification_num']?>">
                                    <div id="FO_unification_num_alert" style="visibility:hidden" class="help-block with-errors">必填</div>
                                </div>
                            </div>
                            <div class="flex-bx">
                                <div class="form-group radio-group paygroup">
                                    <label for=""><span>*</span>付款方式</label>
                                    <div class="radio-flex">
                                        <div class="form-radio">
                                            <input type="radio" required="" value="p-1" id="p-1" name="FO_pay_type" <?=(($order_info['pay_type'] == "信用卡付款" || !$order_info['pay_type'])?" checked":"")?>>
                                            <label for="p-1">
                                                信用卡付款
                                            </label>
                                        </div>
                                        <div class="form-radio">
                                            <input type="radio" required="" value="p-2" id="p-2" name="FO_pay_type" <?=(($order_info['pay_type'] == "ATM繳費")?" checked":"")?>>
                                            <label for="p-2">
                                                ATM虛擬代碼繳費
                                            </label>
                                        </div>
                                        <div class="form-radio">
                                            <input type="radio" required="" value="p-3" id="p-3" name="FO_pay_type" <?=(($order_info['pay_type'] == "超商代碼")?" checked":"")?>>
                                            <label for="p-3">
                                                超商代碼
                                            </label>
                                        </div>
                                        <div class="form-radio">
                                            <input type="radio" required="" value="p-4" id="p-4" name="FO_pay_type" <?=(($order_info['pay_type'] == "超商條碼")?" checked":"")?>>
                                            <label for="p-4">
                                                超商條碼
                                            </label>
                                        </div>
                                        <div class="form-radio">
                                            <input type="radio" required="" value="p-5" id="p-5" name="FO_pay_type" <?=(($order_info['pay_type'] == "貨到付款")?" checked":"")?>>
                                            <label for="p-5">
                                                貨到付款
                                            </label>
                                        </div>
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <?

		                    $max_num=count($order_cnt_info);

		                    $credit_arr = [["title"=>"一次付清","value"=>"一次付清"],["title"=>"三期","value"=>"三期"],["title"=>"六期","value"=>"六期"],["title"=>"十二期","value"=>"十二期"]];
		                    $credit_arr=array("一次付清","三期","六期","十二期");

		                    $credit_num=array();
		                    for($i=0;$i<count($credit_arr);$i++)
		                    {
		                       $credit_num[$credit_arr[$i]]=0;

		                       for($j=0;$j<count($order_cnt_info);$j++)
		                       {
		                           $each_info=array();
		                           $where_clause="Fmain_id = '".$order_cnt_info[$j]['product_id']."'";
		                           $tbl_name="sys_portal_x100_cnt";
		                           get_data($tbl_name, $where_clause, $each_info);
		                           // show_array($each_info); //is_show_size

		                           if($each_info['checkbox_field_19'] != "")
		                           {
		                               if(strstr($each_info['checkbox_field_19'],$credit_arr[$i]))
		                               {
		                                  $credit_num[$credit_arr[$i]]=$credit_num[$credit_arr[$i]]+1;
		                               }
		                           }

		                       }
		                    }

		                    ?>
                            <div class="form-group radio-group timegroup <?=(($order_info['pay_type'] == "信用卡付款" || !$order_info['pay_type'])?" open":"")?>">
                                <label for=""><span>*</span>分期期數</label>
                                <div class="radio-flex">
                                    <div class="form-radio">
                                        <input type="radio" required="" value="一次付清" id="t-1" name="FO_credit_card_split" checked="true">
                                        <label for="t-1">
                                            一次付清
                                        </label>
                                    </div>
                                    <?for($iii=1;$iii<count($credit_arr);$iii++){
		                              $check = "";
		//                              if($iii==0){
		//                                $check = "checked";
		//                              }


		                              if($credit_num[$credit_arr[$iii]] == $max_num)
		                              {

		                          ?>
		                            <div class="form-radio">
                                        <input type="radio" required="" value="<?=$credit_arr[$iii]?>" id="t-<?=($iii+1)?>" name="FO_credit_card_split" <?=$check?>>
                                        <label for="t-<?=($iii+1)?>">
                                            <?=$credit_arr[$iii]?>
                                        </label>
                                    </div>
		                             <?}?>
		                          <?}?>

                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="flex-btn">
                                <a href="javascript:<?=(($_COOKIE['member_userid'])?"form_submit();":"alert('請先登入會員！');location.replace('login.php?back_url=cart.php');")?>" class="sh-btn send-btn">
                                    <div class="ar"></div>
                                    進行付款
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </section>
				<input type="hidden" name="session_ID" value="<?=$session_ID?>">
                <input type="hidden" id="coupon_id" value="<?=$order_info['coupon_id']?>">
            </form>
            <?
            }
            ?>
        </main>
        <?php
            include "quote/template/top_btn.php";
        ?>
    </div>
    <?php
        include "quote/template/footer.php";
    ?>
    <script src="dist/js/main.js"></script>
    <script src="dist/js/jquery.twzipcode.min.js"></script>
    <script>
        $("#twzipcode").twzipcode({
            countySel: '<?=$order_info['send_city']?>', //縣市預設值
			districtSel: '<?=$order_info['send_area']?>',
			countyName: "FO_send_city", // 自訂城市 select 標籤的 name 值
			districtName: "FO_send_area",
            onCountySelect: function() {
                if($(this).val() == ""){
                    $("#county").addClass('nonsel');
                    $("#district").removeClass('nonsel');
                }else {
                        $("#county").removeClass('nonsel');
                        $("#district").addClass('nonsel');
                    }
                },
            zipcodeIntoDistrict: true,
            hideCounty:['金門縣','連江縣','澎湖縣'],
        });

        $('.billgroup input[type=radio]').on('change', function () {
            if ($(this).val() == 'b-2') {
                $('.bill-adr').addClass('open');
                $('.c-lett').removeClass('open');
                $('.c-edit').removeClass('open');
            } else if($(this).val() == 'b-3'){
                $('.bill-adr').addClass('open');
                $('.c-lett').addClass('open');
                $('.c-edit').addClass('open');
            } else if($(this).val() == 'b-1'){
                $('.bill-adr').removeClass('open');
                $('.c-lett').removeClass('open');
                $('.c-edit').removeClass('open');
            }
        });

        $('.paygroup input[type=radio]').on('change', function () {
            if ($(this).val() == 'p-1') {
                $('.timegroup').addClass('open');
            } else{
                $('.timegroup').removeClass('open');
            }
        });
    </script>
    <script type="text/javascript">

  $("input[name='FO_pay_type']").change(function() {
    if($("input[name='FO_pay_type']:checked").val()=="信用卡付款" || $("input[name='FO_pay_type']:checked").val()=="中租零卡分期"){
      $("#credit_count").show();
    }else{
      $("#credit_count").hide();
    }
  });
<?
if($have_hide){
?>
$(function() {
// 	alert('請您確認商品數量，謝謝！');
// 	$(".fmbtn").attr('disabled', 'disabled');
});
<?
}
?>
<?
if($_GET['show_hide']){
?>
$(function() {
// 	alert('請您確認商品數量，謝謝！');
// 	$(".fmbtn").attr('disabled', 'disabled');
});
<?
}
?>
$(function() {
	load_coupon();
});
</script>


<script type="text/javascript">
  function formatNumber(number)
  {
     var num = number.toString();
     var pattern = /(-?\d+)(\d{3})/;

     while(pattern.test(num))
     {
      num = num.replace(pattern, "$1,$2");

     }
     return num;
  }

  function add_or_sub(id,value,product_id){

    var this_amount = parseInt($("#12_cnt_"+id).val());

    $.post("ajax_change_product_amount.php",{
      y100_cnt_id: id,
      amount:this_amount,
      product_id:product_id,
      action:'amount',
    },function(data, status){
      console.log(data);
      data = data.trim();
      if(data!=''){
        if(data.indexOf("shortage") >= 0 ){
          alert("庫存不足");
          $("#12_cnt_"+id).val(data.replace('shortage', ''));
        }else{
          arr=data.split('_');



          $("#show_total").html(formatNumber(arr[1]));
          $("#total").html(formatNumber(arr[0]));
          $("#discount").html(formatNumber(arr[2]));
          $("#traffic_money").html(formatNumber(arr[3]));
          $("#sub_price_"+id).html(formatNumber(arr[4]));
          $("#12_cnt_"+id).val(this_amount);
          if(arr[3] == "0"){
	          $("#traffic_str").attr("style","font-weight:bold;");
          }
          else{
	          $("#traffic_str").attr("style","color:#333;");
          }

          // 更新優惠訊息
          a=Math.floor(Math.random()*(100000-0));
          dataSource = '&parm='+new Date().getTime()+a;

          $.post('ajax_check_sale_info.php?'+dataSource+'',{},function(data,textStatus,XMLHttpRequest)
          {
              //alert(data);
              if(data != "")
              {
                  $("#promote_str").html(data);
              }


          });

          // 更新免運訊息
          a=Math.floor(Math.random()*(100000-0));
          dataSource = '&parm='+new Date().getTime()+a;

          $.post('ajax_check_traffic_money_info.php?'+dataSource+'',{},function(data,textStatus,XMLHttpRequest)
          {
              //alert(data);
              if(data != "")
              {
                  $("#traffic_str").html(data);
              }


          });



        }

        check_promote_str();
        chg_code();
        load_coupon();
        chg_coupon($('#coupon_id').val());
      }
    });

  }
  $("#use_code").change(function(){
		chg_code();
  });

  function chg_code(){
	  var url = "cart.php";
	  $.post("ajax_change_code.php",{
        	code_num: $("#use_code").val()
		},function(data){
		 //console.log(data.error);
			<?
			$order_cnt_info=array();
			$where_clause=" portal_y100_id='".$order_info['Fmain_id']."' and is_addbuy = '2' order by Fmain_id asc";
			$tbl_name=$MYSQL_TABS['portal_y100_cnt'];
			getall_data($tbl_name, $where_clause, $order_cnt_info);
			?>
			if($("#use_code").val()==""){
				$("#code_err").html("");
			    $("#discount_code").html("-0");
			    $("#total").html(data.sum_total);
			    <?
				for($j=0;$j<count($order_cnt_info);$j++){
				?>
					$("#code_dv_<?=$order_cnt_info[$j]['Fmain_id']?>").html('');
				<?
				}
			    ?>
			}
			else if(data.error!=''){
			    $("#code_err").html(data.error);
			    $("#discount_code").html("-0");
			    $("#total").html(data.sum_total);
			    <?
				for($j=0;$j<count($order_cnt_info);$j++){
				?>
					$("#code_dv_<?=$order_cnt_info[$j]['Fmain_id']?>").html('');
				<?
				}
			    ?>
			}
			else{
			    $("#discount_code").html("-"+data.code_money);
			    $("#total").html(data.sum_total);
			    $("#code_err").html("");
			    <?
				for($j=0;$j<count($order_cnt_info);$j++){
				?>
					if(data.code_dv_<?=$order_cnt_info[$j]['Fmain_id']?> == '1'){
						$("#code_dv_<?=$order_cnt_info[$j]['Fmain_id']?>").html(data.code_name);
					}
				<?
				}
			    ?>
			    //window.location.href = url;
			}
		}, "json");
  }

  function chg_coupon(id){
	 var url = "cart.php";

    $.post("ajax_change_coupon.php",{
        coupon_id: id
    },function(data, status){
        // console.log(data);
        data = data.trim();
        if(data!=''){
	        $("#coupon_err").html(data);
	        $("#discount_coupon").html('0');
        }
        else{
	        window.location.href = url;
        }
    });
  }

  function del_d12_cnt(id,product_id){

    var url = "cart.php";

    $.post("ajax_change_product_amount.php",{
        d12_cnt_id: id,
        product_id:product_id,
        action:'remove',
    },function(data, status){
        // console.log(data);
        data = data.trim();
        if(data!=''){
          window.location.href = url;
          // $("#product_show_"+id).remove();
          // $("#show_total").html(data);
        }
        else{
	        alert('此筆訂單已成立，將幫您導回首頁繼續瀏覽，謝謝！');
	        location.replace('index.php');
        }
    });

  }

  function del_d12_cnt_add(id,product_id){

    var url = "cart.php";

    $.post("ajax_change_product_amount.php",{
        d12_cnt_id: id,
        product_id:product_id,
        action:'add_remove',
    },function(data, status){
        console.log(data);
        data = data.trim();
        if(data!=''){
          window.location.href = url;
          // $("#product_show_"+id).remove();
          // $("#show_total").html(data);
          check_promote_str();
        }
        else{
	        alert('此筆訂單已成立，將幫您導回首頁繼續瀏覽，謝謝！');
	        location.replace('index.php');
        }
    });

  }


  function change_size_or_color(cnt_id,value,type_id){

    $.post("ajax_change_product_amount.php",{
      action: "change_size_or_color",
      d12_cnt_id:cnt_id,
      size_id:value,
      amount:$("#12_cnt_"+cnt_id).val(),
    },
    function(data, status){

      console.log(data);
      data = data.trim();
      if(data!=''){
        if(data.indexOf("shortage") >= 0 ){
          alert("庫存不足");
          $("#show_size_"+cnt_id).val(data.replace('shortage', ''));
        }else if(data.indexOf("repeat") >= 0 ){
          alert("品項重複");
          $("#show_size_"+cnt_id).val(data.replace('repeat', ''));
        }else{

          arr=data.split('_');

          $("#price_"+cnt_id).html(formatNumber(arr[4]));
          $("#sub_price_"+cnt_id).html(formatNumber(arr[5]));
          $("#traffic_money").html(formatNumber(arr[3]));
          $("#discount").html(formatNumber(arr[2]));
          $("#show_total").html(formatNumber(arr[1]));
          $("#total").html(formatNumber(arr[0]));
          if(arr[3] == "0"){
	          $("#traffic_str").attr("style","font-weight:bold;");
          }
          else{
	          $("#traffic_str").attr("style","color:#333;");
          }

          if(parseInt(arr[6])>0){
            var str = "";
            for (var i = 1; i <= arr[6]; i++){
              var select = "";
              if(i==$("#12_cnt_"+cnt_id).val()){
                select = "selected";
              }
              str += "<option value='"+i+"' "+select+" >"+i+"</option>";
            }

            $("#12_cnt_"+cnt_id).html(str);
			$(".in_"+cnt_id).removeClass("opa5");
// 			$(".fmbtn").removeAttr('disabled');
          }
		  else if(parseInt(arr[6]) == 0){
			  $("#12_cnt_"+cnt_id).html("<option value=''>已售完</option>");
			  $(".in_"+cnt_id).addClass("opa5");
// 			  alert('請您確認商品數量，謝謝！');
// 			  $(".fmbtn").attr('disabled', 'disabled');
		  }

        }

        check_promote_str();
        load_coupon();
        chg_code();
        chg_coupon($('#coupon_id').val());
      }
    });
  }



  $("#use_bonus").change(function(){
    if(this.value == "")
       var the_value = 0;
    else
       var the_value = parseInt(this.value);


    the_value=Math.abs(the_value);
    $(this).val(the_value);

    if($.isNumeric(the_value)){

      $.post("ajax_change_product_amount.php",{
        bonus:the_value,
        action:'use_bonus',
      },function(data, status){
        console.log(data);
        data = data.trim();

        if(data!=''){
          if(data.indexOf("shortage") >= 0 ){
            alert("點數不足");
            $("#use_bonus").val("");
          }else if(data.indexOf("over") >= 0 ){

            data = data.replace('over', '')
            arr=data.split('_');

            $("#discount_bonus").html(formatNumber(arr[1]));
            $("#use_bonus").val(arr[1]);
			$("#sp_bonus_limit").val(arr[2]);
            $("#total").html(formatNumber(arr[0]));

          }else{
            arr=data.split('_');

            $("#discount_bonus").html(formatNumber(arr[1]));
            $("#sp_bonus_limit").val(arr[2]);
            $("#total").html(formatNumber(arr[0]));
          }

		  load_coupon();
          check_promote_str();
          chg_code();
          chg_coupon($('#coupon_id').val());
        }

      });

    }else{
      $("#use_bonus").val("");
    }


  });

  function load_coupon(){
	  $.post("iframe_coupon.php",{},
	    function(data){
			$("#scrbx").html(data);
	    }, "html");
  }

  function check_promote_str(){

    console.log("test");
    //$("#promote_str").html("");
    //sale_info_give_name amount_sale_info_money_give_name
  }

</script>

</body>

</html>