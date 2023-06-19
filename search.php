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
                                        <li class="active">
                                            <a href="search.php">
                                                <div class="f16">
                                                    <span>系列商品</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
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
                    <!-- 查無頁面顯示 -->
                    <div class="it1-bx">
                        <div class="form-bx">
                            <div class="form-ti">
                                <div class="f16">
                                    查無資料
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 搜尋頁面顯示 -->
                    <!-- <ul class="product-list four-list">
                        <li>
                            <a href="product-detail.php">
                                <div class="tag red">
                                    HOT
                                </div>
                                <div class="img-bx">
                                    <img src="dist/images/product/item1.jpg">
                                </div>
                                <div class="des-bx">
                                    <div class="tx-bx">
                                        <div class="p-num f16">K-1631-WT</div>
                                        <div class="ti f20">
                                            4D深捏臀感按摩椅
                                            4D深捏臀感按摩椅
                                            4D深捏臀感按摩椅
                                            4D深捏臀感按摩椅
                                        </div>
                                    </div>
                                    <div class="pric-bx">
                                        <div class="org-pric f16">
                                            原價<span>628,000</span>
                                        </div>
                                        <div class="dis-pric">
                                            特惠價<span>520,800</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="product-detail.php">
                                <div class="tag blue">
                                    NEW
                                </div>
                                <div class="img-bx">
                                    <img src="dist/images/product/item1.jpg">
                                </div>
                                <div class="des-bx">
                                    <div class="tx-bx">
                                        <div class="p-num f16">K-1631-WT</div>
                                        <div class="ti f20">
                                            4D深捏臀感按摩椅
                                            4D深捏臀感按摩椅
                                        </div>
                                    </div>
                                    <div class="pric-bx">
                                        <div class="org-pric f16">
                                            原價<span>628,000</span>
                                        </div>
                                        <div class="dis-pric">
                                            特惠價<span>520,800</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="product-detail.php">
                                <div class="tag org">
                                    SALE
                                </div>
                                <div class="img-bx">
                                    <img src="dist/images/product/item1.jpg">
                                </div>
                                <div class="des-bx">
                                    <div class="tx-bx">
                                        <div class="p-num f16">K-1631-WT</div>
                                        <div class="ti f20">
                                            4D深捏臀感按摩椅
                                            4D深捏臀感按摩椅
                                        </div>
                                    </div>
                                    <div class="pric-bx">
                                        <div class="org-pric f16">
                                            原價<span>628,000</span>
                                        </div>
                                        <div class="dis-pric">
                                            特惠價<span>520,800</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="product-detail.php">
                                <div class="tag green">
                                    預購
                                </div>
                                <div class="img-bx">
                                    <img src="dist/images/product/item1.jpg">
                                </div>
                                <div class="des-bx">
                                    <div class="tx-bx">
                                        <div class="p-num f16">K-1631-WT</div>
                                        <div class="ti f20">
                                            4D深捏臀感按摩椅
                                            4D深捏臀感按摩椅
                                        </div>
                                    </div>
                                    <div class="pric-bx">
                                        <div class="org-pric f16">
                                            原價<span>628,000</span>
                                        </div>
                                        <div class="dis-pric">
                                            特惠價<span>520,800</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="product-detail.php">
                                <div class="tag red">
                                    HOT
                                </div>
                                <div class="img-bx">
                                    <img src="dist/images/product/item1.jpg">
                                </div>
                                <div class="des-bx">
                                    <div class="tx-bx">
                                        <div class="p-num f16">K-1631-WT</div>
                                        <div class="ti f20">
                                            4D深捏臀感按摩椅
                                            4D深捏臀感按摩椅
                                        </div>
                                    </div>
                                    <div class="pric-bx">
                                        <div class="org-pric f16">
                                            原價<span>628,000</span>
                                        </div>
                                        <div class="dis-pric">
                                            特惠價<span>520,800</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="product-detail.php">
                                <div class="tag red">
                                    HOT
                                </div>
                                <div class="img-bx">
                                    <img src="dist/images/product/item1.jpg">
                                </div>
                                <div class="des-bx">
                                    <div class="tx-bx">
                                        <div class="p-num f16">K-1631-WT</div>
                                        <div class="ti f20">
                                            4D深捏臀感按摩椅
                                            4D深捏臀感按摩椅
                                        </div>
                                    </div>
                                    <div class="pric-bx">
                                        <div class="org-pric f16">
                                            原價<span>628,000</span>
                                        </div>
                                        <div class="dis-pric">
                                            特惠價<span>520,800</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="product-detail.php">
                                <div class="tag red">
                                    HOT
                                </div>
                                <div class="img-bx">
                                    <img src="dist/images/product/item1.jpg">
                                </div>
                                <div class="des-bx">
                                    <div class="tx-bx">
                                        <div class="p-num f16">K-1631-WT</div>
                                        <div class="ti f20">
                                            4D深捏臀感按摩椅
                                            4D深捏臀感按摩椅
                                        </div>
                                    </div>
                                    <div class="pric-bx">
                                        <div class="org-pric f16">
                                            原價<span>628,000</span>
                                        </div>
                                        <div class="dis-pric">
                                            特惠價<span>520,800</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="product-detail.php">
                                <div class="tag red">
                                    HOT
                                </div>
                                <div class="img-bx">
                                    <img src="dist/images/product/item1.jpg">
                                </div>
                                <div class="des-bx">
                                    <div class="tx-bx">
                                        <div class="p-num f16">K-1631-WT</div>
                                        <div class="ti f20">
                                            4D深捏臀感按摩椅
                                            4D深捏臀感按摩椅
                                        </div>
                                    </div>
                                    <div class="pric-bx">
                                        <div class="org-pric f16">
                                            原價<span>628,000</span>
                                        </div>
                                        <div class="dis-pric">
                                            特惠價<span>520,800</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="product-detail.php">
                                <div class="tag red">
                                    HOT
                                </div>
                                <div class="img-bx">
                                    <img src="dist/images/product/item1.jpg">
                                </div>
                                <div class="des-bx">
                                    <div class="tx-bx">
                                        <div class="p-num f16">K-1631-WT</div>
                                        <div class="ti f20">
                                            4D深捏臀感按摩椅
                                            4D深捏臀感按摩椅
                                        </div>
                                    </div>
                                    <div class="pric-bx">
                                        <div class="org-pric f16">
                                            原價<span>628,000</span>
                                        </div>
                                        <div class="dis-pric">
                                            特惠價<span>520,800</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="product-detail.php">
                                <div class="tag red">
                                    HOT
                                </div>
                                <div class="img-bx">
                                    <img src="dist/images/product/item1.jpg">
                                </div>
                                <div class="des-bx">
                                    <div class="tx-bx">
                                        <div class="p-num f16">K-1631-WT</div>
                                        <div class="ti f20">
                                            4D深捏臀感按摩椅
                                            4D深捏臀感按摩椅
                                        </div>
                                    </div>
                                    <div class="pric-bx">
                                        <div class="org-pric f16">
                                            原價<span>628,000</span>
                                        </div>
                                        <div class="dis-pric">
                                            特惠價<span>520,800</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul> -->
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