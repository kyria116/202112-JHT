<?php

    require_once ("global_include_file.php");

    require_once ("global_function_mail.php");
    require_once ('login_admin/library/mail.php');


	if(!$_GET['no_login'])	session_start();
    if(!$_GET['no_login'])	$session_ID = session_id();
    if($_GET['v']!=""){
		$member_info=array();
		$where_clause=" Fmain_id = '".$_GET['v']."' ";
		$tbl_name="sys_portal_g2";
		get_data($tbl_name, $where_clause, $member_info);

        if($member_info['Fmain_id']){
            if($member_info['is_verify']=="2"){
	            $ARR_Update = array();
	            $ARR_Update['is_verify']="1";
	            $tbl_name="sys_portal_g2";
	            $where_clause=" Fmain_id = '".$member_info['Fmain_id']."' ";
	            update_data($tbl_name, $where_clause, $ARR_Update);
	            if(!$_GET['no_login'])	setcookie("member_userid",$member_info['text_field_0']);
	            print "<script>";
	            print " alert('驗證完畢！');";
	            if(substr_count($_GET['back_url'],"ticket")>=1)	header("Location: ".$_GET['back_url']);
	            else print " location.href='member-profile.php';";
	            print "</script>";
	            exit;
            }
            else{
	            print "<script>";
	            print " alert('已驗證過，請直接登入！');";
	            if(substr_count($_GET['back_url'],"ticket")>=1)	header("Location: ".$_GET['back_url']);
	            else print " location.href='login.php';";
	            print "</script>";
	            exit;
            }
        }
        else{
            print "<script>";
            print " alert('查無此帳號！');";
            print " location.href='index.php';";
            print "</script>";

            exit;
        }
    }
    else{
        print "<script>";
        print " alert('操作錯誤！');";
        print " location.href='index.php';";
        print "</script>";

        exit;
    }
?>