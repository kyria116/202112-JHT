<?php include "quote/template/head.php"; ?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/registration.css">
</head>

<body class="orderdetailPage">
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
                                    <li>
                                        <a href="member-profile.php">
                                            <div class="f16">
                                                <span>會員資料</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="active">
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
                        <div class="b-ti">
                            訂單明細
                        </div>
                        <div class="ti-bx">
                            <div class="d1">
                                訂單日期
                            </div>
                            <div class="d2">
                                訂單編號
                            </div>
                            <div class="d3">
                                訂單狀態
                            </div>
                        </div>
                        <ul>
                            <li>
                                <div class="d1">
                                    <div class="center-bx">
                                        <span class="mo">訂單日期</span>
                                        <span>2021 . 03 . 01</span>
                                    </div>
                                </div>
                                <div class="d2">
                                    <div class="center-bx">
                                        <span class="mo">訂單編號</span>
                                        <span>1234567890</span>
                                    </div>
                                </div>
                                <div class="d3">
                                    <div class="center-bx">
                                        <span class="mo">訂單狀態</span>
                                        <span class="grey">待出貨</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
            <section class="item3">
                <div class="container">
                    <div class="it3-bx">
                        <div class="b-ti">
                            購物清單
                        </div>
                        <div class="ti-bx">
                            <div class="d1">購買產品</div>
                            <div class="d2">規格</div>
                            <div class="d3">數量</div>
                            <div class="d4">單價</div>
                            <div class="d5">小計</div>
                            <div class="d6"></div>
                        </div>
                        <ul class="cart-list">
                            <li>
                                <div class="t-flexbx">
                                    <div class="d1">
                                        <div class="img-bx">
                                            <img src="dist/images/cart/c_big_img.jpg" alt="">
                                        </div>
                                        <div class="des-bx">
                                            <div class="num">K-1631-WT</div>
                                            <div class="name">4D深捏臀感按摩椅 </div>
                                            <div class="act">
                                                <span>七夕情人節優惠活動<i>77</i>折</span>
                                                <span>滿1000免運</span>
                                            </div>
                                        </div>
                                    </div>    
                                    <div class="d2">
                                        <div class="mo moti">
                                            規格
                                        </div>
                                        <div class="tx">
                                            雪花白
                                        </div>
                                    </div>
                                    <div class="d3">
                                        <div class="mo moti">
                                            數量
                                        </div>
                                        <div class="tx">
                                            1
                                        </div>
                                    </div>
                                    <div class="d4">
                                        <div class="price-bx">
                                            <div class="mo moti">
                                                單價
                                            </div>
                                            <div class="f20">
                                                <span>520,800</span>
                                            </div>
                                        </div>
                                        <div class="total-bx">
                                            <div class="mo moti">
                                                小計
                                            </div>
                                            <div class="f20">
                                                <span>520,800</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d5">
                                        
                                    </div>
                                </div>
                                <div class="bot-item">
                                    <div class="p-item">
                                        <div class="tag">加購產品</div>
                                        <div class="p1">
                                            <div class="simg-bx">
                                                <img src="dist/images/cart/c_big_img.jpg" alt="">
                                            </div>
                                            <div class="tx-bx">
                                                <div class="name">舞動抖抖機</div>
                                                <div class="f20">
                                                    <span>520,800</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d5">
                                        </div>
                                    </div>
                                    <div class="p-item">
                                        <div class="tag">加購產品</div>
                                        <div class="p1">
                                            <div class="simg-bx">
                                                <img src="dist/images/cart/c_big_img.jpg" alt="">
                                            </div>
                                            <div class="tx-bx">
                                                <div class="name">舞動抖抖機</div>
                                                <div class="f20">
                                                    <span>520,800</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d5">
                                        </div>
                                    </div>
                                </div>
                            </li>
                           
                           
                        </ul>
                    </div>
                </div>
            </section>
            <section class="item4">
                <div class="container">
                    <div class="it4-bx">
                        <div class="l-bx">
                            <div class="use-price">
                                <div class="ti f18">使用購物金</div>
                                <div class="des f16">1000</div>
                            </div>
                            <div class="use-price">
                                <div class="ti f18">使用折扣碼</div>
                                <div class="des f16">TCAA123</div>
                            </div>
                            <div class="promo-bx">
                                <div class="ti f18">優惠活動</div>
                                <div class="tx-bx">
                                    <div>七夕情人節優惠活動77折</div>
                                    <div>滿<span>1000</span>免運</div>
                                    <div class="g-tx">
                                        滿一件送好禮贈送黑金刮痧按摩椅(不適用)
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="r-bx">
                            <ul>
                                <li>
                                    <div>總計</div>
                                    <div>524,780</div>
                                </li>
                                <li>
                                    <div>優惠折抵</div>
                                    <div>-120,700</div>
                                </li>
                                <li>
                                    <div>購物金折抵</div>
                                    <div>-1000</div>
                                </li>
                                <li>
                                    <div>折扣碼折抵</div>
                                    <div>0</div>
                                </li>
                                <li>
                                    <div>滿額優惠折抵</div>
                                    <div>0</div>
                                </li>
                                <li>
                                    <div>運費</div>
                                    <div>0</div>
                                </li>
                                <li>
                                    <div>應付金額</div>
                                    <div>403,080</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <section class="item5">
                <div class="container">
                    <div class="b-ti">
                        收件人資料
                    </div>
                    <div class="it5-bx">
                        <div class="l-bx">
                            <ul>
                                <li>
                                    <div class="ti">姓名</div>
                                    <div class="des">康杰西</div>
                                </li>
                                <li>
                                    <div class="ti">手機</div>
                                    <div class="des">0912345678</div>
                                </li>
                                <li>
                                    <div class="ti">Email</div>
                                    <div class="des">jht27936618@gmail.com</div>
                                </li>
                                <li>
                                    <div class="ti">市內電話</div>
                                    <div class="des"></div>
                                </li>
                                <li>
                                    <div class="ti">地址</div>
                                    <div class="des">花蓮縣吉安鄉中華路2段58號</div>
                                </li>
                                <li>
                                    <div class="ti">備註</div>
                                    <div class="des"></div>
                                </li>
                            </ul>
                        </div>
                        <div class="r-bx">
                            <!-- 二聯 -->
                            <!-- <ul>
                                <li>
                                    <div class="ti">
                                        發票資訊
                                    </div>
                                    <div class="des">
                                        二聯式
                                        <span>
                                            <i class="black">GX30001470</i>
                                            (<i>2021-05-30  19:20:01</i>開立)
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <div class="ti">
                                        發票地址
                                    </div>
                                    <div class="des">
                                        花蓮縣吉安鄉中華路2段58號
                                    </div>
                                </li>
                                <li>
                                    <div class="ti">
                                        付款方式
                                    </div>
                                    <div class="des">
                                        信用卡付款
                                    </div>
                                </li>
                            </ul> -->
                            <!-- 三聯 -->
                            <!-- <ul>
                                <li>
                                    <div class="ti">
                                        發票資訊
                                    </div>
                                    <div class="des">
                                        三聯式
                                        <span>
                                            <i class="black">GX30001470</i>
                                            (<i>2021-05-30  19:20:01</i>開立)
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <div class="ti">
                                        發票地址
                                    </div>
                                    <div class="des">
                                        花蓮縣吉安鄉中華路2段58號
                                    </div>
                                </li>
                                <li>
                                    <div class="ti">
                                        公司抬頭
                                    </div>
                                    <div class="des">
                                        杰西健康科技股份有限公司
                                    </div>
                                </li>
                                <li>
                                    <div class="ti">
                                        公司統編
                                    </div>
                                    <div class="des">
                                        0123456789
                                    </div>
                                </li>
                                <li>
                                    <div class="ti">
                                        付款方式
                                    </div>
                                    <div class="des">
                                        超商代碼
                                    </div>
                                </li>
                                <li>
                                    <div class="ti">
                                        付款資訊
                                    </div>
                                    <div class="des">
                                        LLL21172540
                                    </div>
                                </li>
                            </ul> -->
                            <!-- 超商 -->
                            <ul>
                                <li>
                                    <div class="ti">
                                        發票資訊
                                    </div>
                                    <div class="des">
                                        雲端發票
                                        <span>
                                            <i class="black">GX30001470</i>
                                            (<i>2021-05-30  19:20:01</i>開立)
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <div class="ti">
                                        付款方式
                                    </div>
                                    <div class="des">
                                        超商條碼
                                    </div>
                                </li>
                                <li>
                                    <div class="ti">
                                        付款資訊
                                    </div>
                                    <div class="des">
                                        <div class="img-bx">
                                            <img src="dist/images/order/img.png">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <!-- ATM -->
                            <!-- <ul>
                                <li>
                                    <div class="ti">
                                        發票資訊
                                    </div>
                                    <div class="des">
                                        雲端發票
                                        <span>
                                            <i class="black">GX30001470</i>
                                            (<i>2021-05-30  19:20:01</i>開立)
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <div class="ti">
                                        發票地址
                                    </div>
                                    <div class="des">
                                        ATM虛擬代碼繳費
                                    </div>
                                </li>
                                <li>
                                    <div class="ti">
                                        付款資訊
                                    </div>
                                    <div class="des">
                                        銀行:<i class="black">台新銀行</i><br>
                                        代碼:<i class="black">812</i><br>
                                        帳號:<i class="black">1234678910236</i>
                                    </div>
                                </li>
                            </ul> -->
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