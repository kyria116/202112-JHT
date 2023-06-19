<?php include "quote/template/head.php"; ?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/registration.css">
</head>

<body class="loginPage">
    <?php
        include "quote/template/added.php";
        include "quote/template/nav.php";
    ?>
    <div id="Wrapper">
        <main role="main">
            <div class="sh-banner">
                <img class="pc" src="dist/images/login/line_1_pc.png">
                <img class="mo" src="dist/images/login/line_1_mb.png">
                <div class="container">
                    <h2>
                        <div class="e-ti">LOG IN</div>
                        <div class="t-ti">會員登入</div>
                    </h2>
                </div>
            </div>
            <section class="item1">
                <div class="container">
                    <div class="link-flex">
                        <a href="registration.php">
                            立即註冊
                        </a>
                        <a href="forgot-pw.php">
                            忘記密碼
                        </a>
                    </div>
                    <div class="it1-bx">
                        <div class="l-bx">
                            <img src="dist/images/login/illustration.png">
                        </div>
                        <div class="link-flex mo">
                            <a href="registration.php">
                                立即註冊
                            </a>
                            <a href="forgot-pw.php">
                                忘記密碼
                            </a>
                        </div>
                        <div class="form-bx">
                            <form>
                                <div class="form-group">
                                    <label for=""><span>*</span>帳號</label>
                                    <input type="text" required placeholder="請輸入您註冊的Email">
                                    <div class="help-block with-errors">請輸入正確格式Email</div>
                                </div>
                                <div class="form-group">
                                    <label for=""><span>*</span>密碼</label>
                                    <input type="password" required placeholder="請輸入密碼">
                                    <div class="help-block with-errors">請輸入密碼</div>
                                </div>
                                <a href="member-profile.php" class="sh-btn send-btn">
                                    <div class="ar"></div>
                                    登入
                                </a>
                            </form>
                            <div class="group-login">
                                <a href="javascript:;" target="_blank">
                                    <div class="img-bx">
                                        <img src="dist/images/login/google_bt.png">
                                    </div>
                                    <div class="tx">
                                        使用Google<br class="pc">
                                        帳號登入
                                    </div>
                                </a>
                                <a href="javascript:;" target="_blank">
                                    <div class="img-bx">
                                        <img src="dist/images/login/fb_bt.png">
                                    </div>
                                    <div class="tx">
                                        使用Facebook<br class="pc">
                                        帳號登入
                                    </div>
                                </a>
                                <a href="javascript:;" target="_blank">
                                    <div class="img-bx">
                                        <img src="dist/images/login/line_btn.png">
                                    </div>
                                    <div class="tx">
                                        使用LINE<br class="pc">
                                        帳號登入
                                    </div>
                                </a>
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