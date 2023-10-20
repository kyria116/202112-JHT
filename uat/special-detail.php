<?
    session_start();
    include "quote/template/head.php";
    require_once ("global_include_file.php");

	$tag_color_set = array("HOT"=>"red","NEW"=>"blue","SALE"=>"org","預購"=>"green");

    $cnt_id = $_GET['cnt_id'];
    $num = $_GET['num'];
    $kol_id = $_GET['kol_id'];
    $l1_id = $_GET['l1_id'];

    $portal_l1_info=array();
 			$where_clause="1 and Fmain_id ='".AddSlashes($l1_id)."'";
 			$tbl_name="sys_portal_l1";
 			get_data($tbl_name, $where_clause, $portal_l1_info);


    if($_SESSION['kol_id'] != "" && !$kol_id)
       $kol_id=$_SESSION['kol_id'];

    if($kol_id != "" )
    {
//       $today=date("Y-m-d H:i:s");
       $today=date("Y-m-d");

       $search_info=array();
       $where_clause="Fmain_id = '".AddSlashes($kol_id)."' and (sys_start_date <= '$today' and sys_end_date >= '$today')";# and is_hide='2'
   //    print $where_clause;
       $tbl_name="sys_portal_j3";
       get_data($tbl_name, $where_clause, $search_info);
       //show_array($search_info);

       if(count($search_info) <= 0)
       {
           mb_http_output ("UTF-8");
           mb_internal_encoding("UTF-8");
           ob_start ("mb_output_handler");
           print "<script>";
           print "alert('活動已經結束');";
           print "location.href='index.php';";
           print "</script>";
           exit;
       }

       $kol_info=array();
       $kol_info=$search_info;

       $_SESSION['kol_id']=$kol_id;



    }

//    print $num;
//    exit;

    $temp_info=array();
    if($num != "")
    $where_clause="text_field_1 = '".AddSlashes($num)."'";# and is_hide='2'
//    print $where_clause;
    $tbl_name="sys_portal_x100_cnt";
    get_data($tbl_name, $where_clause, $temp_info);
    //show_array($temp_info);

    if($temp_info['Fmain_id'] != "")
    $cnt_id=$temp_info['Fmain_id'];



    $today = date("Y-m-d");
    $time_sql = " and sys_start_date<='".$today."' and sys_end_date>='".$today."'";
    $info=array();
    $where_clause="Fmain_id='".$cnt_id."' ".$time_sql."";# and is_hide='2'

//    print $where_clause;
//    exit;
    $tbl_name="sys_portal_x100_cnt";
    get_data($tbl_name, $where_clause, $info);
    // show_array($info);

	if(!$info['Fmain_id']){
		print "<meta name=\"robots\" content=\"noindex,nofollow\" />";
		print "無此商品";
		print "<script>alert('無此商品');location.replace('index.php');</script>";
		exit;
	}
    $is_en = "";
    $lang_str= "lang_tw";
    if($_COOKIE['lang_id']=="3"){
        $is_en = 1;
        $lang_str= "lang_en";
    }


//    if($is_en && $info['pic_field_15']!=""){
//        $pic_num = explode(",", $info['pic_field_15'])[0];
//    }else{
        $pic_num = explode(",", $info['pic_field_6'])[0];
//    }

    // $pic_path = get_pic_path_2($pic_num)['pic_file'];
//print $info['Fmain_id'];
//exit;
//    $price_arr = (get_x100_cnt_price($info['Fmain_id']));
    $price_arr = get_x100_cnt_price($info['Fmain_id']);
