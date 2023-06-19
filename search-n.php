<?php include "quote/template/head.php"; ?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/search.css">
</head>

<body class="searchPage">
    <?php
        include "quote/template/added.php";
        include "quote/template/nav.php";
    ?>
    <div id="Wrapper">
        <main role="main">
            <div class="sh-banner">
                <img class="pc" src="dist/images/search/line_1_pc.png">
                <img class="mo" src="dist/images/search/line_1_mb.png">
                <div class="container">
                    <h2>
                        <div class="e-ti">search</div>
                        <div class="t-ti">搜尋結果</div>
                    </h2>
                </div>
            </div>
            <section class="item1">
                <div class="container">
                    <div class="it1-bx">
                        <div class="search-bx">
                            <input type="text">
                            <a href="javascript:;">
                                <img src="dist/images/search/serch_icon_b_.png">
                            </a>
                        </div>
                        <div id="top-menu-ul">
                            <div class="item_Menu">
                                <div class="item_menu_Box">
                                    <ul class="item_menu_list slides">
                                        <li>
                                            <a href="search.php">
                                                <div class="f16">
                                                    <span>系列商品</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="active">
                                            <a href="search-n.php">
                                                <div class="f16">
                                                    <span>活動消息</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="search-v.php">
                                                <div class="f16">
                                                    <span>精彩影音</span>
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
                </div>
            </section>
            <section class="item2">
                <div class="container">
                    <ul class="news-list">
                        <li>
                            <a href="news-detail.php">
                                <div class="da-bx">
                                    <div class="ty">
                                        最新消息
                                    </div>
                                    <div class="da">
                                        2021 .03 .01
                                    </div>
                                </div>
                                <div class="des-bx">
                                    <div class="img-bx">
                                        <div class="bgcover" style="background:url(dist/images/g_4.jpg) center center"></div>
                                    </div>
                                    <div class="des-ti f24">
                                        完成JHT售後語音調查，即有機會抽獎
                                    </div>
                                    <div class="des f16">
                                        生完了三個小孩後，時間早就已經不是自己的。每天從起床開始，似乎一刻不得閒的開始忙小孩，沒時間幫自己買衣服、沒時間打扮，沒辦法跟朋友出門、甚至沒辦法睡超
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="news-detail.php">
                                <div class="da-bx">
                                    <div class="ty">
                                        最新消息
                                    </div>
                                    <div class="da">
                                        2021 .03 .01
                                    </div>
                                </div>
                                <div class="des-bx">
                                    <div class="img-bx">
                                        <div class="bgcover" style="background:url(dist/images/g_4.jpg) center center"></div>
                                    </div>
                                    <div class="des-ti f24">
                                        完成JHT售後語音調查，即有機會抽獎
                                    </div>
                                    <div class="des f16">
                                        生完了三個小孩後，時間早就已經不是自己的。每天從起床開始，似乎一刻不得閒的開始忙小孩，沒時間幫自己買衣服、沒時間打扮，沒辦法跟朋友出門、甚至沒辦法睡超
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
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