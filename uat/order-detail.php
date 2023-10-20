<?php
    include "quote/template/head.php";
    require_once ("global_include_file.php");


    if($_COOKIE['member_userid'] == "")
    {
       print "<script>";
       print "location.href='login.php';";
       print "</script>";
       exit;

    }

    $order_id=$_GET['order_id'];

    $info=array();
    $where_clause="member_userid = '".AddSlashes($_COOKIE['member_userid'])."' and is_confirm = '1' and Fmain_id = '".AddSlashes($order_id)."'";
    $tbl_name="sys_portal_y100";
    get_data($tbl_name, $where_clause, $info);
    // show_array($info);


    $order_time_arr=array();
    $order_time_arr=explode(" ",$info['order_complate_time']);
    $order_date = str_replace("-", " . ", $order_time_arr[0]);

    /******************************
      優惠金額 => 滿件優惠或者滿額優惠
    *******************************/
    $all_sale_money=(int)$info['sale_info_money']+(int)$info['amount_sale_info_money'];

    if($info['use_bonus'] == "")
       $info['use_bonus']=0;


    $order_cnt_info=array();
    $where_clause="portal_y100_id = '".AddSlashes($info['Fmain_id'])."' and is_addbuy = '2' order by Fmain_id asc";
    $tbl_name="sys_portal_y100_cnt";
    getall_data($tbl_name, $where_clause, $order_cnt_info);
//    show_array($order_cnt_info);

?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/registration.css">
</head>

