<?php
    include "quote/template/head.php";
    require_once ("global_include_file.php");
    require_once ("check_login.php");

    if($_COOKIE['member_userid'] == "")
    {
       print "<script>";
       print "location.href='login.php';";
       print "</script>";
       exit;

    }


    if($_POST['submit']!=""){ //送出表單

//show_array($_POST);
//exit;
        $ARR_Update = array();
//        while ( list($Rfield, $Rvalue)=each($_POST) )
        foreach($_POST as $Rfield => $Rvalue)
        {
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
//show_array($ARR_Update);
//exit;

        $where_clause="text_field_0 = '".$_COOKIE['member_userid']."'";
        $tbl_name="sys_portal_g2";
        update_data($tbl_name, $where_clause, $ARR_Update);


        $info=array();
        $where_clause="text_field_0 = '".$_COOKIE['member_userid']."'";
        $tbl_name="sys_portal_g2";
        get_data($tbl_name, $where_clause, $info);
        // show_array($info);

        print "<script>";
        print " alert('更改成功');";
        print "</script>";


    }





    $info=array();
    $where_clause="text_field_0 = '".AddSlashes($_COOKIE['member_userid'])."'";
    $tbl_name="sys_portal_g2";
    get_data($tbl_name, $where_clause, $info);
    // show_array($info);

	if($info['text_field_6']=="-")	$info['text_field_6'] = "";

?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/registration.css">
</head>

<body class="memberprofilePage">
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
                                    <li class="active">
                                        <a href="member-profile.php">
                                            <div class="f16">
                                                <span>會員資料</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
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
                        <div class="l-bx">
                            <div class="img-bx">

                                <?if($info['radio_field_3']=="先生"){?>
				                    <img src="dist/images/member/img_m.png">
				                <?}else{?>
				                    <img src="dist/images/member/img_f.png">
				                <?}?>

                                <!--<img src="dist/images/member/img_m.png">-->
                            </div>
                            <div class="name-bx">
                                <div class="name"><?=$info['text_field_2']?></div>
                                <a href="edit-password.php">
                                    <span>
                                        <div class="img-bx">
                                            <img class="unhov" src="dist/images/member/icon.png">
                                            <img class="hov" src="dist/images/member/hovicon.png">
                                        </div>
                                        修改密碼
                                    </span>
                                </a>
                            </div>
                            <div class="da-bx">
                                <div class="f16">
                                    <i><?=(($info['radio_field_3']=="先生")?"男":"女")?></i><span><?=str_replace("-",".",$info['date_field_4'])?></span>
                                </div>
                                <div class="f16">
                                    <?=$info['text_field_0']?>
                                </div>
                            </div>
                            <div class="pric-bx">
                                <div class="f16">購物金</div>
                                <div class="price">
	                    <?
                        if((int)$info['bonus_num'] < 0)
                           $info['bonus_num']=0;

                        print number_format($info['bonus_num']);

                        ?></div>
                            </div>
                        </div>
                        <div class="form-bx">
                            <form action="member-profile.php" method="post">
                                <div class="form-group">
                                    <label for=""><span>*</span>手機</label>
                                    <input type="tel" name="FO_text_field_5" placeholder="請輸入手機號碼，例如：0912345678" value="<?=$info['text_field_5']?>" maxlength="10" pattern="[0-9]{10}">
                                    <div id="FO_text_field_5_str" style="display: none" class="help-block with-errors">必填</div>
                                </div>
                                <div class="form-group">
                                    <label for="">市內電話</label>
                                    <div class="tel-bx">
                                        <input type="tel" name="FO_text_field_6_1" placeholder="區域號碼"  pattern="[0-9]{2,3}" value="<?=$info['text_field_6_1']?>">
										<input type="tel" name="FO_text_field_6_2" placeholder="請輸入市內電話"  pattern="[0-9]{6,10}" value="<?=(($info['text_field_6_2'])?$info['text_field_6_2']:$info['text_field_6'])?>">
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group ad-group">
                                    <label for="">地址</label>
                                    <div class="flex">
                                        <div id="twzipcode"></div>
                                        <input type="text" name="FO_text_field_7_3" placeholder="請輸入地址" value="<?=(($info['text_field_7_3'])?$info['text_field_7_3']:$info['text_field_7'])?>">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <a href="javascript:send_fn();" class="sh-btn send-btn">
                                    <div class="ar"></div>
                                    儲存變更
                                </a>
                                <input type="submit" id="submit" name="submit" style="display: none">
                            </form>
                        </div>
                    </div>
                </div>
            </section>

        </main>
        <?php
            include "quote/template/top_btn.php";
        ?>
    </div>
    <?
	    $member = $info;
    ?>
    <?php
        include "quote/template/footer.php";
    ?>
    <script src="dist/js/main.js"></script>
    <script src="dist/js/jquery.twzipcode.min.js"></script>
    <script>
        $("#twzipcode").twzipcode({
            countySel: '<?=$member['text_field_7_1']?>', //縣市預設值
			districtSel: '<?=$member['text_field_7_2']?>',
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
        });
    </script>
    <script type="text/javascript">

        function send_fn(){
            if(check_data()){
                $("#submit").click();
            }
        }

        function check_data(){

            var is_flat = 0;
			var the_alert = "";


            // if($("input[name='FO_text_field_1']").val()=="" || $("input[name='FO_text_field_1']").val().length<6){ //密碼
            //     $("#FO_text_field_1_str").show();
            //     is_flat = 1;
            // }else{

            //     $("#FO_text_field_1_str").hide();

            // }



            // if($("input[name='pwdcheck']").val()=="" || $("input[name='pwdcheck']").val().length<6){ //密碼
            //     $("#pwdcheck_str").show();
            //     is_flat = 1;
            // }else{

            //     if($("input[name='FO_text_field_1']").val()!=$("input[name='pwdcheck']").val()){
            //         // $("#FO_text_field_1_str").html("*兩次密碼輸入不同");
            //         // $("#FO_text_field_1_str").show();
            //         $("#pwdcheck_str").html("*兩次密碼輸入不同");
            //         $("#pwdcheck_str").show();

            //         is_flat = 1;

            //     }else{
            //         $("#FO_text_field_1_str").hide();
            //         $("#pwdcheck_str").hide();
            //     }

            // }


            if($("input[name='FO_text_field_5']").val()=="" ){ //手機
                $("#FO_text_field_5_str").show();
                is_flat = 1;
                the_alert += "手機必填！\n";
            }else{
				var a=$("input[name='FO_text_field_5']").val();
                var b=a.slice(0,2);
                if(b != "09")
                {
                    is_flat = 1;
                    $("#FO_text_field_5_str").html("*格式錯誤，請輸入09開頭的十碼數字");
                    $("#FO_text_field_5_str").show();
                    the_alert += "手機格式錯誤，請輸入09開頭的十碼數字！\n";
                }
                else if(!checkNumber($("input[name='FO_text_field_5']").val()) || $("input[name='FO_text_field_5']").val().length<10 ){
                    $("#FO_text_field_5_str").html("*格式錯誤，請輸入09開頭的十碼數字");
                    $("#FO_text_field_5_str").show();
                    the_alert += "手機格式錯誤，請輸入09開頭的十碼數字！\n";
                    is_flat = 1;
                }else{
                    $("#FO_text_field_5_str").hide();
                }

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
</body>

</html>