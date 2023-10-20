<?php
    include "quote/template/head.php";
    require_once ("global_include_file.php");

    $detail_id = $_GET['detail_id'];

/*
    $all_folder_info=array();
    $where_clause="1 order by rank desc";
    $tbl_name="sys_portal_e2";
    getall_data($tbl_name, $where_clause, $all_folder_info);
    // show_array($all_folder_info);
*/

    $info=array();
    $where_clause="Fmain_id ='".$detail_id."' order by rank desc";# and is_hide='2'
    $tbl_name="sys_portal_e2_cnt";
    get_data($tbl_name, $where_clause, $info);
    // show_array($info);

    $c1_info=array();
    $where_clause="Fmain_id ='".$info['portal_e2_id']."'";
    $tbl_name="sys_portal_e2";
    get_data($tbl_name, $where_clause, $c1_info);
    // show_array($c1_info);

    if(count($info)<1 || $detail_id==""){
        // header("Location: news.php");

        print "<script>";
        print "alert('查無資料');";
        print "history.go(-1);";
        print "</script>";
        exit;
    }

    $datetime = str_replace("-", " . ", $info['date_field_0']);
    $folder_name = $c1_info['menu_name'];
    $title_name = $info['text_field_1'];
    $content = $info['html_field_3'];
    $content_mobile = $info['html_field_5'];

    $tag=array();
    if($info['text_field_4'] != "")
    $tag = explode(",",$info['text_field_4']);
?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/news.css">
</head>

<body class="newsdetailPage">
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
                                    <li>
                                        <a href="video.php">
                                            <div class="f16">
                                                <span>影音</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="active">
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
                    <div class="it2-bx">
                        <div class="da-bx">
                            <div class="da">
                                <?=$datetime?>
                            </div>
                            <!-- <div class="ty">
                                最新消息
                            </div> -->
                        </div>
                        <div class="des-ti f24">
                        <?=$title_name?>
                        </div>
                        <?
	                    if(count($tag) > 0)
	                    {
	                    ?>
                        <div class="flex-bx">
                            <?for($kkk=0;$kkk<count($tag);$kkk++){?>
	                            <a href="search-n.php?key_word=<?=$tag[$kkk]?>" class="hastag">#<?=$tag[$kkk]?></a>
	                        <?}?>
                        </div>
                        <?
	                    }
	                    ?>
                        <div class="editor_Content in_fade active">
                            <div class="editor_box pc_use">
                                <?=$content?>
                            </div>
                            <div class="editor_Box mo_use">
                                <?=$content_mobile?>
                            </div>
                        </div>
                        <a href="javascript:window.history.back();" class="sh-btn">
                            <div class="ar"></div>
                            BACK
                        </a>
                    </div>
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