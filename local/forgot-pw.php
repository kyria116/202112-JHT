<?php include "quote/template/head.php"; ?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/registration.css">
</head>

<body class="forgotPage">
    <?php
        include "quote/template/added.php";
        include "quote/template/nav.php";
    ?>
    <div id="Wrapper">
        <main role="main">
            <div class="sh-banner">
                <img class="pc" src="dist/images/forgot/line_1_pc.png">
                <img class="mo" src="dist/images/forgot/line_1_mb.png">
                <div class="container">
                    <h2>
                        <div class="e-ti">FORGOT <br class="mo"> PASSWORD</div>
                        <div class="t-ti">忘記密碼</div>
                    </h2>
                </div>
            </div>
            <section class="item1">
                <div class="container">
                    <div class="it1-bx">
                        <div class="l-bx">
                            <img src="dist/images/forgot/illustration.png">
                        </div>
                        <div class="form-bx">
                            <div class="form-ti">
                                <div class="f16">
                                    系統將寄送臨時密碼至您的Email<br>
                                    因安全性考量，建議登入後立即更改密碼
                                </div>
                            </div>
                            <form>
                                <div class="form-group">
                                    <label for=""><span>*</span>帳號</label>
                                    <input type="email" required placeholder="請輸入您註冊的Email">
                                    <div class="help-block with-errors">請輸入正確格式Email</div>
                                </div>
                                <a href="javascript:;" class="sh-btn send-btn">
                                    <div class="ar"></div>
                                    送出
                                </a>
                            </form>
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