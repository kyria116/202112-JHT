<?php

    require_once ("global_include_file.php");

    require_once ("global_function_mail.php");
    require_once ('login_admin/library/mail.php');



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

        $ARR_Update = array();
        while ( list($Rfield, $Rvalue)=each($_POST) ){
            if (substr($Rfield,0,3)=="FO_") {
                $Rfield = str_replace ("FO_", "", $Rfield);
                  if (!get_magic_quotes_gpc()) {
                      $Rvalue = AddSlashes($Rvalue);
                  }
                  $ARR_Update[$Rfield] = $Rvalue;
           }
        }
		$ARR_Update['text_field_6'] = $ARR_Update['text_field_6_1']."-".$ARR_Update['text_field_6_2'];
		$ARR_Update['text_field_7'] = $_POST['county'].$_POST['district'].$ARR_Update['text_field_7_3'];
		$ARR_Update['text_field_7_1'] = $_POST['county'];
		$ARR_Update['text_field_7_2'] = $_POST['district'];
        $ARR_Update['userid'] = "admin";
        $ARR_Update['now_time'] = date("Y-m-d H:i:s");


        // 新增順序
        $search_info=array();
        $tbl_name="sys_portal_g2";
        $query_string="select max(rank) from $tbl_name";
        sql_data($query_string, $search_info);
        //show_array($search_info);
        //exit;

        if($search_info[0]['max(rank)'] == "")
           $new_id=1;
        else
           $new_id=$search_info[0]['max(rank)']+1;

        $ARR_Update['rank']=$new_id;

        // show_array($ARR_Update);exit;

        $check_info=array();
        $where_clause="text_field_0 = '".$ARR_Update['text_field_0']."'";
        $tbl_name="sys_portal_g2";
        get_data($tbl_name, $where_clause, $check_info);
        // show_array($check_info);

        if(count($check_info)<1){
            $ARR_Update['is_verify']="2";
            $tbl_name="sys_portal_g2";
            $return_arr=array();
            $return_arr=add_data($tbl_name,$ARR_Update);
            $return_id=$return_arr['newrid'];

            if($return_id == "")
            {
                print "<script>";
                print " alert('註冊失敗,請回上一步再試一次,謝謝');";
                print " history.go(-1);";
                print "</script>";

                exit;
            }

            #setcookie("member_userid",$ARR_Update['text_field_0']);

            $mail_info=array();
            $mail_info=get_mail_info("1");
            // show_array($mail_info);
            $v_url = $global_website_url."verify.php?v=".$return_id;
            $mail_title = "註冊信箱驗證";
            $mail_arr = array();
            if($ARR_Update['text_field_0'])	$mail_arr['帳號'] = $ARR_Update['text_field_0'];
            if($ARR_Update['text_field_2'])	$mail_arr['姓名'] = $ARR_Update['text_field_2'];
            if($ARR_Update['radio_field_3'])	$mail_arr['性別'] = $ARR_Update['radio_field_3'];
            if($ARR_Update['text_field_5'])	$mail_arr['手機'] = $ARR_Update['text_field_5'];
            if($ARR_Update['text_field_6'])	$mail_arr['市內電話'] = $ARR_Update['text_field_6'];
			if($ARR_Update['text_field_7'])	$mail_arr['地址'] = $ARR_Update['text_field_7'];
            $mail_arr['身分驗證'] = "<a href='".$v_url."' target='_blank'>".$v_url."</a><br><font color='red'>*請點擊驗證網址以完成會員註冊身分驗證</font>";
			$mail_content = get_mail_html_content_new($mail_title,$mail_arr);
            $Pdata=array();
			$Pdata['RecvAdd']	= $ARR_Update['text_field_0'];	        // 收件人地址
			$Pdata['RecvTi']    = $ARR_Update['text_field_2'];           // 收件者名稱
			$Pdata['SendAdd']	= $mail_info['sendmail_email'];		    // 寄件人地址
			$Pdata['SendTi']	= $mail_info['sendmail_name'];		    // 寄件人名稱
			$Pdata['Subject']	= $mail_title;			   // 主旨
			$Pdata['MailHTML']	= $mail_content;
			//$Pdata['Encoding']	= "big5";				            // 信件本體編碼
			$Pdata['Encoding']	= "utf-8";				            // 信件本體編碼
			//show_array($Pdata);
			//exit;
			
			if($mail_info['mailserver_type'] == "sendmail"){
			 $err = mail_send ($Pdata);
			}else{
			 $err = mail_smtp ($Pdata);
			}

            /*****************
               生日禮
            ******************/
            $today = date("m");

            $money_info=array();
           	$where_clause="1 and Fmain_id ='2'";
           	$tbl_name="sys_portal_j1";
           	get_data($tbl_name, $where_clause, $money_info);
           	// show_array($money_info);

           	$mail_content = get_default_mail_info(2);
	        $money = (int)$money_info['text_field_1'];


	        $str_arr = explode("-", $ARR_Update['date_field_4']);
		    $birth_date = $str_arr[1];  // 取的會員生日月分

		    if($today == $birth_date && $money>0)
		    {
             $birth_note = date("Y")."會員生日禮";

    			$check_info=array();
    			$where_clause="1 and member_userid ='".$ARR_Update['text_field_0']."' and note ='".$birth_note."' and is_manager_del ='2' and is_del ='2' ";
    			$tbl_name="sys_bonus_log";
    			get_data($tbl_name, $where_clause, $check_info);
    			// show_array($check_info);

    			if(count($check_info)<1)
    			{
     				member_bouns_control($money,$ARR_Update['text_field_0'],"admin","1",$birth_note);


     				$mail_title = "會員生日禮";

     				// 發送郵件
                 $Pdata=array();
                 $Pdata['RecvAdd']	= $ARR_Update['text_field_0'];	        // 收件人地址
                 $Pdata['RecvTi']    = $ARR_Update['text_field_2'];           // 收件者名稱
                 $Pdata['SendAdd']	= $mail_info['sendmail_email'];		    // 寄件人地址
                 $Pdata['SendTi']	= $mail_info['sendmail_name'];		    // 寄件人名稱
                 $Pdata['Subject']	= $mail_title;			   // 主旨
                 $Pdata['MailHTML']	= $mail_content;
                 //$Pdata['Encoding']	= "big5";				            // 信件本體編碼
                 $Pdata['Encoding']	= "utf-8";				            // 信件本體編碼
 			    //show_array($Pdata);
 			    //exit;

                 if($mail_info['mailserver_type'] == "sendmail"){
                     $err = mail_send ($Pdata);
                 }else{
                     $err = mail_smtp ($Pdata);
                 }


            	}

		    }

			##生日發送折價券##
			if($today == $birth_date)
		    {
			    $coupon_set_mail_info = array();
				$where_clause = " Fmain_id = '2' ";
				$tbl_name = "coupon_set_mail";
				get_data($tbl_name, $where_clause, $coupon_set_mail_info);
				
				if($coupon_set_mail_info['set_val']){
					$mail_info=array();
					$mail_info=get_mail_info("1");
					#檢查是否有期限
					$chk_coupon_info = array();
					$where_clause = " Fmain_id = '".$coupon_set_mail_info['set_val']."' ";
					$tbl_name = $MYSQL_TABS['set_sale_coupon_list'];
					get_data($tbl_name, $where_clause, $chk_coupon_info);

					$add_info = array();
					$add_info['coupon_id'] = $coupon_set_mail_info['set_val'];
					$add_info['member_userid'] = $ARR_Update['text_field_0'];
					$add_info['get_date']      = date("Y-m-d");
					if($chk_coupon_info['limit_m'] || $chk_coupon_info['limit_d']){
						$add_info['deadline_date'] = date("Y-m-d",strtotime("+ ".(($chk_coupon_info['limit_m'])?$chk_coupon_info['limit_m']:"0")." months ".(($chk_coupon_info['limit_d'])?$chk_coupon_info['limit_d']:"0")." days"));
              		}
					$tbl_name = "member_coupon_list";
					$return_arr=add_data($tbl_name,$add_info);
					$return_id=$return_arr['newrid'];
					if($return_id){
						$mail_title = ($coupon_set_mail_info['set_title'])?$coupon_set_mail_info['set_title']:"會員生日禮";
						$mail_content = ($coupon_set_mail_info['set_mail'])?$coupon_set_mail_info['set_mail']:"送您折價券一張";
						// 發送郵件
		                $Pdata=array();
		                $Pdata['RecvAdd']	= $ARR_Update['text_field_0'];	        // 收件人地址
		                $Pdata['RecvTi']    = $ARR_Update['text_field_2'];           // 收件者名稱
		                $Pdata['SendAdd']	= $mail_info['sendmail_email'];		    // 寄件人地址
		                $Pdata['SendTi']	= $mail_info['sendmail_name'];		    // 寄件人名稱
		                $Pdata['Subject']	= $mail_title;			   // 主旨
		                $Pdata['MailHTML']	= $mail_content;
		                //$Pdata['Encoding']	= "big5";				            // 信件本體編碼
		                $Pdata['Encoding']	= "utf-8";				            // 信件本體編碼
					    //show_array($Pdata);
					    //exit;
		
		                if($mail_info['mailserver_type'] == "sendmail"){
		                    $err = mail_send ($Pdata);
		                }else{
		                    $err = mail_smtp ($Pdata);
		                }
					}

				}
		    }

            /*****************
               會員註冊禮
            ******************/
            $money_info=array();
            $where_clause="1 and Fmain_id ='1'";
            $tbl_name="sys_portal_j1";
            get_data($tbl_name, $where_clause, $money_info);
            // show_array($money_info);
            $money = (int)$money_info['text_field_1'];

            if($money>0){

                $mail_title = "會員註冊禮";
                $mail_content = get_default_mail_info(1);

                member_bouns_control($money,$ARR_Update['text_field_0'],"admin","1",$mail_title);

                // 發送郵件
                $Pdata=array();
                $Pdata['RecvAdd']   = $ARR_Update['text_field_0'];           // 收件人地址
                $Pdata['RecvTi']    = $ARR_Update['text_field_2'];           // 收件者名稱
                $Pdata['SendAdd']   = $mail_info['sendmail_email'];         // 寄件人地址
                $Pdata['SendTi']    = $mail_info['sendmail_name'];          // 寄件人名稱
                $Pdata['Subject']   = $mail_title;             // 主旨
                $Pdata['MailHTML']  = $mail_content;
                //$Pdata['Encoding']    = "big5";                           // 信件本體編碼
                $Pdata['Encoding']  = "utf-8";                          // 信件本體編碼
                //show_array($Pdata);
                //exit;

                if($mail_info['mailserver_type'] == "sendmail"){
                    $err = mail_send ($Pdata);
                }else{
                    $err = mail_smtp ($Pdata);
                }
            }


			##發送折價券##			
			$coupon_set_mail_info = array();
			$where_clause = " Fmain_id = '1' ";
			$tbl_name = "coupon_set_mail";
			get_data($tbl_name, $where_clause, $coupon_set_mail_info);
			
			if($coupon_set_mail_info['set_val']){
				$mail_info=array();
				$mail_info=get_mail_info("1");
				#檢查是否有期限
				$chk_coupon_info = array();
				$where_clause = " Fmain_id = '".$coupon_set_mail_info['set_val']."' ";
				$tbl_name = $MYSQL_TABS['set_sale_coupon_list'];
				get_data($tbl_name, $where_clause, $chk_coupon_info);

				$add_info = array();
				$add_info['coupon_id'] = $coupon_set_mail_info['set_val'];
				$add_info['get_date']      = date("Y-m-d");
				$add_info['member_userid'] = $ARR_Update['text_field_0'];
				if($chk_coupon_info['limit_m'] || $chk_coupon_info['limit_d']){
	            	$add_info['deadline_date'] = date("Y-m-d",strtotime("+ ".(($chk_coupon_info['limit_m'])?$chk_coupon_info['limit_m']:"0")." months ".(($chk_coupon_info['limit_d'])?$chk_coupon_info['limit_d']:"0")." days"));
            	}
				$tbl_name = "member_coupon_list";
				$return_arr=add_data($tbl_name,$add_info);
				$return_id=$return_arr['newrid'];
				if($return_id){
					$mail_title = ($coupon_set_mail_info['set_title'])?$coupon_set_mail_info['set_title']:"會員註冊禮";
					$mail_content = ($coupon_set_mail_info['set_mail'])?$coupon_set_mail_info['set_mail']:"送您折價券一張";
					// 發送郵件
	                $Pdata=array();
	                $Pdata['RecvAdd']	= $ARR_Update['text_field_0'];	        // 收件人地址
	                $Pdata['RecvTi']    = $ARR_Update['text_field_2'];           // 收件者名稱
	                $Pdata['SendAdd']	= $mail_info['sendmail_email'];		    // 寄件人地址
	                $Pdata['SendTi']	= $mail_info['sendmail_name'];		    // 寄件人名稱
	                $Pdata['Subject']	= $mail_title;			   // 主旨
	                $Pdata['MailHTML']	= $mail_content;
	                //$Pdata['Encoding']	= "big5";				            // 信件本體編碼
	                $Pdata['Encoding']	= "utf-8";				            // 信件本體編碼
				    //show_array($Pdata);
				    //exit;
	
	                if($mail_info['mailserver_type'] == "sendmail"){
	                    $err = mail_send ($Pdata);
	                }else{
	                    $err = mail_smtp ($Pdata);
	                }
				}

			}

            print "<script>";
            print " alert('註冊成功，請收取驗證信');";
            print " window.location.href='index.php';";
            print "</script>";


            exit;
        }else{


/*
			$mail_info=array();
            $mail_info=get_mail_info("1");
            // show_array($mail_info);
            $v_url = $global_website_url."verify.php?v=".$check_info['Fmain_id'];
            $mail_title = "註冊信箱驗證";
            $mail_arr = array();
            $mail_arr['姓名'] = $check_info['text_field_2'];
            $mail_arr['驗證網址'] = "<a href='".$v_url."' target='_blank'>".$v_url."</a>";
			$mail_content = get_mail_html_content_new($mail_title,$mail_arr);
            $Pdata=array();
			$Pdata['RecvAdd']	= $check_info['text_field_0'];	        // 收件人地址
			$Pdata['RecvTi']    = $check_info['text_field_2'];           // 收件者名稱
			$Pdata['SendAdd']	= $mail_info['sendmail_email'];		    // 寄件人地址
			$Pdata['SendTi']	= $mail_info['sendmail_name'];		    // 寄件人名稱
			$Pdata['Subject']	= $mail_title;			   // 主旨
			$Pdata['MailHTML']	= $mail_content;
			//$Pdata['Encoding']	= "big5";				            // 信件本體編碼
			$Pdata['Encoding']	= "utf-8";				            // 信件本體編碼
			show_array($Pdata);
			//exit;
			
			if($mail_info['mailserver_type'] == "sendmail"){
			 $err = mail_send ($Pdata);
			}else{
			 $err = mail_smtp ($Pdata);
			}
*/
			#show_array($err);
			print "<script>";
            print " alert('帳號重複，請重新確認');";
            print " history.go(-1);";
            print "</script>";
            exit;
        }


    }


    include "quote/template/head.php";

