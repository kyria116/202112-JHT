<?
    session_start();
    include "quote/template/head.php";
    require_once ("global_include_file.php");

	$tag_color_set = array("HOT"=>"red","NEW"=>"blue","SALE"=>"org","預購"=>"green");
    $type = $_GET['type'];
    $id = $_GET['id'];

    /******************************
      取得該商品有沒有符合滿件優惠活動
    *******************************/

    $get_product_sale_amount_info=get_check_product_sale_amount_info($cnt_id);


    /******************************
      取得該商品有沒有符合滿額優惠活動

    *******************************/
    $get_set_product_sale_info=get_check_product_sale_info($cnt_id);


    /******************
      兩個fun都在  function_portal.php裡面

      1.回傳的陣列裡面有一個 ['all_id']  這個值是設定好這個活動的商品id
      2.如果這個key是空的 代表是所有商品
      3.如果回傳的陣列是空的就代表這個商品沒有符合該活動
      4.滿件跟滿額活動如果同時滿足  以滿件為主

    *******************/

    $today=date("Y-m-d");



    if($type=="total"){ //滿額

        // 判斷期間
//        $website_data_info=array();
//        $where_clause=" website_language_id = '1' and (set_product_sale_start <= '$today' and set_product_sale_end >= '$today')";
//        $tbl_name=$MYSQL_TABS['website_data'];
//        get_data($tbl_name, $where_clause, $website_data_info);
//        // show_array($website_data_info);

        $sale_money_list=array();
        $where_clause="Fmain_id = '$id' and website_language_id = '1' and (set_product_sale_start <= '$today' and set_product_sale_end >= '$today')";
        $tbl_name="sys_set_sale_money_list";
        get_data($tbl_name, $where_clause, $sale_money_list);
        // show_array($sale_money_list);


        $title = $sale_money_list['set_product_sale_title'];

        $product_str = "all";
        if($sale_money_list['set_product_sale_range']=="2"){
            $product_str = $sale_money_list['set_product_sale_range_product_id'];
        }


    }elseif($type=="amount"){ //滿件

        // 判斷期間
//        $website_data_info=array();
//        $where_clause=" website_language_id = '1' and (set_sale_amount_start <= '$today' and set_sale_amount_end >= '$today')";
//        $tbl_name=$MYSQL_TABS['website_data'];
//        get_data($tbl_name, $where_clause, $website_data_info);
//        // show_array($website_data_info);

        $sale_amount_list=array();
        $where_clause="Fmain_id = '$id' and website_language_id = '1' and (set_sale_amount_start <= '$today' and set_sale_amount_end >= '$today')";
        $tbl_name="sys_set_sale_amount_list";
        get_data($tbl_name, $where_clause, $sale_amount_list);
        // show_array($sale_amount_list);

        $title = $sale_amount_list['set_product_sale_amount_title'];

        $product_str = "all";
        if($sale_amount_list['set_sale_amount_range']=="2"){
            $product_str = $sale_amount_list['set_sale_amount_range_product_id'];
        }

    }


    if(count($sale_amount_list)<= 0 && count($sale_money_list) <= 0){

        print "<script>";
        print " alert('找不到優惠內容');";
        print " window.location.href='index.php';";
        print "</script>";

        exit;
    }


    $add_sql = "";
    if($product_str!="all"){
        $add_sql .= " and Fmain_id in(".$product_str.") ";
    }


    if($_GET['kol_id']!="" || $_SESSION['kol_id']!=""){

        if($_GET['kol_id']!=""){
            $kol_id = $_GET['kol_id'];
        }else{
            $kol_id = $_SESSION['kol_id'];
        }

        $kol_info=array();
        $where_clause="1 and Fmain_id='".$kol_id."' and sys_start_date<='".$today."' and sys_end_date>='".$today."' ";
        $tbl_name="sys_portal_j3";
        get_data($tbl_name, $where_clause, $kol_info);
        // show_array($kol_info);

        if(count($kol_info)>0){
            $add_sql .= " and Fmain_id != '".$kol_info['product_id']."'";
        }

    }


    $x100_cnt_info=array();
    $where_clause="1 and is_hide='2' and sys_start_date<='".$today."' and sys_end_date>='".$today."' ".$add_sql." order by rank desc";
//    print $where_clause;
    $tbl_name="sys_portal_x100_cnt";
    getall_data($tbl_name, $where_clause, $x100_cnt_info);
    // show_array($x100_cnt_info);


    /***************
    *  分頁
    **************/
    $each_page_num = 9;
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

    // show_array($info);
?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/product.css">
</head>

<body class="activityPage">
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
                        <div class="e-ti">PRODUCT</div>
                        <div class="t-ti">系列商品</div>
                    </h2>
                </div>
            </div>
            <section class="item1">
                <div class="container">
                    <div class="f24 tx"><?=$title?></div>
                </div>
            </section>
            <section class="item2">
                <div class="container">
                    <!-- tag + red、blue、org、green -->
                    <ul class="product-list four-list">
                <?for($iii=0;$iii<count($info);$iii++){

                    if($_COOKIE['lang_id']=="3" && $info[$iii]['pic_field_15']!=""){
                        $pic_num = explode(",", $info[$iii]['pic_field_15'])[0];
                    }else{
                        $pic_num = explode(",", $info[$iii]['pic_field_6'])[0];
                    }

                    $pic_path = get_pic_path_2($pic_num)['pic_file'];

                    $price_arr = get_x100_cnt_price($info[$iii]['Fmain_id']);

                    $cnt_id = $info[$iii]['Fmain_id'];

                    // include("include_kol_info.php");

                ?>
                        <li>
<!--                             <a href="<?=$info[$iii]['text_field_1']?>.html"> -->
                            <a href="product-detail.php?num=<?=$info[$iii]['text_field_1']?>">
                                <?if($info[$iii]['radio_field_16']!="" && $info[$iii]['radio_field_16']!="不顯示"){?>
	                                <div class="tag <?=$tag_color_set[$info[$iii]['radio_field_16']]?>"><?=$info[$iii]['radio_field_16']?></div>
	                            <?}?>
                                <div class="img-bx">
                                    <img src="<?=$pic_path?>">
                                </div>
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
	                                            特惠價<span><?=number_format($price_arr['price_3'])?></span>
	                                        </div>
	                                    </div>
	                                <?}elseif(count($price_arr)>1){?>
	                                    <!-- 2種價格 -->
	                                    <div class="pric-bx">
	                                        <div class="org-pric f16">
	                                            原價<span><?=number_format($price_arr['price_1'])?></span>
	                                        </div>
	                                        <div class="dis-pric">
	                                            特惠價<span><?=number_format($price_arr['price_2'])?></span>
	                                        </div>
	                                    </div>
	                                <?}elseif($price_arr['price_1']!=""){?>
	                                    <div class="pric-bx">
	                                        <div class="dis-pric">
	                                            特惠價<span><?=number_format($price_arr['price_1'])?></span>
	                                        </div>
	                                    </div>
	                                <?}elseif($price_arr['price_2']!=""){?>
	                                    <div class="pric-bx">
	                                        <div class="dis-pric">
	                                            特惠價<span><?=number_format($price_arr['price_2'])?></span>
	                                        </div>
	                                    </div>
	                                <?}?>
                                    
                                </div>
                            </a>
                        </li>
                <?}?>
                    </ul>
                    <?php
                        include "quote/template/page_list_2.php";
                    ?>
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