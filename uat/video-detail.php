<?php
    include "quote/template/head.php";
    require_once ("global_include_file.php");

    $detail_id = $_GET['detail_id'];

    $today = date("Y-m-d");
    $info=array();
    $where_clause="Fmain_id ='".$detail_id."' and date_field_0 <='".$today."' and is_hide='2'";
    $tbl_name="sys_portal_e1";
    get_data($tbl_name, $where_clause, $info);
    // show_array($info);

    if(count($info)<1 || $detail_id==""){
        // header("Location: news.php");

        print "<script>";
        print "alert('查無資料');";
        print "history.go(-1);";
        print "</script>";
        exit;
    }


    $datetime = str_replace("-", " . ", $info['date_field_0']);

    if($_COOKIE['lang_id']=="3"){
        $title_name = $info['text_field_12'];

        $tag=array();
        if($info['tag_text_field_11'] != "")
        $tag = explode(",",$info['tag_text_field_11']);

        $url = "video-detail.php?detail_id=".$info['Fmain_id'];

        $pic_src = "login_admin/upload_file/".get_pic_path($info['pic_field_8'])['pic_file'];
        if(get_pic_path($info['pic_field_8'])['pic_file']==""){
            $pic_src = get_yt_info($info['text_field_7'])['pic_sddefault'];
        }

        $content = $info['html_field_9'];
        $content_mobile = $info['html_field_10'];
        $yt_url = get_yt_info($info['text_field_7'])['embed_vedio'];
        $lang_str= "lang_en";

    }else{
        $title_name = $info['text_field_1'];

        $tag=array();
        if($info['tag_text_field_4'] != "")
        $tag = explode(",",$info['tag_text_field_4']);

        $url = "video-detail.php?detail_id=".$info['Fmain_id'];

        $pic_src = "login_admin/upload_file/".get_pic_path($info['pic_field_6'])['pic_file'];
        if(get_pic_path($info['pic_field_6'])['pic_file']==""){
            $pic_src = get_yt_info($info['text_field_2'])['pic_sddefault'];
        }

        $content = $info['html_field_3'];
        $content_mobile = $info['html_field_5'];
        $yt_url = get_yt_info($info['text_field_2'])['embed_vedio'];
        $lang_str= "lang_tw";
    }



?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/news.css">
</head>

<body class="newsdetailPage videodetailPage">
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
            <section class="item2">
                <div class="container">
                    <div class="it2-bx">
                        <div class="da-bx">
                            <div class="da">
                                <?=$datetime?>
                            </div>
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
	                            <a href="search-v.php?key_word=<?=$tag[$kkk]?>" class="hastag">#<?=$tag[$kkk]?></a>
	                        <?}?>
	                    </div>
	                    <?
	                    }
	                    ?>
                        <!-- 1025 -->
                        <iframe src="<?=$yt_url?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		                <div class="editor_Content in_fade active">
		                    <div class="editor_box pc_use">
		                        <?=$content?>
		                    </div>
		                    <div class="editor_Box mo_use">
		                        <?=$content_mobile?>
		                    </div>
		                </div>
		                <a href="javascript:history.back();" class="sh-btn">
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