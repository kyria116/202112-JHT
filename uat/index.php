<?php
    include "quote/template/head.php";
    require_once ("global_include_file.php");


    if($_COOKIE['lang_id']=="3"){//英文版
        $lang_id = 3;
        $lang_str= "lang_en";
    }else{
        $lang_id = 1;
        $lang_str= "lang_tw";
    }


    $all_product_info=array();
    $where_clause="1 order by rank desc";
    $tbl_name="sys_portal_x100";
    getall_data($tbl_name, $where_clause, $all_product_info);
    // show_array($all_product_info);

    $slide_info = array();
    $where_clause="is_hide != '1' and sys_start_date <= '".date("Y-m-d")."' and sys_end_date >= '".date("Y-m-d")."' order by rank desc";
    $tbl_name="sys_portal_k3";
    getall_data($tbl_name, $where_clause, $slide_info);
    // show_array($slide_info); // text_field_0 pic_field_1 text_field_2  //text_field_3  pic_field_4 text_field_5
    
    $slide2_info = array();
    $where_clause="is_hide != '1' and sys_start_date <= '".date("Y-m-d")."' and sys_end_date >= '".date("Y-m-d")."' order by rank desc";
    $tbl_name="sys_portal_k9";
    getall_data($tbl_name, $where_clause, $slide2_info);
?>
<link rel="stylesheet" href="dist/css/slick-theme.css">
<link rel="stylesheet" href="dist/css/slick.css">
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/index.css?v=2">
</head>

