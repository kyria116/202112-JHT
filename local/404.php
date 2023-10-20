<?php include "quote/template/head.php"; ?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/registration.css">
</head>

<body class="paysuccessulPage nofoundPage">
    <?php
        include "quote/template/added.php";
        include "quote/template/nav.php";
    ?>
    <div id="Wrapper">
        <main role="main">
            <div class="sh-banner">
                <img class="pc" src="dist/images/404/line_1_pc.png">
                <img class="mo" src="dist/images/404/line_1_mb.png">
                <div class="container">
                    <h2>
                        <div class="e-ti">404 <br class="mo"> not found</div>
                        <div class="t-ti">查無此頁</div>
                    </h2>
                </div>
            </div>
            <section class="item1">
                <div class="container">
                    <div class="it1-bx">
                        <div class="l-bx">
                            <img src="dist/images/404/illustration.png">
                        </div>
                        <div class="form-bx">
                            <div class="form-ti">
                                <div class="f16">
                                    很抱歉！無法找到您所連結的頁面 <br> 歡迎您返回首頁，繼續您的瀏覽
                                </div>
                            </div>
                            <a href="./" class="sh-btn send-btn">
                                <div class="ar"></div>
                                回首頁
                            </a>
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
    <script src="dist/js/jquery.twzipcode.min.js"></script>
    <script>
          $("#twzipcode").twzipcode({
            onCountySelect: function() {
            if($(this).val() == ""){
                $("#county").addClass('nonsel');
                $("#district").removeClass('nonsel');
            }else {
                    $("#county").removeClass('nonsel');
                    $("#district").addClass('nonsel');
                }
            },
            zipcodeIntoDistrict: true,
            });

            $('#demand,#status,#contacttime').change(function(){
            $(this).addClass('chcol');
        })
    </script>
</body>

</html>