//    show_array($price_arr);
//exit;
    $all_cnt_about_info=array(); //相關商品
    $where_clause="1 and x100_cnt_id ='".$cnt_id."'";
    $tbl_name="sys_portal_x100_cnt_about";
    getall_data($tbl_name, $where_clause, $all_cnt_about_info);
    // show_array($all_cnt_about_info);exit;


    $all_cnt_add_buy_info=array(); //加購產品
    $where_clause="1 and x100_cnt_id ='".$cnt_id."'";
    $tbl_name="sys_portal_x100_cnt_add_buy";
    getall_data($tbl_name, $where_clause, $all_cnt_add_buy_info);
    // show_array($all_cnt_add_buy_info);exit;


    $all_cnt_gift_info=array(); //贈品資訊
    $where_clause="1 and x100_cnt_id ='".$cnt_id."'";
    $tbl_name="sys_portal_x100_cnt_gift";
    getall_data($tbl_name, $where_clause, $all_cnt_gift_info);
    // show_array($all_cnt_gift_info);exit;
    if($kol_id && $kol_info['product_id']==$cnt_id){
	    $all_cnt_gift_info=array(); //贈品資訊
	    $where_clause="1 and x100_cnt_id ='".$kol_id."'";
	    $tbl_name="sys_portal_j3_gift";
	    getall_data($tbl_name, $where_clause, $all_cnt_gift_info);
	    // show_array($all_cnt_gift_info);exit;
    }


    $all_size_info=array(); //尺寸選擇
    if($info['is_show_size'] == "是")
    {
       $where_clause="1 and portal_x100_cnt_id ='".$cnt_id."'";
       $tbl_name="sys_portal_x100_cnt_size";
       getall_data($tbl_name, $where_clause, $all_size_info);
       // show_array($all_size_info);exit;   size_name price member_price text_field_10 庫存
    }


    $x100_id_2_arr = explode(",", str_replace("@", "", $info['portal_x100_id_2']));
    $x100_id_2_arr[] = $info['portal_x100_id'];
    #分類排序開始#
    $select_info=array();
    $where_clause=" 1 order by rank desc ";
    $tbl_name="sys_portal_x100";
    getall_data($tbl_name, $where_clause, $select_info);
    $new_x100_id_2 = array();
    for($i=0;$i<count($select_info);$i++){
	    if(in_array($select_info[$i]['Fmain_id'], $x100_id_2_arr)){
		    $new_x100_id_2[] = $select_info[$i]['Fmain_id'];
	    }
    }
    $x100_id_2_arr = array();
    $x100_id_2_arr = $new_x100_id_2;
	#分類排序結束#

    require_once("include_kol_info.php");



    /******************************
      取得該商品有沒有符合滿件優惠活動
    *******************************/

    if($_SESSION['kol_id'] != "" and $kol_info['product_id'] == $cnt_id)
    {
        $get_product_sale_amount_info=array();
    }
    else
    {

       $get_product_sale_amount_info=get_check_product_sale_amount_info($cnt_id);
//show_array($get_product_sale_amount_info);
//       exit;
    }


    /******************************
      取得該商品有沒有符合滿額優惠活動
    *******************************/
    if($_SESSION['kol_id'] != "" and $kol_info['product_id'] == $cnt_id)
    {

        $get_set_product_sale_info=array();
    }
    else
    {

       $get_set_product_sale_info=get_check_product_sale_info($cnt_id);
    }


    $active_arr = array();

//    if($get_set_product_sale_info['title'] != "")
    for($i=0;$i<count($get_set_product_sale_info);$i++)
    {
        $active_arr[] = ["id"=>$get_set_product_sale_info[$i]['id'],"name"=>$get_set_product_sale_info[$i]['title'],"end_date"=>$get_set_product_sale_info[$i]['end_date'],"type"=>"total"];
    }

//    if($get_product_sale_amount_info['title'] != "")
    for($i=0;$i<count($get_product_sale_amount_info);$i++)
    {
        $active_arr[] = ["id"=>$get_product_sale_amount_info[$i]['id'],"name"=>$get_product_sale_amount_info[$i]['title'],"end_date"=>$get_product_sale_amount_info[$i]['end_date'],"type"=>"amount"];
    }

//print count($active_arr);
//exit;
//show_array($active_arr);
//exit;
	$pic_arr = explode(",", $info['pic_field_6']);
	$image_link = get_pic_path_2($pic_arr[0])['pic_file'];

	$price_arr = (get_x100_cnt_price($info['Fmain_id']));
//	show_array($price_arr);
//	exit;



 if($_SESSION['kol_id'] != "")
 {
     $kol_info=array(); //尺寸選擇
     $where_clause="1 and Fmain_id ='".$_SESSION['kol_id']."' and product_id ='".$info['Fmain_id']."' ";
     $tbl_name="sys_portal_j3";
     get_data($tbl_name, $where_clause, $kol_info);
     // show_array($kol_info);exit;

    if(count($kol_info)>0){
        $price_arr['price_3']=$kol_info['price'];
    }

 }
	if($price_arr['price_3'])	$price = $price_arr['price_3'];
	else if($price_arr['price_2'])	$price = $price_arr['price_2'];
	else	$price = $price_arr['price_1'];
