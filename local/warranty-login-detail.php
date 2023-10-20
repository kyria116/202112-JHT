<?php include "quote/template/head.php"; ?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/registration.css">
</head>

<body class="memberorderPage warrantyloginPage warrantylogindetail">
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
                                    <li>
                                        <a href="member-order.php">
                                            <div class="f16">
                                                <span>訂單紀錄</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="active">
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
                    <h1 class="title">保固登錄資訊</h1>

                    <div class="it2-bx">
                        <div class="ti-bx">
                            <div class="d1">
                                登錄日期
                            </div>
                            <div class="d3">
                                訂單編號
                            </div>
                            <div class="d4">
                                購買通路
                            </div>
                        </div>
                        
                        <ul class="warrantylogin">
                            <li>
                                <div class="d1">
                                    <div class="center-bx">
                                        <span>2021 . 03 . 01</span>
                                    </div>
                                </div>
                                <div class="d3">
                                    <div class="center-bx">
                                        <span class="mo">訂單編號</span>
                                        <span>1234567890</span>
                                    </div>
                                </div>
                                <div class="d4">
                                    <div class="center-bx">
                                        <span class="mo">購買通路</span>
                                        <span>其它</span>
                                        <span class="tag_box">蝦皮</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="buy_produce">
                        <div class="wm-title">購買產品</div>
                        <ul>
                            <li>
                                <div class="l-bx">
                                    <span class="l-txt">K-708-WT</span>
                                    <span class="r-txt">LAZY FIT垂直律動機</span>
                                </div>
                                <div class="r-bx">
                                    <span class="number-txt">產品序號</span>
                                    <span class="num pro">2022456789</span>
                                </div>
                            </li>
                            <li>
                                <div class="l-bx">
                                    <span class="l-txt">K-708-WT</span>
                                    <span class="r-txt">LAZY FIT垂直律動機</span>
                                </div>
                                <div class="r-bx">
                                    <span class="number-txt">產品序號</span>
                                    <span class="num pro"></span>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="other_suggest">
                        <div class="wm-title">其它建議</div>
                        <div class="r-bx">建議更多產品都有保固登錄活動</div>
                    </div>
                    <div id="active"></div>


                    <div class="info-bx">
                        <div class="wml-title">活動資訊</div>
                        <div class="editor_Content in_fade active">
                            <div class="editor_box pc_use">
                                <img src="dist/images/about/img_pc.jpg" alt="">
                            </div>
                            <div class="editor_Box mo_use">
                                <img src="dist/images/about/img_pc.jpg" alt="">
                                momomomomomomomm
                            </div>
                        </div>
                    </div>
                    
                    <a href="javascript:window.history.back();" class="sh-btn">
                        <div class="ar"></div>
                        BACK
                    </a>
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
    <script>
        let numTxt = document.querySelectorAll('.num')
        let tagAll = document.querySelectorAll('.tag_box')

        numTxt.forEach( num => {
            if(num.innerHTML === ""){
                num.classList.add('show-txt')
            }
        })
                
        tagAll.forEach( tag => {            
            if(tag.innerHTML !== ""){
                tag.classList.add('show-null')
            }
        })
        
    </script>
</body>

</html>