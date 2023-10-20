<?php include "quote/template/head.php"; ?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/contact.css">
<?
	if($_COOKIE['lang_id']=="3"){//英文版
        $lang_id = 3;
        $lang_str= "lang_en";
    }else{
        $lang_id = 1;
        $lang_str= "lang_tw";
    }

    $lang_info=array();
    $where_clause="1";
    $tbl_name=$MYSQL_TABS['portal_h2'];
    getall_data($tbl_name, $where_clause, $lang_info);
    // show_array($lang_info);

    $global_website_langword = array();
    for($iii=0;$iii<count($lang_info);$iii++){
        $global_website_langword[$lang_info[$iii]['title']] = $lang_info[$iii]['title_'.$lang_id];
    }



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

#print_r($recaptcha);exit;


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

        ####################################################################
        ####################################################################


//         show_array($_POST);
//         exit;
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
		if($_POST['title_add'])	$ARR_Update['title'] .= AddSlashes("：".$_POST['title_add']);
        $ARR_Update['start_time'] = date("Y-m-d H:i:s");
        $ARR_Update['userid'] = $global_website_userid;
        if($_COOKIE['lang_id']!=""){
            $ARR_Update['lang'] = $_COOKIE['lang_id'];
        }
        $tbl_name="sys_portal_g1";
        $return_arr=array();
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
        $send_arr[] = ["title"=>"聯絡電話","value"=>$ARR_Update['phone']];
        $send_arr[] = ["title"=>"聯絡信箱","value"=>$ARR_Update['email']];
        $send_arr[] = ["title"=>"聯絡事項","value"=>$ARR_Update['title']];
        $send_arr[] = ["title"=>"留言內容","value"=>$ARR_Update['content']];

        $mail_content = creat_mail("聯絡人訊息",$send_arr);

        // $mail_info['sendmail_email'] = "tommy@webdo.cc"; //測試

        $Pdata=array();
        $Pdata['RecvAdd']   = $service_email_info['email'];         // 收件人地址
        $Pdata['RecvTi']    = "親愛的管理者";           // 收件者名稱
        $Pdata['SendAdd']   = $mail_info['sendmail_email'];         // 寄件人地址
        $Pdata['SendTi']    = $mail_info['sendmail_name'];           // 寄件人名稱
        $Pdata['Subject']   = "聯絡我們通知信";            // 主旨
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


        if($return_id != "")
        {
           print "<script>";
           print "alert('".$global_website_langword['送出成功']."');";
           print "</script>";
        }
        else
        {
           print "<script>";
           print "alert('".$global_website_langword['送出失敗']."');";
           print "</script>";
        }
    }
?>
</head>

