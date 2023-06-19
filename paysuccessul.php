<?php include "quote/template/head.php"; ?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/registration.css">
</head>

<body class="paysuccessulPage">
    <?php
        include "quote/template/added.php";
        include "quote/template/nav.php";
    ?>
    <div id="Wrapper">
        <main role="main">
            <div class="sh-banner">
                <img class="pc" src="dist/images/pay/line_1_pc.png">
                <img class="mo" src="dist/images/pay/line_1_mb.png">
                <div class="container">
                    <h2>
                        <div class="e-ti">PAY <br class="mo"> SUCCESSFUL</div>
                        <div class="t-ti">購物成功</div>
                    </h2>
                </div>
            </div>
            <section class="item1">
                <div class="container">
                    <div class="it1-bx">
                        <div class="l-bx">
                            <img src="dist/images/pay/illustration.png">
                        </div>
                        <div class="form-bx">
                            <div class="form-ti">
                                <div class="f16">
                                    您已完成訂購   訂單編號為 <span>210207001</span>
                                    <br>
                                    感謝您對JHT的支持!
                                </div>
                                <div class="f14">
                                    本公司保留接受訂單與否的權利，若因交易條件有誤、商品無庫存或有其他本公司無法接受訂單之情形，本公司將以email通知您訂單不成立/取消訂單。
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