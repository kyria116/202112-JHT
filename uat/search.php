<?php
    include "quote/template/head.php";
    require_once ("global_include_file.php");

	$tag_color_set = array("HOT"=>"red","NEW"=>"blue","SALE"=>"org","預購"=>"green");
    $key_word = $_GET['key_word'];
    $key_word2 = $_POST['key_word2'];

    if($key_word2 != "")
      $key_word=$key_word2;


    $add_sql = " and ( text_field_0 like '%".$key_word."%' or text_field_1 like '%".$key_word."%' or html_field_4 like '%".$key_word."%') ";
    if($_COOKIE['lang_id']=="3"){
        $add_sql = " and ( text_field_12 like '%".$key_word."%' or text_field_1 like '%".$key_word."%' or html_field_13 like '%".$key_word."%') ";
    }

    $today = date("Y-m-d");
    $time_sql = " and sys_start_date<='".$today."' and sys_end_date>='".$today."'";

    if($key_word!=""){
        $all_info=array();
        $where_clause="1".$add_sql." and is_hide='2'".$time_sql." order by rank desc";
        $tbl_name="sys_portal_x100_cnt";
        getall_data($tbl_name, $where_clause, $all_info);
        // show_array($all_info);


        /***************
        *  分頁
        **************/
        $base_url = $_SERVER['PHP_SELF']."?key_word=".$key_word;
        $each_page_num = 12;
        $pageNum=$_GET['pageNum'];

        if($pageNum==""){
            $info=array();
            for($i=0;$i<$each_page_num;$i++){
                if(isset($all_info[$i])){
                    $info[$i]=$all_info[$i];
                }
            }
        }else{
            $Si=$pageNum*$each_page_num;
            $Ei=$Si+$each_page_num;
            $info=array();
            $ii=0;
            for($i=$Si;$i<$Ei;$i++){
                if(isset($all_info[$i])){
                    $info[$ii]=$all_info[$i];
                }
                $ii++;
            }
        }

    }

    $show_search_word="請輸入關鍵字";
    if($_COOKIE['lang_id'] == "3")
      $show_search_word="Please enter keywords.";


?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/search.css">
</head>

<body class="searchPage">
    <?php
        include "quote/template/added.php";
        include "quote/template/nav.php";
    ?>
    <div id="Wrapper">
        <main role="main">
            <div class="sh-banner">
                <img class="pc" src="dist/images/search/line_1_pc.png">
                <img class="mo" src="dist/images/search/line_1_mb.png">
                <div class="container">
                    <h2>
                        <div class="e-ti">search</div>
                        <div class="t-ti">搜尋結果</div>
                    </h2>
                </div>
            </div>
            <section class="item1">
                <div class="container">
                    <div class="it1-bx">
                        <form name="f1" action="search.php" method="get">
                        <div class="search-bx">
                            <input type="text" name="key_word" value="<?=$key_word?>" placeholder="<?=$show_search_word?>">
                            <a href="javascript:f1.submit();">
                                <img src="dist/images/search/serch_icon_b_.png">
                            </a>
                        </div>
                        </form>
                        <div id="top-menu-ul">
                            <div class="item_Menu">
                                <div class="item_menu_Box">
                                    <ul class="item_menu_list slides">
                                        <li class="active">
                                            <a href="search.php?key_word=<?=$key_word?>">
                                                <div class="f16">
                                                    <span>系列商品</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="search-n.php?key_word=<?=$key_word?>">
                                                <div class="f16">
                                                    <span>活動消息</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="search-v.php?key_word=<?=$key_word?>">
                                                <div class="f16">
                                                    <span>精彩影音</span>
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
                </div>
            </section>
            <section class="item2">
                <div class="container">
                    
                    <?if(count($info)>0){?>
                    <!-- 搜尋頁面顯示 -->
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

                            include("include_kol_info.php");

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
                    <?}else{?>
                    <!-- 查無頁面顯示 -->
                    <div class="it1-bx">
                        <div class="form-bx">
                            <div class="form-ti">
                                <div class="f16">
                                    查無資料
                                </div>
                            </div>
                        </div>
                    </div>
                    <?}?>
                    <?
	                    if(count($all_info)>$each_page_num){
	                        include "quote/template/page_list_2.php";
	                    }
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