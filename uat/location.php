<?php 
    include "quote/template/head.php";
    require_once ("global_include_file.php"); 

    $URL='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?1";

	$d3_info=array(); 
	$where_clause=" is_hide='2' order by rank desc";
	$tbl_name="sys_portal_d3";
	getall_data($tbl_name, $where_clause, $d3_info);


?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/location.css">
</head>

<body class="locationPage">
    <?php
        include "quote/template/added.php";
        include "quote/template/nav.php";
    ?>
    <div id="Wrapper">
        <main role="main">
            <div class="sh-banner">
                <img class="pc" src="dist/images/location/line_1_pc.png">
                <img class="mo" src="dist/images/location/line_1_mb.png">
                <div class="container">
                    <h2>
                        <div class="e-ti">LOCATION</div>
                        <div class="t-ti">門市據點</div>
                    </h2>
                </div>
            </div>
            <section class="item1">
                <div class="container">
                    <div class="b-ti">
                        門市資訊
                    </div>
                    <div class="it1-bx">
                        <div class="ti-bx">
                            <div class="d1">
                                門市名稱
                            </div>
                            <div class="d2">
                                門市電話
                            </div>
                            <div class="d3">
                                專員手機
                            </div>
                            <div class="d4">
                                地址
                            </div>
                        </div>
                        <ul>

                            <?for($kkk=0;$kkk<count($d3_info);$kkk++){?>
                            <li>
                                <div class="d1">
                                    <div class="center-bx">
                                        <?=$d3_info[$kkk]['text_field_0']?>
                                    </div>
                                </div>
                                <div class="d2">
                                    <div class="center-bx">
                                        <span class="mo">門市電話</span>
                                        <a href="tel:<?=$arr[$kkk]['text_field_1']?>">
                                            <?=$d3_info[$kkk]['text_field_1']?>
                                        </a>
                                    </div>
                                </div>
                                <div class="d3">
                                    <div class="center-bx">
                                        <span class="mo">專員手機</span>
                                        <a href="tel:<?=$arr[$kkk]['text_field_2']?>">
                                            <?=$d3_info[$kkk]['text_field_2']?>
                                        </a>
                                    </div>
                                </div>
                                <div class="d4">
                                    <div class="center-bx">
                                        <span class="mo">地址</span>
                                        <a href="<?=(($d3_info[$kkk]['text_field_4'])?$d3_info[$kkk]['text_field_4']:"javascript:void(0);")?>" <?=(($d3_info[$kkk]['text_field_4'])?' target="_blank"':'')?>>
                                            <?=$d3_info[$kkk]['text_field_3']?>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <?}?>

                        </ul>
                    </div>
                </div>
            </section>
<?php 
    $info=array(); 
    $where_clause="1 and is_hide='2' order by rank desc";
    $tbl_name="sys_portal_d2";
    getall_data($tbl_name, $where_clause, $info);
    // show_array($info);
?>
            <section class="item2">
                <div class="container">
                    <div class="it2-bx">
                        <div class="b-ti">線上通路</div>
                        <ul>
                            <?for($iii=0;$iii<count($info);$iii++){
			                    $pic_src = "login_admin/upload_file/".get_pic_path($info[$iii]['pic_field_1'])['pic_file'];
			                    $url = $info[$iii]['text_field_2'];
			                ?>
			                    <li>
			                        <a href="<?=$url?>" target="_blank" style="background: url(<?=$pic_src?>) center / cover no-repeat">
			                        </a>
			                    </li>
			                <?}?>
                        </ul>
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