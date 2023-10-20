<?php
    include "quote/template/head.php";

    require_once ("global_include_file.php");

    $add_sql = "";
    if($_COOKIE['lang_id']=="3"){
        $add_sql = " and text_field_12 !=''";
    }

    $today = date("Y-m-d");
    $all_info=array();
    $where_clause="1 and is_hide='2' and date_field_0 <='".$today."' ".$add_sql." order by rank desc";
    $tbl_name="sys_portal_e1";
    getall_data($tbl_name, $where_clause, $all_info);
    // show_array($all_info);

    /***************
    *  分頁
    **************/
    $each_page_num = 9;
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

?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/video.css">
</head>

<body class="videoPage">
    <?php
        include "quote/template/added.php";
        include "quote/template/nav.php";
    ?>
    <div id="Wrapper">
        <main role="main">
            <div class="sh-banner">
                <img class="pc" src="dist/images/video/line_1_pc.png">
                <img class="mo" src="dist/images/video/line_1_mb.png">
                <div class="container">
                    <h2>
                        <div class="e-ti">SHARE</div>
                        <div class="t-ti">影音好文</div>
                    </h2>
                </div>
            </div>
            <section class="item1">
                <div id="top-menu-ul">
                    <div class="container">
                        <div class="item_Menu">
                            <div class="item_menu_Box">
                                <ul class="item_menu_list slides">
                                    <li class="active">
                                        <a href="video.php">
                                            <div class="f16">
                                                <span>影音</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="article.php">
                                            <div class="f16">
                                                <span>文章</span>
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
            </section>
            <section class="item2">
                <div class="container">
                    <ul class="video-list">
                        <?for($iii=0;$iii<count($info);$iii++){
                    $datetime = str_replace("-", " . ", $info[$iii]['date_field_0']);

                    if($_COOKIE['lang_id']=="3"){
                        $title_name = $info[$iii]['text_field_12'];

                        $tag=array();
                        if($info[$iii]['tag_text_field_11'] != "")
                        $tag = explode(",",$info[$iii]['tag_text_field_11']);
                        $url = "video-detail.php?detail_id=".$info[$iii]['Fmain_id'];

                        $pic_src = "login_admin/upload_file/".get_pic_path($info[$iii]['pic_field_8'])['pic_file'];
                        if(get_pic_path($info[$iii]['pic_field_8'])['pic_file']==""){
                            $pic_src = get_yt_info($info[$iii]['text_field_7'])['pic_sddefault'];
                        }

                    }else{
                        $title_name = $info[$iii]['text_field_1'];

                        $tag=array();
                        if($info[$iii]['tag_text_field_4'] != "")
                        $tag = explode(",",$info[$iii]['tag_text_field_4']);

                        $url = "video-detail.php?detail_id=".$info[$iii]['Fmain_id'];

                        $pic_src = "login_admin/upload_file/".get_pic_path($info[$iii]['pic_field_6'])['pic_file'];
                        if(get_pic_path($info[$iii]['pic_field_6'])['pic_file']==""){
                            $pic_src = get_yt_info($info[$iii]['text_field_2'])['pic_sddefault'];
                        }
                    }

                ?>
                    <li>
                        <a href="<?=$url?>">
                            <div class="img-bx" style="background-image: url('<?=$pic_src?>');">
<!-- 	                            <img src="<?=$pic_src?>" width="370" height="241"> -->
                            </div>
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