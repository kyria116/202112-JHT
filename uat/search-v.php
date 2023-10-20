<?php
    include "quote/template/head.php";
    require_once ("global_include_file.php");

    $key_word = $_GET['key_word'];


    $add_sql = " and ( text_field_1 like '%".$key_word."%' or tag_text_field_4 like '%".$key_word."%') ";
    if($_COOKIE['lang_id']=="3"){
        $add_sql = " and ( text_field_12 like '%".$key_word."%' or tag_text_field_11 like '%".$key_word."%') ";
    }


    if($key_word!=""){
        $all_info=array();
        $where_clause="1 ".$add_sql." and is_hide='2' order by rank desc";
        $tbl_name="sys_portal_e1";
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
                        <form name="f1" action="search-v.php" method="get">
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
                                        <li>
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
                                        <li class="active">
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
                    <ul class="video-list">
                        <?for($iii=0;$iii<count($info);$iii++){

                            $c1_info=array();
                            $where_clause="Fmain_id ='".$info[$iii]['portal_c1_id']."'";
                            $tbl_name="sys_portal_c1";
                            get_data($tbl_name, $where_clause, $c1_info);
                            // show_array($c1_info);

                            $datetime = str_replace("-", ".", $info[$iii]['date_field_0']);

                            $url = "video-detail.php?detail_id=".$info[$iii]['Fmain_id'];

                            if($_COOKIE['lang_id']=="3"){
                                $title_name = $info[$iii]['text_field_12'];
                                $tag = explode(",",$info[$iii]['tag_text_field_11']);

                                $pic_src = "login_admin/upload_file/".get_pic_path($info[$iii]['pic_field_8'])['pic_file'];
                                if(get_pic_path($info[$iii]['pic_field_8'])['pic_file']==""){
                                    $pic_src = get_yt_info($info[$iii]['text_field_7'])['pic_sddefault'];
                                }
                            }else{
                                $title_name = $info[$iii]['text_field_1'];
                                $tag = explode(",",$info[$iii]['tag_text_field_4']);

                                $pic_src = "login_admin/upload_file/".get_pic_path($info[$iii]['pic_field_6'])['pic_file'];
                                if(get_pic_path($info[$iii]['pic_field_6'])['pic_file']==""){
                                    $pic_src = get_yt_info($info[$iii]['text_field_2'])['pic_sddefault'];
                                }
                            }

                        ?>
                        <li>
                        <!-- 圖片640*360 -->
                        <a href="<?=$url?>">
                            <div class="img-bx"><img src="<?=$pic_src?>"></div>
                            <div class="des-bx">
                                <div class="da">
                                    <?=$datetime?> 
                                </div>
                                <div class="des-ti f20">
                                    <?=$title_name?>
                                </div>
                            </div>
                        </a>
                        <?
                        if(count($tag) > 0 or 1)
                        {
                        ?>
                        <div class="flex-bx">
                            <?for($kkk=0;$kkk<count($tag);$kkk++){?>
                                <a href="search-v.php?key_word=<?=$tag[$kkk]?>" class="hastag">#<?=$tag[$kkk]?></a>
                            <?}?>
                        </div>
                        <?
                        }
                        ?>
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