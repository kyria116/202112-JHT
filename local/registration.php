<?php include "quote/template/head.php"; ?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/registration.css">
</head>

<body class="registrationPage">
    <?php
        include "quote/template/added.php";
        include "quote/template/nav.php";
    ?>
    <div id="Wrapper">
        <main role="main">
            <div class="sh-banner">
                <!-- 1025 -->
                <img class="pc" src="dist/images/registration/line_1_pc.png">
                <img class="mo" src="dist/images/registration/line_1_mb.png">
                <div class="container">
                    <h2>
                        <div class="e-ti">REGISTER</div>
                        <div class="t-ti">會員註冊</div>
                    </h2>
                </div>
            </div>
            <section class="item1">
                <div class="container">
                    <div class="form-bx">
                        <form>
                            <div class="flex-bx">
                                <div class="form-group">
                                    <label for=""><span>*</span>姓名</label>
                                    <input type="text" required placeholder="請輸入真實姓名">
                                    <div class="help-block with-errors">必填</div>
                                </div>
                                <div class="form-group">
                                    <label for=""><span>*</span>帳號</label>
                                    <input type="text" required placeholder="請輸入常用Email">
                                    <div class="help-block with-errors">必填</div>
                                </div>
                            </div>
                            <div class="flex-bx">
                                <div class="form-group">
                                    <label for=""><span>*</span>密碼設定</label>
                                    <input type="password" required placeholder="至少6字元以上">
                                    <div class="help-block with-errors">至少6字元以上</div>
                                </div>
                                <div class="form-group">
                                    <label for=""><span>*</span>密碼確認</label>
                                    <input type="password" required placeholder="請再次輸入密碼">
                                    <div class="help-block with-errors">與密碼不符</div>
                                </div>
                            </div>
                            <div class="flex-bx">
                                <div class="form-group radio-group">
                                    <label for=""><span>*</span>性別</label>
                                    <div class="radio-flex">
                                        <div class="form-radio">
                                            <input type="radio" required="" id="g-1" name="gender" checked="true">
                                            <label for="g-1">
                                                男
                                            </label>
                                        </div>
                                        <div class="form-radio">
                                            <input type="radio" required="" id="g-2" name="gender">
                                            <label for="g-2">
                                                女
                                            </label>
                                        </div>
                                    </div>
                                    <select class="shopsel">
                                        <option value="N">請選擇網路平台</option>
                                        <option value="Google">Google</option>
                                    </select>
                                    <div class="help-block with-errors">必填</div>
                                </div>
                                <div class="form-group">
                                    <label for=""><span>*</span>生日</label>
                                    <input type="date" required>
                                    <div class="help-block with-errors">與密碼不符</div>
                                </div>
                            </div>
                            <div class="flex-bx">
                                <div class="form-group">
                                    <label for=""><span>*</span>手機</label>
                                    <input type="tel" required placeholder="請輸入手機號碼：例0912345678">
                                    <div class="help-block with-errors">必填</div>
                                </div>
                                <div class="form-group">
                                    <label for=""><span></span>市內電話</label>
                                    <div class="tel-bx">
                                        <!-- 1025 -->
                                        <input type="text" placeholder="區域號">
                                        <input type="tel" placeholder="請輸入市內電話">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ad-group">
                                <label for=""><span></span>地址</label>
                                <div class="flex">
                                    <div id="twzipcode"></div>
                                    <input type="text" placeholder="請輸入地址">
                                </div>
                            </div>
                            <div class="flex-btn">
                                <div class="">
                                    <div class="checkbox">
                                        <input type="checkbox" name="agree" value="1" id="agree" required>
                                        <label for="agree">
                                            <p>我同意<a href="terms.php" target="_blank">JHT相關條款</a></p>
                                        </label>
                                    </div>
                                    <div id="agree_str" style="margin-left: 3em;" class="help-block with-errors">*請詳閱JHT相關條款</div>
                                </div>
                                <a href="login.php" class="sh-btn send-btn">
                                    <div class="ar"></div>
                                    註冊
                                </a>
                            </div>
                           
                        </form>
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
        })
    </script>
</body>

</html>