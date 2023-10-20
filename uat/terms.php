<?php 
    include "quote/template/head.php";
    require_once ("global_include_file.php");

    $info=array();
    $where_clause=" Fmain_id = '1' ";
    $tbl_name="sys_portal_k8";
    get_data($tbl_name, $where_clause, $info);
    // show_array($info); //content

?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/search.css">
</head>

<body class="termsPage">
    <?php
        include "quote/template/added.php";
        include "quote/template/nav.php";
    ?>
    <div id="Wrapper">
        <main role="main">
            <div class="sh-banner">
                <img class="pc" src="dist/images/terms/line_1_pc.png">
                <img class="mo" src="dist/images/terms/line_1_mb.png">
                <div class="container">
                    <h2>
                        <div class="e-ti">TERMS</div>
                        <div class="t-ti">本站條款</div>
                    </h2>
                </div>
            </div>
            <section class="item1">
                <div class="container">
                    <div class="it1-bx">
                        <div class="editor_Content edobx">
                            <div class="editor_box pc_use">
                                <?=$info['html_field_0']?>
                            </div>
                            <div class="editor_Box mo_use">
                                <?=$info['html_field_1']?>
                            </div>
                        </div>
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