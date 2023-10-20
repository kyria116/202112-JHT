<?
    include "quote/template/head.php";
    require_once ("global_include_file.php");


    #########################################################
    ################### 產品資訊
    #########################################################

	if($_COOKIE['member_userid'] == "")
	{
		mb_http_output ("UTF-8");
		mb_internal_encoding("UTF-8");
		ob_start ("mb_output_handler");
		print "<script>";
		print "alert('請先登入會員再進行操作，登入會員後填寫保固登錄將可以享有後續優惠活動，謝謝！');";
		print "location.href='login.php?back_url=service-warranty.php';";
		print "</script>";
		exit;
	}
	
	$member_info=array();
    $where_clause="text_field_0 = '".AddSlashes($_COOKIE['member_userid'])."'";
    $tbl_name="sys_portal_g2";
    get_data($tbl_name, $where_clause, $member_info);

    $product_folder_arr=array();
    $where_clause="1 order by rank desc";
    $tbl_name="sys_portal_x100";
    getall_data($tbl_name, $where_clause, $product_folder_arr);
    // show_array($product_folder_arr);

    $today = date("Y-m-d");
    $time_sql = " and sys_start_date<='".$today."' and sys_end_date>='".$today."'";

    $product_arr = array();
    $each_product_arr = array();
    for($iii=0;$iii<count($product_folder_arr);$iii++){
        $x100_cnt_info=array();
        $where_clause="1 ".$time_sql." and is_hide='2' and portal_x100_id='".$product_folder_arr[$iii]['Fmain_id']."' order by rank desc";
        $tbl_name="sys_portal_x100_cnt";
        getall_data($tbl_name, $where_clause, $x100_cnt_info);
        // show_array($x100_cnt_info);

        for($kkk=0;$kkk<count($x100_cnt_info);$kkk++){
            $title = $x100_cnt_info[$kkk]['text_field_1']." ".$x100_cnt_info[$kkk]['text_field_0'];
            $product_arr[$product_folder_arr[$iii]['Fmain_id']][] = ["title"=>$title,"value"=>$x100_cnt_info[$kkk]['Fmain_id']];
            $each_product_arr[$x100_cnt_info[$kkk]['Fmain_id']] = $title;
            // $product_folder_arr[$product_folder_arr[$iii]['Fmain_id']]['menu_name'] = ["title"=>""];
        }


    }

    // show_array($product_arr);

    $portal_g4_info=array();
    $where_clause="1  order by rank desc";
    $tbl_name="sys_portal_g4";
    getall_data($tbl_name, $where_clause, $portal_g4_info);
    // show_array($portal_g4_info);

    $buy_channel_arr = array();
    for($j=0;$j<count($portal_g4_info);$j++)
    {
       $portal_g4_cnt_info=array();
       $where_clause="1 and portal_g4_id = '".$portal_g4_info[$j]['Fmain_id']."'  order by rank desc";
       $tbl_name="sys_portal_g4_cnt";
       getall_data($tbl_name, $where_clause, $portal_g4_cnt_info);
       // show_array($portal_g4_cnt_info);


       $buy_channel_arr[$j]['title'] = $portal_g4_info[$j]['menu_name'];

       for($k=0;$k<count($portal_g4_cnt_info);$k++)
       {
          $buy_channel_arr[$j]['value_arr'][]=$portal_g4_cnt_info[$k]['text_field_0'];
       }
    }

