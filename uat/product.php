<?
    session_start();
    include "quote/template/head.php";
    require_once ("global_include_file.php");

	$tag_color_set = array("HOT"=>"red","NEW"=>"blue","SALE"=>"org","預購"=>"green");
    $URL='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?1";
    $folder_id = $_GET['folder_id'];

    $all_product_menu=array();
    $where_clause="1 and is_hide = '2' order by rank desc";
    $tbl_name="sys_portal_x100";
    getall_data($tbl_name, $where_clause, $all_product_menu);
    // show_array($all_product_menu);

    if($_GET['l1_id']){
	    $all_product_menu=array();
	    $where_clause="1 order by rank desc";# and is_hide = '2'
	    $tbl_name="sys_portal_l1";
	    getall_data($tbl_name, $where_clause, $all_product_menu);
    }

    $today = date("Y-m-d");
    $time_sql = " and sys_start_date<='".$today."' and sys_end_date>='".$today."'";
    if($_GET['l1_id']){
        $add_sql  = " and t.sys_start_date<='".$today."' and t.sys_end_date>='".$today."' and t.is_hide='2'";
		$x100_cnt_info=array();
		$query_string = "SELECT t.*, td.rank AS new_rank FROM `sys_portal_x100_cnt` AS t INNER JOIN ".$MYSQL_TABS['portal_l1_cnt_rank']." AS td ON t.Fmain_id = td.portal_l1_cnt_id WHERE td.portal_l1_id = '".$_GET['l1_id']."' ".$add_sql." order by new_rank desc";
		sql_data($query_string, $x100_cnt_info);
    }
    else if($folder_id==""){
        $x100_cnt_info=array();
        $where_clause="1 and is_hide='2' ".$time_sql." order by rank desc";
        $tbl_name="sys_portal_x100_cnt";
        getall_data($tbl_name, $where_clause, $x100_cnt_info);
        // show_array($x100_cnt_info);
    }
    else{

/*
        $x100_id_2_sql = " and ( portal_x100_id='".$folder_id."' or portal_x100_id_2 LIKE '%@".$folder_id."@%')";

        $x100_cnt_info=array();
        $where_clause="1 ".$time_sql." ".$x100_id_2_sql." and is_hide='2' order by rank desc";
        $tbl_name="sys_portal_x100_cnt";
        getall_data($tbl_name, $where_clause, $x100_cnt_info);
*/
        // show_array($x100_cnt_info);
		$add_sql  = " and t.sys_start_date<='".$today."' and t.sys_end_date>='".$today."' and t.is_hide='2'";
		$x100_cnt_info=array();
		$query_string = "SELECT t.*, td.rank AS new_rank FROM `sys_portal_x100_cnt` AS t INNER JOIN ".$MYSQL_TABS['portal_x100_cnt_rank']." AS td ON t.Fmain_id = td.portal_x100_cnt_id WHERE td.portal_x100_id = '".$folder_id."' ".$add_sql." order by new_rank desc";
		sql_data($query_string, $x100_cnt_info);
    }



//  show_array($x100_cnt_info);
//print count($x100_cnt_info);
//exit;

    // 濾掉隱藏的分類
//    $temp_arr=array();
//    $temp_arr=$x100_cnt_info;
//    $x100_cnt_info=array();
//
//    $k=0;
//    for($i=0;$i<count($temp_arr);$i++)
//    {
//        $temp_folder_arr=array();
//        $temp_folder_arr=explode(",",$temp_arr[$i]['portal_x100_id_2']);
//
//        $p=0;
//        for($j=0;$j<count($temp_folder_arr);$j++)
//        {
//            $temp_folder_arr[$j] = str_replace("@", "", $temp_folder_arr[$j]);
//
//            $each_info=array();
//            $where_clause="Fmain_id='".$temp_folder_arr[$j]."'";
//            $tbl_name="sys_portal_x100";
//            get_data($tbl_name, $where_clause, $each_info);
//            // show_array($each_info);
//
//            if($each_info['is_hide'] == "2")
//               $p++;
//
//        }
//
//        if($p == count($temp_folder_arr) || $folder_id=="")
//        {
//            $x100_cnt_info[$k]=$temp_arr[$i];
//
//            $k++;
//        }
//
//    }

//    show_array($x100_cnt_info);


    /***************
    *  分頁
    **************/
    $each_page_num = 12;
    $pageNum=$_GET['pageNum'];

    if($pageNum==""){
        $info=array();
        for($i=0;$i<$each_page_num;$i++){
            if(isset($x100_cnt_info[$i])){
                $info[$i]=$x100_cnt_info[$i];
            }
        }
    }else{
        $Si=$pageNum*$each_page_num;
        $Ei=$Si+$each_page_num;
        $info=array();
        $ii=0;
        for($i=$Si;$i<$Ei;$i++){
            if(isset($x100_cnt_info[$i])){
                $info[$ii]=$x100_cnt_info[$i];
            }
            $ii++;
        }
    }

    $all_info = $x100_cnt_info;

//     show_array($info);

?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/product.css">
</head>

