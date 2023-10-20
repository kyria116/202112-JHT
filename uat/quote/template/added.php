<?
include_once("global_include_file.php");
$website_seo_info=array();
$where_clause="Fmain_id = '1'";
$tbl_name="sys_website_seo";
get_data($tbl_name, $where_clause, $website_seo_info);
//show_array($website_seo_info);
?>
<?=$website_seo_info['body_code']?>