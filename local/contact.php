<?php include "quote/template/head.php"; ?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/contact.css">
</head>

<body class="contactPage">
    <?php
        include "quote/template/added.php";
        include "quote/template/nav.php";
    ?>
    <div id="Wrapper">
        <main role="main">
            <div class="sh-banner">
                <img class="pc" src="dist/images/contact/line_1_pc.png">
                <img class="mo" src="dist/images/contact/line_1_mb.png">
                <div class="container">
                    <h2>
                        <div class="e-ti">contact</div>
                        <div class="t-ti">聯絡我們</div>
                    </h2>
                </div>
            </div>
            <section class="item1">
                <div class="container">
                    <div class="it1-bx">
                        <div class="l-bx">
                            <div class="des-ti">
                                感謝您拜訪JHT健康科技，如果您有任何疑問或意見！<br class="pc">
                                為了提供您更完善的服務，請務必輸入正確的資料，謝謝您。
                            </div>
                            <div class="img-bx">
                                <img src="dist/images/contact/illustration.png">
                            </div>
                        </div>
                        <div class="r-bx">
                            <div class="form-bx">
                                <form>
                                    <div class="flex-bx">
                                        <div class="form-group">
                                            <label for=""><span>*</span>姓名</label>
                                            <input type="text" required placeholder="請輸入真實姓名">
                                            <div class="help-block with-errors">必填</div>
                                        </div>
                                        <div class="form-group">
                                            <label for=""><span>*</span>手機</label>
                                            <input type="tel" required placeholder="請輸入手機號碼：例0912345678">
                                            <div class="help-block with-errors">必填</div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><span>*</span>Email</label>
                                        <input type="email" required placeholder="請輸入常用Email">
                                        <div class="help-block with-errors">請輸入正確格式Email</div>
                                    </div>
                                    <div class="form-group radio-group">
                                        <label for=""><span>*</span>聯絡事項</label>
                                        <div class="radio-flex">
                                            <div class="form-radio">
                                                <input type="radio" required="" id="c-1" name="con" checked="true">
                                                <label for="c-1">
                                                    購買問題
                                                </label>
                                            </div>
                                            <div class="form-radio">
                                                <input type="radio" required="" id="c-2" name="con">
                                                <label for="c-2">
                                                    維修問題
                                                </label>
                                            </div>
                                            <div class="form-radio">
                                                <input type="radio" required="" id="c-3" name="con">
                                                <label for="c-3">
                                                    商品退/換貨
                                                </label>
                                            </div>
                                            <div class="form-radio">
                                                <input type="radio" required="" id="c-4" name="con">
                                                <label for="c-4">
                                                    合作需求
                                                </label>
                                            </div>
                                            <div class="form-radio w100">
                                                <input type="radio" required="" id="c-5" name="con">
                                                <label for="c-5">
                                                    其他
                                                </label>
                                                <input type="text" placeholder="請輸入內容">
                                            </div>
                                        </div>
                                        <select class="shopsel">
                                            <option value="N">請選擇網路平台</option>
                                            <option value="Google">Google</option>
                                        </select>
                                        <div class="help-block with-errors">必填</div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><span>*</span>內容</label>
                                        <textarea placeholder="請輸入內容 "></textarea>
                                        <div class="help-block with-errors">必填</div>
                                    </div>
                                    <a href="javascript:;" class="sh-btn send-btn">
                                        <div class="ar"></div>
                                        送出
                                    </a>
                                </form>
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