<body class="productPage">
    <?php
        include "quote/template/added.php";
        include "quote/template/nav.php";
    ?>
    <div id="Wrapper">
        <main role="main">
            <div class="sh-banner">
                <img class="pc" src="dist/images/product/line_1_pc.png">
                <img class="mo" src="dist/images/product/line_1_mb.png">
                <div class="container">
                    <h2>
                        <div class="e-ti"><?=(($_GET['l1_id'])?"Special":"PRODUCT")?></div>
                        <div class="t-ti"><?=(($_GET['l1_id'])?"強檔優惠":"系列商品")?></div>
                    </h2>
                </div>
            </div>

            <section class="item1">
                <div id="top-menu-ul">
                    <div class="container">
                        <div class="item_Menu">
                            <div class="item_menu_Box">
                                <ul class="item_menu_list slides">
                                    <?
		                                $active = "";
		                                if($folder_id=="" || $folder_id=="all"){
		                                    $active = "active";
		                                }
		                                if(!$_GET['l1_id']){
		                            ?>

		                            <li class="<?=$active?>">
		                                <a href="product.php">
			                                <div class="f16">
		                                    <span class="tw">全部商品</span>
		                                	</div>
		                                </a>
		                            </li>

		                            <?
			                            }


			                            for($iii=0;$iii<count($all_product_menu);$iii++){
			                                $active = "";
			                                if($folder_id==$all_product_menu[$iii]['Fmain_id']){
			                                    $active = "active";
			                                }
			                                else if($_GET['l1_id']==$all_product_menu[$iii]['Fmain_id']){
			                                    $active = "active";
			                                }
			                                if($_GET['l1_id']){
				                                $the_id = "l1_id";
			                                }
			                                else{
				                                $the_id = "folder_id";
			                                }
		                            ?>
		                                <li class="<?=$active?>">
		                                    <a href="product.php?<?=$the_id?>=<?=$all_product_menu[$iii]['Fmain_id']?>"><?=$show_str?>
		                                        <div class="f16">
		                                        <span class="tw"><?=$all_product_menu[$iii]['menu_name']?></span>
												</div>
		                                    </a>
		                                </li>
		                            <?
			                            }
		                            ?>
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
                    <!-- tag + red、blue、org、green -->
                    <ul class="product-list four-list">

                <?for($iii=0;$iii<count($info);$iii++){

//                    if($_COOKIE['lang_id']=="3" && $info[$iii]['pic_field_15']!=""){
//                        $pic_num = explode(",", $info[$iii]['pic_field_15'])[0];
//                    }else{
                        $pic_num = explode(",", $info[$iii]['pic_field_6'])[0];
//                    }

                    $pic_path = get_pic_path_2($pic_num)['pic_file'];

                    $price_arr = get_x100_cnt_price($info[$iii]['Fmain_id']);


                    $cnt_id = $info[$iii]['Fmain_id'];

                    include("include_kol_info.php");


                    // if($_GET['kol_id']!="" || $_SESSION['kol_id']!=""){

                    //     if($_GET['kol_id']!=""){
                    //         $kol_id = $_GET['kol_id'];
                    //     }else{
                    //         $kol_id = $_SESSION['kol_id'];
                    //     }


                    //     $x100_info=array();
                    //     $where_clause="1 and Fmain_id='".$kol_id."' and product_id ='".$cnt_id."'";
                    //     $tbl_name="sys_portal_j3";
                    //     get_data($tbl_name, $where_clause, $x100_info);
                    //     // show_array($x100_info);

                    //     if(count($x100_info)>0){

                    //         $_SESSION['kol_id'] = $x100_info['Fmain_id'];

                    //         $price_arr = array();
                    //         $price_arr['price_3'] = $x100_info['price'];

                    //     }

                    // }

                    // show_array($price_arr);

                ?>
                        <li>
<!--                             <a href="<?=$info[$iii]['text_field_1']?>.html"> -->
                            <a href="product-detail.php?num=<?=$info[$iii]['text_field_1']?>&l1_id=<?=$_GET['l1_id']?>">
                                <?if($info[$iii]['radio_field_16']!="" && $info[$iii]['radio_field_16']!="不顯示"){?>
	                                <div class="tag <?=$tag_color_set[$info[$iii]['radio_field_16']]?>"><?=$info[$iii]['radio_field_16']?></div>
	                            <?}?>
                                <div class="img-bx" style="background: url(<?=$pic_path?>) center / cover no-repeat;"></div>
                                <div class="des-bx">
                                    <div class="tx-bx">
                                        <div class="p-num f16"><?=$info[$iii]['text_field_1']?></div>
                                        <div class="ti f20">
                                            <?=$info[$iii]['text_field_0']?>
                                        </div>
                                    </div>

                                    <?if($price_arr['price_3']!=""){?>
	                                    <div class="pric-bx">
	                                        <div class="dis-pric">
	                                            <i class="specialprice">特惠價</i><span><?=number_format($price_arr['price_3'])?></span>
	                                        </div>
	                                    </div>
	                                <?}elseif(count($price_arr)>1){?>
	                                    <!-- 2種價格 -->
	                                    <div class="pric-bx">
	                                        <div class="org-pric f16">
	                                            原價<span><?=number_format($price_arr['price_1'])?></span>
	                                        </div>
	                                        <div class="dis-pric">
	                                            <i class="specialprice">特惠價</i><span><?=number_format($price_arr['price_2'])?></span>
	                                        </div>
	                                    </div>
	                                <?}elseif($price_arr['price_1']!=""){?>
	                                    <div class="pric-bx">
	                                        <div class="dis-pric">
	                                            <i class="specialprice">特惠價</i><span><?=number_format($price_arr['price_1'])?></span>
	                                        </div>
	                                    </div>
	                                <?}elseif($price_arr['price_2']!=""){?>
	                                    <div class="pric-bx">
	                                        <div class="dis-pric">
	                                            <i class="specialprice">特惠價</i><span><?=number_format($price_arr['price_2'])?></span>
	                                        </div>
	                                    </div>
	                                <?}?>

                                </div>
                            </a>
                        </li>
                <?}?>
                    </ul>
                    <?include "quote/template/page_list_2.php";?>
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
</body>

</html>