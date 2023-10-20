<?php 
	include "quote/template/head.php"; 
	require_once ("global_include_file.php");
    require_once ("check_login.php");

    if($_COOKIE['member_userid'] == "")
    {
       print "<script>";
       print "location.href='login.php';";
       print "</script>";
       exit;

    }
	
	$all_info=array();
    $where_clause="1 and email='".$_COOKIE['member_userid']."' order by start_time desc";
    $tbl_name="sys_portal_g3";
    getall_data($tbl_name, $where_clause, $all_info);
    // show_array($all_info);

    /***************
    *  分頁
    **************/
    $each_page_num = 9;
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
?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/registration.css">
</head>

<body class="memberorderPage warrantyloginPage">
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
                    <div class="it2-bx">
                        <div class="ti-bx">
                            <div class="d1">
                                登錄日期
                            </div>
                            <div class="d2">
                                購買產品
                            </div>
                            <div class="d3">
                                產品序號
                            </div>
                            <div class="d4">
                                購買通路
                            </div>
                            <div class="d5">
                                登錄活動
                            </div>
                        </div>
                        
                        <ul class="warrantylogin">
                            <?
				                for($iii=0;$iii<count($info);$iii++){
					                $date_arr = explode(" ", $info[$iii]['start_time']);
			                ?>
                            <li>
                                <div class="d1">
                                    <div class="center-bx">
                                        <span><?=str_replace("-"," . ",$date_arr[0])?></span>
                                    </div>
                                </div>
                                <div class="d2">
                                    <div class="center-bx">
                                        <span class="mo">購買產品</span>
                                        <ul class="buy-list">
                                            <?
					                            $product_id_arr = explode(",", $info[$iii]['product_id']);
					                            $product_name_arr = explode(",", $info[$iii]['product_name']);
					                            $product_code_arr = explode(",", $info[$iii]['product_code']);
				
					                            $show_action = 0;
					                            foreach($product_id_arr as $product_key => $product_id){
						                            $product_info=array();
						                            $where_clause=" Fmain_id = '".$product_id."' ";
						                            $tbl_name="sys_portal_x100_cnt";
						                            get_data($tbl_name, $where_clause, $product_info);
						                            #show_array($product_info);
						                            if($product_info['html_field_20'] != "")
						                            $show_action = 1;
				                            ?>
                                            <li><?=$product_name_arr[$product_key]?></li>
				                            <?
				                            	}
				                            ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="d3">
                                    <div class="center-bx">
                                        <span class="mo">產品序號</span>
                                        <ul class="buy-list">
                                        <?
				                            foreach($product_id_arr as $product_key => $product_id){
			                            ?>
                                        <li><?=$product_code_arr[$product_key]?></li>
			                            <?
			                            	}
			                            ?>
			                            </ul>
                                    </div>
                                </div>
                                <div class="d4">
                                    <div class="center-bx">
                                        <span class="mo">購買通路</span>
                                        <span><?=$info[$iii]['buy_channel']?></span>
<!--                                         <span class="tag_box">中正</span> -->
                                    </div>
                                </div>
                                <div class="d5">
                                    <?=(($show_action)?'<a href="warranty-login-detail.php?v='.$info[$iii]['Fmain_id'].'#active" class="center-bx"><span class="info-active">查看活動資訊</span></a>':'<a href="warranty-login-detail.php#active" class="center-bx"><span class="info-active"></span></a>')?>
                                </div>
                                <a class="see-btn" href="warranty-login-detail.php?v=<?=$info[$iii]['Fmain_id']?>">
                                    <span>查看</span>
                                </a>
                            </li>
                            <?
	                            }
                            ?>
                        </ul>
                        <?php include "quote/template/page_list_2.php"; ?>
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
    <script>
        let infoAll = document.querySelectorAll('.info-active')
        let tagAll = document.querySelectorAll('.tag_box')
        
        infoAll.forEach( info => {
            if(document.body.clientWidth > 992){                
                if(info.innerHTML === ""){
                    info.classList.add('show-null')
                }
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