//    show_array($buy_channel_arr);

    #########################################################
    #########################################################


    if($_POST['submit']!=""){ //送出表單

        ####################################################################
        ######################## gooogle v3 驗證
        ####################################################################

        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_secret = $reCAPTCHA_setting['secret_key'];
        $recaptcha_response = $_POST['recaptcha_response'];

        $target_url = $recaptcha_url.'?secret='.$recaptcha_secret.'&response='.$recaptcha_response;
        //Make and decode POST request:


        // $recaptcha = file_get_contents($target_url);
        // $recaptcha = json_decode($recaptcha);


        // if($recaptcha->success!=true){
            $ch = curl_init();
            $timeout = 5;
            curl_setopt ($ch, CURLOPT_URL,$target_url);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
            curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $recaptcha = curl_exec($ch);
            curl_close($ch);
            $recaptcha = json_decode($recaptcha);
        // }




        //如果驗證成功，就進一步計算使用者分數，官方回饋分數為 0-1，分數愈接近 1 就是正常，低於 0.5 以下就有可能是機器人了
        // if($recaptcha->success==true){
        //    if($recaptcha->score >= 0.5) {
        //        echo 'Pass !';
        //    } else {
        //        echo 'Spammer';
        //    }
        // } else {
        //   echo 'Connection failed';
        // }
        // exit;

if($_SERVER['HTTP_HOST'] != "jht.mak66design2.com"){
        if($recaptcha->success==true && $recaptcha->score >= 0.5){

        }else{
            if($recaptcha->score < 0.5 && $recaptcha->success==true){
                print "<script>";
                print " alert('請正常操作網頁".$recaptcha->score."');"; //機器人
                print "history.go(-1);";
                print "</script>";
                exit;

            }else{
                print "<script>";
                print " alert('連線失敗');";
                print "history.go(-1);";
                print "</script>";

                exit;
            }

        }
}
        ####################################################################
        ####################################################################

		#先確認產品序號
if(1)# or get_ip()== "220.133.80.159" or get_ip()=="220.136.37.79"
{
		for($iii=0;$iii<count($_POST['product_id']);$iii++){
            $all_code_info=array();
		    $where_clause="portal_x100_cnt_id = '".$_POST['product_id'][$iii]."' ";
		    $tbl_name="sys_portal_x100_cnt_code";
		    getall_data($tbl_name, $where_clause, $all_code_info);
            if(count($all_code_info) > 0){
            
	            $code_info=array();
			    $where_clause="portal_x100_cnt_id = '".$_POST['product_id'][$iii]."' and the_code='".$_POST['product_code'][$iii]."'  ";
			    $tbl_name="sys_portal_x100_cnt_code";
			    get_data($tbl_name, $where_clause, $code_info);
	
			    if(!$code_info['Fmain_id']){
				    print "<script>";
	                print " alert('無此產品序號');";
	                print "history.go(-1);";
	                print "</script>";
	                exit;
			    }
			    else if($code_info['member_userid'] && 0){
					         print "<script>";
	               print " alert('此產品序號已註冊');";
	               print "history.go(-1);";
	               print "</script>";
	               exit;

			   }
			}
		}
}

//         show_array($_POST);
//         exit;

        $ARR_Update = array();

        $ARR_Update['product_id'] ="";
        $ARR_Update['product_name'] ="";

        for($iii=0;$iii<count($_POST['product_id']);$iii++){
            $code_info=array();
		    $where_clause="portal_x100_cnt_id = '".$_POST['product_id'][$iii]."' and the_code='".$_POST['product_code'][$iii]."'  ";
		    $tbl_name="sys_portal_x100_cnt_code";
		    get_data($tbl_name, $where_clause, $code_info);
		    
            if($iii>0){
                $ARR_Update['product_id'].=",";
                $ARR_Update['product_name'] .=",";
                $ARR_Update['product_code'] .=",";
            }

            $product_info=array();
            $where_clause="Fmain_id = '".AddSlashes($_POST['product_id'][$iii])."'";
            $tbl_name="sys_portal_x100_cnt";
            get_data($tbl_name, $where_clause, $product_info);
            //show_array($product_info);

            $ARR_Update['product_id'].=$_POST['product_id'][$iii];
            $ARR_Update['product_name'] .=$product_info['text_field_0'];
            $ARR_Update['product_code'] .=$_POST['product_code'][$iii];
            
            if($code_info['Fmain_id']){
	            $upd_info = array();
	            $upd_info['member_userid'] = $code_info['member_userid']."`".$_COOKIE['member_userid']."`";
	            $upd_info['now_time'] = date("Y-m-d H:i:s");
	            $where_clause=" Fmain_id = '".$code_info['Fmain_id']."'  ";
			    $tbl_name="sys_portal_x100_cnt_code";
	            update_data($tbl_name, $where_clause, $upd_info);
            }
        }
		$b_arr = explode("-", $_POST['path']);
        $ARR_Update['buy_channel'] = $_POST['buy_channel_'.$b_arr[1]];
        if(!$ARR_Update['buy_channel'] && $_POST['buy_channel_other']) $ARR_Update['buy_channel'] = "其他-".$_POST['buy_channel_other'];

        while ( list($Rfield, $Rvalue)=each($_POST) ){
            if (substr($Rfield,0,3)=="FO_") {
                $Rfield = str_replace ("FO_", "", $Rfield);
                  if (!get_magic_quotes_gpc()) {
                      $Rvalue = AddSlashes($Rvalue);
                  }
                  $ARR_Update[$Rfield] = $Rvalue;
           }
        }

        // show_array($ARR_Update);exit;

        $ARR_Update['start_time'] = date("Y-m-d H:i:s");
        $ARR_Update['userid'] = $global_website_userid;
        $ARR_Update['email'] = $_COOKIE['member_userid'];
		$ARR_Update['tel'] = $member_info['text_field_5'];
		$ARR_Update['name'] = $member_info['text_field_2'];
        $ARR_Update['input_name'] = $_COOKIE['member_userid'];
        // if($_COOKIE['lang_id']!=""){
        //     $ARR_Update['lang'] = $_COOKIE['lang_id'];
        // }
        $tbl_name="sys_portal_g3";
        $return_arr=array();

        // show_array($ARR_Update);exit;
        $return_arr=add_data($tbl_name,$ARR_Update);
        $return_id=$return_arr['newrid'];



        $service_email_info=array();
        $where_clause="website_language_id = '1'";
        $tbl_name=$MYSQL_TABS['service_email'];
        get_data($tbl_name, $where_clause, $service_email_info);
        //show_array($service_email_info);

        $mail_info=array();
        $mail_info=get_mail_info("");

        // show_array($mail_info);
        //papabear0711@gmail.com
        $send_arr = array();
        $send_arr[] = ["title"=>"留言時間","value"=>$ARR_Update['start_time']];
        $send_arr[] = ["title"=>"聯絡人","value"=>$ARR_Update['name']];
        $send_arr[] = ["title"=>"聯絡電話","value"=>$ARR_Update['tel']];
        $send_arr[] = ["title"=>"聯絡信箱","value"=>$ARR_Update['email']];
        $send_arr[] = ["title"=>"訂單編號","value"=>$ARR_Update['order_num']];
        $send_arr[] = ["title"=>"購買通路","value"=>$ARR_Update['buy_channel']];
        $send_arr[] = ["title"=>"購買日期","value"=>$ARR_Update['buy_date']];
        $send_arr[] = ["title"=>"購買商品","value"=>$ARR_Update['product_name']];
        $send_arr[] = ["title"=>"其他建議","value"=>$ARR_Update['content']];

        $mail_content = creat_mail("聯絡人訊息",$send_arr);
        // $mail_info['sendmail_email'] = "tommy@webdo.cc"; //測試

        $Pdata=array();
        $Pdata['RecvAdd']   = $service_email_info['email_2'];         // 收件人地址
        $Pdata['RecvTi']    = "親愛的管理者";           // 收件者名稱
        $Pdata['SendAdd']   = $mail_info['sendmail_email'];         // 寄件人地址
        $Pdata['SendTi']    = $mail_info['sendmail_name'];           // 寄件人名稱
        $Pdata['Subject']   = "保固登入通知信";            // 主旨
        $Pdata['MailHTML']  = $mail_content;
        //$Pdata['Encoding']    = "big5";                           // 信件本體編碼
        $Pdata['Encoding']  = "utf-8";                          // 信件本體編碼
        // show_array($Pdata);
        // exit;

        if($mail_info['mailserver_type'] == "sendmail"){
           $err = mail_send ($Pdata);
        }else{
           $err = mail_smtp ($Pdata);
        }


        if($ARR_Update['email']){
	        $Pdata=array();
	        $Pdata['RecvAdd']   = $ARR_Update['email'];         // 收件人地址
	        $Pdata['RecvTi']    = $ARR_Update['name'];           // 收件者名稱
	        $Pdata['SendAdd']   = $mail_info['sendmail_email'];         // 寄件人地址
	        $Pdata['SendTi']    = $mail_info['sendmail_name'];           // 寄件人名稱
	        $Pdata['Subject']   = "保固登入通知信";            // 主旨
	        $Pdata['MailHTML']  = $mail_content;
	        //$Pdata['Encoding']    = "big5";                           // 信件本體編碼
	        $Pdata['Encoding']  = "utf-8";                          // 信件本體編碼
	        // show_array($Pdata);
	        // exit;

	        if($mail_info['mailserver_type'] == "sendmail"){
	           $err = mail_send ($Pdata);
	        }else{
	           $err = mail_smtp ($Pdata);
	        }
        }


        print "<script>";
        print "alert('已送出，我們會盡快與您聯絡');";
        print "location.href='warranty-login.php';";
        print "</script>";
    }

