<?php
    include "quote/template/head.php";
    require_once ("global_include_file.php");


    if($_COOKIE['member_userid'] == "")
    {
       print "<script>";
       print "location.href='login.php';";
       print "</script>";
       exit;

    }


    $all_info=array();
    $where_clause="member_userid = '".AddSlashes($_COOKIE['member_userid'])."' and is_confirm = '1' and order_complate_time != '0000-00-00 00:00:00' order by order_complate_time desc";
    $tbl_name="sys_portal_y100";
    getall_data($tbl_name, $where_clause, $all_info);
    // show_array($all_info);


    /***************
    *  分頁
    **************/
    $each_page_num = 10;
    $pageNum=$_GET['pageNum'];

    if($pageNum==""){
        $info=array();
        for($i=0;$i<$each_page_num;$i++){
            if(isset($all_info[$i])){
                $info[$i]=$all_info[$i];
            }
        }
    }else{
        $Si=$pageNum*$each_page_num;
        $Ei=$Si+$each_page_num;
        $info=array();
        $ii=0;
        for($i=$Si;$i<$Ei;$i++){
            if(isset($all_info[$i])){
                $info[$ii]=$all_info[$i];
            }
            $ii++;
        }
    }
/*
<!-- 黑色 (預設) - 待出貨、已出貨、退貨中-->
<!-- 藍色 (.blue) - 訂單完成 -->
<!-- 橘色 (.org) - 待付款 -->
<!-- 灰色 (.grey) - 訂單取消  -->
*/
function get_status_color($status){
	$return = "";
	if($status == "訂單完成"){
		$return = "blue";
	}
	else if($status == "待付款"){
		$return = "org";
	}
	else if($status == "訂單取消"){
		$return = "grey";
	}
	return $return;
}
?>
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
                            <?
			                for($i=0;$i<count($info);$i++)
			                {
			                    $order_time_arr=array();
			                    $order_time_arr=explode(" ",$info[$i]['order_complate_time']);
			                    $order_date = str_replace("-", " . ", $order_time_arr[0]);
			
			
			                ?>
                            <li>
                                <div class="d1">
                                    <div class="center-bx">
                                        <span><?=$order_date?></span>
                                    </div>
                                </div>
                                <div class="d2">
                                    <div class="center-bx">
                                        <span class="mo">訂單編號</span>
                                        <span><?=$info[$i]['order_num']?></span>
                                    </div>
                                </div>
                                <div class="d3">
                                    <div class="center-bx">
                                        <span class="mo">訂單金額</span>
                                        <span>$<?=number_format($info[$i]['sum_total'])?></span>
                                    </div>
                                </div>
                                <div class="d4">
                                    <div class="center-bx">
                                        <span class="mo">付款方式</span>
                                        <span><?=$info[$i]['pay_type']?></span>
                                    </div>
                                </div>
                                <div class="d5">
                                    <div class="center-bx">
                                        <span class="mo">訂單狀態</span>
                                        <span class="<?=get_status_color($info[$i]['pay_state'])?>"><?=$info[$i]['pay_state']?></span>
                                    </div>
                                </div>
                                <a class="see-btn" href="order-detail.php?order_id=<?=$info[$i]['Fmain_id']?>">
                                    <span>查看</span>
                                </a>
                            </li>
                            <?
			                }
			                ?>
                        </ul>
                    </div>
                </div>
            </section>
           <?include "quote/template/page_list_2.php";?>
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