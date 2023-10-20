<?
	require_once ("global_include_file.php");

	header("Content-Type:text/html; charset=utf-8");
	session_start();
    $session_ID = session_id();
	setcookie("member_userid","",time ()-6000);
	$_COOKIE['member_userid'] = "";
	$_COOKIE['member_input_name'] = "";
	setcookie("member_input_name","",time ()-6000);
	$_SESSION['owner_num_other'] = "";
	$_SESSION['uniqid_str'] = "";
	$_SESSION['order_num'] = "";
	$_SESSION['facebook_access_token'] = "";
	unset($_SESSION['facebook_access_token']);

    print "<script>";
    // print " alert('已登出');";
    print " window.location.href='index.php';";
    print "</script>";

    exit;
?>