<body class="indexPage">
    <?php
        include "quote/template/added.php";
        include "quote/template/nav.php";
    ?>
    <div id="Wrapper">
        <main role="main">
            <div class="ind-banner">
                <ul>
                <?for($iii=0;$iii<count($slide_info);$iii++){

                    if($lang_id=="3"){
                           $pic_m = $slide_info[$iii]['pic_field_7'];
                           $pic = $slide_info[$iii]['pic_field_4'];
                        $title = $slide_info[$iii]['text_field_3'];
                        $url = $slide_info[$iii]['text_field_5'];
                    }else{
                          $pic_m = $slide_info[$iii]['pic_field_8'];
                          $pic = $slide_info[$iii]['pic_field_1'];
                       $title = $slide_info[$iii]['text_field_0'];
                       $url = $slide_info[$iii]['text_field_2'];
                    }

                    $pic_arr = get_pic_path($pic);
                    $pic = "./login_admin/upload_file/".$pic_arr['pic_file'];
                    $pic_m_arr = get_pic_path($pic_m);
                    $pic_m = "./login_admin/upload_file/".$pic_m_arr['pic_file'];

                ?>
                    <li>
                        <a  href="<?=$url?>" target="_blank" title="<?=$title?>">
                            <div class="bgcover pc" style="background:url(<?=$pic?>) center center"></div>
                            <div class="bgcover mo" style="background:url(<?=$pic_m?>) center center"></div>
                        </a>
                    </li>
                <?}?>
                </ul>
            </div>
            <section class="item1">
                <div class="container">
                    <ul>
                    <?for($iii=0;$iii<count($slide2_info);$iii++){

	                    if($lang_id=="3"){
	                           $pic_m = $slide2_info[$iii]['pic_field_7'];
	                           $pic = $slide2_info[$iii]['pic_field_4'];
	                        $title = $slide2_info[$iii]['text_field_3'];
	                        $url = $slide2_info[$iii]['text_field_5'];
	                    }else{
	                          $pic_m = $slide2_info[$iii]['pic_field_8'];
	                          $pic = $slide2_info[$iii]['pic_field_1'];
	                       $title = $slide2_info[$iii]['text_field_0'];
	                       $url = $slide2_info[$iii]['text_field_2'];
	                    }
	
	                    $pic_arr = get_pic_path($pic);
	                    $pic = "./login_admin/upload_file/".$pic_arr['pic_file'];
	                    $pic_m_arr = get_pic_path($pic_m);
	                    $pic_m = "./login_admin/upload_file/".$pic_m_arr['pic_file'];
	
	                ?>
	                    <li>
	                        <a  href="<?=$url?>" title="<?=$title?>">
	                            <div class="bgcover pc" style="background:url(<?=$pic?>) center center"></div>
	                            <div class="bgcover mo" style="background:url(<?=$pic_m?>) center center"></div>
	                        </a>
	                    </li>
	                <?}?>
                    </ul>
                    <div class="bg">
                        <img src="dist/images/1_illustration.png">
                    </div>
                </div>
            </section>
            <section class="item2">
                <div class="container">
                    <div class="ind-ti">
                        <div class="e-ti">
                            PRODUCT
                        </div>
                        <div class="t-ti">
                            系列商品
                        </div>
                    </div>
                    <ul>
                        <?
	                    $x100_info=array();
	                    $where_clause=" 1 order by rank desc ";
	                    $tbl_name="sys_portal_k12";
	                    getall_data($tbl_name, $where_clause, $x100_info);    
                        for($iii=0;$iii<count($x100_info);$iii++){
							$pic = $x100_info[$iii]['pic_field_2'];
		                    $pic_arr = get_pic_path($pic);
		                    $pic = "./login_admin/upload_file/".$pic_arr['pic_file'];
		                ?>
		                <li>
                            <a href="<?=(($x100_info[$iii]['text_field_1'])?$x100_info[$iii]['text_field_1']:"javascript:void(0);")?>">
                                <div class="img-bx">
                                    <img src="<?=$pic?>">
                                </div>
                                <div class="tx f24">
                                    <?=$x100_info[$iii]['text_field_0']?>
                                </div>
                            </a>
                        </li>    
		                <?}?>
                    </ul>
                    <div class="bg">
                        <img src="dist/images/2_illustration.png">
                    </div>
                </div>
                <div class="bg2">
                    <img class="pc" src="dist/images/line_1_pc.png">
                    <img class="mo" src="dist/images/mbbg_line1.png">
                </div>
            </section>
            <section class="item3">
                <div class="container">
                    <div class="t-flex">
                        <div class="ind-ti">
                            <div class="e-ti">
                                VIDEO
                            </div>
                            <div class="t-ti">
                                精彩影音
                            </div>
                        </div>
                        <a href="video.php" class="sh-btn">
                            <div class="ar"></div>
                            MORE
                        </a>
                    </div>
                    <ul>
                <?
                    $vedio_info=array();
                    $where_clause="1 order by rank desc";
                    $tbl_name="sys_portal_k2";
                    getall_data($tbl_name, $where_clause, $vedio_info);
                    //show_array($vedio_info);

                    $today = date("Y-m-d");
                    $lang_sql = "";
                    if($_COOKIE['lang_id']=="3"){
                        $lang_sql = " and text_field_12 !=''";
                    }
                    $add_sql=" and is_hide='2' and date_field_0 <='".$today."' ".$lang_sql;

                $k=0;
                for($iii=0;$iii<count($vedio_info);$iii++){
                    $each_info=array();
                    $where_clause="Fmain_id='".$vedio_info[$iii]['id']."'".$add_sql;
                    $tbl_name="sys_portal_e1";
                    get_data($tbl_name, $where_clause, $each_info);
                    //show_array($each_info);

                    if(count($each_info)<1){
                        continue;
                    }

                    $k++;

                    $datetime = str_replace("-", " . ", $each_info['date_field_0']);
					$tag = array();
                    if($_COOKIE['lang_id']=="3"){
                        $title_name = $each_info['text_field_12'];

                        if($each_info['tag_text_field_11'] != "")
                        $tag = explode(",",$each_info['tag_text_field_11']);
                        $url = "video-detail.php?detail_id=".$each_info['Fmain_id'];

                        $pic_src = "login_admin/upload_file/".get_pic_path($each_info['pic_field_8'])['pic_file'];
                        if(get_pic_path($each_info['pic_field_8'])['pic_file']==""){
                            $pic_src = get_yt_info($each_info['text_field_7'])['pic_sddefault'];
                        }

                    }else{
                        $title_name = $each_info['text_field_1'];

                        if($each_info['tag_text_field_4'] != "")
                        $tag = explode(",",$each_info['tag_text_field_4']);
                        $url = "video-detail.php?detail_id=".$each_info['Fmain_id'];

                        $pic_src = "login_admin/upload_file/".get_pic_path($each_info['pic_field_6'])['pic_file'];
                        if(get_pic_path($each_info['pic_field_6'])['pic_file']==""){
                            $pic_src = get_yt_info($each_info['text_field_2'])['pic_sddefault'];
                        }
                    }

                ?>
                        <li>
                            <div class="ti-bx">
                                <a href="<?=$url?>" class="ti f24 fu3"><?=$title_name?></a>
                                <a href="<?=$url?>" class="da f16">
                                    <?=$datetime?>
                                </a>
                            </div>
                            <div class="iframe-bx">
                                <iframe id="iframe1" allowfullscreen src="<?=get_yt_info($each_info['text_field_2'])['embed_vedio']?>" ></iframe>
                            </div>
                            <?
                            if(count($tag) > 0 or 1)
                            {
                            ?>
                            <div class="tag-bx">
                                <?for($kkk=0;$kkk<count($tag);$kkk++){?>
                                    <a href="search-v.php?key_word=<?=$tag[$kkk]?>"><span>#<?=$tag[$kkk]?></span></a>
                                <?}?>
                            </div>
                            <?
                            }
                            ?>
                            <div class="more-bx">
                                <a href="<?=$url?>" class="more-btn">
                                    <div class="cir"></div>
                                    MORE
                                </a>
                            </div>
                        </li>
                <?}?>
                    </ul>
                    <div class="bg">
                        <img src="dist/images/3_illustration.png">
                    </div>
                </div>
            </section>
            <section class="item4">
                <div class="bg2">
                    <img class="pc" src="dist/images/line_2_pc.png">
                    <img class="mo" src="dist/images/mbbg_line2.png">
                </div>
                <div class="bg3">
                    <img class="pc" src="dist/images/line_3_pc.png">
                    <img class="mo" src="dist/images/mbbg_line3.png">
                </div>
                <div class="container">
                    <div class="ind-ti">
                        <div class="e-ti">
                            SHARE
                        </div>
                        <div class="t-ti">
                            好物分享
                        </div>
                    </div>
                    <?
	                    $k11_info=array();
	                    $where_clause=" Fmain_id = '1' ";
	                    $tbl_name="sys_portal_k11";
	                    get_data($tbl_name, $where_clause, $k11_info);    
	                ?>
                    <div class="it4-bx">
                        <div class="l-bx">
                            <div class="ti-bx">
                                <div class="ti f24">
                                    <?=$k11_info['text_field_0']?>
                                </div>
                                <div class="des f16">
                                    <?=nl2br($k11_info['textarea_field_1'])?>
                                </div>
                            </div>
                            <div class="more-bx">
                                <a href="<?=(($k11_info['text_field_2'])?$k11_info['text_field_2']:"javascript:;")?>" class="more-btn">
                                    <div class="cir"></div>
                                    MORE
                                </a>
                            </div>
                            <div class="flex-bx">
                                <div class="img-bx" style="background-image: url('<?="login_admin/upload_file/".get_pic_path($k11_info['pic_field_3'])['pic_file']?>');background-position: left;">
                                </div>
                                <div class="img-bx" style="background-image: url('<?="login_admin/upload_file/".get_pic_path($k11_info['pic_field_4'])['pic_file']?>');background-position: right;">
                                </div>
                            </div>
                        </div>
                        <div class="r-bx">
                            <div class="img-bx" style="background-image: url('<?="login_admin/upload_file/".get_pic_path($k11_info['pic_field_5'])['pic_file']?>');">
                            </div>
                        </div>
                    </div>
                    <div class="bg">
                        <img src="dist/images/4_illustration.png">
                    </div>
                </div>
            </section>
            <section class="item5">
                <div class="it5-bx">
                    <ul>
                        <?
	                    $k10_info=array();
	                    $where_clause=" 1 order by rank desc ";
	                    $tbl_name="sys_portal_k10";
	                    getall_data($tbl_name, $where_clause, $k10_info);    
                        for($iii=0;$iii<count($k10_info);$iii++){
							$pic = $k10_info[$iii]['pic_field_0'];
		                    $pic_arr = get_pic_path($pic);
		                    $pic = "./login_admin/upload_file/".$pic_arr['pic_file'];
		                    $url = ($k10_info[$iii]['text_field_1'])?$k10_info[$iii]['text_field_1']:"javascript:;";
		                ?>                        
                        <li>
                            <a href="<?=$url?>" class="img-bx" style="background-image: url('<?=$pic?>');">
                            </a>
                        </li>  
		                <?}?>
                    </ul>
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
    <!-- 套件JS -->
    <script src="dist/js/slick.js"></script>
    <script src="dist/js/index.js"></script>


   
</body>

</html>