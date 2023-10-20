<?php
    include "quote/template/head.php";
    require_once ("global_include_file.php");


    $URL='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?1";
	$folder_id = $_GET['folder_id'];

    $all_folder_info=array();
	$where_clause="1 order by rank desc";
	$tbl_name="sys_portal_c1";
	getall_data($tbl_name, $where_clause, $all_folder_info);
	// show_array($all_folder_info);

	if($folder_id==""){
		$all_info=array();
		$where_clause="1 and is_hide='2' order by date_field_0 desc";
		$tbl_name="sys_portal_c1_cnt";
		getall_data($tbl_name, $where_clause, $all_info);
		// show_array($all_info);
	}else{
		$all_info=array();
		$where_clause="1 and portal_c1_id='".$folder_id."' and is_hide='2' order by rank desc";
		$tbl_name="sys_portal_c1_cnt";
		getall_data($tbl_name, $where_clause, $all_info);
		// show_array($all_info);
	}


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


?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/news.css">
</head>

<body class="newsPage">
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
                                    <?
	                        		$active = "";
	                        		if($folder_id==""){
	                        			$active = "active";
	                        		}
	                        	?>
	
	                            <li class="<?=$active?>"><a href="<?=$URL?>">
		                            <div class="f16">
                                        <span>全部</span>
                                    </div>
	                            </a></li>
	
	                            <?for($iii=0;$iii<count($all_folder_info);$iii++){
	                            	$active = "";
	                        		if($folder_id==$all_folder_info[$iii]['Fmain_id']){
	                        			$active = "active";
	                        		}
	                            ?>
	                            	<li class="<?=$active?>"><a href="<?=$URL.'&folder_id='.$all_folder_info[$iii]['Fmain_id']?>">
		                            	<div class="f16">
                                        <span><?=$all_folder_info[$iii]['menu_name']?></span>
                                    </div></a></li>
	                            <?}?>
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
                    <ul class="news-list">
            <?for($iii=0;$iii<count($info);$iii++){
            		// show_array($info[$iii]);

              $tag=array();
              if($info[$iii]['tag_text_field_5'] != "")
            		$tag = explode(",",$info[$iii]['tag_text_field_5']);
            		$datetime = str_replace("-", " . ", $info[$iii]['date_field_0']);

            		$pic_url = "";
            		if($info[$iii]['pic_field_2']!=""){// pic_file thumbs_pic_file  thumbs4_pic_file
            			$pic_arr = get_pic_path($info[$iii]['pic_field_2']);
            			if(count($pic_arr)>0){
            				$pic_url = "./login_admin/upload_file/".$pic_arr['pic_file'];
            			}
            		}

            		$link = "news-detail.php?folder_id=".$info[$iii]['portal_c1_id']."&detail_id=".$info[$iii]['Fmain_id']."&now_folder=".$_GET['folder_id'];

            		$this_folder_info=array();
             	$where_clause="Fmain_id  = '".$info[$iii]['portal_c1_id']."'";
             	$tbl_name="sys_portal_c1";
             	get_data($tbl_name, $where_clause, $this_folder_info);
             	// show_array($this_folder_info);
			 	if($info[$iii]['portal_c1_id']){
            	?>
	            		<li>
                            <a href="<?=$link?>">
                                <div class="da-bx">
                                    <div class="ty">
                                        <?=$this_folder_info['menu_name']?>
                                    </div>
                                    <div class="da">
                                        <?=$datetime?>
                                    </div>
                                </div>
                                <div class="des-bx">
                                    <div class="img-bx">
                                        <div class="bgcover" style="background:url(<?=$pic_url?>) center center"></div>
                                    </div>
                                    <div class="des-ti f24">
                                        <?=$info[$iii]['text_field_1']?>
                                    </div>
                                    <div class="des f16">
                                        <?=$info[$iii]['text_field_4']?>
                                    </div>
                                </div>
                            </a>
                        </li>
            	<?
	            	}
            	}
            	?>
                    </ul>
                    <?php
                        include "quote/template/page_list_2.php";
                    ?>
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