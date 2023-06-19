<?php include "quote/template/head.php"; ?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/registration.css">
</head>

<body class="memberorderPage">
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
                        <div class="ti-bx">
                            <div class="d1">
                                訂單日期
                            </div>
                            <div class="d2">
                                訂單編號
                            </div>
                            <div class="d3">
                                訂單金額
                            </div>
                            <div class="d4">
                                付款方式
                            </div>
                            <div class="d5">
                                訂單狀態
                            </div>
                        </div>
                        <!-- 黑色 (預設) - 待出貨、已出貨、退貨中-->
                        <!-- 藍色 (.blue) - 訂單完成 -->
                        <!-- 橘色 (.org) - 待付款 -->
                        <!-- 灰色 (.grey) - 訂單取消  -->
                        <ul>
                            <li>
                                <div class="d1">
                                    <div class="center-bx">
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
                                        <span class="mo">訂單金額</span>
                                        <span>$520,800</span>
                                    </div>
                                </div>
                                <div class="d4">
                                    <div class="center-bx">
                                        <span class="mo">付款方式</span>
                                        <span>ATM繳費</span>
                                    </div>
                                </div>
                                <div class="d5">
                                    <div class="center-bx">
                                        <span class="mo">訂單狀態</span>
                                        <span class="">待出貨</span>
                                    </div>
                                </div>
                                <a class="see-btn" href="order-detail.php">
                                    <span>查看</span>
                                </a>
                            </li>
                            <li>
                                <div class="d1">
                                    <div class="center-bx">
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
                                        <span class="mo">訂單金額</span>
                                        <span>$520,800</span>
                                    </div>
                                </div>
                                <div class="d4">
                                    <div class="center-bx">
                                        <span class="mo">付款方式</span>
                                        <span>ATM繳費</span>
                                    </div>
                                </div>
                                <div class="d5">
                                    <div class="center-bx">
                                        <span class="mo">訂單狀態</span>
                                        <span class="blue">訂單完成</span>
                                    </div>
                                </div>
                                <a class="see-btn" href="order-detail.php">
                                    <span>查看</span>
                                </a>
                            </li>
                            <li>
                                <div class="d1">
                                    <div class="center-bx">
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
                                        <span class="mo">訂單金額</span>
                                        <span>$520,800</span>
                                    </div>
                                </div>
                                <div class="d4">
                                    <div class="center-bx">
                                        <span class="mo">付款方式</span>
                                        <span>ATM繳費</span>
                                    </div>
                                </div>
                                <div class="d5">
                                    <div class="center-bx">
                                        <span class="mo">訂單狀態</span>
                                        <span class="org">待付款</span>
                                    </div>
                                </div>
                                <a class="see-btn" href="order-detail.php">
                                    <span>查看</span>
                                </a>
                            </li>
                            <li>
                                <div class="d1">
                                    <div class="center-bx">
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
                                        <span class="mo">訂單金額</span>
                                        <span>$520,800</span>
                                    </div>
                                </div>
                                <div class="d4">
                                    <div class="center-bx">
                                        <span class="mo">付款方式</span>
                                        <span>ATM繳費</span>
                                    </div>
                                </div>
                                <div class="d5">
                                    <div class="center-bx">
                                        <span class="mo">訂單狀態</span>
                                        <span class="">已出貨</span>
                                    </div>
                                </div>
                                <a class="see-btn" href="order-detail.php">
                                    <span>查看</span>
                                </a>
                            </li>
                            <li>
                                <div class="d1">
                                    <div class="center-bx">
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
                                        <span class="mo">訂單金額</span>
                                        <span>$520,800</span>
                                    </div>
                                </div>
                                <div class="d4">
                                    <div class="center-bx">
                                        <span class="mo">付款方式</span>
                                        <span>ATM繳費</span>
                                    </div>
                                </div>
                                <div class="d5">
                                    <div class="center-bx">
                                        <span class="mo">訂單狀態</span>
                                        <span class="">退貨中</span>
                                    </div>
                                </div>
                                <a class="see-btn" href="order-detail.php">
                                    <span>查看</span>
                                </a>
                            </li>
                            <li>
                                <div class="d1">
                                    <div class="center-bx">
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
                                        <span class="mo">訂單金額</span>
                                        <span>$520,800</span>
                                    </div>
                                </div>
                                <div class="d4">
                                    <div class="center-bx">
                                        <span class="mo">付款方式</span>
                                        <span>ATM繳費</span>
                                    </div>
                                </div>
                                <div class="d5">
                                    <div class="center-bx">
                                        <span class="mo">訂單狀態</span>
                                        <span class="grey">訂單取消</span>
                                    </div>
                                </div>
                                <a class="see-btn" href="order-detail.php">
                                    <span>查看</span>
                                </a>
                            </li>
                            <li>
                                <div class="d1">
                                    <div class="center-bx">
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
                                        <span class="mo">訂單金額</span>
                                        <span>$520,800</span>
                                    </div>
                                </div>
                                <div class="d4">
                                    <div class="center-bx">
                                        <span class="mo">付款方式</span>
                                        <span>ATM繳費</span>
                                    </div>
                                </div>
                                <div class="d5">
                                    <div class="center-bx">
                                        <span class="mo">訂單狀態</span>
                                        <span class="blue">訂單完成</span>
                                    </div>
                                </div>
                                <a class="see-btn" href="order-detail.php">
                                    <span>查看</span>
                                </a>
                            </li>
                        </ul>
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