<body class="contactPage">
    <?php
        include "quote/template/added.php";
        include "quote/template/nav.php";
    ?>
    <script src="https://www.google.com/recaptcha/api.js?render=<?=$reCAPTCHA_setting['golden_key']?>">  </script>
    <div id="Wrapper">
        <main role="main">
            <div class="sh-banner">
                <img class="pc" src="dist/images/contact/line_1_pc.png">
                <img class="mo" src="dist/images/contact/line_1_mb.png">
                <div class="container">
                    <h2>
                        <div class="e-ti">contact</div>
                        <div class="t-ti">聯絡我們</div>
                    </h2>
                </div>
            </div>
            <section class="item1">
                <div class="container">
                    <div class="it1-bx">
                        <div class="l-bx">
                            <div class="des-ti">
                                感謝您拜訪JHT健康科技，如果您有任何疑問或意見！<br class="pc">
                                為了提供您更完善的服務，請務必輸入正確的資料，謝謝您。
                            </div>
                            <div class="img-bx">
                                <img src="dist/images/contact/illustration.png">
                            </div>
                        </div>
                        <div class="r-bx">
                            <div class="form-bx">
                                <form  name="f1" action="contact.php" method="post">
                                    <div class="flex-bx">
                                        <div class="form-group">
                                            <label for=""><span>*</span>姓名</label>
                                            <input type="text" name="FO_name" placeholder="<?=$global_website_langword['請輸入姓名']?>" required >
                                            <input type="hidden" value="" name="recaptcha_response" id="recaptchaResponse">
                                            <div id="FO_name_str" style="display: none" class="help-block with-errors"><?=$global_website_langword['必填']?></div>
                                        </div>
                                        <div class="form-group">
                                            <label for=""><span>*</span>手機</label>
                                            <input type="tel" name="FO_phone"  placeholder="<?=$global_website_langword['請輸入聯絡電話']?>" required maxlength="10" pattern="[0-9]{10}">
                                            <div id="FO_phone_str" style="display: none" class="help-block with-errors"><?=$global_website_langword['必填']?></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><span>*</span>Email</label>
                                        <input type="email" name="FO_email" placeholder="<?=$global_website_langword['請輸入常用Email']?>" required  pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,5}$">
                                        <div id="FO_email_str" style="display: none" class="help-block with-errors"><?=$global_website_langword['請輸入正確格式Email']?></div>
                                    </div>
                                    <div class="form-group radio-group">
                                        <label for=""><span>*</span>聯絡事項</label>
                                        <div class="radio-flex">
                                            <div class="form-radio">
                                                <input type="radio" required="" id="c-1" name="FO_title" value="購買問題" checked="true">
                                                <label for="c-1">
                                                    購買問題
                                                </label>
                                            </div>
                                            <div class="form-radio">
                                                <input type="radio" required="" id="c-2" name="FO_title" value="維修問題">
                                                <label for="c-2">
                                                    維修問題
                                                </label>
                                            </div>
                                            <div class="form-radio">
                                                <input type="radio" required="" id="c-3" name="FO_title" value="商品退/換貨">
                                                <label for="c-3">
                                                    商品退/換貨
                                                </label>
                                            </div>
                                            <div class="form-radio">
                                                <input type="radio" required="" id="c-4" name="FO_title" value="合作需求">
                                                <label for="c-4">
                                                    合作需求
                                                </label>
                                            </div>
                                            <div class="form-radio w100">
                                                <input type="radio" required="" id="c-5" name="FO_title" value="其他">
                                                <label for="c-5">
                                                    其他
                                                </label>
                                                <input type="text" name="title_add" placeholder="請輸入內容">
                                            </div>
                                        </div>
                                        <div id="FO_title_str" style="display: none" class="help-block with-errors"><?=$global_website_langword['必填']?></div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><span>*</span>內容</label>
                                        <textarea rows="4" name="FO_content" placeholder="<?=$global_website_langword['請輸入內容']?>" required ></textarea>
                                        <div id="FO_content_str" style="display: none" class="help-block with-errors"><?=$global_website_langword['必填']?></div>
                                    </div>
                                    <a href="javascript:;" class="sh-btn send-btn" onclick="send_fn();">
                                        <div class="ar"></div>
                                        送出
                                    </a>
                                    <input type="submit" id="submit" name="submit" style="display: none">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <script type="text/javascript">
                function send_fn(){
                    if(check_data()){
//                         $("#submit").click();
						grecaptcha.execute('<?=$reCAPTCHA_setting['golden_key']?>', {action: 'submit'}).then(function(token) {
		                    $("#recaptchaResponse").val(token);
		                    $("#submit").click();
		                });
                    }
                }



                function check_data(){

                    var is_flat = 0;
					var the_alert = "";
                    if($("input[name='FO_name']").val()==""){
                        $("#FO_name_str").show();
                        is_flat = 1;
                        the_alert += "姓名必填！\n";
                    }else{
                        $("#FO_name_str").hide();
                    }

                    if($("input[name='FO_phone']").val()=="" ){ //手機
                        $("#FO_phone_str").show();
                        is_flat = 1;
                        the_alert += "手機必填！\n";
                    }else{

                        var a=$("input[name='FO_phone']").val();
						var b=a.slice(0,2);

                        if(b != "09")
		                {
		                    is_flat = 1;
		                    the_alert += "手機格式錯誤，請輸入09開頭的十碼數字！\n";
		                    $("#FO_phone_str").html("*格式錯誤，請輸入09開頭的十碼數字");
		                    $("#FO_phone_str").show();
		                }
		                else if(!checkNumber($("input[name='FO_phone']").val()) || $("input[name='FO_phone']").val().length<10 ){
                            $("#FO_phone_str").html("*格式錯誤，請輸入09開頭的十碼數字");
                            $("#FO_phone_str").show();
                            is_flat = 1;
                            the_alert += "手機格式錯誤，請輸入09開頭的十碼數字！\n";
                        }else{
                            $("#FO_phone_str").hide();
                        }

                    }

//                    if($("input[name='FO_phone']").val()=="" ){
//                        $("#FO_phone_str").show();
//                        is_flat = 1;
//                    }else{
//
//                        if(!checkNumber($("input[name='FO_phone']").val())){
//                            $("#FO_phone_str").html("*<?=$global_website_langword['格式錯誤']?>");
//                            $("#FO_phone_str").show();
//                            is_flat = 1;
//                        }else{
//                            $("#FO_phone_str").hide();
//                        }
//
//
//                    }


                    if($("input[name='FO_email']").val()=="" ){
                        $("#FO_email_str").show();
                        is_flat = 1;
                        the_alert += "E-mail必填！\n";
                    }else{

                        if(!checkEmail($("input[name='FO_email']").val())){
                            $("#FO_email_str").html("*<?=$global_website_langword['請輸入正確格式Email']?>");
                            $("#FO_email_str").show();
                            is_flat = 1;
							the_alert += "<?=$global_website_langword['請輸入正確格式Email']?>！\n";
                        }else{
                            $("#FO_email_str").hide();
                        }

                    }

                    if($("textarea[name='FO_content']").val()==""){
                        $("#FO_content_str").show();
                        is_flat = 1;
                        the_alert += "內容必填！\n";
                    }else{
                        $("#FO_content_str").hide();
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

            </script>

        </main>
        <?php
            include "quote/template/top_btn.php";
        ?>
    </div>
    <?php
        include "quote/template/footer.php";
    ?>
    <script src="dist/js/main.js"></script>
        <script>
//      	$( "#product_id" ).chosen();
     	$(function() {
            	setTimeout(function(){
            	   $(".grecaptcha-badge").hide();
            	},800);
        });
    </script>
</body>

</html>