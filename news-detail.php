<?php include "quote/template/head.php"; ?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/news.css">
</head>

<body class="newsdetailPage">
    <?php
        include "quote/template/added.php";
        include "quote/template/nav.php";
    ?>
    <div id="Wrapper">
        <main role="main">
            <div class="sh-banner">
                <img class="pc" src="dist/images/news/line_1_pc.png">
                <img class="mo" src="dist/images/news/line_1_mb.png">
                <div class="container">
                    <h2>
                        <div class="e-ti">NEWS</div>
                        <div class="t-ti">活動消息</div>
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
                                        <a href="news.php">
                                            <div class="f16">
                                                <span>全部</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="news.php">
                                            <div class="f16">
                                                <span>最新消息</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="news.php">
                                            <div class="f16">
                                                <span>最新消息</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="news.php">
                                            <div class="f16">
                                                <span>最新消息</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="news.php">
                                            <div class="f16">
                                                <span>最新消息</span>
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
                        <div class="da-bx">
                            <div class="da">
                                2021 .03 .01
                            </div>
                            <div class="ty">
                                最新消息
                            </div>
                        </div>
                        <div class="des-ti f24">
                        【JHT年度代言人】 謝祖武x武哥
                        </div>
                        <div class="flex-bx">
                            <a href="search-n.php" class="hastag">#JHT杰西健康科技</a>
                            <a href="search-n.php" class="hastag">#JHT代言人</a>
                            <a href="search-n.php" class="hastag">#JHT代言人</a>
                            <a href="search-n.php" class="hastag">#JHT代言人</a>
                        </div>
                        
                        <div class="editor_Content in_fade active">
                            <div class="editor_box pc_use">
                                <p>測試</p>
                                <p>測試</p>
                                <p>測試</p>
                            </div>
                            <div class="editor_Box mo_use">
                                <p>測試2</p>
                                <p>測試2</p>
                                <p>測試2</p>
                            </div>
                        </div>
                        <a href="javascript:window.history.back();" class="sh-btn">
                            <div class="ar"></div>
                            BACK
                        </a>
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