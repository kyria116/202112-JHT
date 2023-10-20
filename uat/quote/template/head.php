<?
include_once("global_include_file.php");

$website_seo_info=array();
$where_clause="Fmain_id = '1'";
$tbl_name="sys_website_seo";
get_data($tbl_name, $where_clause, $website_seo_info);
//show_array($website_seo_info);

/****************
about         關於我們
product       系列商品
news           活動消息
video          精彩影音
warranty        保固登錄
faq               常見問題
location        實體門市
onlinestore       網路平台
contact    聯絡我們
login       會員登入
register    會員註冊
forgotpassword   忘記密碼

******************/
$this_title_name="";
if(strstr($_SERVER['REQUEST_URI'],"about"))
{
    $this_title_name="|關於我們";
}
elseif(strstr($_SERVER['REQUEST_URI'],"product") or strstr($_SERVER['REQUEST_URI'],"HY-"))
{


    $this_title_name="|系列商品";

    $num = $_GET['num'];
    $num = str_replace("%", "", $num);
    $num = str_replace("select", "", $num);
	   $num = str_replace("SELECT", "", $num);
	   $num = str_replace("deletc", "", $num);
	   $num = str_replace("DELETE", "", $num);
	   $num = str_replace("update", "", $num);
	   $num = str_replace("UPDATE", "", $num);
	   $num = str_replace("sysdate", "", $num);
	   $num = str_replace("sleep", "", $num);
	   $num = str_replace("*", "", $num);
	   $num = str_replace(">", "", $num);
	   $num = str_replace("<", "", $num);
	   $num = str_replace("(", "", $num);
	   $num = str_replace(")", "", $num);

    $temp_info=array();
    $where_clause="text_field_1 = '".AddSlashes($num)."'";# and is_hide='2'
//    print $where_clause;
    $tbl_name="sys_portal_x100_cnt";
    get_data($tbl_name, $where_clause, $temp_info);
//    show_array($temp_info);
//    exit;

    $temp_folder_id = $temp_info['portal_x100_id_2'];
    $temp_arr=array();
    $temp_arr=explode(",",$temp_folder_id);
    $temp_arr[0] = str_replace("@", "", $temp_arr[0]);
    $temp_folder_id=$temp_arr[0];

//    print $temp_folder_id;
//    exit;

    $temp_detail_id = $temp_info['Fmain_id'];
    if(!$temp_folder_id && $_GET['folder_id'])	$temp_folder_id = $_GET['folder_id'];



    if($_GET['l1_id']){
		$x100_info=array();
		$where_clause=" Fmain_id = '".$_GET['l1_id']."' ";
		$tbl_name="sys_portal_l1";
		get_data($tbl_name, $where_clause, $x100_info);
		
		$sys_seo_info=array();
		$where_clause="button_num = 'l1' and source_id = '0' and folder_id = ''";
		$tbl_name="sys_seo";
		get_data($tbl_name, $where_clause, $sys_seo_info);

		
		if($_COOKIE['lang_id'] == "3")
       {
          if($x100_info['menu_name_en'] == "")
          $sys_seo_info['title']=$sys_seo_info['title']."|Product";
          else
          $sys_seo_info['title']=$sys_seo_info['title']."|".$x100_info['menu_name_en'];

       }
       else
       {
          if($x100_info['menu_name'] == "")
          $sys_seo_info['title']=$sys_seo_info['title']."|全部產品";
          else
          $sys_seo_info['title']=$sys_seo_info['title']."|".$x100_info['menu_name'];

       }
    }
    else if($temp_detail_id == "" and $temp_folder_id == "")
    {
       $x100_info=array();
       $where_clause="Fmain_id = '".$_GET['folder_id']."'";
       $tbl_name="sys_portal_x100";
       get_data($tbl_name, $where_clause, $x100_info);
       //show_array($x100_info);

       $sys_seo_info=array();
       $where_clause="button_num = 'x100' and source_id = '0' and folder_id = ''";
       $tbl_name="sys_seo";
       get_data($tbl_name, $where_clause, $sys_seo_info);
       //show_array($sys_seo_info);

       if($_COOKIE['lang_id'] == "3")
       {
          if($x100_info['menu_name_en'] == "")
          $sys_seo_info['title']=$sys_seo_info['title']."|Product";
          else
          $sys_seo_info['title']=$sys_seo_info['title']."|".$x100_info['menu_name_en'];

       }
       else
       {
          if($x100_info['menu_name'] == "")
          $sys_seo_info['title']=$sys_seo_info['title']."|全部產品";
          else
          $sys_seo_info['title']=$sys_seo_info['title']."|".$x100_info['menu_name'];

       }

    }
    else
    {

       $sys_seo_info=array();
       $where_clause="button_num = 'x100' and source_id = '".$temp_detail_id."'";
       $tbl_name="sys_seo";
       get_data($tbl_name, $where_clause, $sys_seo_info);
       //show_array($sys_seo_info);

/*
       if(count($sys_seo_info) <= 0)
       {
           $sys_seo_info=array();
           $where_clause="button_num = 'x100' and source_id = '0' and folder_id = '".$temp_folder_id."'";
           $tbl_name="sys_seo";
           get_data($tbl_name, $where_clause, $sys_seo_info);
           //show_array($sys_seo_info);
       }
*/

       if(count($sys_seo_info) <= 0)
       {
           $sys_seo_info=array();
           $where_clause="button_num = 'x100' and source_id = '0' and folder_id = ''";
           $tbl_name="sys_seo";
           get_data($tbl_name, $where_clause, $sys_seo_info);
           //show_array($sys_seo_info);
       }

       if($_COOKIE['lang_id'] == "3")
       {
          $sys_seo_info['author'] = $temp_info['text_field_12'];
          $sys_seo_info['title']=$global_meta_author."-".$temp_info['text_field_12'];
       }
       else
       {
          $sys_seo_info['author'] = $temp_info['text_field_0'];
          $sys_seo_info['title']=$global_meta_author."-".$temp_info['text_field_0'];
       }
    }

    if(count($sys_seo_info) > 0)
    {
        $website_seo_info['title']=$sys_seo_info['title'];
        $website_seo_info['keywords']=$sys_seo_info['keywords'];
        $website_seo_info['description']=$sys_seo_info['description'];
        $website_seo_info['author']=$sys_seo_info['author'];
		$website_seo_info['img']=$sys_seo_info['img'];
        $this_title_name="";

    }
}
elseif(strstr($_SERVER['REQUEST_URI'],"special"))
{


    $this_title_name="|強檔優惠";

    $num = $_GET['num'];
    $num = str_replace("%", "", $num);
    $num = str_replace("select", "", $num);
	   $num = str_replace("SELECT", "", $num);
	   $num = str_replace("deletc", "", $num);
	   $num = str_replace("DELETE", "", $num);
	   $num = str_replace("update", "", $num);
	   $num = str_replace("UPDATE", "", $num);
	   $num = str_replace("sysdate", "", $num);
	   $num = str_replace("sleep", "", $num);
	   $num = str_replace("*", "", $num);
	   $num = str_replace(">", "", $num);
	   $num = str_replace("<", "", $num);
	   $num = str_replace("(", "", $num);
	   $num = str_replace(")", "", $num);

    $temp_info=array();
    $where_clause="text_field_1 = '".AddSlashes($num)."'";# and is_hide='2'
//    print $where_clause;
    $tbl_name="sys_portal_x100_cnt";
    get_data($tbl_name, $where_clause, $temp_info);
//    show_array($temp_info);
//    exit;

    $temp_folder_id = $temp_info['portal_x100_id_2'];
    $temp_arr=array();
    $temp_arr=explode(",",$temp_folder_id);
    $temp_arr[0] = str_replace("@", "", $temp_arr[0]);
    $temp_folder_id=$temp_arr[0];

//    print $temp_folder_id;
//    exit;

    $temp_detail_id = $temp_info['Fmain_id'];
    if(!$temp_folder_id && $_GET['folder_id'])	$temp_folder_id = $_GET['folder_id'];



    if($_GET['l1_id']){
		$x100_info=array();
		$where_clause=" Fmain_id = '".$_GET['l1_id']."' ";
		$tbl_name="sys_portal_l1";
		get_data($tbl_name, $where_clause, $x100_info);
		
		$sys_seo_info=array();
		$where_clause="button_num = 'l1' and source_id = '0' and folder_id = ''";
		$tbl_name="sys_seo";
		get_data($tbl_name, $where_clause, $sys_seo_info);

		
		if($_COOKIE['lang_id'] == "3")
       {
          if($x100_info['menu_name_en'] == "")
          $sys_seo_info['title']=$sys_seo_info['title']."|Product";
          else
          $sys_seo_info['title']=$sys_seo_info['title']."|".$x100_info['menu_name_en'];

       }
       else
       {
          if($x100_info['menu_name'] == "")
          $sys_seo_info['title']=$sys_seo_info['title']."|全部產品";
          else
          $sys_seo_info['title']=$sys_seo_info['title']."|".$x100_info['menu_name'];

       }
    }
    else
    {

       $sys_seo_info=array();
       $where_clause="button_num = 'x100' and source_id = '".$temp_detail_id."'";
       $tbl_name="sys_seo";
       get_data($tbl_name, $where_clause, $sys_seo_info);
       //show_array($sys_seo_info);

/*
       if(count($sys_seo_info) <= 0)
       {
           $sys_seo_info=array();
           $where_clause="button_num = 'x100' and source_id = '0' and folder_id = '".$temp_folder_id."'";
           $tbl_name="sys_seo";
           get_data($tbl_name, $where_clause, $sys_seo_info);
           //show_array($sys_seo_info);
       }
*/

       if(count($sys_seo_info) <= 0)
       {
           $sys_seo_info=array();
           $where_clause="button_num = 'x100' and source_id = '0' and folder_id = ''";
           $tbl_name="sys_seo";
           get_data($tbl_name, $where_clause, $sys_seo_info);
           //show_array($sys_seo_info);
       }

       if($_COOKIE['lang_id'] == "3")
       {
          $sys_seo_info['author'] = $temp_info['text_field_12'];
          $sys_seo_info['title']=$global_meta_author."-".$temp_info['text_field_12'];
       }
       else
       {
          $sys_seo_info['author'] = $temp_info['text_field_0'];
          $sys_seo_info['title']=$global_meta_author."-".$temp_info['text_field_0'];
       }
    }

    if(count($sys_seo_info) > 0)
    {
        $website_seo_info['title']=$sys_seo_info['title'];
        $website_seo_info['keywords']=$sys_seo_info['keywords'];
        $website_seo_info['description']=$sys_seo_info['description'];
        $website_seo_info['author']=$sys_seo_info['author'];
		$website_seo_info['img']=$sys_seo_info['img'];
        $this_title_name="";

    }
}
elseif(strstr($_SERVER['REQUEST_URI'],"news"))
{
    $this_title_name="|活動消息";

    if($_GET['detail_id'] != "" and !is_numeric($_GET['detail_id']))
    {
       header("location:index.php");
       exit;
    }

    if($_GET['folder_id'] != "" and !is_numeric($_GET['folder_id']))
    {
       header("location:index.php");
       exit;
    }

    if($_GET['detail_id'] == "" and $_GET['folder_id'] == "")
    {
       $sys_seo_info=array();
       $where_clause="button_num = 'c1' and source_id = '0'";
       $tbl_name="sys_seo";
       get_data($tbl_name, $where_clause, $sys_seo_info);
       //show_array($sys_seo_info);
    }
    elseif($_GET['detail_id'] == "" and $_GET['folder_id'] != "")
    {
       $sys_seo_info=array();
       $where_clause="button_num = 'c1' and source_id = '0' and folder_id = '".$_GET['folder_id']."'";
       $tbl_name="sys_seo";
       get_data($tbl_name, $where_clause, $sys_seo_info);
       //show_array($sys_seo_info);

       if(count($sys_seo_info) <= 0)
       {
           $sys_seo_info=array();
           $where_clause="button_num = 'c1' and source_id = '0' and folder_id = ''";
           $tbl_name="sys_seo";
           get_data($tbl_name, $where_clause, $sys_seo_info);
           //show_array($sys_seo_info);
       }


    }
    elseif($_GET['detail_id'] != "" and $_GET['folder_id'] != "")
    {
       $sys_seo_info=array();
       $where_clause="button_num = 'c1' and source_id = '".$_GET['detail_id']."'";
       $tbl_name="sys_seo";
       get_data($tbl_name, $where_clause, $sys_seo_info);
       //show_array($sys_seo_info);

       if(count($sys_seo_info) <= 0)
       {
           if($_GET['folder_id'] != "")
           {
               $sys_seo_info=array();
               $where_clause="button_num = 'c1' and source_id = '0' and folder_id = '".$_GET['folder_id']."'";
               $tbl_name="sys_seo";
               get_data($tbl_name, $where_clause, $sys_seo_info);
               //show_array($sys_seo_info);

           }


           if(count($sys_seo_info) <= 0)
           {
               $sys_seo_info=array();
               $where_clause="button_num = 'c1' and source_id = '0' and folder_id = ''";
               $tbl_name="sys_seo";
               get_data($tbl_name, $where_clause, $sys_seo_info);
               //show_array($sys_seo_info);
           }

       }


    }
    else
    {

       $sys_seo_info=array();
       $where_clause="button_num = 'c1' and source_id = '".$_GET['detail_id']."'";
       $tbl_name="sys_seo";
       get_data($tbl_name, $where_clause, $sys_seo_info);
       //show_array($sys_seo_info);

       if(count($sys_seo_info) <= 0)
       {
           $sys_seo_info=array();
           $where_clause="button_num = 'c1' and source_id = '0' and folder_id = ''";
           $tbl_name="sys_seo";
           get_data($tbl_name, $where_clause, $sys_seo_info);
           //show_array($sys_seo_info);
       }
    }

    if(count($sys_seo_info) > 0)
    {
        $website_seo_info['title']=$sys_seo_info['title'];
        $website_seo_info['keywords']=$sys_seo_info['keywords'];
        $website_seo_info['description']=$sys_seo_info['description'];
        $website_seo_info['author']=$sys_seo_info['author'];
		$website_seo_info['img']=$sys_seo_info['img'];
        $this_title_name="";

    }





}
elseif(strstr($_SERVER['REQUEST_URI'],"video"))
{
    $this_title_name="|精彩影音";

    if($_GET['detail_id'] != "" and !is_numeric($_GET['detail_id']))
    {
       header("location:index.php");
       exit;
    }

    if($_GET['detail_id'] == "")
    {
       $sys_seo_info=array();
       $where_clause="button_num = 'e1' and source_id = '0'";
       $tbl_name="sys_seo";
       get_data($tbl_name, $where_clause, $sys_seo_info);
       //show_array($sys_seo_info);
    }
    else
    {

       $sys_seo_info=array();
       $where_clause="button_num = 'e1' and source_id = '".$_GET['detail_id']."'";
       $tbl_name="sys_seo";
       get_data($tbl_name, $where_clause, $sys_seo_info);
       //show_array($sys_seo_info);

       if(count($sys_seo_info) <= 0)
       {
           $sys_seo_info=array();
           $where_clause="button_num = 'e1' and source_id = '0'";
           $tbl_name="sys_seo";
           get_data($tbl_name, $where_clause, $sys_seo_info);
           //show_array($sys_seo_info);
       }
    }

    if(count($sys_seo_info) > 0)
    {
        $website_seo_info['title']=$sys_seo_info['title'];
        $website_seo_info['keywords']=$sys_seo_info['keywords'];
        $website_seo_info['description']=$sys_seo_info['description'];
        $website_seo_info['author']=$sys_seo_info['author'];
		$website_seo_info['img']=$sys_seo_info['img'];
        $this_title_name="";

    }
}
elseif(strstr($_SERVER['REQUEST_URI'],"service-warranty"))
{
    $this_title_name="|保固登錄";
}
elseif(strstr($_SERVER['REQUEST_URI'],"service-faq"))
{
    $this_title_name="|常見問題";
}
elseif(strstr($_SERVER['REQUEST_URI'],"location"))
{
    $this_title_name="|門市據點";
}
elseif(strstr($_SERVER['REQUEST_URI'],"contact"))
{
    $this_title_name="|聯絡我們";
}
elseif(strstr($_SERVER['REQUEST_URI'],"login"))
{
    $this_title_name="|會員登入";
}
elseif(strstr($_SERVER['REQUEST_URI'],"member"))
{
    $this_title_name="|會員專區";
}