?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/chosen.css">
<link rel="stylesheet" href="dist/css/servicewarranty.css?v=1">
<script src="https://www.google.com/recaptcha/api.js?render=<?=$reCAPTCHA_setting['golden_key']?>">  </script>
</head>

<body class="servicewarrantyPage">
    <?php
        include "quote/template/added.php";
        include "quote/template/nav.php";
        include "quote/template/modal.php";
    ?>
    <div id="Wrapper">
        <main role="main">
            <div class="sh-banner">
                <img class="pc" src="dist/images/service/line_1_pc.png">
                <img class="mo" src="dist/images/service/line_1_mb.png">
                <div class="container">
                    <h2>
                        <div class="e-ti">SERVICE</div>
                        <div class="t-ti">客戶服務</div>
                    </h2>
                </div>
            </div>
            <section class="item1">
                <div id="top-menu-ul">
                    <div class="container">
                        <div class="item_Menu">
                            <div class="item_menu_Box">
                                <ul class="item_menu_list slides">
                                    <li class="active">
                                        <a href="service-warranty.php">
                                            <div class="f16">
                                                <span>保固登錄</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="service-faq.php">
                                            <div class="f16">
                                                <span>常見問題</span>
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
                    <div class="form-bx">
                        <form method="post"  action="service-warranty.php">
	                        <input type="hidden" value="" name="recaptcha_response" id="recaptchaResponse">
                            <!-- <div class="flex-bx">
                                <div class="form-group">
                                    <label for=""><span>*</span>姓名</label>
                                    <input type="text" name="FO_name" placeholder="請輸入真實姓名" required>
									
                                    <div id="FO_name_str" style="visibility: hidden;" class="help-block with-errors">必填</div>
                                </div>
                                <div class="form-group">
                                    <label for=""><span>*</span>手機</label>
                                    <input type="tel" name="FO_tel" placeholder="請輸入手機號碼，例如：0912345678" required maxlength="10" pattern="[0-9]{10}">
                                    <div id="FO_tel_str" style="visibility: hidden;" class="help-block with-errors">必填</div>
                                </div>
                            </div> -->
                            <div class="flex-bx">
                                <!-- <div class="form-group">
                                    <label for=""><span>*</span>Email</label>
                                    <input type="email" name="FO_email" placeholder="請輸入常用Email" required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,5}$">
                                    <div id="FO_email_str" style="visibility: hidden;" class="help-block with-errors">請輸入正確格式Email</div>
                                </div> -->
                                <div class="form-group">
                                    <label for=""><span>*</span>購買日期</label>
                                    <input type="date" name="FO_buy_date" placeholder="" required>
                                    <div id="FO_buy_date_str" style="visibility: hidden;" class="help-block with-errors">必填</div>
                                </div>
                            </div>
                            <div class="form-group sel-group buy-product-box">
