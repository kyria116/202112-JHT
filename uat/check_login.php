<?

	$check_login=array();
    $where_clause="text_field_0 = '".$_COOKIE['member_userid']."'";
    $tbl_name="sys_portal_g2";
    get_data($tbl_name, $where_clause, $check_login);
    // show_array($check_login);

    // setcookie("member_userid",$ARR_Update['text_field_0']);


    if($_COOKIE['member_userid']=="" || count($check_login)<1){
        print "<script>";
        // print " alert('尚未登入，跳轉至登入頁面');";
        print " window.location.href='login.php';";
        print "</script>";
        

        // header("Location: login.php"); 

        exit;
    }

?>