?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/registration.css">
<script src="https://www.google.com/recaptcha/api.js?render=<?=$reCAPTCHA_setting['golden_key']?>">  </script>
</head>

<body class="registrationPage">
    <?php
        include "quote/template/added.php";
        include "quote/template/nav.php";
    ?>
    <div id="Wrapper">
        <main role="main">
            <div class="sh-banner">
                <!-- 1025 -->
                <img class="pc" src="dist/images/registration/line_1_pc.png">
                <img class="mo" src="dist/images/registration/line_1_mb.png">
                <div class="container">
                    <h2>
                        <div class="e-ti">REGISTER</div>
                        <div class="t-ti">會員註冊</div>
                    </h2>
                </div>
            </div>
            <section class="item1">
                <div class="container">
                    <div class="form-bx">
                        <form action="registration.php" method="post">
                            <input type="hidden" value="" name="recaptcha_response" id="recaptchaResponse">
                            <div class="flex-bx">
                                <div class="form-group">
                                    <label for=""><span>*</span>姓名</label>
                                    <input type="text" name="FO_text_field_2" required placeholder="請輸入真實姓名">
                                    <div id="FO_text_field_2_str" style="display: none" class="help-block with-errors">必填</div>
                                </div>
                                <div class="form-group">
                                    <label for=""><span>*</span>帳號</label>
                                    <input type="email" name="FO_text_field_0" placeholder="請輸入常用Email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,5}$">
                                    <div id="FO_text_field_0_str" style="display: none" class="help-block with-errors">必填</div>
                                </div>
                            </div>
                            <div class="flex-bx">
                                <div class="form-group">
                                    <label for=""><span>*</span>密碼設定</label>
                                    <input type="password" name="FO_text_field_1" placeholder="至少6字元以上">
                                    <div id="FO_text_field_1_str" style="display: none" class="help-block with-errors">至少6字元以上</div>
                                </div>
                                <div class="form-group">
                                    <label for=""><span>*</span>密碼確認</label>
                                    <input type="password" name="pwdcheck" placeholder="請再次輸入密碼">
                                    <div id="pwdcheck_str" style="display: none" class="help-block with-errors">與密碼不符</div>
                                </div>
                            </div>
                            <div class="flex-bx">
                                <div class="form-group radio-group">
                                    <label for=""><span>*</span>性別</label>
                                    <div class="radio-flex">
                                        <div class="form-radio">
                                            <input type="radio" required="" id="g-1" value="先生" name="FO_radio_field_3" checked="true">
                                            <label for="g-1">
                                                男
                                            </label>
                                        </div>
                                        <div class="form-radio">
                                            <input type="radio" required="" value="小姐" id="g-2" name="FO_radio_field_3">
                                            <label for="g-2">
                                                女
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for=""><span>*</span>生日</label>
                                    <input type="date" name="FO_date_field_4" placeholder="">
                                    <div class="help-block with-errors" id="FO_date_field_4_str" style="display: none">必填</div>
                                </div>
                            </div>
                            <div class="flex-bx">
                                <div class="form-group">
                                    <label for=""><span>*</span>手機</label>
                                    <input type="tel" name="FO_text_field_5" placeholder="請輸入手機號碼，例如：0912345678" maxlength="10"  pattern="[0-9]{10}">
                                    <div id="FO_text_field_5_str" style="display: none" class="help-block with-errors">必填</div>
                                </div>
                                <div class="form-group">
                                    <label for="">市內電話</label>
                                    <div class="tel-bx">
                                        <!-- 1025 -->
                                        <input type="tel" name="FO_text_field_6_1" placeholder="區域號碼"   pattern="[0-9]{2,3}">
				                        <input type="tel" name="FO_text_field_6_2" placeholder="請輸入市內電話"  pattern="[0-9]{6,10}">
                                    </div>
                                    <div id="FO_text_field_6_str" style="display: none" class="help-block with-errors">必填</div>
                                </div>
                            </div>
                            <div class="form-group ad-group">
                                <label for="">地址</label>
                                <div class="flex">
                                    <div id="twzipcode"></div>
                                    <input type="text" name="FO_text_field_7_3" placeholder="請輸入地址">
                                    <div id="FO_text_field_7_str" style="display: none" class="help-block with-errors">必填</div>
                                </div>
                            </div>
                            <div class="flex-btn">
                                <div class="">
                                    <div class="checkbox">
                                        <input type="checkbox" name="agree" value="1" id="agree" required>
                                        <label for="agree">
                                            <p>我同意<a href="terms.php" target="_blank">JHT相關條款</a></p>
                                        </label>
                                    </div>
                                    <div id="agree_str" style="margin-left: 3em;" class="help-block with-errors">*請詳閱JHT相關條款</div>
                                </div>
                                <a href="javascript:send_fn();" class="sh-btn send-btn">
                                    <div class="ar"></div>
                                    註冊
                                </a>
                            </div>
							<input type="submit" id="submit" name="submit" style="display: none">
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
    <script src="dist/js/jquery.twzipcode.min.js"></script>
    <script>
        $("#twzipcode").twzipcode({
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
        })
        
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
                    if($("input[name='FO_text_field_2']").val()==""){ //姓名
                        $("#FO_text_field_2_str").show();
                        is_flat = 1;
                        the_alert += "姓名必填！\n";
                    }else{
                        $("#FO_text_field_2_str").hide();
                    }


                    if($("input[name='FO_date_field_4']").val()==""){ //生日
                        $("#FO_date_field_4_str").show();
                        is_flat = 1;
                        the_alert += "生日必填！\n";
                    }else{
                        $("#FO_date_field_4_str").hide();
                    }



                    if($("input[name='FO_text_field_0']").val()=="" ){ //帳號
                        $("#FO_text_field_0_str").show();
                        is_flat = 1;
                        the_alert += "帳號必填！\n";
                    }else{

                        if(!checkEmail($("input[name='FO_text_field_0']").val())){
                            $("#FO_text_field_0_str").html("*請輸入正確格式Email");
                            $("#FO_text_field_0_str").show();
                            is_flat = 1;
                            the_alert += "請輸入正確格式Email！\n";

                        }else{
                            $("#FO_text_field_0_str").hide();
                        }

                    }

                    if($("input[name='FO_text_field_1']").val()=="" || $("input[name='FO_text_field_1']").val().length<6){ //密碼
                        $("#FO_text_field_1_str").show();
                        is_flat = 1;
                        the_alert += "密碼必填！\n";
                    }else{

                        $("#FO_text_field_1_str").hide();

                    }



                    if($("input[name='pwdcheck']").val()=="" || $("input[name='pwdcheck']").val().length<6){ //密碼
                        $("#pwdcheck_str").show();
                        is_flat = 1;
                        the_alert += "確認密碼必填！\n";
                    }else{

                        if($("input[name='FO_text_field_1']").val()!=$("input[name='pwdcheck']").val()){
                            // $("#FO_text_field_1_str").html("*兩次密碼輸入不同");
                            // $("#FO_text_field_1_str").show();
                            $("#pwdcheck_str").html("*兩次密碼輸入不同");
                            $("#pwdcheck_str").show();
							the_alert += "兩次密碼輸入不同！\n";
                            is_flat = 1;

                        }else{
                            $("#FO_text_field_1_str").hide();
                            $("#pwdcheck_str").hide();
                        }

                    }




                    if($("input[name='FO_text_field_5']").val()=="" ){ //手機
                        $("#FO_text_field_5_str").show();
                        is_flat = 1;
                        the_alert += "手機必填！\n";
                    }else{

                        var a=$("input[name='FO_text_field_5']").val();
                        var b=a.slice(0,2);
//                        alert(b);

                        if(b != "09")
                        {
                            is_flat = 1;
                            the_alert += "手機格式錯誤，請輸入09開頭的十碼數字！\n";
                            $("#FO_text_field_5_str").html("*格式錯誤，請輸入09開頭的十碼數字");
                            $("#FO_text_field_5_str").show();
                        }
                        else
                        {
                           if(!checkNumber($("input[name='FO_text_field_5']").val()) || $("input[name='FO_text_field_5']").val().length<10){
                               $("#FO_text_field_5_str").html("*格式錯誤，請輸入09開頭的十碼數字");
                               $("#FO_text_field_5_str").show();
                               is_flat = 1;
                               the_alert += "手機格式錯誤，請輸入09開頭的十碼數字！\n";
                           }
                           else{
                               $("#FO_text_field_5_str").hide();
                           }
                        }

                    }

/*
                    if($("input[name='FO_text_field_6_1']").val()=="" || $("input[name='FO_text_field_6_2']").val()=="" ){ //市內電話
                        $("#FO_text_field_6_str").show();
                        is_flat = 1;
                        the_alert += "市內電話必填！\n";
                    }else{
                        $("#FO_text_field_6_str").hide();
                    }


                    if($("input[name='FO_text_field_7_3']").val()=="" || $("select[name='county']").find(":selected").val()=="" || $("select[name='district']").find(":selected").val()=="" ){// 地址
                        $("#FO_text_field_7_str").show();
                        is_flat = 1;
                        the_alert += "地址必填！\n";
                    }else{
                        $("#FO_text_field_7_str").hide();
                    }
*/


                    if(!$("#agree").prop("checked")){// 輝葉相關條款
                        $("#agree_str").show();
                        is_flat = 1;
                        the_alert += "相關條款需同意！\n";
                    }else{
                        $("#agree_str").hide();
                    }






                    if(is_flat==0){
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
		 $(function() {
            	setTimeout(function(){
            	   $(".grecaptcha-badge").css("visibility","hidden");
            	},800);
        });
    </script>
</body>

</html>