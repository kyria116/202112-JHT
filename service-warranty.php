<?php include "quote/template/head.php"; ?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/chosen.css">
<link rel="stylesheet" href="dist/css/servicewarranty.css">
</head>

<body class="servicewarrantyPage">
    <?php
        include "quote/template/added.php";
        include "quote/template/nav.php";
        include "quote/template/modal.php";
    ?>
    <div id="Wrapper">
        <main role="main">
            <div class="sh-banner">
                <img class="pc" src="dist/images/service/line_1_pc.png">
                <img class="mo" src="dist/images/service/line_1_mb.png">
                <div class="container">
                    <h2>
                        <div class="e-ti">SERVICE</div>
                        <div class="t-ti">客戶服務</div>
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
                                        <a href="service-warranty.php">
                                            <div class="f16">
                                                <span>保固登錄</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="service-faq.php">
                                            <div class="f16">
                                                <span>常見問題</span>
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
                    <div class="form-bx">
                        <form>
                            <!-- <div class="flex-bx">
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
                            </div> -->
                            <div class="flex-bx">
                                <!-- <div class="form-group">
                                    <label for=""><span>*</span>Email</label>
                                    <input type="email" required placeholder="請輸入常用Email">
                                    <div class="help-block with-errors">請輸入正確格式Email</div>
                                </div> -->
                                <div class="form-group">
                                    <label for=""><span>*</span>購買日期</label>
                                    <input type="date" required>
                                    <div class="help-block with-errors">必填</div>
                                </div>
                            </div>
                            <div class="form-group sel-group buy-product-box">
                                <label for="" class="buy-product"><span>*</span>購買產品</label><a href="javascript:;" class="product-number">產品序號</a>
                                <!-- <ul class="sel-bx">
                                    <li>
                                        <select>
                                            <option value="N">請選擇購買產品</option>
                                            <option value="K-1730-BU 太空深捏臀感按摩椅">K-1730-BU 太空深捏臀感按摩椅</option>
                                        </select>
                                        <div class="help-block with-errors">必填</div>
                                    </li>
                                </ul> -->
                                <ul class="sel-bx">
                                    <li>
                                        <div class="flex">
                                            <div>
                                                <select data-placeholder="請選擇購買產品" class="product_id" name="product_id[]" required >
                                                    <option value="">請選擇購買產品</option>
                                                    <option value='122'>自在極意棒(HY-10339)</option><option value='121'>經典按摩棒(HY-10341)</option><option value='103'>極速震動按摩槍(HY-10501)</option><option value='144'>Marvel漫威 鋼鐵人極速震動按摩槍(HY-10503)</option><option value='101'>XE深層震動按摩槍(HY-10598)</option><option value='86'>miniV美型口袋按摩槍(HY-10599)</option><option value='158'>miniV美型口袋按摩槍Test(HY-10599Test)</option><option value='131'>NBR環保8mm瑜珈墊(HY-1201)</option><option value='91'>Transform伸縮瑜珈滾輪 35cm(HY-1206)</option><option value='148'>Transform伸縮瑜珈滾輪 35cm HY-1206(瑜珈滾筒/瑜珈柱)+NBR環保8mm瑜珈墊(台灣製)(HY-1206＋HY-1201)</option><option value='150'>MARVEL漫威 鋼鐵人UNECK頸部按摩儀(HY-1234)</option><option value='120'>熱感揉震舒壓按摩枕(HY-1688)</option><option value='119'>熱感揉震按摩墊(HY-1689)</option><option value='116'>微電腦溫控高桶身SPA泡腳機(HY-19967A)</option><option value='113'>輕商用磁控健身車(HY-20149)</option><option value='111'>創飛輪健身車(HY-20151)</option><option value='104'>方塊健身車(HY-20152)</option><option value='102'>二合一飛輪伸展健身車(HY-20153)</option><option value='147'>輝葉 LAZY GO 樂走機(踏步機/橢圓機/復健機)(HY-20156-GY)</option><option value='109'>旗艦型輕商用跑步機(3.0HP馬力)(HY-20601)</option><option value='108'>Werun 小智跑步機(HY-20602)</option><option value='106'>newrun新平板跑步機(HY-20603)</option><option value='107'>newrunS新平板跑步機(升級款)(HY-20603A)</option><option value='105'>K9商用型跑步機(HY-20606)</option><option value='96'>鋁合金新平板跑步機(HY-20607)</option><option value='98'>Werun iX全折疊電動跑步機(HY-20608)</option><option value='100'>newrunX第三代平板兩用滑步健走機(HY-20609)</option><option value='95'>輝葉 Werun2 新小智跑步機(HY-20610)</option><option value='130'>22合1多功能塑腹健身機(HY-29975)</option><option value='97'>多功能重訓椅-統一7-ELEVEN獅聯名款(HY-29979)</option><option value='93'>環保槓鈴啞鈴兩用組(40kg)(HY-29982)</option><option value='99'>環保槓鈴啞鈴兩用組 (40kg)+多功能重訓椅統一7-ELEVEN獅聯名款(HY-29982＋HY-29979)</option><option value='142'>Vsofa沙發按摩椅(HY-3067A)</option><option value='152'>WULA超有力小沙發(HY-3068A)</option><option value='123'>摩力推脂機(升級版)(HY-333)</option><option value='143'>商務艙PLUS零重力按摩椅(HY-5013)</option><option value='84'>360度原力按摩椅(HY-5081)</option><option value='83'>追夢椅(臀感按摩椅)(HY-5083)</option><option value='88'>新一代 4D溫熱手感按摩墊(HY-633)</option><option value='90'>4D溫熱揉搥按摩墊(HY-640)</option><option value='114'>熱膝足翻轉美腿機(HY-6880)</option><option value='110'>極度深捏3D美腿機(HY-702)</option><option value='112'>三芯手感美腿機(HY-703)</option><option value='141'>新頭等艙PLUS臀感按摩椅(HY-7060A)</option><option value='87'>美腿舒揉按摩器(HY-737)</option><option value='94'>雙效溫感美腿機(HY-750)</option><option value='115'>4 IN ONE 美腿新膝望(HY-768)</option><option value='129'>舞動機第三代(小巧進化版)(HY-803)</option><option value='82'>超夢椅(HY-8092)</option><option value='92'>YOGA舒展按摩床墊(HY-900)</option><option value='125'>全方位透氣竹炭護膝(HY-9901)</option><option value='124'>Protection漸壓運動薄護膝(HY-9918)</option><option value='128'>ENERGY能量磁石涼感護腕(HY-9931)</option><option value='126'>活能銀碳纖維塑體護腰(HY-9950)</option><option value='127'>Strength可調式加壓支撐護腰帶(HY-9958)</option><option value='118'>uNeck頸部溫熱按摩儀(HY-N01)</option><option value='145'>Marvel漫威 鋼鐵人uNeck頸部按摩儀(HY-N03)</option><option value='151'>test(HY-test)</option><option value='117'>晶亮眼2眼部按摩器(HY-Y03)</option><option value='156'>商品名稱test1(JHT0001)</option><option value='159'>測試JHT商品-按摩椅(JHT1234856)</option><option value='155'>測試商品(test-123)</option>					                        
                                                </select>
                                                <div class="help-block with-errors">必填</div>
                                            </div>
                                            <div>
                                                <input type="text" placeholder="請輸入產品序號">
                                                <div class="help-block with-errors">必填</div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <a href="javascript:;" class="add-btn">
                                    <span>
                                        <div class="ar"></div>
                                        新增產品
                                    </span>
                                </a>
                                <a class="remove-btn" href="javascript:;">
                                    <div class="ar"></div>
                                </a>
                            </div>
                            <div class="form-group radio-group">
                                <label for=""><span>*</span>購買通路</label>
                                <div class="radio-flex">
                                    <div class="form-radio">
                                        <input type="radio" required="" value="s-1" id="s-1" name="shop">
                                        <label for="s-1">
                                            實體門市
                                        </label>
                                    </div>
                                    <div class="form-radio">
                                        <input type="radio" required="" value="s-2" id="s-2" name="shop" checked="true">
                                        <label for="s-2">
                                            網路平台
                                        </label>
                                    </div>
                                    <div class="form-radio">
                                        <input type="radio" required="" value="s-3" id="s-3" name="shop">
                                        <label for="s-3">
                                            電視購物
                                        </label>
                                    </div>
                                    <div class="form-radio">
                                        <input type="radio" required="" value="s-4" id="s-4" name="shop">
                                        <label for="s-4">
                                            其他
                                        </label>
                                    </div>
                                </div>
                                <!-- 1025 -->
                                <select class="shopsel show">
                                    <option value="N">請選擇網路平台</option>
                                    <option value="Google">Google</option>
                                </select>
                                <select class="shopsel2">
                                    <option value="N">請選擇實體門市</option>
                                    <option value="Google">Google</option>
                                </select>
                                <select class="shopsel3">
                                    <option value="N">請選擇電視購物</option>
                                    <option value="Google">Google</option>
                                </select>
                                <input class="shopsel4" type="text" placeholder="請輸入其他">
                                <div class="help-block with-errors">必填</div>
                            </div>
                            <div class="form-group">
                                <label for="">訂單編號</label>
                                <input type="text" placeholder="請輸入訂單編號">
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="">其它建議</label>
                                <!-- 1025 -->
                                <textarea placeholder="請輸入建議內容"></textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                            <a href="javascript:;" class="sh-btn send-btn">
                                <div class="ar"></div>
                                送出
                            </a>
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
    <script src="dist/js/service.js"></script>
    <script src="dist/js/chosen.jquery.min.js"></script>
    <script>
        $(".product_id" ).chosen();
    </script>
</body>

</html>