<body class="orderdetailPage">
    <?php
        include "quote/template/added.php";
        include "quote/template/nav.php";
    ?>
    <div id="Wrapper">
        <main role="main">
            <div class="sh-banner">
                <img class="pc" src="dist/images/member/line_1_pc.png">
                <img class="mo" src="dist/images/member/line_1_mb.png">
                <div class="container">
                    <h2>
                        <div class="e-ti">member</div>
                        <div class="t-ti">會員專區</div>
                    </h2>
                </div>
            </div>
            <section class="item1">
                <div id="top-menu-ul">
                    <div class="container">
                        <div class="item_Menu">
                            <div class="item_menu_Box">
                                <ul class="item_menu_list slides">
                                    <li>
                                        <a href="member-profile.php">
                                            <div class="f16">
                                                <span>會員資料</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="active">
                                        <a href="member-order.php">
                                            <div class="f16">
                                                <span>訂單紀錄</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="warranty-login.php">
                                            <div class="f16">
                                                <span>保固登錄</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="flex-direction-nav">
                            <a href="#" class="flex-prev"></a>
                            <a href="#" class="flex-next"></a>
                        </div>
                    </div>
                </div>
            </section>
            <section class="item2">
                <div class="container">
                    <div class="it2-bx">
                        <div class="b-ti">
                            訂單明細
                        </div>
                        <div class="ti-bx">
                            <div class="d1">
                                訂單日期
                            </div>
                            <div class="d2">
                                訂單編號
                            </div>
                            <div class="d3">
                                訂單狀態
                            </div>
                        </div>
                        <ul>
                            <li>
                                <div class="d1">
                                    <div class="center-bx">
                                        <span class="mo">訂單日期</span>
                                        <span><?=$order_date?></span>
                                    </div>
                                </div>
                                <div class="d2">
                                    <div class="center-bx">
                                        <span class="mo">訂單編號</span>
                                        <span><?=$info['order_num']?></span>
                                    </div>
                                </div>
                                <div class="d3">
                                    <div class="center-bx">
                                        <span class="mo">訂單狀態</span>
                                        <span class="grey"><?=$info['pay_state']?></span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
            <section class="item3">
                <div class="container">
                    <div class="it3-bx">
                        <div class="b-ti">
                            購物清單
                        </div>
                        <div class="ti-bx">
                            <div class="d1">購買產品</div>
                            <div class="d2">規格</div>
                            <div class="d3">數量</div>
                            <div class="d4">單價</div>
                            <div class="d5">小計</div>
                            <div class="d6"></div>
                        </div>
                        <ul class="cart-list">
                            <?
		                    $product_total=0;
		                    for($i=0;$i<count($order_cnt_info);$i++)
		                    {
		                        $pic_temp_arr=array();
		                        $pic_temp_arr=explode(",",$order_cnt_info[$i]['pic_file']);

		                        $pic_info=array();
		                        $where_clause="Fmain_id = '".$pic_temp_arr[0]."'";
		                        $tbl_name=$MYSQL_TABS['sys_file'];
		                        get_data($tbl_name, $where_clause, $pic_info);
		                        //show_array($pic_info);

		                        if($pic_info['file_path'] != "")
		                           $show_str="".$global_website_url."login_admin/upload_file/".$pic_info['file_path']."";


		                        // 加購品
		                        $order_addbuy_info=array();
		                        $where_clause="portal_y100_id = '".AddSlashes($info['Fmain_id'])."' and is_addbuy = '1' and s_product_id = '".$order_cnt_info[$i]['product_id']."' order by  Fmain_id asc";
		//                        print $where_clause;
		                        $tbl_name="sys_portal_y100_cnt";
		                        getall_data($tbl_name, $where_clause, $order_addbuy_info);
		                        // show_array($order_addbuy_info);

		                    ?>
                            <li>
                                <div class="t-flexbx">
                                    <div class="d1">
                                        <div class="img-bx">
                                            <img src="<?=$show_str?>" alt="">
                                        </div>
                                        <div class="des-bx">
                                            <div class="num"><?=$order_cnt_info[$i]['product_num']?></div>
                                            <div class="name"><?=$order_cnt_info[$i]['product_name']?></div>
                                            <div class="act">
                                                <?=(($order_cnt_info[$i]['send_time'])?"最快出貨時間：".$order_cnt_info[$i]['send_time']:"")?>
<!--                                                 <span>七夕情人節優惠活動<i>77</i>折</span> -->
<!--                                                 <span>滿1000免運</span> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d2">
                                        <div class="mo moti">
                                            規格
                                        </div>
                                        <div class="tx">
                                            <?=$order_cnt_info[$i]['size_id_text']?>
                                        </div>
                                    </div>
                                    <div class="d3">
                                        <div class="mo moti">
                                            數量
                                        </div>
                                        <div class="tx">
                                            <?=$order_cnt_info[$i]['amount']?>
                                        </div>
                                    </div>
                                    <div class="d4">
                                        <div class="price-bx">
                                            <div class="mo moti">
                                                單價
                                            </div>
                                            <div class="f20">
                                                <span><?=number_format($order_cnt_info[$i]['price'])?></span>
                                            </div>
                                        </div>
                                        <div class="total-bx">
                                            <div class="mo moti">
                                                小計
                                            </div>
                                            <div class="f20">
                                                <span><?=number_format($order_cnt_info[$i]['small_price'])?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d5">

                                    </div>
                                </div>
                                <div class="bot-item">
                                    <?
			                        for($j=0;$j<count($order_addbuy_info);$j++)
			                        {
			                            $pic_temp_arr=array();
			                            $pic_temp_arr=explode(",",$order_addbuy_info[$j]['pic_file']);

			                            $pic_info=array();
			                            $where_clause="Fmain_id = '".$pic_temp_arr[0]."'";
			                            $tbl_name=$MYSQL_TABS['sys_file'];
			                            get_data($tbl_name, $where_clause, $pic_info);
			                            //show_array($pic_info);

			                            if($pic_info['file_path'] != "")
			                               $show_str="".$global_website_url."login_admin/upload_file/".$pic_info['file_path']."";

			                        ?>
                                    <div class="p-item">
                                        <div class="tag">加購產品</div>
                                        <div class="p1">
                                            <div class="simg-bx">
                                                <img src="<?=$show_str?>" alt="">
                                            </div>
                                            <div class="tx-bx">
                                                <div class="name"><?=$order_addbuy_info[$j]['product_name']?></div>
                                                <div class="f20">
                                                    <span><?=number_format($order_addbuy_info[$j]['price'])?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d5">
                                        </div>
                                    </div>
                                    <?
			                        }
			                        ?>
			                        <?
			                        if($order_cnt_info[$i]['is_give'] == "1")
			                        {

			                            $give_num_arr = explode("`", $order_cnt_info[$i]['give_num']);
										$give_text_arr = explode("`", $order_cnt_info[$i]['give_text']);
										$give_text_pic_arr = explode("`", $order_cnt_info[$i]['give_text_pic']);

										foreach($give_text_arr as $give_text_key => $give_text_val){
			                            $pic_temp_arr=array();
			                            $pic_temp_arr=explode(",",$give_text_pic_arr[$give_text_key]);

			                            $pic_info=array();
			                            $where_clause="Fmain_id = '".$pic_temp_arr[0]."'";
			                            $tbl_name=$MYSQL_TABS['sys_file'];
			                            get_data($tbl_name, $where_clause, $pic_info);
			                            //show_array($pic_info);

			                            if($pic_info['file_path'] != "")
			                               $show_str="".$global_website_url."login_admin/upload_file/".$pic_info['file_path']."";

			                        ?>
                                    <div class="p-item">
                                        <div class="tag">贈品</div>
                                        <div class="p1">
                                            <div class="simg-bx">
                                                <img src="<?=$show_str?>" alt="">
                                            </div>
                                            <div class="tx-bx">
                                                <div class="name"><?=$give_text_val?></div>
                                            </div>
                                        </div>
                                        <div class="d5">
                                        </div>
                                    </div>
                                    <?
			                        	}
			                        }
			                        ?>
                                </div>
                            </li>
                            <?

		                       $product_total=$product_total+$order_cnt_info[$i]['small_price'];
		                    }
		                    ?>

                        </ul>
                    </div>
                </div>
            </section>
            <section class="item4">
                <div class="container">
                    <div class="it4-bx">
                        <div class="l-bx">
                            <div class="use-price">
                                <div class="ti f18">使用購物金</div>
                                <div class="des f16"><?=$info['use_bonus']?></div>
                            </div>
                            <div class="use-price">
                                <div class="ti f18">使用折扣碼</div>
                                <div class="des f16"><?=$info['use_code']?></div>
                            </div>
                            <div class="promo-bx">
                                <div class="ti f18">優惠活動</div>
                                <div class="tx-bx">
                                    <div>
	                                    <?
			                                $log_arr = explode("<br>", $info['sale_info_log']);
			                                foreach($log_arr as $log_key => $log_val){
				                                $val_arr = explode("折抵", $log_val);
				                                if(strip_tags($val_arr[0])){
					                                if(substr_count($val_arr[0],"#333")>=1){
						                                #print "<font style='color:#333;'>".strip_tags($val_arr[0])."</font><br>";
					                                }
					                                else{
						                                print "".strip_tags($val_arr[0])."<br>";
					                                }
				                                }
			                                }
		                                ?>
                                    </div>
                                    <div>
	                                    <?
			                                $log_arr = explode("<br>", $info['amount_sale_info_log']);
			                                foreach($log_arr as $log_key => $log_val){
				                                $val_arr = explode("折抵", $log_val);
				                                if(strip_tags($val_arr[0])){
					                                if(substr_count($val_arr[0],"#333")>=1){
						                                #print "<font style='color:#333;'>".strip_tags($val_arr[0])."</font><br>";
					                                }
					                                else{
						                                print "".strip_tags($val_arr[0])."<br>";
					                                }
				                                }
			                                }
		                                ?>
                                    </div>
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
                                    <div><?=number_format($product_total)?></div>
                                </li>
                                <li>
                                    <div>優惠折抵</div>
                                    <div>-<?=number_format(($info['amount_sale_info_money'])?$info['amount_sale_info_money']:0)?></div>
                                </li>
                                <li>
                                    <div>購物金折抵</div>
                                    <div>-<?=number_format(($info['use_bonus'])?$info['use_bonus']:0)?></div>
                                </li>
                                <li>
                                    <div>折扣碼折抵</div>
                                    <div>-<?=number_format(($info['code_money'])?$info['code_money']:0)?></div>
                                </li>
                                <li>
                                    <div>滿額優惠折抵</div>
                                    <div>-<?=number_format(($info['sale_info_money'])?$info['sale_info_money']:0)?></div>
                                </li>
                                <li>
                                    <div>運費</div>
                                    <div><?=number_format($info['traffic_money'])?></div>
                                </li>
                                <li>
                                    <div>應付金額</div>
                                    <div><?=number_format($info['sum_total'])?></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <section class="item5">
                <div class="container">
                    <div class="b-ti">
                        收件人資料
                    </div>
                    <div class="it5-bx">
                        <div class="l-bx">
                            <ul>
                                <li>
                                    <div class="ti">姓名</div>
                                    <div class="des"><?=$info['send_man']?></div>
                                </li>
                                <li>
                                    <div class="ti">手機</div>
                                    <div class="des"><?=$info['send_handphone']?></div>
                                </li>
                                <li>
                                    <div class="ti">Email</div>
                                    <div class="des"><?=$info['send_email']?></div>
                                </li>
                                <?if($info['send_tel']){?>
                                <li>
                                    <div class="ti">市內電話</div>
                                    <div class="des"><?=(($info['recipient_tel'])?$info['recipient_tel']."-":"")?><?=$info['send_tel']?></div>
                                </li>
                                <?}?>
                                <li>
                                    <div class="ti">地址</div>
                                    <div class="des"><?=$info['send_city']?><?=$info['send_area']?><?=$info['send_address']?></div>
                                </li>
                                <?if($info['send_note']){?>
                                <li>
                                    <div class="ti">備註</div>
                                    <div class="des"><?=$info['send_note']?></div>
                                </li>
                                <?}?>
                            </ul>
                        </div>
                        <div class="r-bx">
                            <ul>
	                            <li>
                                    <div class="ti">
                                        發票資訊
                                    </div>
                                    <div class="des">
                                        <?=$info['invoice_type']?>
                                        <?
				                        if($info['invoice_num'])
				                        {
				                        ?>
                                        <span>
                                            <i class="black"><?=$info['invoice_num']?></i>
                                            <?=(($info['invoice_time'])?" (<i>".$info['invoice_time']."</i>開立)":"")?>
                                        </span>
                                        <?
				                        }
				                        ?>
                                    </div>
                                </li>
                                <?if($info['recipient_address']){?>
                                <li>
                                    <div class="ti">
                                        發票地址
                                    </div>
                                    <div class="des">
                                        <?=$info['recipient_address']?>
                                    </div>
                                </li>
                                <?}?>
                                <?if($info['invoice_title']){?>
                                <li>
                                    <div class="ti">
                                        公司抬頭
                                    </div>
                                    <div class="des">
                                        <?=$info['invoice_title']?>
                                    </div>
                                </li>
                                <?}?>
                                <?if($info['unification_num']){?>
                                <li>
                                    <div class="ti">
                                        公司統編
                                    </div>
                                    <div class="des">
                                        <?=$info['unification_num']?>
                                    </div>
                                </li>
                                <?}?>
                                <li>
                                    <div class="ti">
                                        付款方式
                                    </div>
                                    <div class="des">
                                        <?=$info['pay_type']?>
                                        <?
				                        if($info['pay_type'] == "信用卡付款")
				                        {
				                            if($info['credit_card_split'] != "一次")
				                            {
				                        ?>
				                           (<?=$info['credit_card_split']?>期)
				                        <?
				                            }
				                        }
				                        ?>
                                    </div>
                                </li>
                                <?if(in_array($info['pay_type'], array("ATM繳費","超商代碼","超商條碼"))){?>
								<li>
                                    <div class="ti">
                                        付款資訊
                                    </div>
                                    <div class="des">
						<?
                        if($info['pay_type'] == "超商條碼")
                        {
                        ?>
                        <iframe src="<?=$global_website_url?>login_admin/print_code.php?id=<?=$info['Fmain_id']?>" name="mainframe" width="100%" height="300" marginwidth="0" marginheight="0" onload="Javascript:SetCwinHeight()"  scrolling="No" frameborder="0" id="mainframe"></iframe>

<script type="text/javascript">
function SetCwinHeight()
{
var iframeid=document.getElementById("mainframe"); //iframe id
  if (document.getElementById)
  {
   if (iframeid && !window.opera)
   {
    if (iframeid.contentDocument && iframeid.contentDocument.body.offsetHeight)
     {
       iframeid.height = iframeid.contentDocument.body.offsetHeight;
     }else if(iframeid.Document && iframeid.Document.body.scrollHeight)
     {
       iframeid.height = iframeid.Document.body.scrollHeight;
      }
    }
   }
}
</script>
                        <?
                        }
                        ?>
                        <?
                        if($info['pay_type'] == "超商代碼")
                        {
                        ?>
                           <?=$info['PaymentNo']?>
                        <?
                        }
                        ?>

                        <?
                        if($info['pay_type'] == "ATM繳費")
                        {
                        ?>
                           <?if($info['vmatm_bankname']){?>銀行：<i class="black"><?=$info['vmatm_bankname']?></i><br><?}?>
                           銀行代碼：<i class="black"><?=$info['vmatm_bankcode']?></i><br>
                           帳號：<i class="black"><?=$info['vmatm_account']?></i>
                        <?
                        }
                        ?>
                                    </div>
                                </li>
                                <?}?>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <?php
            include "quote/template/top_btn.php";
        ?>
    </div>
    <?php
        include "quote/template/footer.php";
    ?>
    <script src="dist/js/main.js"></script>

</body>

</html>