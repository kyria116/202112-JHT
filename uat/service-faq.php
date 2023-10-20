<?php
    include "quote/template/head.php";
    require_once ("global_include_file.php");

    $folder_id = $_GET['folder_id'];

    $all_folder_info=array();
    $where_clause="1 order by rank desc";
    $tbl_name="sys_portal_f1";
    getall_data($tbl_name, $where_clause, $all_folder_info);
    // show_array($all_folder_info);


    $all_f1_cnt_arr = array();
    for($iii=0;$iii<count($all_folder_info);$iii++){
        $each_info=array();
        $where_clause="1 and portal_f1_id='".$all_folder_info[$iii]['Fmain_id']."' and is_hide='2' order by rank desc";
        $tbl_name="sys_portal_f1_cnt";
        getall_data($tbl_name, $where_clause, $each_info);
        // show_array($each_info);

        $all_f1_cnt_arr[$all_folder_info[$iii]['Fmain_id']] = $each_info;
    }


    if($folder_id=="" || $folder_id=="0"){
        $all_info=array();
        $where_clause="1 and is_hide='2' order by rank desc";
        $tbl_name="sys_portal_f1_cnt";
        getall_data($tbl_name, $where_clause, $all_info);
        // show_array($all_info);
    }else{
        $all_info=array();
        $where_clause="1 and portal_f1_id='".$folder_id."' and is_hide='2' order by rank desc";
        $tbl_name="sys_portal_f1_cnt";
        getall_data($tbl_name, $where_clause, $all_info);
        // show_array($all_info);
    }


?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/servicewarranty.css">
</head>

<body class="servicefaqPage">
    <?php
        include "quote/template/added.php";
        include "quote/template/nav.php";
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
                                    <li>
                                        <a href="service-warranty.php">
                                            <div class="f16">
                                                <span>保固登錄</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li  class="active">
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
                   <div class="it2-bx" id="datilContent">
                       <div class="l-bx">
                            <div class="pc">
                                <ul>
                                    <?
		                                $active = "";
		                                if($folder_id==""){
		                                    $active = "active";
		                                }
		                            ?>
		
		                            <li class="in_servi"  data-secblock='item0'><a href="javascript:go_url('0');">全部</a></li>
		
		                            <?
		                            for($iii=0;$iii<count($all_folder_info);$iii++){
		                                $active = "";
		                                if($folder_id==$all_folder_info[$iii]['Fmain_id']){
		                                    $active = "active";
		                                }
		                            ?>
		                                <li class="in_servi"  data-secblock='item<?=($iii+1)?>'><a href="javascript:go_url('<?=$all_folder_info[$iii]['Fmain_id']?>');"><?=$all_folder_info[$iii]['menu_name']?></a></li>
		                            <?}?>
                                </ul>
                            </div>
                            <div class="mo">
                                <select onchange="go_url(this.value);">
                                <option value="0">全部</option>
                                <?

                                for($iii=0;$iii<count($all_folder_info);$iii++){
                                    $ppp=$iii+1;
                                    $select = "";
                                    if($folder_id==$all_folder_info[$iii]['Fmain_id']){
                                        $select = "selected";
                                    }
                                ?>
                                    <option value="<?=$ppp?>" <?=$select?> ><?=$all_folder_info[$iii]['menu_name']?></option>
                                <?}?>

                            </select>
                            </div>
                       </div>
                       <script type="text/javascript">
                            function go_url(value){
                                window.location.href = "service-faq.php?folder_id="+value;
                            }
                        </script>
                       
                       <div class="r-bx">
                            <?
	                            for($iii=0;$iii<count($all_folder_info);$iii++){
	                            	if($folder_id=="" || $folder_id=="0" || $folder_id==$all_folder_info[$iii]['Fmain_id']){
                            ?>
                            <div class="ul-bx in_services" data-secblock='item<?=($iii+1)?>'>
                                <div class="b-ti f24"><?=$all_folder_info[$iii]['menu_name']?></div>
                                <ul>
                                    <?  $now_cnt_arr = $all_f1_cnt_arr[$all_folder_info[$iii]['Fmain_id']];
                                    for($kkk=0;$kkk<count($now_cnt_arr);$kkk++){?>
                                    <li>
                                        <div class="ball">
                                            Q
                                        </div>
                                        <div class="des-ti">
                                            <?=$now_cnt_arr[$kkk]['text_field_0']?>
                                        </div>
                                        <div class="editor_Content">
                                            <div class="editor_box pc_use">
                                                <?=$now_cnt_arr[$kkk]['html_field_1']?>
                                            </div>
                                            <div class="editor_Box mo_use">
                                                <?=$now_cnt_arr[$kkk]['html_field_2']?>
                                            </div>
                                        </div>
                                    </li>
                                    <?}?>
                                </ul>
                            </div>   
                            <?
	                            	}
	                            }
                            ?>
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
    <script src="dist/js/faq.js"></script>
</body>

</html>