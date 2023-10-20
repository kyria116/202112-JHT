<?php include "quote/template/head.php"; ?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/registration.css">
</head>

<body class="editPage">
    <?php
        include "quote/template/added.php";
        include "quote/template/nav.php";
    ?>
    <div id="Wrapper">
        <main role="main">
            <div class="sh-banner">
                <img class="pc" src="dist/images/edit/line_1_pc.png">
                <img class="mo" src="dist/images/edit/line_1_mb.png">
                <div class="container">
                    <h2>
                        <div class="e-ti">edit <br class="mo"> password</div>
                        <div class="t-ti">密碼修改</div>
                    </h2>
                </div>
            </div>
            <section class="item1">
                <div class="container">
                    <div class="it1-bx">
                        <div class="l-bx">
                            <img src="dist/images/edit/illustration.png">
                        </div>
                        <div class="form-bx">
                            <form>
                                <div class="form-group">
                                    <label for=""><span>*</span>原密碼</label>
                                    <input type="password" required placeholder="請輸入原密碼">
                                    <div class="help-block with-errors">請輸入原密碼</div>
                                </div>
                                <div class="form-group">
                                    <label for=""><span>*</span>新密碼</label>
                                    <input type="password" required placeholder="至少6字元以上">
                                    <div class="help-block with-errors">至少6字元以上</div>
                                </div>
                                <div class="form-group">
                                    <label for=""><span>*</span>確認新密碼</label>
                                    <input type="password" required placeholder="請再次輸入新密碼">
                                    <div class="help-block with-errors">與新密碼不符</div>
                                </div>
                                <a href="javascript:;" class="sh-btn send-btn">
                                    <div class="ar"></div>
                                    密碼修改
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
</body>

</html>