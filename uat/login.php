<?
    // ini_set('display_errors','1');
    // error_reporting(E_ALL);
    session_start();

    require_once ("global_include_file.php");
    require_once ("global_function_mail.php");
    require_once ('login_admin/library/mail.php');
    require_once 'facebook_login/initialization.php'; //引入 Facebook 登入初始設定




    if (isset($accessToken) and $_COOKIE['member_userid'] == "")
    {
       require_once 'facebook_login/statuslogin.php';



       if($profile["email"] != ""){
         $member_userid=$profile["email"];
       }else{
         $member_userid=$profile["id"];
         $sn=1;
       }

       $member_input_name=$profile["name"];
       $fb_uid=$profile["id"];

       $set_owner_num = "g2g2g2g2";
       $set_button_num = "g2";

       $check_info=array();
       $where_clause="userid = 'admin' and text_field_0 = '".$member_userid."'";// and owner_num = '".$set_owner_num."'
       $tbl_name='sys_portal_'.$set_button_num;
       get_data($tbl_name, $where_clause, $check_info);
       #show_array($check_info);exit;

       setcookie("member_userid",$member_userid);
       setcookie("member_input_name",$member_input_name);

       $_COOKIE['member_userid']=$member_userid;


       if(count($check_info) <= 0)
       {


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


           $add_info=array();
           $add_info['userid']="admin";
           // $add_info['owner_num']=$set_owner_num;
           $add_info['text_field_0']=$member_userid;
           $add_info['text_field_1']=time();
           $add_info['text_field_2']=$member_input_name;
           #$add_info['website_language_id']="1";
           // if($sn == 0)
           // $add_info['member_email']=$member_userid;
           $add_info['now_time']=date("Y-m-d H:i:s");
            $add_info['rank']=$new_id;

           $add_info['is_fb_login']="1";
           $add_info['fb_uid']=$fb_uid;
           $add_info['level']="一般會員";

           $tbl_name='sys_portal_'.$set_button_num;
           $return_arr=array();
           $return_arr=add_data($tbl_name,$add_info);
           $return_id=$return_arr['newrid'];


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

              member_bouns_control($money,$add_info['text_field_0'],"admin","1",$mail_title);

              // 發送郵件
              $Pdata=array();
              $Pdata['RecvAdd']   = $add_info['text_field_0'];           // 收件人地址
              $Pdata['RecvTi']    = $add_info['text_field_2'];           // 收件者名稱
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

			$add_c_info = array();
			$add_c_info['coupon_id'] = $coupon_set_mail_info['set_val'];
			$add_c_info['get_date']      = date("Y-m-d");
			$add_c_info['member_userid'] = $add_info['text_field_0'];
			if($chk_coupon_info['limit_m'] || $chk_coupon_info['limit_d']){
	        	$add_c_info['deadline_date'] = date("Y-m-d",strtotime("+ ".(($chk_coupon_info['limit_m'])?$chk_coupon_info['limit_m']:"0")." months ".(($chk_coupon_info['limit_d'])?$chk_coupon_info['limit_d']:"0")." days"));
            }
			$tbl_name = "member_coupon_list";
			$return_arr=add_data($tbl_name,$add_c_info);
			$return_id=$return_arr['newrid'];
			if($return_id){
				$mail_title = ($coupon_set_mail_info['set_title'])?$coupon_set_mail_info['set_title']:"會員註冊禮";
				$mail_content = ($coupon_set_mail_info['set_mail'])?$coupon_set_mail_info['set_mail']:"送您折價券一張";
				// 發送郵件
                $Pdata=array();
                $Pdata['RecvAdd']	= $add_info['text_field_0'];	        // 收件人地址
                $Pdata['RecvTi']    = $add_info['text_field_2'];           // 收件者名稱
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



           mb_http_output ("UTF-8");
           mb_internal_encoding("UTF-8");
           ob_start ("mb_output_handler");
           print "<script>";
           print "alert('歡迎您的加入');";
           print "location.href='index.php';";
           print "</script>";
           exit;
       }
       else
       {
           if($check_info['is_fb_login'] == "1" and $check_info['is_fb_login_complete'] == "2" || 0)
           {
               mb_http_output ("UTF-8");
               mb_internal_encoding("UTF-8");
               ob_start ("mb_output_handler");
               print "<script>";
               print "alert('歡迎您的加入');";
               print "location.href='index.php';";
    //                   print "opener.location='member_info.php';";
    //                   print "window.close();";
               print "</script>";
               exit;
           }
           else
           {
               mb_http_output ("UTF-8");
               mb_internal_encoding("UTF-8");
               ob_start ("mb_output_handler");
               print "<script>";
               print "alert('歡迎您回來');";
               print "location.href='index.php';";
    //                   print "opener.location='index.php';";
    //                   print "window.close();";
               print "</script>";
               exit;
           }


       }




    }


    $check_info=array();
    $where_clause="text_field_0 = '".$_COOKIE['member_userid']."'";
    $tbl_name="sys_portal_g2";
    get_data($tbl_name, $where_clause, $check_info);
    // show_array($check_info);

    if($_COOKIE['member_userid']!="" && count($check_info)>0){
        header("Location: member-profile.php");
        exit;
    }






    if($_POST['submit']!=""){ //送出表單


        // print "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>---------<br>";
        // show_array($_POST);


        $check_info=array();
        $where_clause="text_field_0 = '".$_POST['account']."' and text_field_1='".$_POST['password']."'";
        $tbl_name="sys_portal_g2";
        get_data($tbl_name, $where_clause, $check_info);
        // show_array($check_info);

		if($check_info['is_verify']=="2"){
			print "<script>";
            print " alert('尚未驗證，請先收取驗證信！');";
            print " history.go(-1);";
            print "</script>";
            exit;
		}
        else if(count($check_info)>0){
            setcookie("member_userid",$_POST['account']);

            // show_array($_COOKIE);
            // exit;

            // print "<script>";
            // print " alert('登入成功，跳轉至會員中心');";
            // print " window.location.href='member-profile.php';";
            // print "</script>";

            if($_GET['back_url'])	header("Location: ".$_GET['back_url']);
            else	header("Location: member-profile.php");

            exit;
        }else{
            print "<script>";
            print " alert('帳密錯誤，請重新確認');";
            print " history.go(-1);";
            print "</script>";
            exit;
        }


    }

    include "quote/template/head.php";
?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/registration.css">
</head>

<body class="loginPage">
    <?php
        include "quote/template/added.php";
        include "quote/template/nav.php";
    ?>
    <div id="Wrapper">
        <main role="main">
            <div class="sh-banner">
                <img class="pc" src="dist/images/login/line_1_pc.png">
                <img class="mo" src="dist/images/login/line_1_mb.png">
                <div class="container">
                    <h2>
                        <div class="e-ti">LOG IN</div>
                        <div class="t-ti">會員登入</div>
                    </h2>
                </div>
            </div>
            <section class="item1">
                <div class="container">
                    <div class="link-flex">
                        <a href="registration.php">
                            立即註冊
                        </a>
                        <a href="forgot-pw.php">
                            忘記密碼
                        </a>
                    </div>
                    <div class="it1-bx">
                        <div class="l-bx">
                            <img src="dist/images/login/illustration.png">
                        </div>
                        <div class="link-flex mo">
                            <a href="registration.php">
                                立即註冊
                            </a>
                            <a href="forgot-pw.php">
                                忘記密碼
                            </a>
                        </div>
                        <div class="form-bx">
                            <form action="login.php?back_url=<?=$_GET['back_url']?>" method="post">
                                <div class="form-group">
                                    <label for=""><span>*</span>帳號</label>
                                    <input type="email" name="account" required placeholder="請輸入您註冊的Email">
                                    <div id="account_str" style="display: none" class="help-block with-errors">請輸入正確格式Email</div>
                                </div>
                                <div class="form-group">
                                    <label for=""><span>*</span>密碼</label>
                                    <input type="password" name="password" required placeholder="請輸入密碼">
                                    <div id="password_str" style="display: none" class="help-block with-errors">請輸入密碼</div>
                                </div>
                                <a href="javascript:send_fn();" class="sh-btn send-btn">
                                    <div class="ar"></div>
                                    登入
                                </a>
                                <input type="submit" id="submit" name="submit" style="display: none">
                            </form>
                            <div class="group-login">
                                <a href="javascript:$('.abcRioButtonContentWrapper').click();">
                                    <div class="img-bx">
                                        <img src="dist/images/login/google_bt.png">
                                    </div>
                                    <div class="tx">
                                        使用Google<br class="pc">
                                        帳號登入
                                    </div>
                                </a>
                <?
                $url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; //取得目前頁面網址
                $loginUrl = $helper->getLoginUrl($url, $permissions); //取得 Facebook 登入網址
                ?>
                                <a href="<?php echo $loginUrl; ?>">
                                    <div class="img-bx">
                                        <img src="dist/images/login/fb_bt.png">
                                    </div>
                                    <div class="tx">
                                        使用Facebook<br class="pc">
                                        帳號登入
                                    </div>
                                </a>
                                <a href="javascript:;" target="_blank">
                                    <div class="img-bx">
                                        <img src="dist/images/login/line_btn.png">
                                    </div>
                                    <div class="tx">
                                        使用LINE<br class="pc">
                                        帳號登入
                                    </div>
                                </a>
                            </div>
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
    <script type="text/javascript">
        function send_fn(){
            if(check_data()){
                $("#submit").click();
            }
        }

        function check_data(){

            var is_flat = 0;

            if($("input[name='password']").val()=="" || $("input[name='password']").val().length<6){ //密碼
                $("#password_str").show();
                is_flat = 1;
            }else{
                $("#password_str").hide();
            }


            if($("input[name='account']").val()=="" ){ //帳號
                $("#account_str").show();
                is_flat = 1;
            }else{

                if(!checkEmail($("input[name='account']").val())){
                    $("#account_str").html("*請輸入正確格式Email");
                    $("#account_str").show();
                    is_flat = 1;

                }else{
                    $("#account_str").hide();
                }

            }


            if(is_flat==0){
                return true;
            }else{
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


    <script>
	  function onSignIn(googleUser){
	    var profile=googleUser.getBasicProfile();
	    //$(".g-signin2").css("display","none");
	    console.log('Full Name: ' + profile.getName());
	    console.log('Email: ' + profile.getEmail());

	    $.cookie('member_userid', profile.getEmail());
	    $.cookie('member_input_name', profile.getName());
	    signOut();

	    var a=Math.floor(Math.random()*(100000-0));
	    dataSource = '&parm='+new Date().getTime()+a;
	    $.get('ajax_social_save.php?'+dataSource+'','',function(data,textStatus,XMLHttpRequest){
	       if(data == "new")
	       {
	//          alert(data);
	            window.location.replace("member-profile.php");

	       }
	       else if(data == "repeat")
	       {
	          alert("登入方式錯誤,請使用FB登入");
	//            window.location.replace("member_info.php");

	       }
	       else
	       {
	           var s_now_url= $.cookie("s_now_url");

	           if(s_now_url != null && s_now_url != "" && s_now_url != undefined)
	           window.location.replace(s_now_url);
	           else
	           window.location.replace("index.php");
	       }
	    });




	  }


	  function signOut(){
	    var auth2 = gapi.auth2.getAuthInstance();
	    auth2.signOut().then(function(){
	      // alert("You have been successrully signed out");
	      // $(".g-signin2").css("display","block");
	    });
	  }

	</script>




	<script type="text/javascript">

		/*window.fbAsyncInit = function(){
	    FB.init({
	      appId      : '134731631890043',
	      cookie     : true,                     // Enable cookies to allow the server to access the session.
	      xfbml      : true,                     // Parse social plugins on this webpage.
	      version    : 'v5.0'           // Use this Graph API version for this call.
	    });


	    FB.getLoginStatus(function(response) {   // Called after the JS SDK has been initialized.
	      // statusChangeCallback(response);        // Returns the login status.
	      // console.log(response);
	    });
	  };


	  (function(d, s, id) {  // Load the SDK asynchronously
	    var js, fjs = d.getElementsByTagName(s)[0];
	    if (d.getElementById(id)) return;
	    js = d.createElement(s); js.id = id;
	    js.src = "https://connect.facebook.net/en_US/sdk.js";
	    fjs.parentNode.insertBefore(js, fjs);
	  }(document, 'script', 'facebook-jssdk'));
      */


		function FBLogin(){
		    FB.getLoginStatus(function (res) {
		        // console.log(`status:${res.status}`);//Debug

		        if(res.status === "connected"){
		          // console.log(res);
		          let userID = res["authResponse"]["userID"];
		          // console.log("用戶已授權您的App，用戶須先revoke撤除App後才能再重新授權你的App");
		          // console.log(`已授權App登入FB 的 userID:${userID}`);
		          GetProfile();
		        }else if (res.status === 'not_authorized' || res.status === "unknown"){
		          //App未授權或用戶登出FB網站才讓用戶執行登入動作
		          FB.login(function (response) {
		            // console.log(response); //debug用
		            if (response.status === 'connected'){
		              // console.log("here");
		                //user已登入FB
		                //抓userID
		                // console.log(response);
		                let userID = response["authResponse"]["userID"];
		                // console.log(`已授權App登入FB 的 userID:${userID}`);
		                GetProfile();

		            } else {
		                // user FB取消授權
		                // alert("Facebook帳號無法登入");
		            }
		            //"public_profile"可省略，仍然可以取得name、userID
		          }, { scope: 'email'});
		        }
		    });
		  }




		  //取得用戶姓名、email
		  function GetProfile() {
		      // document.getElementById('content').innerHTML = "";//先清空顯示結果

		      //FB.api()使用說明：https://developers.facebook.com/docs/javascript/reference/FB.api
		      //取得用戶個資
		      FB.api("/me", "GET", { "fields" : "id,name,gender,email" }, function (user) {
		          //user物件的欄位：https://developers.facebook.com/docs/graph-api/reference/user
		          if(user.error) {
		              console.log(response);
		          }else{

		            <?if(get_ip()=="125.227.236.37"){?>
		              // console.log(user);return;
		            <?}?>


		            $.get("register_enter.php",{
		              name: user.name,
		              mail: user.email,
		              id:user.id,
		              submit:"FB_註冊",
		              prepage:$("#pre_page").val()
		            },
		            function(data, status){

		              if(data!=''){
		                console.log(data);
		                  <?if($_GET['s_now_url']==""){?>
		                    window.location.href = "index.php";
		                  <?}else{?>
		                    window.location.href = "<?=$_GET['s_now_url']?>";
		                  <?}?>


		              }

		            });

		          }
		      });

		  }
	</script>
</body>

</html>