<!--                                 <div class="form-group sel-group"> -->
                                    <label for="" class="buy-product"><span>*</span>購買產品</label><a href="javascript:;" class="product-number">產品序號</a>
                                    <ul class="sel-bx">
                                        <li>
                                            <div class="flex">
                                            <div>
	                                            <select data-placeholder="請選擇購買產品" class="product_id" name="product_id[]" required >
						                            <option value="">請選擇購買產品</option>
													<?
													$x100_cnt_info=array();
												    $where_clause="1 order by text_field_1 asc";
												    $tbl_name="sys_portal_x100_cnt";
												    getall_data($tbl_name, $where_clause, $x100_cnt_info);
												    #show_array($x100_cnt_info);
												    for($kkk=0;$kkk<count($x100_cnt_info);$kkk++){
												        print "<option value='".$x100_cnt_info[$kkk]['Fmain_id']."'>".$x100_cnt_info[$kkk]['text_field_0']."(".$x100_cnt_info[$kkk]['text_field_1'].")</option>";
												    }
													?>
						                        </select>

                                            <div style="visibility: hidden;" class="FO_product_id_str help-block with-errors">必填</div>
                                            </div>
                                            <div>
                                            <input type="text" class="product_code" name="product_code[]" placeholder="請輸入產品序號">
                                            <div style="visibility: hidden;" class="FO_product_code_str help-block with-errors">必填</div>
                                            </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <a href="javascript:;" class="add-btn">
                                        <span>
                                            <div class="ar"></div>
                                            新增產品
                                        </span>
                                    </a>
                                    <a class="remove-btn" href="javascript:;">
                                        <div class="ar"></div>
                                    </a>
                            </div>
                            <div class="form-group radio-group">
                                    <label for=""><span>*</span>購買通路</label>
                                    <div class="radio-flex">
                                        <?for($iii=1;$iii<=count($buy_channel_arr);$iii++){
				                             $checked="";
				                             if($iii == 2)
				                                $checked="checked";
				                        ?>
				                            <div class="form-radio">
				                                <input type="radio" name="path" id="s-<?=$iii?>" <?=$checked?> value="s-<?=$iii?>" required>
				                                <label for="s-<?=$iii?>">
				                                <?=$buy_channel_arr[$iii-1]['title']?>
				                                </label>
				                            </div>
				                        <?
					                        }
					                        $other_val = "s-".$iii;
				                        ?>
                                        <div class="form-radio">
                                            <input type="radio" required="" value="s-<?=$iii?>" id="s-<?=$iii?>" name="path">
                                            <label for="s-<?=$iii?>">
                                                其他
                                            </label>
                                        </div>
                                    </div>

                                    <?for($iii=1;$iii<=count($buy_channel_arr);$iii++){
				                        $show = "";
				                        if($iii==1){
				                            $show = "show";
				                        }
				                        if($iii==1)	$now_number = 1;
				                        else if($iii==2)	$now_number = 0;
				                        else	$now_number = $iii-1;
				                    ?>
		                                <select name="buy_channel_<?=($now_number+1)?>"  class="shopsel<?=(($iii>1)?$iii:"")?> <?=$show?>">
		                                    <option value="">請選擇<?=$buy_channel_arr[$now_number]['title']?></option>
		                                    <?for($kkk=0;$kkk<count($buy_channel_arr[$now_number]['value_arr']);$kkk++){?>
		                                        <option value="<?=$buy_channel_arr[$now_number]['value_arr'][$kkk]?>"><?=$buy_channel_arr[$now_number]['value_arr'][$kkk]?></option>
		                                    <?}?>
		                                </select>
				                    <?}?>
									<input class="shopsel<?=$iii?>" type="text" name="buy_channel_other" placeholder="請輸入其他">
				                    <div id="FO_path_str" style="visibility: hidden;" class="help-block with-errors">必填</div>
                                </div>
                            <div class="form-group">
                                <label for="">訂單編號</label>
                                <input type="text" name="FO_order_num" placeholder="請輸入訂單編號">
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="">其它建議</label>
                                <!-- 1025 -->
                                <textarea rows="4" name="FO_content" placeholder="請輸入建議內容"></textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                            <a href="javascript:send_fn();" class="sh-btn send-btn">
                                <div class="ar"></div>
                                送出
                            </a>
                            <input type="submit" id="submit" name="submit" style="visibility: hidden;">
                        </form>
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
    <script src="dist/js/service.js?v=6"></script>
    <script>
        function send_fn(){
            if(check_data()){
                grecaptcha.execute('<?=$reCAPTCHA_setting['golden_key']?>', {action: 'submit'}).then(function(token) {
                    $("#recaptchaResponse").val(token);
                    $("#submit").click();
                });

            }
        }

        function check_data(){



            var is_flat = 0;
			var the_alert = "";
/*
            if($("input[name='FO_name']").val()==""){
                $("#FO_name_str").css("visibility","visible");
                is_flat = 1;
                the_alert += "姓名必填！\n";
            }else{
                $("#FO_name_str").css("visibility","hidden");
            }
*/


/*
            if($("input[name='FO_tel']").val()=="" ){ //手機
                $("#FO_tel_str").css("visibility","visible");
                is_flat = 1;
                the_alert += "手機必填！\n";
            }else{
				var a=$("input[name='FO_tel']").val();
                var b=a.slice(0,2);
                if(b != "09")
                {
                    is_flat = 1;
                    the_alert += "手機格式錯誤，請輸入09開頭的十碼數字！\n";
                    $("#FO_tel_str").html("*格式錯誤，請輸入09開頭的十碼數字");
                    $("#FO_tel_str").css("visibility","visible");
                }
                else if(!checkNumber($("input[name='FO_tel']").val()) || $("input[name='FO_tel']").val().length<10 ){
                    $("#FO_tel_str").html("*格式錯誤，請輸入09開頭的十碼數字");
                    $("#FO_tel_str").css("visibility","visible");
                    is_flat = 1;
                    the_alert += "手機格式錯誤，請輸入09開頭的十碼數字！\n";
                }else{
                    $("#FO_tel_str").css("visibility","hidden");
                }

            }
*/


//            if($("input[name='FO_tel']").val()=="" ){
//                $("#FO_tel_str").html("*必填");
//                $("#FO_tel_str").css("visibility","visible");
//                is_flat = 1;
//            }else{
//
//                if(!checkNumber($("input[name='FO_tel']").val())){
//                    $("#FO_tel_str").html("*格式錯誤");
//                    $("#FO_tel_str").css("visibility","visible");
//                    is_flat = 1;
//                }else{
//                    $("#FO_tel_str").css("visibility","hidden");
//                }
//
//            }


/*
            if($("input[name='FO_email']").val()=="" ){
                $("#FO_email_str").html("*必填");
                $("#FO_email_str").css("visibility","visible");
                is_flat = 1;
                the_alert += "Email必填！\n";
            }else{

                if(!checkEmail($("input[name='FO_email']").val())){
                    $("#FO_email_str").html("*請輸入正確格式Email");
                    $("#FO_email_str").css("visibility","visible");
                    is_flat = 1;
					the_alert += "請輸入正確格式Email！\n";
                }else{
                    $("#FO_email_str").css("visibility","hidden");
                }

            }
*/


            if($("input[name='FO_buy_date']").val()=="" ){
                $("#FO_buy_date_str").css("visibility","visible");
                is_flat = 1;
                the_alert += "購買日期必填！\n";
            }else{
                $("#FO_buy_date_str").css("visibility","hidden");
            }

			var s_alert = "";	var ss_alert = "";
			for(var i=0;i<$('.product_id').size();i++)
		   {
		     	if($(".product_id").eq(i).val()=="" ){
                $(".FO_product_id_str").eq(i).css("visibility","visible");
                is_flat = 1;
                s_alert = "購買商品必填！\n";
	            }else{
	                $(".FO_product_id_str").eq(i).css("visibility","hidden");
	            }
	
	            if($('.product_code').eq(i).val() == ""){
		        	is_flat = 1;
					ss_alert = "產品序號必填！\n";
					$(".FO_product_code_str").eq(i).css("visibility","visible");
	            }
	            else{
	                $(".FO_product_code_str").eq(i).css("visibility","hidden");
	            }
		   }
		   the_alert += s_alert;
		   the_alert += ss_alert;
            


            if($("input[name='path']:checked").val()=="" || $("input[name='path']:checked").val()===undefined ){
                $("#FO_path_str").css("visibility","visible");
                is_flat = 1;
                the_alert += "購買通路必填！\n";
            }else{

                if($("input[name='path']:checked").val()=="<?=$other_val?>"){
                    this_val = $("input[name='buy_channel_other']").val();
                }else{
                    var aanum=$("input[name='path']:checked").val();
                    bbnum=aanum.split("-");
                    this_val = $("select[name='buy_channel_"+bbnum[1]+"']").val();
                }

                if(this_val=="" || this_val===undefined){
                    $("#FO_path_str").css("visibility","visible");
                    is_flat = 1;
                    the_alert += "購買通路必填！\n";
                }else{
                    $("#FO_path_str").css("visibility","hidden");
                }

            }


            if(is_flat==0){
	            $("#submit").hide();
                return true;

            }else{
	            alert(the_alert);
                return false;
            }


        }

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


		<?
		$add_option = "";
		$x100_cnt_info=array();
	    $where_clause="1 order by text_field_1 asc";
	    $tbl_name="sys_portal_x100_cnt";
	    getall_data($tbl_name, $where_clause, $x100_cnt_info);
	    #show_array($x100_cnt_info);
	    for($kkk=0;$kkk<count($x100_cnt_info);$kkk++){
	        $add_option .= "<option value='".$x100_cnt_info[$kkk]['Fmain_id']."'>".$x100_cnt_info[$kkk]['text_field_0']."(".$x100_cnt_info[$kkk]['text_field_1'].")</option>";
	    }
		?>
		 function add_product(){
			 $(".adsel").append("<div><select class=\"product_id\" name=\"product_id[]\" required ><option value=\"\">請選擇購買產品</option><?=$add_option?></select><span class=\"rmicon\"></span></div>");
			 $( ".product_id" ).chosen();
		 }

        var buy_channel_arr = <?php echo json_encode($buy_channel_arr);?>;


    </script>
    <script src="dist/js/chosen.jquery.min.js"></script>
    <script>
     	$( ".product_id" ).chosen();
     	$(function() {
            	setTimeout(function(){
            	   $(".grecaptcha-badge").css("visibility","hidden");
            	},800);
        });
    </script>
</body>

</html>