<dl class="page">
    <!-- 若沒有上一則或下一則請使用 nopage -->
    <?

    if($base_url=="" || $base_url===undefined){
      $base_url = $_SERVER['PHP_SELF']."?1";
    }


    $total_info=count($all_info);
    $total_page_num=ceil($total_info/$each_page_num);

    $prev_page=$pageNum-1;
    if($prev_page>=0){
        $prev_URL=$base_url."&pageFor=".$pageFor."&pageNum=".$prev_page."&folder_id=$folder_id&l1_id=".$_GET['l1_id']."";
        echo "<dt class='ltbn'><a href='".$prev_URL."'></a></dt>";
    }else{
//        echo "<dt class='rtbn nopage'><a href='javascript:;'></a></dt>";
    }
	$first = $pageNum - 3;
	if($total_page_num < ($first+8))	$first = $total_page_num-8;
	if($first < 0)	$first = 0;
    for($d=$first;$d<$total_page_num && $d < ($first+8) && $total_page_num>1;$d++){
        $D=$d+1;

        #連結
        $page_URL=$base_url."&pageFor=".$pageFor."&pageNum=".$d."&folder_id=$folder_id&l1_id=".$_GET['l1_id']."";

        $page_show="";
        if($pageNum==$d){
            $page_show="class='active'";
            $page_URL="javascript:void(0);";
        }
    ?>
    <dd <?=$page_show?> ><a href="<?=$page_URL?>"><?=$D?></a></dd>
    <?
    }
    ?>

    <?
    $next_page=$pageNum+1;
    $nextP=$total_page_num-1;
    if($next_page<=$nextP){
        $next_URL=$base_url."&pageFor=".$pageFor."&pageNum=".$next_page."&folder_id=$folder_id&l1_id=".$_GET['l1_id']."";
        echo "<dt class='rtbn'><a href='".$next_URL."'></a></dt>";
    }else{
//        echo "<dt class='rtbn nopage'><a href='javascript:;'></a></dt>";
    }
    ?>
</dl>