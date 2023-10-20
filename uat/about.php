<?php include "quote/template/head.php"; ?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/about.css">
<?
	require_once ("global_include_file.php");

    $info=array();
    $where_clause="1";
    $tbl_name="sys_portal_h1";
    get_data($tbl_name, $where_clause, $info);
	
?>
</head>

<body class="aboutPage">
    <?php
        include "quote/template/added.php";
        include "quote/template/nav.php";
    ?>
    <div id="Wrapper">
        <main role="main">
            <div class="sh-banner">
                <img class="pc" src="dist/images/about/line_1_pc.png">
                <img class="mo" src="dist/images/about/line_1_mb.png">
                <div class="container">
                    <h2>
                        <div class="e-ti">ABOUT</div>
                        <div class="t-ti">關於我們</div>
                    </h2>
                </div>
            </div>
            <section class="item1">
                <div class="container">
                    <div class="it1-bx">
                        <div class="img-bx">                            
                            <div class="pc" style="background-image: url(<?="login_admin/upload_file/".get_pic_path($info['pic_field_6'])['pic_file']?>)"></div>
                            <div class="mo" style="background-image: url(<?="login_admin/upload_file/".get_pic_path($info['pic_field_5'])['pic_file']?>)"></div>
                        </div>
                        <div class="editor_Content">
                            <div class="editor_box pc_use">
                                <?=$info['html_field_1']?>
                            </div>
                            <div class="editor_Box mo_use">
                                <?=$info['html_field_3']?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg1">
                    <img src="dist/images/about/line_2_pc.png">
                </div>
                <div class="bg2">
                    <img src="dist/images/about/line_3_pc.png">
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