//	show_array($price_arr);
//	exit;
	if($info['radio_field_16'] == "預購" and 0)	$availability = "OutOfStock";
	else{
		if($info['is_show_size']=="是"){
			$all_size_info2=array();
			$where_clause="1 and portal_x100_cnt_id ='".$info['Fmain_id']."'";
			$tbl_name="sys_portal_x100_cnt_size";
			getall_data($tbl_name, $where_clause, $all_size_info2);


			for($aa=0;$aa<count($all_size_info2);$aa++){
				if($all_size_info2[$aa]['text_field_10']){
					$availability = "InStock";
				}
			}
			if(!$availability)	$availability = "OutOfStock";
		}
		else{
			if($info['stock']){
				$availability = "InStock";
			}
			else{
				$availability = "OutOfStock";
			}
		}
	}

?>
<link rel="stylesheet" href="dist/css/slick-theme.css">
<link rel="stylesheet" href="dist/css/slick.css">
<link rel="stylesheet" href="dist/css/jquery.mCustomScrollbar.min.css">
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/product.css">


</head>

<body class="productdetailPage">
<script type="application/ld+json">
{
"@context": "https://schema.org/",
"@type": "Product",
"name": "<?=$info['text_field_0']?>",
"image":"<?=$global_website_url.str_replace("./","",$image_link)?>",
"description": "<?=strip_tags($info['html_field_4'])?>",
"productID": "<?=$info['Fmain_id']?>",
"offers": {
"price": "<?=$price?>",
"priceCurrency": "TWD",
"availability": "<?=$availability?>"
}
}
</script>
    <?php
        include "quote/template/added.php";
        include "quote/template/nav.php";
    ?>
    <div id="Wrapper">
        <main role="main">
        <form name="buy_form" id="formId" target="" method="post" action="cart.php">
            <div class="sh-banner">
                <img class="pc" src="dist/images/product/line_1_pc.png">
                <img class="mo" src="dist/images/product/line_1_mb.png">
                <div class="container">
                    <h2>
                        <div class="e-ti">Special</div>
                        <div class="t-ti">強檔優惠</div>
                    </h2>
                </div>
            </div>
            <section class="item1">
                <div class="container">
                    <div class="link-bx">
                        <div class="share-card">
                            <?$url = urlencode('https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);?>
                            <a class="resp-sharing-button__link" href="https://facebook.com/sharer/sharer.php?u=<?=$url?>" target="_blank" rel="noopener" aria-label="Share on Facebook">
                                <img src="dist/images/product/b_fb_icon.png">
                            </a>
                            <a target="_blank" href="https://social-plugins.line.me/lineit/share?url=<?=$url?>">
                                <img src="dist/images/product/b_line_icon.png">
                            </a>
                        </div>
                        <div class="tag-card">
                            <?
//                               for($iii=0;$iii<count($x100_id_2_arr);$iii++){
//
//                                $each_info=array();
//                                $where_clause="Fmain_id='".$x100_id_2_arr[$iii]."'";
//                                $tbl_name="sys_portal_x100";
//                                get_data($tbl_name, $where_clause, $each_info);
//                                // show_array($each_info);
//
//                                if(count($each_info)<1 or $each_info['is_hide'] == "1"){
//                                    continue;
//                                }
                            ?>
                                    <a href="special.php?folder_id=<?=$each_info['Fmain_id']?>" class="sh-btn">
                                        <?=$portal_l1_info['menu_name']?>
                                    </a>
                            <?
//                               }
                            ?>
                        </div>
                    </div>
                    <div class="flex-bx">
                        <div class="t-bx">
                            <div class="tx-bx">
                                <div class="p-num f16"><?=$info['text_field_1']?></div>
                                <div class="ti">
                                    <?=$info['text_field_0']?>
                                </div>
                                <!-- 桌機板價格 -->
                                <div class="pric-bx pc">

                            <?if($price_arr['price_3']!=""){?>
                                	<div class="dis-pric">
                                        專屬特惠價<span><i>$</i><?=number_format($price_arr['price_3'])?></span>
                                    </div>
                                <?
	                                if($price_arr['price_1'] && $price_arr['price_1'] != $price_arr['price_3']){
		                        	?>
		                        		<div class="org-pric f16">
	                                        原價$<span><?=number_format($price_arr['price_1'])?></span>
	                                    </div>
									<?
	                                }
	                                else if($price_arr['price_2'] && $price_arr['price_2'] != $price_arr['price_3']){
		                            ?>
		                        		<div class="org-pric f16">
	                                        原價$<span><?=number_format($price_arr['price_2'])?></span>
	                                    </div>
									<?
	                                }
                                ?>
                            <?}elseif(count($price_arr)>1){?>
                                	<div class="dis-pric">
                                        特惠價<span><i>$</i><?=number_format($price_arr['price_2'])?></span>
                                    </div>
                                    <div class="org-pric f16">
                                        原價$<span><?=number_format($price_arr['price_1'])?></span>
                                    </div>
                            <?}elseif($price_arr['price_1']!=""){?>
                                	<div class="dis-pric">
                                        原價<span><i>$</i><?=number_format($price_arr['price_1'])?></span>
                                    </div>
                            <?}elseif($price_arr['price_2']!=""){?>
                                	<div class="dis-pric">
                                        特惠價<span><i>$</i><?=number_format($price_arr['price_2'])?></span>
                                    </div>
                            <?}?>

                                </div>
                            </div>
                            <div class="b-imgobx">
                                <?if($info['radio_field_16']!="" && $info['radio_field_16']!="不顯示"){?>
			                        <div class="tag <?=$tag_color_set[$info['radio_field_16']]?>"><?=$info['radio_field_16']?></div>
			                    <?}?>
                                <?
	                                $pic_arr = explode(",", $info['pic_field_6']);
                                ?>
                                <ul class="b-imgbx">
                                    <?for($iii=0;$iii<count($pic_arr);$iii++){?>
			                            <li><div class="bgcover" style="background-image:url('<?=get_pic_path_2($pic_arr[$iii])['pic_file']?>')"></div></li>
			                        <?}?>
                                </ul>
                            </div>
                            <ul class="s-imgbx">
                                <?for($iii=0;$iii<count($pic_arr);$iii++){?>
		                            <li><a href="javascript:;">
		                            <div class="bgcover" style="background-image:url('<?=get_pic_path_2($pic_arr[$iii])['pic_file']?>')"></div>
		                            </a></li>
		                        <?}?>
                            </ul>
                        </div>
                        <div class="bot-bx">
                        <?
                        if(count($active_arr)>0)
                        {
                        ?>
                            <?for($kkk=0;$kkk<count($active_arr);$kkk++){?>
                            <a href="activity.php?type=<?=$active_arr[$kkk]['type']?>&id=<?=$active_arr[$kkk]['id']?>" target="_balnk" class="activity-card">
                                <div class="f20">
                                    <?=$active_arr[$kkk]['name']?>
                                </div>
                                <div class="f16">
                                    活動至<span><?=str_replace("-",".",$active_arr[$kkk]['end_date'])?></span>截止
                                </div>
                            </a>
                            <?}?>
                        <?
                        }
                        ?>
                            <?if(strip_tags($info['html_field_4'])){?>
                            <div class="html-bx">
                                <div class="editor_Content in_fade active">
                                    <div class="editor_box pc_use">
                                        <?=$info['html_field_4']?>
                                    </div>
                                    <div class="editor_Box mo_use">
                                        <?=$info['html_field_4']?>
                                    </div>
                                </div>
                            </div>
                            <?}?>
                            <div class="sel-group">
                            <?if(count($all_size_info)>0){
	                            //size_name price member_price text_field_10 庫存
	                            $stock_num = 0;
	                            $size_arr = array();

	                        ?>
                                <div class="sel-bx">
                                    <label class="f16">規格</label>
                                    <select name="p_size_id" id='p_size_id' onchange="select_size(this.value);">
	                                    <?for($iii=0;$iii<count($all_size_info);$iii++){

	                                        $select = "";
	                                        $salt_out_str = "";


	                                        if($all_size_info[$iii]['text_field_10']==""){
	                                            if($stock_num==0){
	                                                $stock_num = 10;
	                                                $select = "selected";
	                                            }

	                                        }elseif($all_size_info[$iii]['text_field_10']>0){

	                                            if($stock_num==0){
	                                                print $stock_num."<br>";
	                                                if($all_size_info[$iii]['text_field_10']>10){
	                                                    $stock_num = 10;
	                                                }else{
	                                                    $stock_num = $all_size_info[$iii]['text_field_10'];
	                                                }
	                                                $select = "selected";
	                                            }

	                                        }else{
	                                            $salt_out_str = "(已完售)";
	                                            $select = "disabled";
	                                        }

	                                        if($all_size_info[$iii]['text_field_10']=="" || $all_size_info[$iii]['text_field_10']>10){
	                                            $size_arr[$all_size_info[$iii]['Fmain_id']] = 10;
	                                        }else{
	                                            $size_arr[$all_size_info[$iii]['Fmain_id']] = $all_size_info[$iii]['text_field_10'];
	                                        }


	                                    ?>
	                                        <option value="<?=$all_size_info[$iii]['Fmain_id']?>" <?=$select?> ><?=$all_size_info[$iii]['size_name'].$salt_out_str?></option>
	                                    <?}?>
	                                </select>
                                    <script type="text/javascript">

	                                    var size_arr = <?php echo json_encode($size_arr);?>;

	                                    function select_size(size_id){

	                                        var str = "";

	                                        for (var i = 0; i < size_arr[size_id]; i++) {
	                                            num = i+1;
	                                            str+= "<option value='"+num+"'>"+num+"</option>";
	                                        }

	                                        $("#select_amount").html(str);
	                                    }
	                                </script>
                                </div>
                             <?}else{
	                            $stock_num = 0;
	                            if($info['stock']==""){
	                                $stock_num = 10;
	                            }
	                            elseif($info['stock']>10){
	                                $stock_num = 10;
	                            }
	                            elseif($info['stock']>0){
	                                $stock_num = $info['stock'];
	                            }
	                        }?>
	                        <?if($stock_num>0){?>
                                <div class="sel-bx">
                                    <label class="f16">數量</label>
                                    <select id='select_amount' name="amount">
	                                    <?for($iii=1;$iii<=$stock_num;$iii++){?>
	                                        <option value="<?=$iii?>"><?=$iii?></option>
	                                    <?}?>
	                                </select>
                                </div>
                            <?}?>
                            </div>
                            <!-- 手機板價格 -->
                            <div class="pric-bx mo">
                                <?if($price_arr['price_3']!=""){?>
                                	<div class="dis-pric">
                                        專屬特惠價<span><i>$</i><?=number_format($price_arr['price_3'])?></span>
                                    </div>
                                <?
	                                if($price_arr['price_1'] && $price_arr['price_1'] != $price_arr['price_3']){
		                        	?>
		                        		<div class="org-pric f16">
	                                        原價$<span><?=number_format($price_arr['price_1'])?></span>
	                                    </div>
									<?
	                                }
	                                else if($price_arr['price_2'] && $price_arr['price_2'] != $price_arr['price_3']){
		                            ?>
		                        		<div class="org-pric f16">
	                                        原價$<span><?=number_format($price_arr['price_2'])?></span>
	                                    </div>
									<?
	                                }
                                ?>
                            <?}elseif(count($price_arr)>1){?>
                                	<div class="dis-pric">
                                        特惠價<span><i>$</i><?=number_format($price_arr['price_2'])?></span>
                                    </div>
                                    <div class="org-pric f16">
                                        原價$<span><?=number_format($price_arr['price_1'])?></span>
                                    </div>
                            <?}elseif($price_arr['price_1']!=""){?>
                                	<div class="dis-pric">
                                        原價<span><i>$</i><?=number_format($price_arr['price_1'])?></span>
                                    </div>
                            <?}elseif($price_arr['price_2']!=""){?>
                                	<div class="dis-pric">
                                        特惠價<span><i>$</i><?=number_format($price_arr['price_2'])?></span>
                                    </div>
                            <?}?>
                            </div>

                            <?
			                if(count($all_cnt_gift_info) > 0)
			                {
			                ?>
                            <div class="give-bx">
                                <div class="ti f20">
                                    <span>贈品</span>
                                </div>
								<?
                                    if( $info['gift_id']=="1" && ($kol_info['product_id']!=$info['Fmain_id'] || !$kol_info['gift_id']) ||$kol_info['gift_id']=="1" && $kol_info['product_id']==$info['Fmain_id']){
                                ?>
                                <!-- 贈品 (選贈) -->
                                <div class="card2">
                                    <?for($iii=0;$iii<count($all_cnt_gift_info);$iii++){

/*
			                            if($all_cnt_gift_info[$iii]['product_id']!=""){
			                                $each_info=array();
			                                $where_clause="Fmain_id='".$all_cnt_gift_info[$iii]['product_id']."'";
			                                $tbl_name="sys_portal_x100_cnt";
			                                get_data($tbl_name, $where_clause, $each_info);
			                                // show_array($each_info);

			                                $product_name = $each_info['text_field_0'];
			                                $pic_url = get_pic_path_2(explode(',',$each_info['pic_field_6'])[0])['pic_file'];
			                            }else{
			*/
			                                $product_name = $all_cnt_gift_info[$iii]['product_name'];
			                                $pic_url = get_pic_path_2($all_cnt_gift_info[$iii]['product_pic'])['pic_file'];
			//                             }

			                        ?>
                                    <div class="form-radio">
                                        <input type="radio" id="p-<?=($iii+1)?>" name="give_id" value="<?=$all_cnt_gift_info[$iii]['Fmain_id']?>" required <?=(($iii==0)?" checked":"")?> >
                                        <label for="p-<?=($iii+1)?>">
                                            <div class="img-bx">
                                                <img src="<?=$pic_url?>">
                                            </div>
                                            <div class="des-bx">
                                                <div class="des-ti f20">
                                                    <?=$product_name?>
                                                </div>
                                                <?
		                                        if($all_cnt_gift_info[$iii]['add_money'] != "")
		                                        {
		                                        ?>
                                                <div class="price f16">
                                                    價值 $<span><?=number_format($all_cnt_gift_info[$iii]['add_money'])?></span>
                                                </div>
                                                <?
		                                        }
		                                        ?>
                                            </div>
                                        </label>
                                    </div>
                                    <?}?>
                                </div>
                                <?
                                    }
                                    else{
                                ?>
                                <!-- 贈品 (全贈) -->
                                <div class="card1">
                                    <ul>
                                        <?for($iii=0;$iii<count($all_cnt_gift_info);$iii++){

	/*
				                            if($all_cnt_gift_info[$iii]['product_id']!=""){
				                                $each_info=array();
				                                $where_clause="Fmain_id='".$all_cnt_gift_info[$iii]['product_id']."'";
				                                $tbl_name="sys_portal_x100_cnt";
				                                get_data($tbl_name, $where_clause, $each_info);
				                                // show_array($each_info);

				                                $product_name = $each_info['text_field_0'];
				                                $pic_url = get_pic_path_2(explode(',',$each_info['pic_field_6'])[0])['pic_file'];
				                            }else{
				*/
				                                $product_name = $all_cnt_gift_info[$iii]['product_name'];
				                                $pic_url = get_pic_path_2($all_cnt_gift_info[$iii]['product_pic'])['pic_file'];
				//                             }

				                        ?>
                                        <li>
                                            <div class="img-bx">
                                                <img src="<?=$pic_url?>">
                                            </div>
                                            <div class="des-bx">
                                                <div class="des-ti f20">
                                                    <?=$product_name?>
                                                </div>
                                                <?
		                                        if($all_cnt_gift_info[$iii]['add_money'] != "")
		                                        {
		                                        ?>
                                                <div class="price f16">
                                                    價值 $<span><?=number_format($all_cnt_gift_info[$iii]['add_money'])?></span>
                                                </div>
                                                <?
		                                        }
		                                        ?>
                                            </div>
                                        </li>
                                        <?}?>
                                    </ul>
                                </div>
                                <?
                                    }
                                ?>
                            </div>
                            <?
			                }
			                ?>
                            <!-- 桌機板加入購物車 -->
                            <div class="cart-bx pc">
                                <?if($stock_num>0){?>
                                <!-- 加入購物車 -->
                                <a href="javascript:submit_shopcar();" class="cart-btn">
                                    <span>
                                        <div class="img-bx">
                                            <img src="dist/images/product/shop_icon.png">
                                        </div>
                                        加入購物車
                                    </span>
                                </a>
                                <?}else{?>
                                <!-- 售完補貨 -->
                                <a href="javacsript:;" class="soldout-btn">
                                    <span>售完補貨中</span>
                                </a>
                                <?}?>
                                <?if($info['text_field_11']){?>
                                <div class="ship-tx">
                                    <span>最快出貨時間<?=$info['text_field_11']?></span>
                                </div>
                                <?}?>
                            </div>
                        </div>
                    </div>
                    <?
	                if(count($all_cnt_add_buy_info) > 0)
	                {
	                ?>
                    <div class="add-purbx">
                        <div class="ti">
                            <span>加價購</span>
                        </div>
                        <ul>
                            <?for($iii=0;$iii<count($all_cnt_add_buy_info);$iii++){

	/*
	                            if($all_cnt_add_buy_info[$iii]['product_id']!=""){
	                                $each_info=array();
	                                $where_clause="Fmain_id='".$all_cnt_add_buy_info[$iii]['product_id']."'";
	                                $tbl_name="sys_portal_x100_cnt";
	                                get_data($tbl_name, $where_clause, $each_info);
	                                // show_array($each_info);

	                                $product_name = $each_info['text_field_0'];
	                                $pic_url = get_pic_path_2(explode(',',$each_info['pic_field_6'])[0])['pic_file'];
	                            }else{
	*/
	                                $product_name = $all_cnt_add_buy_info[$iii]['product_name'];
	                                $pic_url = get_pic_path_2($all_cnt_add_buy_info[$iii]['product_pic'])['pic_file'];
	//                             }

	                        ?>
                            <li>
                                <div class="form-checkbox">
                                    <input type="checkbox" id="pro-<?=($iii+1)?>" name="addbuy_id[]" value="<?=$all_cnt_add_buy_info[$iii]['Fmain_id']?>">
                                    <label for="pro-<?=($iii+1)?>">
                                        <div class="img-bx">
                                            <img src="<?=$pic_url?>">
                                        </div>
                                        <div class="des-bx">
                                            <div class="des-ti f20">
                                                <?=$product_name?>
                                            </div>
                                            <div class="price f16">
                                                <i>加購價</i>
                                                $<span><?=number_format($all_cnt_add_buy_info[$iii]['add_money'])?></span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </li>
                            <?}?>
                        </ul>
                    </div>
                    <?
	                }
	                ?>
                     <!-- 手機板加入購物車 -->
                     <div class="cart-bx mo">
                        <?if($stock_num>0){?>
                        <!-- 加入購物車 -->
                        <a href="javascript:submit_shopcar();" class="cart-btn">
                            <span>
                                <div class="img-bx">
                                    <img src="dist/images/product/shop_icon.png">
                                </div>
                                加入購物車
                            </span>
                        </a>
                        <?}else{?>
                        <!-- 售完補貨 -->
                        <a href="javacsript:;" class="soldout-btn">
                            <span>售完補貨中</span>
                        </a>
                        <?}?>
                        <?if($info['text_field_11']){?>
                        <div class="ship-tx">
                            最快出貨時間<span><?=$info['text_field_11']?></span>
                        </div>
                        <?}?>
                    </div>
                    <div class="editor_Content edobx">
                        <div class="editor_box pc_use">
                            <?=$info['html_field_7']?>
                        </div>
                        <div class="editor_Box mo_use">
                            <?=$info['html_field_17']?>
                        </div>
                    </div>
                </div>
            </section>

            <section class="item2">
                <div class="container">
                    <div class="it2-bx">
                        <?
			            if(count($all_cnt_about_info) > 0)
			            {
			            ?>
                        <div class="b-ti">
                            相關產品
                        </div>
                        <ul class="product-list four-list">
                            <?for($iii=0;$iii<count($all_cnt_about_info);$iii++){

		                        $each_info = get_x100_cnt_product_info($all_cnt_about_info[$iii]['product_id'],$is_en);

		                        if(count($each_info)<1){
		                            continue;
		                        }
								if($each_info['text_field_1']){
		                    ?>
                            <li>
<!--                            <a href="<?=$each_info['text_field_1']?>.html"> -->
	                            <a href="special-detail.php?num=<?=$each_info['text_field_1']?>">
                                    <?if($each_info['radio_field_16']!="" && $each_info['radio_field_16']!="不顯示"){?>
	                                    <div class="tag <?=$tag_color_set[$each_info['radio_field_16']]?>"><?=$each_info['radio_field_16']?></div>
	                                <?}?>
                                    <div class="img-bx" style="background: url(<?=$each_info['pic_path']?>) center / cover no-repeat">
<!--                                         <img src="<?=$each_info['pic_path']?>"> -->
                                    </div>
                                    <div class="des-bx">
                                        <div class="tx-bx">
                                            <div class="p-num f16"><?=$each_info['text_field_1']?></div>
                                            <div class="ti f20">
                                                <?=$each_info['text_field_0']?>
                                            </div>
                                        </div>
                                        <div class="pric-bx">
                                        <?if(count($each_info['price_arr'])>1){?>
	                                        <!-- 2種價格 -->
	                                        <div class="org-pric f16">
                                                原價<span><?=number_format($each_info['price_arr']['price_1'])?></span>
                                            </div>
                                            <div class="dis-pric">
                                                <i class="specialprice">特惠價</i><span><?=number_format($each_info['price_arr']['price_2'])?></span>
                                            </div>

	                                    <?}elseif($price_arr['price_3']!=""){?>
	                                         <div class="dis-pric">
                                                <i class="specialprice">特惠價</i><span><?=number_format($each_info['price_arr']['price_3'])?></span>
                                            </div>
	                                    <?}elseif($price_arr['price_1']!=""){?>
	                                        <div class="dis-pric">
                                                <i class="specialprice">特惠價</i><span><?=number_format($each_info['price_arr']['price_1'])?></span>
                                            </div>
	                                    <?}elseif($price_arr['price_2']!=""){?>
	                                        <div class="dis-pric">
                                                <i class="specialprice">特惠價</i><span><?=number_format($each_info['price_arr']['price_2'])?></span>
                                            </div>
	                                    <?}?>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?
	                            	}
	                            }
                            ?>
                        </ul>
                        <?
			            }
			            ?>
                        <a href="javascript:window.history.back();" class="sh-btn">
                            <div class="ar"></div>
                            BACK
                        </a>
                    </div>
                </div>
            </section>
			<input type="hidden" name="cnt_id" value="<?=$info['Fmain_id']?>">
            <input type="hidden" name="global_addbuy_id" id="global_addbuy_id" value="">
            <input type="hidden" name="give_text" id="give_text" value="">
            <input type="hidden" name="product_folder_id" id="product_folder_id" value="<?=$info['portal_x100_id']?>">
        </form>
        </main>
        <?php
            include "quote/template/top_btn.php";
        ?>
    </div>
    <?php
        include "quote/template/footer.php";
    ?>
    <script src="dist/js/main.js"></script>
    <script src="dist/js/slick.js"></script>
    <script src="dist/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="dist/js/product.js"></script>
    <script>
        function submit_shopcar()
        {

            <?
            if($_COOKIE['member_userid'] == "" and 0)
            {
            ?>

                alert("您尚未登入會員，請先登入後再進行操作!");
                return false;

            <?
            }
            else
            {
            ?>

            $.ajax({
                cache: true,
                type: "POST",
                url:"cart.php",
                data:$('#formId').serialize(),// 你的formid
                async: false,
                error: function(request) {
                    alert("Connection error:"+request.error);
                },
                success: function(data) {
                    alert("已加入購物車");

                    a=Math.floor(Math.random()*(100000-0));
                    dataSource = '&parm='+new Date().getTime()+a;

                    // 不帶第二個參數
                    $.get('get_cart_num.php?&userid1=test1&userid2=test2'+dataSource+'','',function(data,textStatus,XMLHttpRequest)
                    {
                        //alert(data);
                        if(data != "")
                        {
                            $(".mcount").text(data);
                        }


                    });
                }
            });

            <?
            }
            ?>


//            var cnt_id=$("input[name=cnt_id]").val();
//            var global_addbuy_id=$("input[name=global_addbuy_id]").val();
//            var give_text=$("input[name=give_text]").val();
//            var product_folder_id=$("input[name=product_folder_id]").val();
//
//
//            $.ajax({
//                    type: "POST", //傳送方式
//                    url: "cart.php", //傳送目的地
//                    data: { //傳送資料
//                        "cnt_id": cnt_id,
//                        "global_addbuy_id": global_addbuy_id,
//                        "give_text": give_text,
//                        "product_folder_id": product_folder_id
//                    },
//                    success: function(data) {
//                       alert("已加入購物車");
//
//
//
//                       a=Math.floor(Math.random()*(100000-0));
//                       dataSource = '&parm='+new Date().getTime()+a;
//
//                       // 不帶第二個參數
//                       $.get('get_cart_num.php?&userid1=test1&userid2=test2'+dataSource+'','',function(data,textStatus,XMLHttpRequest)
//                       {
//                           //alert(data);
//                           if(data != "")
//                           {
//                               $(".mcount").text(data);
//                           }
//
//
//                       });
//
//                    },
//                    error: function(jqXHR) {
//
//                    }
//            })
        }
        </script>
</body>

</html>