if($_COOKIE['lang_id'] == "3")
$this_title_name="";
?>
<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <meta http-equiv="X-ua-compatible" content="IE=edge" >
    <meta http-equiv="x-ua-compatible" content="IE=9,10,11">
    <meta charset="UTF-8">
     <meta name="keywords" content="<?=$website_seo_info['keywords']?>">
    <meta name="description" content="<?=$website_seo_info['description']?>">
    <meta name="author" content="<?=$website_seo_info['author']?>">
    <meta name="copyright" content="<?=$website_seo_info['copyright']?>">
    <?
    $img_file = "";
    if($website_seo_info['img']){
	    $pic_arr = explode(",", $website_seo_info['img']);

	    $pic_info = array();
	    $where_clause = "Fmain_id = '".$pic_arr[0]."'";
	    $tbl_name = "sys_file";
	    get_data($tbl_name, $where_clause, $pic_info);

	    if($pic_info['file_path'])	$img_file = $global_website_url."login_admin/upload_file/".$pic_info['file_path'];
    }
    if(!$img_file && strstr($_SERVER['REQUEST_URI'],"product-detail")){
	    $info=array();
	    $where_clause="text_field_1 = '".AddSlashes($_GET['num'])."'";
	    $tbl_name="sys_portal_x100_cnt";
	    get_data($tbl_name, $where_clause, $info);
	    $pic_arr = explode(",", $info['pic_field_6']);
		$img_file = get_pic_path_2($pic_arr[0])['pic_file'];
    }
    if($img_file){
	?>
	<meta property="og:image" content="<?=$img_file?>"/>
	<link rel="image_src" type="image/jpeg" href="<?=$img_file?>" />
	<?
    }
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta property="og:image" content="dist/images/ogimg.jpg"/>
    <link rel="shortcut icon" href="dist/images/JHT_logo_16X16.ico" type="image/x-icon" />
    <meta name="format-detection" content="telephone=no">
    <title><?=$website_seo_info['title']?><?=$this_title_name?></title>
   <?=$ga_even_js2?>
   <?=$website_seo_info['head_code']?>