<?php include "quote/template/head.php"; ?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/registration.css">
</head>

<body class="memberprofilePage">
    <?php
        include "quote/template/added.php";
        include "quote/template/nav.php";
    ?>
    <div id="Wrapper">
        <main role="main">
            <div class="sh-banner">
                <img class="pc" src="dist/images/member/line_1_pc.png">
                <img class="mo" src="dist/images/member/line_1_mb.png">
                <div class="container">
                    <h2>
                        <div class="e-ti">member</div>
                        <div class="t-ti">會員專區</div>
                    </h2>
                </div>
            </div>
            <section class="item1">
                <div id="top-menu-ul">
                    <div class="container">
                        <div class="item_Menu">
                            <div class="item_menu_Box">
                                <ul class="item_menu_list slides">
                                    <li class="active">
                                        <a href="member-profile.php">
                                            <div class="f16">
                                                <span>會員資料</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="member-order.php">
                                            <div class="f16">
                                                <span>訂單紀錄</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="warranty-login.php">
                                            <div class="f16">
                                                <span>保固登錄</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="flex-direction-nav">
                            <a href="#" class="flex-prev"></a>
                            <a href="#" class="flex-next"></a>
                        </div>
                    </div>
                </div>
            </section>
            <section class="item2">
                <div class="container">
                    <div class="it2-bx">
                        <div class="l-bx">
                            <div class="img-bx">
                                <img src="dist/images/member/img_m.png">
                            </div>
                            <div class="name-bx">
                                <div class="name">康杰西</div>
                                <a href="edit-password.php">
                                    <span>
                                        <div class="img-bx">
                                            <img class="unhov" src="dist/images/member/icon.png">
                                            <img class="hov" src="dist/images/member/hovicon.png">
                                        </div>
                                        修改密碼
                                    </span>
                                </a>
                            </div>
                            <div class="da-bx">
                                <div class="f16">
                                    <i>男</i><span>1988.8.8</span>
                                </div>
                                <div class="f16">
                                    jht27936618@gmail.com
                                </div>
                            </div>
                            <div class="pric-bx">
                                <div class="f16">購物金</div>
                                <div class="price">1,000</div>
                            </div>
                        </div>
                        <div class="form-bx">
                            <form>
                                <div class="form-group">
                                    <label for=""><span>*</span>手機</label>
                                    <input type="tel" required placeholder="請輸入手機號碼：例0912345678">
                                    <div class="help-block with-errors">必填</div>
                                </div>
                                <div class="form-group">
                                    <label for="">市內電話</label>
                                    <div class="tel-bx">
                                        <input type="text" required placeholder="區域號">
                                        <input type="tel" required placeholder="請輸入市內電話">
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group ad-group">
                                    <label for="">地址</label>
                                    <div class="flex">
                                        <div id="twzipcode"></div>
                                        <input type="text" required placeholder="請輸入地址">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <a href="javascript:;" class="sh-btn send-btn">
                                    <div class="ar"></div>
                                    儲存變更
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
    </script>
</body>

</html>