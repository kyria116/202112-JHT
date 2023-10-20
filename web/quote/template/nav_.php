<?
	$all_news_info=array();
	$where_clause="1 order by rank desc";
	$tbl_name="sys_portal_c1";
	getall_data($tbl_name, $where_clause, $all_news_info);
	// show_array($all_news_info);


	$all_product_info=array();
	$where_clause="1 and is_hide = '2' order by rank desc";
	$tbl_name="sys_portal_x100";
	getall_data($tbl_name, $where_clause, $all_product_info);
	// show_array($all_product_info);

	$show_search_word="請輸入關鍵字";
    if($_COOKIE['lang_id'] == "3")
      $show_search_word="Please enter keywords.";
?>
<div class="header_box">
    <div class="logo">
        <a href="index.php">SoulMatch</a>
    </div>
    <!-- mobile menu -->
    <div class="menu-wrapper">
        <div class="hamburger-menu burger2"><span></span></div>	  
    </div>
    <div class="nav_box">
        <nav>
            <!-- 手機版search -->
            <div class="mo">
                <div class="serch-bx">
                    <form name="f4" id="f4" action="search.php" method="get">
                    <input type="text" name="key_word" placeholder="請輸入關鍵字">
                    <a href="javascript:document.getElementById('f4').submit();" class="search-send">
                        <img src="dist/images/moserch_icon.png">
                    </a>
                    </form>
                </div>
            </div>
            <ul>
                <li><a class="in_servi"  href="about.php"><span>關於我們</span></a></li>
                <li class="hamenu">
                    <a class="in_servi"  href="javascript:;">
                        <span>系列商品</span>
                    </a>
                    <div class="botdes-bx">
                        <div class="b-lis">
                            <div class="b-ti mo">
                                系列商品
                            </div>
                            <div class="lisbx">
	                            	<a href="product.php?folder_id=">
										<span class="tw">全部商品</span>
<!-- 										<span class="en"><?=$all_product_info[$iii]['menu_name_en']?></span> -->
									</a>
                                <?for($iii=0;$iii<count($all_product_info);$iii++){?>
									<a href="product.php?folder_id=<?=$all_product_info[$iii]['Fmain_id']?>">
										<span class="tw"><?=$all_product_info[$iii]['menu_name']?></span>
<!-- 										<span class="en"><?=$all_product_info[$iii]['menu_name_en']?></span> -->
									</a>
								<?}?>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="hamenu">
                    <a class="in_servi"  href="javascript:;">
                        <span>活動消息</span>
                    </a>
                    <div class="botdes-bx">
                        <div class="b-lis">
                            <div class="b-ti mo">
                                活動消息
                            </div>
                            <div class="lisbx">
                                	<a href="news.php?folder_id=">
										<span class="tw">全部</span>
									</a>
                                <?for($iii=0;$iii<count($all_news_info);$iii++){?>
									<a href="news.php?folder_id=<?=$all_news_info[$iii]['Fmain_id']?>">
										<span class="tw"><?=$all_news_info[$iii]['menu_name']?></span>
									</a>
								<?}?>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="hamenu">
                    <a class="in_servi" href="javascript:;">
                        <span>影音好文</span>
                    </a>
                    <div class="botdes-bx">
                        <div class="b-lis">
                            <div class="b-ti mo">
                            影音好文
                            </div>
                            <div class="lisbx">
                                <a href="video.php">
                                    <span>影音</span>
                                </a>
                                <a href="article.php">
                                    <span>文章</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="hamenu">
                    <a class="in_servi"  href="javascript:;">
                        <span>客戶服務</span>
                    </a>
                    <div class="botdes-bx">
                        <div class="b-lis">
                            <div class="b-ti mo">
                            客戶服務
                            </div>
                            <div class="lisbx">
                                <a href="service-warranty.php">
                                    <span>保固登錄</span>
                                </a>
                                <a href="service-faq.php">
                                    <span>常見問題</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li><a class="in_servi"  href="location.php"><span>門市據點</span></a></li>
                <li><a class="in_servi"  href="contact.php"><span>聯絡我們</span></a></li>
            </ul>
        </nav>
    </div>
    <!-- 已登入狀態在member-bx +上 mem-st -->
    <div class="member-bx <?=(($_COOKIE['member_userid'])?" mem-st":"")?>">
        <a href="javascript:;" class="member-btn"></a>
        <a href="javascript:;" class="member-btn2"></a>
        <!-- pc會員選項 -->
        <div class="under-bx">
            <a href="member-profile.php">
                <span>會員專區</span>
            </a>
            <a href="logout.php">
                <span>登出</span>
            </a>
        </div>
        <div class="under-bx2">
            <a href="login.php">
                <span>會員登入</span>
            </a>
            <a href="registration.php">
                <span>註冊</span>
            </a>
        </div>
    </div>
    <!-- 手機會員選項 -->
    <div class="mo-memberbx <?=(($_COOKIE['member_userid'])?" mem-st":"")?>">
        <div class="ins-bx">
            <a href="member-profile.php">會員專區</a>
            <a href="logout.php">登出</a>
            <a href="javascript:;" class="close1"></a>
        </div>
    </div>
    <div class="mo-memberbx2">
        <div class="ins-bx">
            <a href="login.php">會員登入</a>
            <a href="registration.php">註冊</a>
            <a href="javascript:;" class="close2"></a>
        </div>
    </div>
    <!-- 201021 end -->
    <a href="search.php" class="search_btn">
        
    </a>
    <?
    	$cart_num = 0;
	    if($_SESSION['uniqid_str']){
		    $y100_info=array();
		    $where_clause=" uniqid_str = '".$_SESSION['uniqid_str']."' and is_confirm != '1'  ";
		    $tbl_name="sys_portal_y100";
		    get_data($tbl_name, $where_clause, $y100_info);

		    $y100_cnt_info=array();
		    $where_clause=" portal_y100_id = '".$y100_info['Fmain_id']."' ";
		    $tbl_name="sys_portal_y100_cnt";
		    getall_data($tbl_name, $where_clause, $y100_cnt_info);
		    $cart_num = count($y100_cnt_info);
	    }

	    if($_COOKIE['member_userid'] == "")
	       $car_a="javascript:alert('您尚未登入會員，請先登入後再進行操作，謝謝!');location.replace('login.php?back_url=".rawurlencode($_SERVER['REQUEST_URI'])."');";
	    else
	       $car_a="cart.php";



    ?>
    <a href="<?=$car_a?>" class="cart_btn">
        <span class="mcount"><?=$cart_num?></span>
    </a>
</div>
	