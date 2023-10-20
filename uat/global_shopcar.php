<?
#各商品的滿件分攤折扣金額
function product_in_amount($order_id,$product_id){
	global $MYSQL_VARS,$dblink,$MYSQL_TABS;
	$order_info=array();
	$where_clause=" Fmain_id='".$order_id."'";
	$tbl_name=$MYSQL_TABS['portal_y100'];
	get_data($tbl_name, $where_clause, $order_info);
	$order_cnt_info=array();
	$where_clause=" portal_y100_id='".$order_id."' and is_addbuy = '2' order by Fmain_id asc";
	$tbl_name=$MYSQL_TABS['portal_y100_cnt'];
	getall_data($tbl_name, $where_clause, $order_cnt_info);
	$return_money = 0;
	$total_sales = $order_info['sale_amount_log_1']."@@@".$order_info['sale_amount_log_2'];
	$total_sales_arr = explode("@@@", $total_sales);
	foreach($total_sales_arr as $sales){
		$sales_arr = explode("`", $sales);
		$product_id_arr = explode(",", $sales_arr[2]);
		if(in_array($product_id, $product_id_arr) || $sales_arr[2] == "all"){
			$total_amount = 0;	#全部符合件數
			$in_amount = 0;	#符合件數
			for($j=0;$j<count($order_cnt_info);$j++){
				if($order_cnt_info[$j]['product_id'] == $product_id){
					$in_amount += $order_cnt_info[$j]['amount']*1;
				}
				if(in_array($order_cnt_info[$j]['product_id'], $product_id_arr) || $sales_arr[2] == "all"){
					$total_amount += $order_cnt_info[$j]['amount']*1;
				}
			}
			$return_money += $sales_arr[1]*$in_amount/$total_amount;
		}
	}
	return $return_money;
}

#各商品的滿額分攤折扣金額
function product_in_money($order_id,$product_id){
	global $MYSQL_VARS,$dblink,$MYSQL_TABS;
	$order_info=array();
	$where_clause=" Fmain_id='".$order_id."'";
	$tbl_name=$MYSQL_TABS['portal_y100'];
	get_data($tbl_name, $where_clause, $order_info);
	$order_cnt_info=array();
	$where_clause=" portal_y100_id='".$order_id."' and is_addbuy = '2' order by Fmain_id asc";
	$tbl_name=$MYSQL_TABS['portal_y100_cnt'];
	getall_data($tbl_name, $where_clause, $order_cnt_info);
	$return_money = 0;
	$total_sales = $order_info['sale_money_log_1']."@@@".$order_info['sale_money_log_2'];
	$total_sales_arr = explode("@@@", $total_sales);
	foreach($total_sales_arr as $sales){
		$sales_arr = explode("`", $sales);
		$product_id_arr = explode(",", $sales_arr[2]);
		if(in_array($product_id, $product_id_arr) || $sales_arr[2] == "all"){
			$total_amount = 0;	#全部符合件數
			$in_amount = 0;	#符合件數
			for($j=0;$j<count($order_cnt_info);$j++){
				if($order_cnt_info[$j]['product_id'] == $product_id){
					$in_amount += $order_cnt_info[$j]['amount']*1;
				}
				if(in_array($order_cnt_info[$j]['product_id'], $product_id_arr) || $sales_arr[2] == "all"){
					$total_amount += $order_cnt_info[$j]['amount']*1;
				}
			}
			$return_money += $sales_arr[1]*$in_amount/$total_amount;
		}
	}
	return $return_money;
}

#各商品的折價券分攤折扣金額
function product_in_coupon($order_id,$product_id){
	global $MYSQL_VARS,$dblink,$MYSQL_TABS;
	$order_info=array();
	$where_clause=" Fmain_id='".$order_id."'";
	$tbl_name=$MYSQL_TABS['portal_y100'];
	get_data($tbl_name, $where_clause, $order_info);
	$order_cnt_info=array();
	$where_clause=" portal_y100_id='".$order_id."' and is_addbuy = '2' order by Fmain_id asc";
	$tbl_name=$MYSQL_TABS['portal_y100_cnt'];
	getall_data($tbl_name, $where_clause, $order_cnt_info);
	$product_id_arr = explode(",", $order_info['coupon_product_id']);
	$return_money = 0;
	if(in_array($product_id, $product_id_arr) || $order_info['coupon_product_id'] == "all"){
		$total_amount = 0;	#全部符合件數
		$in_amount = 0;	#符合件數
		for($j=0;$j<count($order_cnt_info);$j++){
			if($order_cnt_info[$j]['product_id'] == $product_id){
				$in_amount += $order_cnt_info[$j]['amount']*1;
			}
			if(in_array($order_cnt_info[$j]['product_id'], $product_id_arr) || $order_info['coupon_product_id'] == "all"){
				$total_amount += $order_cnt_info[$j]['amount']*1;
			}
		}
		$return_money = $order_info['coupon_money']*$in_amount/$total_amount;
	}
	return $return_money;
}

#各商品的折扣碼分攤折扣金額
function product_in_code($order_id,$product_id){
	global $MYSQL_VARS,$dblink,$MYSQL_TABS;
	$order_info=array();
	$where_clause=" Fmain_id='".$order_id."'";
	$tbl_name=$MYSQL_TABS['portal_y100'];
	get_data($tbl_name, $where_clause, $order_info);
	$order_cnt_info=array();
	$where_clause=" portal_y100_id='".$order_id."' and is_addbuy = '2' order by Fmain_id asc";
	$tbl_name=$MYSQL_TABS['portal_y100_cnt'];
	getall_data($tbl_name, $where_clause, $order_cnt_info);
	$product_id_arr = explode(",", $order_info['code_product_id']);
	$return_money = 0;
	if(in_array($product_id, $product_id_arr) || $order_info['code_product_id'] == "all"){
		$total_amount = 0;	#全部符合件數
		$in_amount = 0;	#符合件數
		for($j=0;$j<count($order_cnt_info);$j++){
			if($order_cnt_info[$j]['product_id'] == $product_id){
				$in_amount += $order_cnt_info[$j]['amount']*1;
			}
			if(in_array($order_cnt_info[$j]['product_id'], $product_id_arr) || $order_info['code_product_id'] == "all"){
				$total_amount += $order_cnt_info[$j]['amount']*1;
			}
		}
		$return_money = $order_info['code_money']*$in_amount/$total_amount;
	}
	return $return_money;
}

#新版滿額優惠
function count_sale_money($order_info,$order_cnt_info)
{
	global $MYSQL_VARS,$dblink,$MYSQL_TABS;
	#$cart_setting = get_set_in_portal("b5");	#購物車設定
	$order_id = $order_info['Fmain_id'];
	$order_info=array();
	$where_clause=" Fmain_id = '".$order_id."' ";
	$tbl_name="sys_portal_y100";
	get_data($tbl_name, $where_clause, $order_info);
	$order_cnt_info=array();
	$where_clause=" portal_y100_id = '".$order_id."' ";
	$tbl_name="sys_portal_y100_cnt";
	getall_data($tbl_name, $where_clause, $order_cnt_info);
	#show_array($order_cnt_info);
	$kol_info=array();
    if($order_info['kol_id']){
		$where_clause=" Fmain_id = '".$order_info['kol_id']."' ";
		$tbl_name="sys_portal_j3";
		get_data($tbl_name, $where_clause, $kol_info);
	}

	#取出時間內所有優惠
	$info=array();
	$where_clause=" website_language_id = '1' and set_product_sale_start <= '".date("Y-m-d")."' and set_product_sale_end >= '".date("Y-m-d")."' ";
	$tbl_name="sys_set_sale_money_list";
	getall_data($tbl_name, $where_clause,$info);
	$total_sale_money = 0;#總折扣金額
	$gift_arr = array();	#贈品
	$log_arr = array();		#紀錄
	$not_log_arr = array();	#未符合紀錄
	$the_best = array();	#最低折扣
	$the_best_id = array();	#最低折扣來自哪個優惠
	$final_sale_money = 0;	$final_sale_money_2 = 0;	$sale_amount_log_1 = "";	$sale_amount_log_2 = "";	$final_sale_giveaway_info_arr = array();	$final_sale_giveaway_id_arr = array();	$return_str_arr = array();	$log_str_arr = array();	#符合輝葉用
	for($i=0;$i<count($info);$i++){
		$sale_money = 0;	#此優惠折扣金額
		$sale_title = "";	#此優惠條件名稱
		### 確認符合件數 ###
		$count_amount = 0;	#符合件數
		$in_y100_cnt = "";	#符合條件的y100_cnt_id
		if($info[$i]['set_product_sale_range']=="1"){
			$total_amount = 0;	#全部件數
			$in_amount = 0;	#符合件數
			for($j=0;$j<count($order_cnt_info);$j++){
				if($order_cnt_info[$j]['product_id'] != $kol_info['product_id'] || !$kol_info['Fmain_id']){
					$count_amount += $order_cnt_info[$j]['small_price'];
					$in_y100_cnt .= ",".$order_cnt_info[$j]['product_id'];
					$in_amount += $order_cnt_info[$j]['amount']*1;
					$count_amount -= product_in_amount($order_id,$order_cnt_info[$j]['product_id']);	#扣掉滿件折扣
					$count_amount -= product_in_coupon($order_id,$order_cnt_info[$j]['product_id']);	#扣掉折價券折扣
					$count_amount -= product_in_code($order_id,$order_cnt_info[$j]['product_id']);	#扣掉折扣碼折扣
				}
				$total_amount += $order_cnt_info[$j]['amount']*1;#扣掉購物金折扣
			}
/*
			$in_y100_cnt = "all";
			$count_amount -= $order_info['amount_sale_info_money'];	#扣掉滿件折扣
			$count_amount -= $order_info['use_bonus'];	#扣掉購物金折扣
			$count_amount -= $order_info['coupon_money'];	#扣掉折價券折扣
			$count_amount -= $order_info['code_money'];	#扣掉折扣碼折扣
*/
		}
		else{
			$savePARR=array();
			$savePARR=explode(",",$info[$i]['set_product_sale_range_product_id']);
			$total_amount = 0;	#全部件數
			$in_amount = 0;	#符合件數
			for($j=0;$j<count($order_cnt_info);$j++){
				if(in_array($order_cnt_info[$j]['product_id'], $savePARR) && $order_cnt_info[$j]['product_id'] != $kol_info['product_id']){
					$count_amount += $order_cnt_info[$j]['small_price'];
					$in_y100_cnt .= ",".$order_cnt_info[$j]['product_id'];
					$in_amount += $order_cnt_info[$j]['amount']*1;
					$count_amount -= product_in_amount($order_id,$order_cnt_info[$j]['product_id']);	#扣掉滿件折扣
					$count_amount -= product_in_coupon($order_id,$order_cnt_info[$j]['product_id']);	#扣掉折價券折扣
					$count_amount -= product_in_code($order_id,$order_cnt_info[$j]['product_id']);	#扣掉折扣碼折扣
					#print "<br>".$order_id."&".$order_cnt_info[$j]['product_id']."=".product_in_amount($order_id,$order_cnt_info[$j]['product_id'])."<br>";
				}
				$total_amount += $order_cnt_info[$j]['amount']*1;#扣掉購物金折扣
			}
			if($in_y100_cnt != "")	$in_y100_cnt .= ",";
			#print "<br>".$count_amount."-".$order_info['use_bonus']."*".$in_amount."/".$total_amount."<br>";
			$count_amount -= $order_info['use_bonus']*$in_amount/$total_amount;
		}

		### 計算折扣金額 ###
		$if_gift = 0;	#是否有贈品
		$sale_way = "";	#折扣方式：折扣、折價
		if($count_amount){
			$giveaway_info=array();
			if($info[$i]['set_product_sale_full']=="2"){#滿X折X元
				$sale_money += floor($count_amount / $info[$i]['set_product_sale_fixed_money']) * $info[$i]['set_product_sale_fixed_deductible'];
				$sale_title = $info[$i]['set_product_sale_title'];
				$sale_way = "折價";
				#print "<br>".$info[$i]['set_product_sale_title']."=>".$sale_money."=".$count_amount ."/". $info[$i]['set_product_sale_fixed_money']."*".$info[$i]['set_product_sale_fixed_deductible'];
			}
			else{
				$infoCnt_all=array();
				$where_clause="website_data_id = '".$info[$i]['Fmain_id']."' and CAST(set_product_sale_moneylimit AS SIGNED) <= '".$count_amount."' order by CAST(set_product_sale_moneylimit AS SIGNED) desc";
				if($info[$i]['is_add']=="2"){	#不累加時只取一個
					$where_clause .= " limit 0,1";
				}
				$tbl_name="sys_website_data_set_product_sale";
				getall_data($tbl_name, $where_clause,$infoCnt_all);
				foreach($infoCnt_all as $infoCnt){
					if($infoCnt['set_product_sale_money']){#滿X折X元
						#$sale_money += floor($count_amount / $infoCnt['set_product_sale_moneylimit']) * $infoCnt['set_product_sale_money'];
						$sale_money += $infoCnt['set_product_sale_money'];
						$sale_title = $infoCnt['set_title'];
						$sale_way = "折價";
						#print "<br>".$info[$i]['set_title']."=>".$sale_money."=".$count_amount ."/". $infoCnt['set_product_sale_moneylimit']."*".$infoCnt['set_product_sale_money'];
					}
					else if($infoCnt['set_product_sale']){
						if($info[$i]['set_product_sale_range']=="1"){
							for($j=0;$j<count($order_cnt_info);$j++){
								$order_cnt_info[$j]['small_price'] -= product_in_amount($order_id,$order_cnt_info[$j]['product_id']);	#扣掉滿件折扣
								$order_cnt_info[$j]['small_price'] -= product_in_coupon($order_id,$order_cnt_info[$j]['product_id']);	#扣掉折價券折扣
								$order_cnt_info[$j]['small_price'] -= product_in_code($order_id,$order_cnt_info[$j]['product_id']);	#扣掉折扣碼折扣
								$sale_money += ($order_cnt_info[$j]['small_price']*(10-$infoCnt['set_product_sale'])/10);
								$sale_title = $infoCnt['set_title'];
								$sale_way = "折扣";
								if(!$the_best[$order_cnt_info[$j]['product_id']] || $the_best[$order_cnt_info[$j]['product_id']] < ($order_cnt_info[$j]['small_price']*(10-$infoCnt['set_product_sale'])/10)){
									$the_best[$order_cnt_info[$j]['product_id']] = ($order_cnt_info[$j]['small_price']*(10-$infoCnt['set_product_sale'])/10);
									$the_best_id[$order_cnt_info[$j]['product_id']] = $info[$i]['Fmain_id'];
								}
								#print "<br>".$info[$i]['set_product_sale_amount_title']."=>".$sale_money."=".$order_cnt_info[$j]['small_price']."*".(10-$infoCnt['set_product_sale'])/10;
							}
						}
						else{
							$savePARR=array();
							$savePARR=explode(",",$info[$i]['set_product_sale_range_product_id']);
							for($j=0;$j<count($order_cnt_info);$j++){
								if(in_array($order_cnt_info[$j]['product_id'], $savePARR)){
									$order_cnt_info[$j]['small_price'] -= product_in_amount($order_id,$order_cnt_info[$j]['product_id']);	#扣掉滿件折扣
									$order_cnt_info[$j]['small_price'] -= product_in_coupon($order_id,$order_cnt_info[$j]['product_id']);	#扣掉折價券折扣
									$order_cnt_info[$j]['small_price'] -= product_in_code($order_id,$order_cnt_info[$j]['product_id']);	#扣掉折扣碼折扣
									$sale_money += ($order_cnt_info[$j]['small_price']*(10-$infoCnt['set_product_sale'])/10);
									$sale_title = $infoCnt['set_title'];
									$sale_way = "折扣";
									if(!$the_best[$order_cnt_info[$j]['product_id']] || $the_best[$order_cnt_info[$j]['product_id']] < ($order_cnt_info[$j]['small_price']*(10-$infoCnt['set_product_sale'])/10)){
										$the_best[$order_cnt_info[$j]['product_id']] = ($order_cnt_info[$j]['small_price']*(10-$infoCnt['set_product_sale'])/10);
										$the_best_id[$order_cnt_info[$j]['product_id']] = $info[$i]['Fmain_id'];
									}
									#print "<br>".$info[$i]['set_title']."=>".$sale_money."=".$order_cnt_info[$j]['small_price']."*".(10-$infoCnt['set_product_sale'])/10;
								}
							}
						}
					}
					if($infoCnt['giveaway_id'] && $count_amount >= $infoCnt['set_product_sale_moneylimit']){
						$giveaway_info = get_giveaway_info($infoCnt['giveaway_id']);
						$if_gift += 1;
						$sale_title = $infoCnt['set_title'];
						$final_sale_giveaway_info_arr[] = "".$giveaway_info['text_field_0'];
						$final_sale_giveaway_id_arr[] = "".$giveaway_info['text_field_2'];
						$log_arr[] = $info[$i]['Fmain_id']."`".$info[$i]['set_product_sale_title']."``".$in_y100_cnt."`".$giveaway_info['text_field_0']."`";
					}
				}
			}
			if($sale_money > 0){
				$sale_money = round($sale_money);	#四捨五入
				#print $info[$i]['Fmain_id']."`".$info[$i]['set_product_sale_amount_title']."`".$sale_money."`".$in_y100_cnt."`".$giveaway_info['text_field_0'];
				$log_arr[] = $info[$i]['Fmain_id']."`".$info[$i]['set_product_sale_title']."`".$sale_money."`".$in_y100_cnt."``".$sale_way;
				$total_sale_money += $sale_money;
			}
			else{#查詢差幾元
				$not_count_amount = 0;	#差幾元
				if($info[$i]['set_product_sale_full']=="2"){#滿X折X元
					$not_count_amount = $info[$i]['set_product_sale_fixed_money']-$count_amount;
					$sale_title = $info[$i]['set_product_sale_amount_title'];
				}
				else{
					$infoCnt=array();
					$where_clause="website_data_id = '".$info[$i]['Fmain_id']."' order by CAST(set_product_sale_moneylimit AS SIGNED) asc limit 0,1";
					$tbl_name="sys_website_data_set_product_sale";
					get_data($tbl_name, $where_clause,$infoCnt);
					if(count($infoCnt)){
						$not_count_amount = $infoCnt['set_product_sale_moneylimit']-$count_amount;
						$sale_title = $infoCnt['set_title'];
					}
				}
				if($not_count_amount){
					$not_log_arr[] = $info[$i]['Fmain_id']."`".$info[$i]['set_product_sale_title']."`".$not_count_amount;
				}
			}
		}
	}
	#show_array($the_best);
	foreach($not_log_arr as $the_log){
		$s_log = explode("`", $the_log);
		$log_str_arr[] = "<font style='color:#a5a5a5;'>".$s_log[1]."(不適用)</font>";
	    $return_str_arr[] = "<font style='color:#a5a5a5;'>".$s_log[1]."(不適用)</font>";
	}
	foreach($the_best as $the_key => $the_val){
		$the_best[$the_key] = round($the_val);
	}
	#再算一次把log換成輝葉的做法，並檢查折扣方式是否為最低價$the_best
    foreach($log_arr as $the_log){
	    $s_log = explode("`", $the_log);
	    if($s_log[5] == "折扣"){
		    $chk_sale_money = 0;
		    foreach($the_best_id as $the_best_key => $the_best_val){
			    if($the_best_val == $s_log[0]){
				    $chk_sale_money += $the_best[$the_best_key];
			    }
		    }
		    if($chk_sale_money){
			    $final_sale_money += $chk_sale_money;
			    $sale_amount_log_1 .= $s_log[1]."`".$chk_sale_money."`".$s_log[3]."@@@";
			    $log_str_arr[] = "<b style='font-weight:bold;'>".$s_log[1]."</b>折抵".$chk_sale_money."元";
			    $return_str_arr[] = "<b style='font-weight:bold;'>".$s_log[1]."</b>";
		    }
		    else{
			    $log_str_arr[] = "<font style='color:#a5a5a5;'>".$s_log[1]."(不適用)</font>";
			    $return_str_arr[] = "<font style='color:#a5a5a5;'>".$s_log[1]."(不適用)</font>";
		    }
	    }
	    else if($s_log[5] == "折價" && $s_log[2]){
		    $final_sale_money_2 += $s_log[2]*1;
		    $sale_amount_log_2 .= $s_log[1]."`".$s_log[2]."`".$s_log[3]."@@@";
		    $log_str_arr[] = "<b style='font-weight:bold;'>".$s_log[1]."</b>折抵".$s_log[2]."元";
		    $return_str_arr[] = "<b style='font-weight:bold;'>".$s_log[1]."</b>";
	    }
	    if($s_log[4]){
		    $log_str_arr[] = "<b style='font-weight:bold;'>".$s_log[1]."</b> ◎贈".$s_log[4];
		    $return_str_arr[] = "<b style='font-weight:bold;'>".$s_log[1]."</b> ◎贈".$s_log[4];
	    }
    }
	#show_array($log_str_arr);

	$upd_info = array();
	$upd_info['sale_info_money']=(string)$final_sale_money*1+$final_sale_money_2*1;
    $upd_info['sale_info_give_name']=implode (",", $final_sale_giveaway_info_arr);
    $upd_info['sale_info_give_id']=implode ("`", $final_sale_giveaway_id_arr);
    $upd_info['sale_info_log']=AddSlashes(implode ("<br>", $log_str_arr));
	$upd_info['sale_money_log_1']=AddSlashes($sale_amount_log_1);	#滿額打幾折log
	$upd_info['sale_money_log_2']=AddSlashes($sale_amount_log_2);	#滿額折扣多少錢log
	$where_clause=" Fmain_id = '".$order_id."' ";
	$tbl_name="sys_portal_y100";
	update_data($tbl_name, $where_clause, $upd_info);
	$return_title = implode ("<br>", $return_str_arr);
	return $return_title;
}

#新版滿件優惠
function count_sale_amount($order_info,$order_cnt_info)
{
	global $MYSQL_VARS,$dblink,$MYSQL_TABS;
	#$cart_setting = get_set_in_portal("b5");	#購物車設定
	$order_id = $order_info['Fmain_id'];
	$order_info=array();
	$where_clause=" Fmain_id = '".$order_id."' ";
	$tbl_name="sys_portal_y100";
	get_data($tbl_name, $where_clause, $order_info);
	$order_cnt_info=array();
	$where_clause=" portal_y100_id = '".$order_id."' ";
	$tbl_name="sys_portal_y100_cnt";
	getall_data($tbl_name, $where_clause, $order_cnt_info);
	#show_array($order_cnt_info);
	$kol_info=array();
    if($order_info['kol_id']){
		$where_clause=" Fmain_id = '".$order_info['kol_id']."' ";
		$tbl_name="sys_portal_j3";
		get_data($tbl_name, $where_clause, $kol_info);
	}

	#取出時間內所有滿件優惠
	$info=array();
	$where_clause=" website_language_id = '1' and set_sale_amount_start <= '".date("Y-m-d")."' and set_sale_amount_end >= '".date("Y-m-d")."' ";
	$tbl_name="sys_set_sale_amount_list";
	getall_data($tbl_name, $where_clause,$info);
	$total_sale_money = 0;#總折扣金額
	$gift_arr = array();	#贈品
	$log_arr = array();		#紀錄
	$not_log_arr = array();	#未符合紀錄
	$the_best = array();	#最低折扣
	$the_best_id = array();	#最低折扣來自哪個優惠
	$final_sale_money = 0;	$final_sale_money_2 = 0;	$sale_amount_log_1 = "";	$sale_amount_log_2 = "";	$final_sale_giveaway_info_arr = array();	$final_sale_giveaway_id_arr = array();	$return_str_arr = array();	$log_str_arr = array();	#符合輝葉用
	for($i=0;$i<count($info);$i++){
		$sale_money = 0;	#此優惠折扣金額
		$sale_title = "";	#此優惠條件名稱
		### 確認符合件數 ###
		$count_amount = 0;	#符合件數
		$in_y100_cnt = "";	#符合條件的y100_cnt_id
		if($info[$i]['set_sale_amount_range']=="1"){
			for($j=0;$j<count($order_cnt_info);$j++){
				if($order_cnt_info[$j]['product_id'] != $kol_info['product_id']){
					$count_amount += $order_cnt_info[$j]['amount'];
					$in_y100_cnt .= ",".$order_cnt_info[$j]['product_id'];
				}
			}
			if($in_y100_cnt != "")	$in_y100_cnt .= ",";
			#$in_y100_cnt = "all";
		}
		else{
			$savePARR=array();
			$savePARR=explode(",",$info[$i]['set_sale_amount_range_product_id']);
			for($j=0;$j<count($order_cnt_info);$j++){
				if(in_array($order_cnt_info[$j]['product_id'], $savePARR) && $order_cnt_info[$j]['product_id'] != $kol_info['product_id']){
					$count_amount += $order_cnt_info[$j]['amount'];
					$in_y100_cnt .= ",".$order_cnt_info[$j]['product_id'];
				}
			}
			if($in_y100_cnt != "")	$in_y100_cnt .= ",";
		}

		### 計算折扣金額 ###
		$if_gift = 0;	#是否有贈品
		$sale_way = "";	#折扣方式：折扣、折價
		if($count_amount){
			$giveaway_info=array();
			if($info[$i]['set_sale_amount_full']=="2"){#滿X折X元
				$sale_money += floor($count_amount / $info[$i]['set_sale_amount_fixed_money']) * $info[$i]['set_sale_amount_fixed_deductible'];
				$sale_title = $info[$i]['set_product_sale_amount_title'];
				$sale_way = "折價";
				#print "<br>".$info[$i]['set_product_sale_amount_title']."=>".$sale_money."=".floor($count_amount / $info[$i]['set_sale_amount_fixed_money'])."*".$info[$i]['set_sale_amount_fixed_deductible'];
			}
			else{
				$infoCnt_all=array();
				$where_clause="website_data_id = '".$info[$i]['Fmain_id']."' and CAST(set_sale_amount_moneylimit AS SIGNED) <= '".$count_amount."' order by CAST(set_sale_amount_moneylimit AS SIGNED) desc";
				if($info[$i]['is_add']=="2"){	#不累加時只取一個
					$where_clause .= " limit 0,1";
				}
				$tbl_name="sys_website_data_set_sale_amount";
				getall_data($tbl_name, $where_clause,$infoCnt_all);
				foreach($infoCnt_all as $infoCnt){
					if($infoCnt['set_sale_amount_money']){#滿X折X元
						#$sale_money += floor($count_amount / $infoCnt['set_sale_amount_moneylimit']) * $infoCnt['set_sale_amount_money'];
						$sale_money += $infoCnt['set_sale_amount_money'];
						$sale_title = $infoCnt['set_title'];
						$sale_way = "折價";
						#print "<br>".$info[$i]['set_title']."=>".$sale_money."=".floor($count_amount / $infoCnt['set_sale_amount_moneylimit'])."*".$infoCnt['set_sale_amount_money'];
					}
					else if($infoCnt['set_sale_amount']){
						if($info[$i]['set_sale_amount_range']=="1"){
							for($j=0;$j<count($order_cnt_info);$j++){
								$sale_money += ($order_cnt_info[$j]['small_price']*(10-$infoCnt['set_sale_amount'])/10);
								$sale_title = $infoCnt['set_title'];
								$sale_way = "折扣";
								if(!$the_best[$order_cnt_info[$j]['product_id']] || ($the_best[$order_cnt_info[$j]['product_id']] < ($order_cnt_info[$j]['small_price']*(10-$infoCnt['set_sale_amount'])/10))){
									$the_best[$order_cnt_info[$j]['product_id']] = ($order_cnt_info[$j]['small_price']*(10-$infoCnt['set_sale_amount'])/10);
									$the_best_id[$order_cnt_info[$j]['product_id']] = $info[$i]['Fmain_id'];
									#print $order_cnt_info[$j]['product_id']."=".($order_cnt_info[$j]['small_price']*(10-$infoCnt['set_sale_amount'])/10)."<br>";
								}
								#print "<br>".$info[$i]['set_product_sale_amount_title']."=>".$sale_money."=".$order_cnt_info[$j]['small_price']*(10-$infoCnt['set_sale_amount'])/10;
							}
						}
						else{
							$savePARR=array();
							$savePARR=explode(",",$info[$i]['set_sale_amount_range_product_id']);
							for($j=0;$j<count($order_cnt_info);$j++){
								if(in_array($order_cnt_info[$j]['product_id'], $savePARR)){
									$sale_money += ($order_cnt_info[$j]['small_price']*(10-$infoCnt['set_sale_amount'])/10);
									$sale_title = $infoCnt['set_title'];
									$sale_way = "折扣";
									if(!$the_best[$order_cnt_info[$j]['product_id']] || $the_best[$order_cnt_info[$j]['product_id']] < ($order_cnt_info[$j]['small_price']*(10-$infoCnt['set_sale_amount'])/10)){
										$the_best[$order_cnt_info[$j]['product_id']] = ($order_cnt_info[$j]['small_price']*(10-$infoCnt['set_sale_amount'])/10);
										$the_best_id[$order_cnt_info[$j]['product_id']] = $info[$i]['Fmain_id'];
									}
									#print "<br>".$info[$i]['set_title']."=>".$sale_money."=".$order_cnt_info[$j]['small_price']."*".(10-$infoCnt['set_sale_amount'])/10;
								}
							}
						}
					}
					if($infoCnt['giveaway_id'] && $count_amount >= $infoCnt['set_sale_amount_moneylimit']){
						$giveaway_info = get_giveaway_info($infoCnt['giveaway_id']);
						$if_gift += 1;
						$sale_title = $infoCnt['set_title'];
						$final_sale_giveaway_info_arr[] = "".$giveaway_info['text_field_0'];
						$final_sale_giveaway_id_arr[] = "".$giveaway_info['text_field_2'];
						$log_arr[] = $info[$i]['Fmain_id']."`".$info[$i]['set_product_sale_amount_title']."``".$in_y100_cnt."`".$giveaway_info['text_field_0']."`";
					}
				}
			}
			if($sale_money > 0){
				$sale_money = round($sale_money);	#四捨五入
				#print $info[$i]['Fmain_id']."`".$info[$i]['set_product_sale_amount_title']."`".$sale_money."`".$in_y100_cnt."`".$giveaway_info['text_field_0'];
				$log_arr[] = $info[$i]['Fmain_id']."`".$info[$i]['set_product_sale_amount_title']."`".$sale_money."`".$in_y100_cnt."``".$sale_way;
				$total_sale_money += $sale_money;
			}
			else{#查詢差幾件
				$not_count_amount = 0;	#差幾件
				if($info[$i]['set_sale_amount_full']=="2"){#滿X折X元
					$not_count_amount = $info[$i]['set_sale_amount_fixed_money']-$count_amount;
					$sale_title = $info[$i]['set_product_sale_amount_title'];
				}
				else{
					$infoCnt=array();
					$where_clause="website_data_id = '".$info[$i]['Fmain_id']."' order by CAST(set_sale_amount_moneylimit AS SIGNED) asc limit 0,1";
					$tbl_name="sys_website_data_set_sale_amount";
					get_data($tbl_name, $where_clause,$infoCnt);
					if(count($infoCnt)){
						$not_count_amount = $infoCnt['set_sale_amount_moneylimit']-$count_amount;
						$sale_title = $infoCnt['set_title'];
					}
				}
				if($not_count_amount){
					$not_log_arr[] = $info[$i]['Fmain_id']."`".$info[$i]['set_product_sale_amount_title']."`".$not_count_amount;
				}
			}
		}
	}
	foreach($not_log_arr as $the_log){
		$s_log = explode("`", $the_log);
		$log_str_arr[] = "<font style='color:#a5a5a5;'>".$s_log[1]."(不適用)</font>";
	    $return_str_arr[] = "<font style='color:#a5a5a5;'>".$s_log[1]."(不適用)</font>";
	}
	foreach($the_best as $the_key => $the_val){
		$the_best[$the_key] = round($the_val);
	}
	#再算一次把log換成輝葉的做法，並檢查折扣方式是否為最低價$the_best
	#show_array($the_best);
    foreach($log_arr as $the_log){
	    $s_log = explode("`", $the_log);
	    if($s_log[5] == "折扣"){
		    $chk_sale_money = 0;
		    foreach($the_best_id as $the_best_key => $the_best_val){
			    if($the_best_val == $s_log[0]){
				    $chk_sale_money += $the_best[$the_best_key];
			    }
		    }
		    if($chk_sale_money){
			    $final_sale_money += $chk_sale_money;
			    $sale_amount_log_1 .= $s_log[1]."`".$chk_sale_money."`".$s_log[3]."@@@";
			    $log_str_arr[] = "<b style='font-weight:bold;'>".$s_log[1]."</b>折抵".$chk_sale_money."元";
			    $return_str_arr[] = "<b style='font-weight:bold;'>".$s_log[1]."</b>";
		    }
		    else{
			    $log_str_arr[] = "<font style='color:#a5a5a5;'>".$s_log[1]."(不適用)</font>";
			    $return_str_arr[] = "<font style='color:#a5a5a5;'>".$s_log[1]."(不適用)</font>";
		    }
	    }
	    else if($s_log[5] == "折價" && $s_log[2]){
		    $final_sale_money_2 += $s_log[2]*1;
		    $sale_amount_log_2 .= $s_log[1]."`".$s_log[2]."`".$s_log[3]."@@@";
		    $log_str_arr[] = "<b style='font-weight:bold;'>".$s_log[1]."</b>折抵".$s_log[2]."元";
		    $return_str_arr[] = "<b style='font-weight:bold;'>".$s_log[1]."</b>";
	    }
	    if($s_log[4]){
		    $log_str_arr[] = "<b style='font-weight:bold;'>".$s_log[1]."</b> ◎贈".$s_log[4];
		    $return_str_arr[] = "<b style='font-weight:bold;'>".$s_log[1]."</b> ◎贈".$s_log[4];
	    }
    }


	$upd_info = array();
	$upd_info['amount_sale_info_money']=(string)$final_sale_money*1+$final_sale_money_2*1;
    $upd_info['amount_sale_info_money_give_name']=implode (",", $final_sale_giveaway_info_arr);
    $upd_info['amount_sale_info_money_give_id']=implode ("`", $final_sale_giveaway_id_arr);
    $upd_info['amount_sale_info_log']=AddSlashes(implode ("<br>", $log_str_arr));
	$upd_info['sale_amount_log_1']=AddSlashes($sale_amount_log_1);
	$upd_info['sale_amount_log_2']=AddSlashes($sale_amount_log_2);
	$where_clause=" Fmain_id = '".$order_id."' ";
	$tbl_name="sys_portal_y100";
	update_data($tbl_name, $where_clause, $upd_info);
	$return_title = implode ("<br>", $return_str_arr);
	return $return_title;
}


function chk_have_kol($order_id){
	global $MYSQL_VARS,$dblink,$MYSQL_TABS;
	$order_info=array();
   	$where_clause=" Fmain_id = '".$order_id."' ";
   	$tbl_name=$MYSQL_TABS['portal_y100'];
   	get_data($tbl_name, $where_clause, $order_info);

   	$have_kol = 0;
   	if($order_info['kol_id']){
		$order_cnt_info=array();
		$where_clause=" portal_y100_id='".$order_info['Fmain_id']."' order by Fmain_id asc";
		$tbl_name=$MYSQL_TABS['portal_y100_cnt'];
		getall_data($tbl_name, $where_clause, $order_cnt_info);

		$kol_info=array();
		$where_clause="Fmain_id = '".AddSlashes($order_info['kol_id'])."' ";# and is_hide='2'
		$tbl_name="sys_portal_j3";
		get_data($tbl_name, $where_clause, $kol_info);

		for($j=0;$j<count($order_cnt_info);$j++){
			if($kol_info['product_id']==$order_cnt_info[$j]['product_id']){
				$have_kol = 1;
			}
		}
   	}
   	if(!$have_kol){
	   	$upd_info = array();
	   	$upd_info['kol_id'] = "";
	   	$where_clause=" Fmain_id='".$order_id."' order by Fmain_id asc";
	   	$tbl_name=$MYSQL_TABS['portal_y100'];
	   	update_data($tbl_name, $where_clause, $upd_info);
   	}
   	return $have_kol;
}

#折扣碼
function code_use($code_num,$member_userid,$order_id){
	global $MYSQL_VARS,$dblink,$MYSQL_TABS;
	$return_arr = array();

	$code_info=array();
	$where_clause=" set_sale_code = '".$code_num."' and set_sale_start <= '".date("Y-m-d")."' and set_sale_end >= '".date("Y-m-d")."' ";
	$tbl_name="sys_set_sale_code_list";
	get_data($tbl_name, $where_clause, $code_info);
	$order_info=array();
	$where_clause=" Fmain_id='".$order_id."'";
	$tbl_name=$MYSQL_TABS['portal_y100'];
	get_data($tbl_name, $where_clause, $order_info);

	if($order_info['kol_id']){
		$return_arr['error'] = "此訂單不可使用折扣碼";
	}
	else if($code_info['set_sale_fixed_deductible']){
		$y100_info=array();
		$where_clause=" Fmain_id != '".$order_id."' and member_userid = '".$member_userid."' and use_code = '".$code_num."' and is_confirm = '1' ";
		$tbl_name="sys_portal_y100";
		getall_data($tbl_name, $where_clause, $y100_info);
		if(count($y100_info)==0){
			#發行張數確認
			$y100_info=array();
			$where_clause=" Fmain_id != '".$order_id."' and use_code = '".$code_num."' and is_confirm = '1' and pay_state != '訂單取消' and pay_state != '退貨中' and pay_state != '已退貨' ";
			$tbl_name="sys_portal_y100";
			getall_data($tbl_name, $where_clause, $y100_info);
			if(count($y100_info) >= $code_info['all_num']){
				$return_arr['error'] = "已達使用次數上限";
			}
			else if($code_info['set_sale_range']=="1"){#查總價
				if($order_info['old_sum_total']-$order_info['amount_sale_info_money']-$order_info['use_bonus']-$order_info['coupon_money']>=$code_info['set_sale_fixed_money']){
					$return_arr['title'] = $code_info['set_product_sale_title'];
					$return_arr['money'] = $code_info['set_sale_fixed_deductible'];
					$return_arr['code_id'] = $code_info['Fmain_id'];
					$return_arr['product_id'] = "all";
				}
				else{
					$return_arr['error'] = "全館消費未滿額";
				}
			}
			else{
				$product_id_arr = explode(",", $code_info['set_sale_range_product_id']);
				$in_order = 0;
				$order_cnt_info=array();
				$where_clause=" portal_y100_id='".$order_id."' and is_addbuy = '2' order by Fmain_id asc";
				$tbl_name=$MYSQL_TABS['portal_y100_cnt'];
				getall_data($tbl_name, $where_clause, $order_cnt_info);
				for($j=0;$j<count($order_cnt_info);$j++){
					if(in_array($order_cnt_info[$j]['product_id'], $product_id_arr))	$in_order = 1;
				}
				if($in_order){
					$return_arr['title'] = $code_info['set_product_sale_title'];
					$return_arr['money'] = $code_info['set_sale_fixed_deductible'];
					$return_arr['code_id'] = $code_info['Fmain_id'];
					$return_arr['product_id'] = $code_info['set_sale_range_product_id'];
				}
				else{
					$return_arr['error'] = "未購買指定商品";
				}
			}
		}
		else{
			$return_arr['error'] = "已使用過此折扣碼";
		}
	}
	else{
		$return_arr['error'] = "不適用";
	}

	return $return_arr;
}

#折價券
function coupon_use($coupon_id,$member_userid,$order_id){
	global $MYSQL_VARS,$dblink,$MYSQL_TABS;
	$return_arr = array();

	$code_info=array();
	$where_clause=" Fmain_id = '".$coupon_id."' and set_sale_start <= '".date("Y-m-d")."' and set_sale_end >= '".date("Y-m-d")."' ";
	$tbl_name="sys_set_sale_coupon_list";
	get_data($tbl_name, $where_clause, $code_info);
	$order_info=array();
	$where_clause=" Fmain_id='".$order_id."'";
	$tbl_name=$MYSQL_TABS['portal_y100'];
	get_data($tbl_name, $where_clause, $order_info);

	if($order_info['kol_id']){
		$return_arr['error'] = "此訂單不可使用折價券";
	}
	else if($code_info['set_sale_fixed_deductible']){
		$member_coupon_info=array();
		$where_clause=" coupon_id = '".$coupon_id."' and member_userid = '".$member_userid."' and use_date = '0000-00-00 00:00:00' ";
		$tbl_name="member_coupon_list";
		get_data($tbl_name, $where_clause, $member_coupon_info);
		if($member_coupon_info['Fmain_id']){
			if($member_coupon_info['deadline_date'] != "9999-12-31" && time()>strtotime($member_coupon_info['deadline_date']." 23:59:59")){
				$return_arr['error'] = "已過期";
			}
			else if(!$order_id){#無訂單，僅列折價券狀態
				$return_arr['title'] = $code_info['set_product_sale_title'];
				$return_arr['money'] = $code_info['set_sale_fixed_deductible'];
			}
			else if($code_info['set_sale_range']=="1"){#查總價
				if($order_info['old_sum_total']-$order_info['amount_sale_info_money']-$order_info['use_bonus']>=$code_info['set_sale_fixed_money']){
					$return_arr['title'] = $code_info['set_product_sale_title'];
					$return_arr['money'] = $code_info['set_sale_fixed_deductible'];
					$return_arr['product_id'] = "all";
				}
				else{
					$return_arr['error'] = "全館消費未滿額";
				}
			}
			else{
				$product_id_arr = explode(",", $code_info['set_sale_range_product_id']);
				$in_order = 0;
				$order_cnt_info=array();
				$where_clause=" portal_y100_id='".$order_id."' and is_addbuy = '2' order by Fmain_id asc";
				$tbl_name=$MYSQL_TABS['portal_y100_cnt'];
				getall_data($tbl_name, $where_clause, $order_cnt_info);
				for($j=0;$j<count($order_cnt_info);$j++){
					if(in_array($order_cnt_info[$j]['product_id'], $product_id_arr))	$in_order = 1;
				}
				if($in_order){
					$return_arr['title'] = $code_info['set_product_sale_title'];
					$return_arr['money'] = $code_info['set_sale_fixed_deductible'];
					$return_arr['product_id'] = $code_info['set_sale_range_product_id'];
				}
				else{
					$return_arr['error'] = "未購買指定商品";
				}
			}

		}
		else{
			$return_arr['error'] = "此折價券已不可使用";
		}
	}
	else{
		$return_arr['error'] = "無此折價券";
	}

	return $return_arr;
}

//
function get_size_id_text($size_id)
{
    global $MYSQL_VARS,$dblink,$MYSQL_TABS;

    $check_size_info=array();
    $where_clause="Fmain_id = '".$size_id."'";
    $tbl_name=$MYSQL_TABS['portal_x100_cnt_size'];
    get_data($tbl_name, $where_clause, $check_size_info);
    //show_array($check_size_info);

    return $check_size_info['size_name'];

}

function get_size_id_number($size_id)
{
    global $MYSQL_VARS,$dblink,$MYSQL_TABS;

    $check_size_info=array();
    $where_clause="Fmain_id = '".$size_id."'";
    $tbl_name=$MYSQL_TABS['portal_x100_cnt_size'];
    get_data($tbl_name, $where_clause, $check_size_info);
    //show_array($check_size_info);

    return $check_size_info['item_number'];

}



 /******************************
      滿件優惠
*******************************/
function get_set_product_sale_amount($order_info,$order_cnt_info)
{
  global $MYSQL_VARS,$dblink,$MYSQL_TABS,$_SERVER;
  global $set_sale_amount_end;

  return count_sale_amount($order_info,$order_cnt_info);
  exit;
  $today=date("Y-m-d");

  // 返回的活動名稱
  $return_title="";

//  show_array($order_cnt_info);

//   // 判斷期間
//   $website_data_info=array();
//  	$where_clause=" website_language_id = '1' and (set_sale_amount_start <= '$today' and set_sale_amount_end >= '$today')";
//  	$tbl_name=$MYSQL_TABS['website_data'];
//  	get_data($tbl_name, $where_clause, $website_data_info);
// //     	show_array($website_data_info);
// //     	exit;

  $sale_amount_list=array();
  $where_clause="website_language_id = '1' and (set_sale_amount_start <= '$today' and set_sale_amount_end >= '$today')";
  $tbl_name="sys_set_sale_amount_list";
  getall_data($tbl_name, $where_clause, $sale_amount_list);
  #show_array($sale_amount_list);

  $final_sale_money = 0;#折多少錢
  $final_sale_money_2 = 0;#幾折
  $final_sale_name_arr = array();
  $return_str_arr = array();
  $in_sale_id = array();	#key=商品id => money=各商品的折扣價，id=$sale_amount_list[$iii]['Fmain_id']
  $final_sale_giveaway_info_arr = array();	$final_sale_giveaway_id_arr = array();	#贈品名和贈品id
  $sale_amount_log_1 = "";	#打幾折log
  $sale_amount_log_2 = "";	#折扣多少錢log
  $have_rate_sale = 0;	#是否有打折	若為1，則折扣x元皆不適用
  $name_arr = array();	#key=$sale_amount_list[$iii]['Fmain_id'] => title=log文字，status=m使用,n不使用，type=rate打x折,sale折x元,gift贈品
  $type_arr = array();	#key=$sale_amount_list[$iii]['Fmain_id'] => value=rate打x折,sale折x元,gift贈品
  for($iii=0;$iii<count($sale_amount_list);$iii++)
  {

    // 是否需要會員
    $sn=0;
    if($sale_amount_list[$iii]['set_sale_amount_is_member'] == "1"){
      if($order_info['member_userid'] == ""){
        $sn=1;
      }
    }

    if(count($sale_amount_list[$iii]) > 0 and $sn == 0){
         $set_sale_amount_end=$sale_amount_list[$iii]['set_sale_amount_end'];

         /*******************
            取得判斷判斷"滿額"的金額
         **********************/
        // 判斷設定滿額的範圍
        if($sale_amount_list[$iii]['set_sale_amount_range'] == "2")  // 有設定範圍
        {
          $set_product_sale_range_product_id_arr=array();
          $set_product_sale_range_product_id_arr=explode(",",$sale_amount_list[$iii]['set_sale_amount_range_product_id']);
		  #show_array($set_product_sale_range_product_id_arr);
		  $this_product_id_arr = array();	#	符合的商品id

          $product_total=0;
          $product_total2=0;
           for($i=0;$i<count($order_cnt_info);$i++)
          {
              if(in_array($order_cnt_info[$i]['product_id'],$set_product_sale_range_product_id_arr)){
	              $product_total=$product_total+$order_cnt_info[$i]['amount'];
				  $product_total2=$product_total2+$order_cnt_info[$i]['small_price'];
				  $this_product_id_arr[] = $order_cnt_info[$i]['product_id'];
              }


          }

        }
        else  // 全部商品
        {

         $product_total=0;
         $product_total2=0;
         for($i=0;$i<count($order_cnt_info);$i++)
          {
              $product_total=$product_total+$order_cnt_info[$i]['amount'];
              $product_total2=$product_total2+$order_cnt_info[$i]['small_price'];

          }



        }

        // show_array($order_cnt_info);
        #print $product_total."_".$sale_amount_list[$iii]['set_product_sale_amount_title']."<br>";
        //exit;


        /*******************
            優惠方式
         **********************/

        $sale_money=0; // 被優惠了多少錢
        $sale_giveaway_id=""; // 贈品id
        $rate_sale_money = "";

        if($sale_amount_list[$iii]['set_sale_amount_full'] == "1"){  // 自訂級距

          $set_product_sale_info=array();
          if($sale_amount_list[$iii]['is_add'] == "1"){
	          $where_clause=" website_data_id = '".$sale_amount_list[$iii]['Fmain_id']."' and CAST(`set_sale_amount_moneylimit` AS DECIMAL(10,2)) <= '$product_total' order by CAST(`set_sale_amount_moneylimit` AS DECIMAL(10,2)) desc";
	      }
	      else{
		      $where_clause=" website_data_id = '".$sale_amount_list[$iii]['Fmain_id']."' and CAST(`set_sale_amount_moneylimit` AS DECIMAL(10,2)) <= '$product_total' order by CAST(`set_sale_amount_moneylimit` AS DECIMAL(10,2)) desc limit 1";
	      }

//          print $where_clause."<br>";
          $tbl_name="sys_website_data_set_sale_amount";
          getall_data($tbl_name, $where_clause, $set_product_sale_info);
		  #show_array($set_product_sale_info);
          //exit;


          $sale_giveaway_info_arr=array();
          if(count($set_product_sale_info) > 0){
		    for($ss=0;$ss<count($set_product_sale_info);$ss++){
			    if($set_product_sale_info[$ss]['set_sale_amount'] != "" && ($rate_sale_money == "" || $set_product_sale_info[$ss]['set_sale_amount'] < $rate_sale_money))  // 幾折
	            {
	                 $set_product_sale_rate=$set_product_sale_info[$ss]['set_sale_amount'] / 10;

	                 $rate_sale_money=round($product_total2*$set_product_sale_rate);

	                 $sale_money+=$product_total2-$rate_sale_money;
					 $type_arr[$sale_amount_list[$iii]['Fmain_id']] = "rate";

	            }
	            elseif(trim($set_product_sale_info[$ss]['set_sale_amount_money']) != "" )  // 折抵
	            {
	                 $set_product_sale_money=trim($set_product_sale_info[$ss]['set_sale_amount_money']);
	                 $sale_money+=$set_product_sale_money;
	                 $type_arr[$sale_amount_list[$iii]['Fmain_id']] = "sale";
	            }
	            if(trim($set_product_sale_info[$ss]['giveaway_id']) != "")   #贈品，miku：因可同時送贈品而拿掉else
	            {
	                 $sale_giveaway_id=$set_product_sale_info[$ss]['giveaway_id'];
	                 if($sale_amount_list[$iii]['is_add'] == "1"){
		                 $sale_giveaway_info_arr[$sale_amount_list[$iii]['Fmain_id']][] = get_giveaway_info($sale_giveaway_id);
	                 }
	                 else{
		                 $sale_giveaway_info_arr[$sale_amount_list[$iii]['Fmain_id']]=get_giveaway_info($sale_giveaway_id);
	                 }

	            }
		    }
          }
          else{
/*
	          if($_SERVER['REMOTE_ADDR']=="114.35.245.43"){
	          	unset($sale_amount_list[$iii]);
	          }
*/
          }

        }else{   // 固定滿多少折抵多少

          $a=Floor((int)$product_total / (int)$sale_amount_list[$iii]['set_sale_amount_fixed_money']);
          $b=$a*(int)$sale_amount_list[$iii]['set_sale_amount_fixed_deductible'];
          $sale_money=$b;
		  $type_arr[$sale_amount_list[$iii]['Fmain_id']] = "sale";
        }
        if($_SERVER['REMOTE_ADDR']=="111.249.123.148"){
        	#show_array($sale_giveaway_info_arr);
        	#print $sale_money."_".$sale_amount_list[$iii]['set_product_sale_amount_title'];
        }

		if($sale_money != "" and $type_arr[$sale_amount_list[$iii]['Fmain_id']]=="rate"){#打幾折
			if($final_sale_money_2 <= $sale_money){
				if($have_rate_sale){#$return_str_arr['p'] != ""
					#if($return_str_arr['n'] != "")	$return_str_arr['n'] .= "<br>";
					#$return_str_arr['n'] .= "<font style='color:#333;'>".$return_str_arr['p']."(不適用)</font>";
					$name_arr[$have_rate_sale]['status'] = "n";
				}
				$final_sale_money_2 = $sale_money;
				#$return_str_arr['p'] = $sale_amount_list[$iii]['set_product_sale_amount_title'];
				if(count($this_product_id_arr)){
					$sale_amount_log = $sale_amount_list[$iii]['set_product_sale_amount_title']."`".$sale_money."`".implode (",", $this_product_id_arr);
				}
				else{
					$sale_amount_log = $sale_amount_list[$iii]['set_product_sale_amount_title']."`".$sale_money."`all";
				}
				$name_arr[$sale_amount_list[$iii]['Fmain_id']] = array("title"=>$sale_amount_log."@@@" , "status"=>"m","type"=>"rate");
			}
			else{
				#if($return_str_arr['n'] != "")	$return_str_arr['n'] .= "<br>";
				#$return_str_arr['n'] .= "<font style='color:#333;'>".$sale_amount_list[$iii]['set_product_sale_amount_title']."(不適用)</font>";
				$name_arr[$sale_amount_list[$iii]['Fmain_id']] = array("title"=>$sale_amount_list[$iii]['set_product_sale_amount_title']."`".$sale_money."`@@@" , "status"=>"n","type"=>"rate");
			}
			$have_rate_sale = $sale_amount_list[$iii]['Fmain_id'];
			if($_SERVER['REMOTE_ADDR']=="111.249.123.148"){
				#print "rate=".$have_rate_sale;
	        	#show_array($name_arr);
	        }
		}
	    else if( $sale_money != "" and $type_arr[$sale_amount_list[$iii]['Fmain_id']]=="sale")
	    {#折扣多少錢
				$can_count = 0;
				if(count($this_product_id_arr)){
					foreach($this_product_id_arr as $product_id){
						if(!$in_sale_id[$product_id]['money'] || $in_sale_id[$product_id]['money'] < $sale_money){
							$can_count = ($in_sale_id[$product_id]['money'])?$sale_money-$in_sale_id[$product_id]['money']:$sale_money;
							$in_sale_id[$product_id]['money'] = $sale_money;
							if($in_sale_id[$product_id]['id'])	$name_arr[$in_sale_id[$product_id]['id']]['status'] = "n";
							$in_sale_id[$product_id]['id'] = $sale_amount_list[$iii]['Fmain_id'];
						}
					}
				}
				else{
					if(!$in_sale_id['all']['money'] || $in_sale_id['all']['money'] < $sale_money){
						$can_count = ($in_sale_id['all']['money'])?$sale_money-$in_sale_id['all']['money']:$sale_money;
						$in_sale_id['all']['money'] = $sale_money;
						if($in_sale_id['all']['id'])	$name_arr[$in_sale_id['all']['id']]['status'] = "n";
						$in_sale_id['all']['id'] = $sale_amount_list[$iii]['Fmain_id'];
					}
				}
				#print $can_count."_".$sale_amount_list[$iii]['set_product_sale_amount_title']."<br>";
				if($can_count){
					if(count($this_product_id_arr)){
						$name_arr[$sale_amount_list[$iii]['Fmain_id']] = array("title"=>$sale_amount_list[$iii]['set_product_sale_amount_title']."`".$sale_money."`".implode (",", $this_product_id_arr)."@@@" , "status"=>"m","type"=>"sale");
					}
					else{
						$name_arr[$sale_amount_list[$iii]['Fmain_id']] = array("title"=>$sale_amount_list[$iii]['set_product_sale_amount_title']."`".$sale_money."`all@@@" , "status"=>"m","type"=>"sale");
					}
					$final_sale_money += $can_count;
				}
				else{
					$name_arr[$sale_amount_list[$iii]['Fmain_id']] = array("title"=>$sale_amount_list[$iii]['set_product_sale_amount_title']."`".$sale_money."`all@@@" , "status"=>"n","type"=>"sale");
				}

	    }

	    if(count($sale_giveaway_info_arr) > 0)	#MIKU在5/30時修折扣同時送贈品的bug，所以拿掉了前面的else
	    {
	        foreach($sale_giveaway_info_arr as $sale_giveaway_key => $sale_giveaway_info)
	        {
	           #$return_str_gift = $sale_amount_list[$iii]['set_product_sale_amount_title']."贈送".$sale_giveaway_info_arr['text_field_0'];
	           if($sale_giveaway_key == $sale_amount_list[$iii]['Fmain_id']){
		           if($sale_giveaway_info['Fmain_id']){
			           $return_str_arr[$sale_amount_list[$iii]['Fmain_id']] = $sale_amount_list[$iii]['set_product_sale_amount_title']."贈送".$sale_giveaway_info['text_field_0'];
					   $final_sale_giveaway_info_arr[] = "".$sale_giveaway_info['text_field_0'];
					   $final_sale_giveaway_id_arr[] = "".$sale_giveaway_info['text_field_2'];
		           }
		           else{
			           foreach($sale_giveaway_info as $sale_key => $sale_info){
				           $return_str_arr[] = $sale_amount_list[$iii]['set_product_sale_amount_title']."贈送".$sale_info['text_field_0'];
						   $final_sale_giveaway_info_arr[] = "".$sale_info['text_field_0'];
						   $final_sale_giveaway_id_arr[] = "".$sale_info['text_field_2'];
			           }
		           }

	           }

	        }
	/*
	        else
	        $final_sale_giveaway_info_arr="";
	*/

	    }
    }
  }

	if($_SERVER['REMOTE_ADDR']=="111.249.123.148"){
		#show_array($name_arr);
		#print "rate=".$final_sale_money."+".$final_sale_money_2;
	}
	if($have_rate_sale){
		$final_sale_money = 0;
	}

  foreach($name_arr as $name_key => $name_val){
	  $s_val = explode("`", $name_val['title']);
	  if($name_val['status'] == "m" && $have_rate_sale && $name_val['type'] == "rate"){
		  $sale_amount_log_1 .= $name_val['title'];
		  if($return_str_arr['m'] != "")	$return_str_arr['m'] .= "<br>";
		  $return_str_arr['m'] .= $s_val[0];
	  }
	  else if($name_val['status'] == "m" && !$have_rate_sale && $name_val['type'] == "sale"){
		  $sale_amount_log_2 .= $name_val['title'];
		  if($return_str_arr['m'] != "")	$return_str_arr['m'] .= "<br>";
		  $return_str_arr['m'] .= $s_val[0];
	  }
	  else if($name_val['status'] == "m" && $have_rate_sale && $name_val['type'] == "sale"){
		  if($return_str_arr['n'] != "")	$return_str_arr['n'] .= "<br>";
		  $return_str_arr['n'] .= "<font style='color:#a5a5a5;'>".$s_val[0]."(不適用)</font>";
	  }
	  else if($name_val['status'] == "n"){
		  if($return_str_arr['n'] != "")	$return_str_arr['n'] .= "<br>";
		  $return_str_arr['n'] .= "<font style='color:#a5a5a5;'>".$s_val[0]."(不適用)</font>";
	  }
  }
  #show_array($name_val);print $have_rate_sale;
/*
if($_SERVER['REMOTE_ADDR']=="114.35.245.43"){
	show_array($return_str_arr);
}
*/

  if(count($order_info) > 0){
    #if($final_sale_money_2)	$return_str_arr['p'] .= "折抵".$final_sale_money_2."元";
    #if($final_sale_money)	$return_str_arr['m'] .= "折抵".$final_sale_money."元";
    $update_info=array();
    $update_info['amount_sale_info_money']=(string)$final_sale_money*1+$final_sale_money_2*1;
    $update_info['amount_sale_info_money_give_name']=implode (",", $final_sale_giveaway_info_arr);
    $update_info['amount_sale_info_money_give_id']=implode ("`", $final_sale_giveaway_id_arr);
    $where_clause="Fmain_id = '".$order_info['Fmain_id']."' ";
    $tbl_name="sys_portal_y100";
    update_data($tbl_name, $where_clause, $update_info);
	$return_title = implode ("<br>", $return_str_arr);
  }
  #print $sale_amount_log_1."___".$sale_amount_log_2;
  if(count($order_info) > 0){
      if($final_sale_money_2)	$return_str_arr['p'] .= "折抵".$final_sale_money_2."元";
      if($final_sale_money)	$return_str_arr['m'] .= "折抵".$final_sale_money."元";
      $update_info=array();
      $update_info['amount_sale_info_log']=AddSlashes(implode ("<br>", $return_str_arr));
      $update_info['sale_amount_log_1']=AddSlashes($sale_amount_log_1);
      $update_info['sale_amount_log_2']=AddSlashes($sale_amount_log_2);
      $where_clause="Fmain_id = '".$order_info['Fmain_id']."' ";
      $tbl_name="sys_portal_y100";
      update_data($tbl_name, $where_clause, $update_info);
	}

  return $return_title;

}


  /******************************
      滿額優惠
    *******************************/
  function get_set_product_sale($order_info,$order_cnt_info)
{
  global $MYSQL_VARS,$dblink,$MYSQL_TABS,$_SERVER;
  global $set_sale_amount_end;

  return count_sale_money($order_info,$order_cnt_info);
  exit;
  $order_id = $order_info['Fmain_id'];

	$order_info=array();
	$where_clause="Fmain_id = '".$order_id."'  ";
	$tbl_name=$MYSQL_TABS['portal_y100'];
	get_data($tbl_name, $where_clause, $order_info);
	//      show_array($order_info);

	// 判斷是否有滿件優惠了(只判斷有沒有優惠到金額)
	$is_sale_sn=0;
	if( $order_info['amount_sale_info_money'] > 0 or $order_info['amount_sale_info_money_give_name'] != "" )	{
		$is_sale_sn=1;
	}

  $today=date("Y-m-d");

  // 返回的活動名稱
  $return_title="";

  if($is_sale_sn == 1){   // 已經有滿件優惠  滿額不再做優惠
 	    $update_info=array();
     	$update_info['sale_info_money']="";
     	#$update_info['sale_info_give_name']="";
     	$where_clause="Fmain_id = '".$order_info['Fmain_id']."' ";
     	$tbl_name="sys_portal_y100";
     	update_data($tbl_name, $where_clause, $update_info);
 	}

  $sale_amount_list=array();
  $where_clause="website_language_id = '1' and (set_product_sale_start <= '$today' and set_product_sale_end >= '$today')";
  $tbl_name="sys_set_sale_money_list";
  getall_data($tbl_name, $where_clause, $sale_amount_list);
  #show_array($sale_amount_list);

  $final_sale_money = 0;#折多少錢
  $final_sale_money_2 = 0;#幾折
  $final_sale_name_arr = array();
  $return_str_arr = array();
  $in_sale_id = array();	#已計算的商品(若不在其中就可以計算進去)
  $final_sale_giveaway_info_arr = array();	$final_sale_giveaway_id_arr = array();	#贈品名和贈品id
  $sale_amount_log_1 = "";	#打幾折log
  $sale_amount_log_2 = "";	#折扣多少錢log
  $have_rate_sale = 0;	#是否有打折	若為1，則折扣x元皆不適用
  $name_arr = array();	#key=$sale_amount_list[$iii]['Fmain_id'] => title=log文字，status=m使用,n不使用，type=rate打x折,sale折x元,gift贈品
  $type_arr = array();	#key=$sale_amount_list[$iii]['Fmain_id'] => value=rate打x折,sale折x元,gift贈品
  for($iii=0;$iii<count($sale_amount_list);$iii++)
  {

    // 是否需要會員
    $sn=0;
    if($sale_amount_list[$iii]['set_product_sale_is_member'] == "1"){
      if($order_info['member_userid'] == ""){
        $sn=1;
      }
    }

    if(count($sale_amount_list[$iii]) > 0 and $sn == 0){
         $set_sale_amount_end=$sale_amount_list[$iii]['set_product_sale_end'];

         /*******************
            取得判斷判斷"滿額"的金額
         **********************/
        // 判斷設定滿額的範圍
        if($sale_amount_list[$iii]['set_product_sale_range'] == "2")  // 有設定範圍
        {
          $set_product_sale_range_product_id_arr=array();
          $set_product_sale_range_product_id_arr=explode(",",$sale_amount_list[$iii]['set_product_sale_range_product_id']);
		  #show_array($set_product_sale_range_product_id_arr);


          $product_total=0;
          $product_total2=0;
          $this_product_id_arr = array();	#	符合的商品id
           for($i=0;$i<count($order_cnt_info);$i++)
          {
              if(in_array($order_cnt_info[$i]['product_id'],$set_product_sale_range_product_id_arr)){
	              $product_total=$product_total+$order_cnt_info[$i]['amount'];
				  $product_total2=$product_total2+$order_cnt_info[$i]['small_price'];
				  $this_product_id_arr[] = $order_cnt_info[$i]['product_id'];

              }


          }

        }
        else  // 全部商品
        {

         $product_total=0;
         $product_total2=0;
         for($i=0;$i<count($order_cnt_info);$i++)
          {
              $product_total=$product_total+$order_cnt_info[$i]['amount'];
              $product_total2=$product_total2+$order_cnt_info[$i]['small_price'];

          }



        }

        // show_array($order_cnt_info);
        #print $product_total."_".$sale_amount_list[$iii]['set_product_sale_title'];
        //exit;


        /*******************
            優惠方式
         **********************/

        $sale_money=0; // 被優惠了多少錢
        $sale_giveaway_id=""; // 贈品id
        $rate_sale_money = "";
        if($sale_amount_list[$iii]['set_product_sale_full'] == "1"){  // 自訂級距

          $set_product_sale_info=array();
          if($sale_amount_list[$iii]['is_add'] == "1"){
	          $where_clause=" website_data_id = '".$sale_amount_list[$iii]['Fmain_id']."' and CAST(`set_product_sale_moneylimit` AS DECIMAL(10,2)) <= '$product_total2' order by CAST(`set_product_sale_moneylimit` AS DECIMAL(10,2)) desc";
	      }
	      else{
		      $where_clause=" website_data_id = '".$sale_amount_list[$iii]['Fmain_id']."' and CAST(`set_product_sale_moneylimit` AS DECIMAL(10,2)) <= '$product_total2' order by CAST(`set_product_sale_moneylimit` AS DECIMAL(10,2)) desc limit 1";
	      }

//          print $where_clause."<br>";
          $tbl_name="sys_website_data_set_product_sale";
          getall_data($tbl_name, $where_clause, $set_product_sale_info);
		  #show_array($set_product_sale_info);
          //exit;


          $sale_giveaway_info_arr=array();
          if(count($set_product_sale_info) > 0){
		    for($ss=0;$ss<count($set_product_sale_info);$ss++){
			    if($set_product_sale_info[$ss]['set_product_sale'] != "" && ($rate_sale_money == "" || $set_product_sale_info[$ss]['set_product_sale'] < $rate_sale_money))  // 幾折
	            {
	                 $set_product_sale_rate=$set_product_sale_info[$ss]['set_product_sale'] / 10;

	                 $rate_sale_money=round($product_total2*$set_product_sale_rate);

	                 $sale_money+=$product_total2-$rate_sale_money;
					 $type_arr[$sale_amount_list[$iii]['Fmain_id']] = "rate";

	            }
	            elseif(trim($set_product_sale_info[$ss]['set_product_sale_money']) != "")  // 折抵
	            {
	                 $set_product_sale_money=trim($set_product_sale_info[$ss]['set_product_sale_money']);
	                 $sale_money+=$set_product_sale_money;
	                 $type_arr[$sale_amount_list[$iii]['Fmain_id']] = "sale";
	            }
	            if(trim($set_product_sale_info[$ss]['giveaway_id']) != "")   #贈品，miku：因可同時送贈品而拿掉else
	            {
	                 $sale_giveaway_id=$set_product_sale_info[$ss]['giveaway_id'];
	                 if($sale_amount_list[$iii]['is_add'] == "1"){
		                 $sale_giveaway_info_arr[$sale_amount_list[$iii]['Fmain_id']][] = get_giveaway_info($sale_giveaway_id);
	                 }
	                 else{
		                 $sale_giveaway_info_arr[$sale_amount_list[$iii]['Fmain_id']]=get_giveaway_info($sale_giveaway_id);
	                 }

	            }
		    }
          }

        }else{   // 固定滿多少折抵多少

          $a=Floor((int)$product_total2 / (int)$sale_amount_list[$iii]['set_product_sale_fixed_money']);
          $b=$a*(int)$sale_amount_list[$iii]['set_product_sale_fixed_deductible'];
          $sale_money=$b;

        }
		#show_array($sale_giveaway_info_arr);
		#print $sale_money."_".$sale_amount_list[$iii]['set_product_sale_title'];
		if($sale_money != "" and $type_arr[$sale_amount_list[$iii]['Fmain_id']]=="rate"){#打幾折
			if($final_sale_money_2 <= $sale_money){
				if($have_rate_sale){
					#if($return_str_arr['n'] != "")	$return_str_arr['n'] .= "<br>";
					#$return_str_arr['n'] .= "<font style='color:#333;'>".$return_str_arr['p']."(不適用)</font>";
					$name_arr[$have_rate_sale]['status'] = "n";
				}
				$final_sale_money_2 = $sale_money;
				#$return_str_arr['p'] = $sale_amount_list[$iii]['set_product_sale_title'];
				if(count($this_product_id_arr)){
					$sale_amount_log = $sale_amount_list[$iii]['set_product_sale_title']."`".$sale_money."`".implode (",", $this_product_id_arr);
				}
				else{
					$sale_amount_log = $sale_amount_list[$iii]['set_product_sale_title']."`".$sale_money."`all";
				}
				$name_arr[$sale_amount_list[$iii]['Fmain_id']] = array("title"=>$sale_amount_log."@@@" , "status"=>"m","type"=>"rate");
			}
			else{
				#if($return_str_arr['n'] != "")	$return_str_arr['n'] .= "<br>";
				#$return_str_arr['n'] .= "<font style='color:#333;'>".$sale_amount_list[$iii]['set_product_sale_title']."(不適用)</font>";
				$name_arr[$sale_amount_list[$iii]['Fmain_id']] = array("title"=>$sale_amount_list[$iii]['set_product_sale_title']."`".$sale_money."`@@@" , "status"=>"n","type"=>"rate");
			}
			$have_rate_sale = $sale_amount_list[$iii]['Fmain_id'];
		}
	    else if( $sale_money != ""  and $type_arr[$sale_amount_list[$iii]['Fmain_id']]=="sale")
	    {#折扣多少錢
// 			if($final_sale_money <= $sale_money){
				$can_count = 0;
				if(count($this_product_id_arr)){
					foreach($this_product_id_arr as $product_id){
						if(!in_array($product_id, $in_sale_id)){
							$in_sale_id[] = $product_id;
							$can_count = 1;
						}
					}
				}
				else{
					if(!in_array("all", $in_sale_id)){
						$in_sale_id[] = "all";
						$can_count = 1;
					}
				}
				if($can_count){
					$final_sale_money += $sale_money;
					#if($return_str_arr['m'] != "")			$return_str_arr['m'] .=  "<br>";
					#$return_str_arr['m'] .= $sale_amount_list[$iii]['set_product_sale_title'];
					if(count($this_product_id_arr)){
						$name_arr[$sale_amount_list[$iii]['Fmain_id']] = array("title"=>$sale_amount_list[$iii]['set_product_sale_title']."`".$sale_money."`".implode (",", $this_product_id_arr)."@@@" , "status"=>"m","type"=>"sale");
					}
					else{
						$name_arr[$sale_amount_list[$iii]['Fmain_id']] = array("title"=>$sale_amount_list[$iii]['set_product_sale_title']."`".$sale_money."`all@@@" , "status"=>"m","type"=>"sale");
					}
				}
				else{
					#if($return_str_arr['n'] != "")	$return_str_arr['n'] .= "<br>";
					#$return_str_arr['n'] .= "<font style='color:#333;'>".$sale_amount_list[$iii]['set_product_sale_title']."(不適用)</font>";
					$name_arr[$sale_amount_list[$iii]['Fmain_id']] = array("title"=>$sale_amount_list[$iii]['set_product_sale_title']."`".$sale_money."`all@@@" , "status"=>"n","type"=>"sale");
				}
/*
			}
			else{
				$return_str_arr['n'] .= "<font style='color:#333;'>".$sale_amount_list[$iii]['set_product_sale_title']."(不適用)</font>";
			}
*/
	    }

	    if(count($sale_giveaway_info_arr) > 0)	#MIKU在5/30時修折扣同時送贈品的bug，所以拿掉了前面的else
	    {
	        foreach($sale_giveaway_info_arr as $sale_giveaway_key => $sale_giveaway_info)
	        {
	           #$return_str_gift = $sale_amount_list[$iii]['set_product_sale_title']."贈送".$sale_giveaway_info_arr['text_field_0'];
	           if($sale_giveaway_key == $sale_amount_list[$iii]['Fmain_id']){
		           if($sale_giveaway_info['Fmain_id']){
			           $return_str_arr[$sale_amount_list[$iii]['Fmain_id']] = $sale_amount_list[$iii]['set_product_sale_title']."贈送".$sale_giveaway_info['text_field_0'];
					   $final_sale_giveaway_info_arr[] = "".$sale_giveaway_info['text_field_0'];
					   $final_sale_giveaway_id_arr[] = "".$sale_giveaway_info['text_field_2'];
		           }
		           else{
			           foreach($sale_giveaway_info as $sale_key => $sale_info){
				           $return_str_arr[] = $sale_amount_list[$iii]['set_product_sale_title']."贈送".$sale_info['text_field_0'];
						   $final_sale_giveaway_info_arr[] = "".$sale_info['text_field_0'];
						   $final_sale_giveaway_id_arr[] = "".$sale_info['text_field_2'];
			           }
		           }

	           }

	        }
	/*
	        else
	        $final_sale_giveaway_info_arr="";
	*/

	    }
    }





  }
  #show_array($return_str_arr);
if($_SERVER['REMOTE_ADDR']=="111.249.123.148"){
	#show_array($name_arr);
	#print "rate=".$final_sale_money."+".$final_sale_money_2;
}
	if($have_rate_sale){
		$final_sale_money = 0;
	}

  foreach($name_arr as $name_key => $name_val){
	  $s_val = explode("`", $name_val['title']);
	  if($name_val['status'] == "m" && $have_rate_sale && $name_val['type'] == "rate"){
		  $sale_amount_log_1 .= $name_val['title'];
		  if($return_str_arr['m'] != "")	$return_str_arr['m'] .= "<br>";
		  $return_str_arr['m'] .= $s_val[0];
	  }
	  else if($name_val['status'] == "m" && !$have_rate_sale && $name_val['type'] == "sale"){
		  $sale_amount_log_2 .= $name_val['title'];
		  if($return_str_arr['m'] != "")	$return_str_arr['m'] .= "<br>";
		  $return_str_arr['m'] .= $s_val[0];
	  }
	  else if($name_val['status'] == "m" && $have_rate_sale && $name_val['type'] == "sale"){
		  if($return_str_arr['n'] != "")	$return_str_arr['n'] .= "<br>";
		  $return_str_arr['n'] .= "<font style='color:#a5a5a5;'>".$s_val[0]."(不適用)</font>";
	  }
	  else if($name_val['status'] == "n"){
		  if($return_str_arr['n'] != "")	$return_str_arr['n'] .= "<br>";
		  $return_str_arr['n'] .= "<font style='color:#a5a5a5;'>".$s_val[0]."(不適用)</font>";
	  }
  }
  #show_array($name_val);print $have_rate_sale;
if($_SERVER['REMOTE_ADDR']=="114.34.33.84"){
	#show_array($return_str_arr);
	#print $have_rate_sale."<br>";
	#print $sale_amount_log_1."<br>";
	#print $sale_amount_log_2."<br>";
}


  if(count($order_info) > 0){
    if($is_sale_sn == 0)
	  {
	      $update_info=array();
	      $update_info['sale_info_money']=(string)$final_sale_money*1+$final_sale_money_2*1;
	      $update_info['sale_info_give_name']=implode (",", $final_sale_giveaway_info_arr);
	      $update_info['sale_info_give_id']=implode ("`", $final_sale_giveaway_id_arr);
	      $where_clause="Fmain_id = '".$order_info['Fmain_id']."' ";
	      $tbl_name="sys_portal_y100";
	      update_data($tbl_name, $where_clause, $update_info);
	  }
	  else{
		  $update_info=array();
	      $update_info['sale_info_give_name']=implode (",", $final_sale_giveaway_info_arr);
	      $update_info['sale_info_give_id']=implode ("`", $final_sale_giveaway_id_arr);
	      $where_clause="Fmain_id = '".$order_info['Fmain_id']."' ";
	      $tbl_name="sys_portal_y100";
	      update_data($tbl_name, $where_clause, $update_info);
	  }
	  $return_title = implode ("<br>", $return_str_arr);

  }

  if($is_sale_sn == 1 ){   // 已經有滿件優惠  滿額不再做優惠
	    if($return_title != "")
	    {
	    	$return_title_arr = explode("<br>", $return_title);
			foreach($return_title_arr as $return_key => $return_str){
				if(substr_count($return_str,"贈送")>=1){
					#$return_str = str_replace("###", "贈送", $return_str);
					$return_str = "".$return_str."";
				}
				else if(substr_count($return_str,"(不適用)")==0){
					$return_str = "<font style='color:#a5a5a5;'>".$return_str."(不適用)</font>";
				}
				$return_title_arr[$return_key] = $return_str;
			}
	        $return_title = implode ("<br>", $return_title_arr);
	        $return_title = "<p>".$return_title."</p>";
	        $sale_money="";


	        foreach($return_str_arr as $return_key => $return_str){
				if(substr_count($return_str,"贈送")>=1){
					#$return_str = str_replace("###", "贈送", $return_str);
					$return_str = "".$return_str."";
				}
				else if(substr_count($return_str,"(不適用)")==0){
					$return_str = "<font style='color:#a5a5a5;'>".$return_str."(不適用)</font>";
				}
				$return_str_arr[$return_key] = $return_str;
			}
	    }

	}

	#$return_str_arr['p'] = str_replace("</font><font","</font><br><font",$return_str_arr['p']);
	#$return_str_arr['n'] = str_replace("</font><font","</font><br><font",$return_str_arr['n']);
	#$return_str_arr['m'] = str_replace("</font><font","</font><br><font",$return_str_arr['m']);
if($_SERVER['REMOTE_ADDR']=="114.34.33.84"){
	#show_array($return_str_arr);
	#print AddSlashes(implode ("<br>", $return_str_arr))."<br>";
	#print $sale_amount_log_1."<br>";
	#print $sale_amount_log_2."<br>";
}
  if(count($order_info) > 0){
      if($final_sale_money_2)	$return_str_arr['p'] .= "折抵".$final_sale_money_2."元";
      if($final_sale_money)	$return_str_arr['m'] .= "折抵".$final_sale_money."元";
      $update_info=array();
      $update_info['sale_info_log']=AddSlashes(implode ("<br>", $return_str_arr));
      $where_clause="Fmain_id = '".$order_info['Fmain_id']."' ";
      $tbl_name="sys_portal_y100";
      update_data($tbl_name, $where_clause, $update_info);
	}

  return $return_title;

}

  function get_set_product_sale_old($order_info,$order_cnt_info)
  {
      global $MYSQL_VARS,$dblink,$MYSQL_TABS;
      global $set_product_sale_end;

      $order_id = $order_info['Fmain_id'];

      $order_info=array();
      $where_clause="Fmain_id = '".$order_id."'  ";
      $tbl_name=$MYSQL_TABS['portal_y100'];
      get_data($tbl_name, $where_clause, $order_info);
//      show_array($order_info);

      // 判斷是否有滿件優惠了(只判斷有沒有優惠到金額)
      $is_sale_sn=0;
      if( $order_info['amount_sale_info_money'] > 0 or $order_info['amount_sale_info_money_give_name'] != "" )	{
        $is_sale_sn=1;
      }

      $today=date("Y-m-d");

      // 返回的活動名稱
      $return_title="";


      if($is_sale_sn == 1){   // 已經有滿件優惠  滿額不再做優惠


     	    $update_info=array();
         	$update_info['sale_info_money']="";
         	#$update_info['sale_info_give_name']="";
         	$where_clause="Fmain_id = '".$order_info['Fmain_id']."' ";
         	$tbl_name="sys_portal_y100";
         	update_data($tbl_name, $where_clause, $update_info);

     	}

        $sale_money_list=array();
        $where_clause="website_language_id = '1' and (set_product_sale_start <= '$today' and set_product_sale_end >= '$today')";
        $tbl_name="sys_set_sale_money_list";
        getall_data($tbl_name, $where_clause, $sale_money_list);
        // show_array($sale_money_list);


        $final_sale_money = 0;
        $final_sale_giveaway_info_arr = "";
        $return_str = "";	$return_str_save = "";


        for ($iii=0; $iii < count($sale_money_list); $iii++) {

            // 是否需要會員
            if($sale_money_list[$iii]['set_product_sale_is_member'] == "1"){
                if($order_info['member_userid'] == ""){
                  continue;
                }
            }


               $set_product_sale_end=$sale_money_list[$iii]['set_product_sale_end'];
			   $sale_giveaway_info_arr=array();
               /*******************
                  取得判斷判斷"滿額"的金額
               **********************/
              // 判斷設定滿額的範圍
              if($sale_money_list[$iii]['set_product_sale_range'] == "2")  // 有設定範圍
              {
                    $set_product_sale_range_product_id_arr=array();
                    $set_product_sale_range_product_id_arr=explode(",",$sale_money_list[$iii]['set_product_sale_range_product_id']);

                    $product_total=0;
                     for($i=0;$i<count($order_cnt_info);$i++)
                    {
                        if(in_array($order_cnt_info[$i]['product_id'],$set_product_sale_range_product_id_arr))
                        $product_total=$product_total+$order_cnt_info[$i]['small_price'];

                    }
              }
              else  // 全部商品
              {
                   $product_total=0;
                   for($i=0;$i<count($order_cnt_info);$i++)
                    {
                        $product_total=$product_total+$order_cnt_info[$i]['small_price'];
                    }

              }
        //          print $product_total;
        //          exit;

              /*******************
                  優惠方式
               **********************/

              $sale_money=""; // 被優惠了多少錢
              $sale_giveaway_id=""; // 贈品id
              if($sale_money_list[$iii]['set_product_sale_full'] == "1")  // 自訂級距
              {
                  $set_product_sale_info=array();
                  if($sale_money_list[$iii]['is_add'] == "1"){
	                  $where_clause=" website_data_id = '".$sale_money_list[$iii]['Fmain_id']."' and set_product_sale_moneylimit <= '$product_total' order by set_product_sale_moneylimit desc";
                  }
                  else{
	                  $where_clause=" website_data_id = '".$sale_money_list[$iii]['Fmain_id']."' and set_product_sale_moneylimit <= '$product_total' order by set_product_sale_moneylimit desc limit 1";
                  }

                  $tbl_name="sys_website_data_set_product_sale";
                  getall_data($tbl_name, $where_clause, $set_product_sale_info);
                  //show_array($set_product_sale_info);
                  //exit;

                  if(count($set_product_sale_info) > 0)
                  {
                      $sale_giveaway_info_arr=array();
					  for($ss=0;$ss<count($set_product_sale_info);$ss++){
	                      if($set_product_sale_info[$ss]['set_product_sale'] != "" && $rate_sale_money == "")  // 幾折
	                      {
	                           $set_product_sale_rate=$set_product_sale_info[$ss]['set_product_sale'] / 10;
	                           $rate_sale_money=round($product_total*$set_product_sale_rate);
	                           $sale_money=$product_total-$rate_sale_money;

	                      }
	                      elseif(trim($set_product_sale_info[$ss]['set_product_sale_money']) != "")  // 折抵
	                      {
	                           $set_product_sale_money=trim($set_product_sale_info[$ss]['set_product_sale_money']);
	                           $sale_money+=$set_product_sale_money;
	                      }
	                      if(trim($set_product_sale_info[$ss]['giveaway_id']) != "")   #贈品，miku：因可同時送贈品而拿掉else
	                      {
	                           $sale_giveaway_id=$set_product_sale_info[$ss]['giveaway_id'];
							   if($sale_money_list[$iii]['is_add'] == "1"){
					                 $sale_giveaway_info_arr[$sale_money_list[$iii]['Fmain_id']][] = get_giveaway_info($sale_giveaway_id);
				                 }
				                 else{
					                 $sale_giveaway_info_arr[$sale_money_list[$iii]['Fmain_id']]=get_giveaway_info($sale_giveaway_id);
				                 }
	                      }
                      }
                  }
              }
              else   // 固定滿多少折抵多少
              {
                  $a=Floor((int)$product_total / (int)$sale_money_list[$iii]['set_product_sale_fixed_money']);
                  $b=$a*(int)$sale_money_list[$iii]['set_product_sale_fixed_deductible'];
                  $sale_money=$b;
              }

#show_array($sale_giveaway_info_arr);
//exit;
//            if($final_sale_money <= $sale_money)
            $final_sale_save = "";
            if($sale_money != "" or count($sale_giveaway_info_arr) > 0)
            {
              $final_sale_money = $final_sale_money+$sale_money;

              if(count($sale_giveaway_info_arr) > 0)
              {
                 foreach($sale_giveaway_info_arr as $sale_giveaway_key =>  $sale_giveaway_info){
	                 if($sale_giveaway_key == $sale_money_list[$iii]['Fmain_id']){
		                 if($sale_giveaway_info['Fmain_id']){
			                 if($save_sale_info_give_name == "")
			                 $save_sale_info_give_name=$sale_giveaway_info['text_field_0'];
			                 else
			                 $save_sale_info_give_name=$save_sale_info_give_name.",".$sale_giveaway_info['text_field_0'];

			                 $final_sale_giveaway_info_arr .= "###".$sale_giveaway_info['text_field_0']."。";
			                 $final_sale_save .= "###".$sale_giveaway_info['text_field_0']."。";
		                 }
		                 else{
			                 foreach($sale_giveaway_info as $sale_key => $sale_info){
				                 if($save_sale_info_give_name == "")
				                 $save_sale_info_give_name=$sale_info['text_field_0'];
				                 else
				                 $save_sale_info_give_name=$save_sale_info_give_name.",".$sale_info['text_field_0'];

				                 $final_sale_giveaway_info_arr .= "###".$sale_info['text_field_0']."。";
				                 $final_sale_save .= "###".$sale_info['text_field_0']."。";
			                 }
		                 }
	                 }
                 }



              }
              else if($is_sale_sn == 0){
	              #$final_sale_giveaway_info_arr="折抵".$sale_money."元";
	              $final_sale_giveaway_info_arr="";
	              $final_sale_save = "折抵".$sale_money."元";
              }
              else{
	              $final_sale_giveaway_info_arr="";
	              $final_sale_save = "";
              }


              if($return_str == "")
              $return_str =$sale_money_list[$iii]['set_product_sale_title'].$final_sale_giveaway_info_arr;
              else
              $return_str =$return_str."@@@".$sale_money_list[$iii]['set_product_sale_title'].$final_sale_giveaway_info_arr;

			  if($return_str_save == "")
              $return_str_save =$sale_money_list[$iii]['set_product_sale_title'].$final_sale_save;
              else
              $return_str_save =$return_str."@@@".$sale_money_list[$iii]['set_product_sale_title'].$final_sale_save;

            }





        }




        if(count($order_info) > 0){

          if($is_sale_sn == 0)
          {
              $update_info=array();
              $update_info['sale_info_money']=(string)$final_sale_money;
              $update_info['sale_info_give_name']=AddSlashes($save_sale_info_give_name);
              $where_clause="Fmain_id = '".$order_info['Fmain_id']."' ";
              $tbl_name="sys_portal_y100";
              update_data($tbl_name, $where_clause, $update_info);
          }
		  else{
			  $update_info=array();
              $update_info['sale_info_give_name']=AddSlashes($save_sale_info_give_name);
              $where_clause="Fmain_id = '".$order_info['Fmain_id']."' ";
              $tbl_name="sys_portal_y100";
              update_data($tbl_name, $where_clause, $update_info);
		  }
          if(($final_sale_money != 0 and $final_sale_money != "") or $final_sale_giveaway_info_arr['text_field_0'] != "")
          {
            $return_title = $return_str;

//            if($final_sale_giveaway_info_arr['text_field_0'] != "")
//               $return_title=$return_title."贈送".$final_sale_giveaway_info_arr['text_field_0']."";

          }
        }


        if($is_sale_sn == 1 ){   // 已經有滿件優惠  滿額不再做優惠
            if($return_title != "")
            {
            	$return_title_arr = explode("@@@", $return_title);
				foreach($return_title_arr as $return_key => $return_str){
					if(substr_count($return_str,"###")>=1){
						$return_str = str_replace("###", "贈送", $return_str);
					}
					else{
						$return_str = "<font style='color:#a5a5a5;'>".$return_str."(不適用)</font>";
					}
					$return_title_arr[$return_key] = $return_str;
				}
	            $return_title = implode ("<br>", $return_title_arr);
	            $return_title = "<p>".$return_title."</p>";
	            $sale_money="";

	            $save_title_arr = explode("@@@", $return_str_save);
	            foreach($save_title_arr as $return_key => $return_str){
					if(substr_count($return_str,"###")>=1){
						$return_str = str_replace("###", "贈送", $return_str);
					}
					else{
						$return_str = "<font style='color:#a5a5a5;'>".$return_str."(不適用)</font>";
					}
					$save_title_arr[$return_key] = $return_str;
				}
	            $return_str_save = implode ("<br>", $save_title_arr);
            }

        }
        else
        {
            $return_title = str_replace("@@@", "<br>", $return_title);
            $return_title = str_replace("###", "贈送", $return_title);

            $return_str_save = str_replace("@@@", "<br>", $return_str_save);
            $return_str_save = str_replace("###", "贈送", $return_str_save);
        }

        if(count($order_info) > 0){
              $update_info=array();
              $update_info['sale_info_log'] = AddSlashes($return_str_save);
              $where_clause="Fmain_id = '".$order_info['Fmain_id']."' ";
              $tbl_name="sys_portal_y100";
              update_data($tbl_name, $where_clause, $update_info);
        }

        return $return_title;



//     	}



  }

  // 取得滿額贈品
  function get_giveaway_info($id)
  {
      global $MYSQL_VARS,$dblink,$MYSQL_TABS;

      $j4_info=array();
     	$where_clause=" Fmain_id = '".$id."' ";
     	$tbl_name="sys_portal_j4";
     	get_data($tbl_name, $where_clause, $j4_info);

     	return $j4_info;



  }

  /******************************
      取得運費並更新
    *******************************/
  function get_traffic_money($order_info,$order_cnt_info)
  {
      global $MYSQL_VARS,$dblink,$MYSQL_TABS;



     	// 取得總價
     	$sum_total=0;

     	for($i=0;$i<count($order_cnt_info);$i++)
     	{
     	    $sum_total=$sum_total+$order_cnt_info[$i]['small_price'];

     	}

     	$total = $sum_total; //商品合計
      $total -= $order_info['amount_sale_info_money'];      // 滿件優惠費用
      $total -= $order_info['use_bonus'];	#購物金
      $total -= $order_info['coupon_money'];	#折價券
      $total -= $order_info['code_money'];	#折扣碼
      $total -= $order_info['sale_info_money'];  // 滿額優惠費用

     	$sum_total=$total;

//     	print $sum_total;
//     	exit;


     	// 取的購物車設定
     	$set_shop_info=array();
     	$where_clause=" Fmain_id = '1'";
     	$tbl_name="sys_portal_j5";
     	get_data($tbl_name, $where_clause, $set_shop_info);

     	$set_shop_info2=array();
     	$where_clause=" Fmain_id = '2'";
     	$tbl_name="sys_portal_j5";
     	get_data($tbl_name, $where_clause, $set_shop_info2);

     	// 運費
     	$set_traffic_money=(int)$set_shop_info['text_field_1'];

     	// 免運費金額
     	$set_free_traffic_money=(int)$set_shop_info2['text_field_1'];

     	$traffic_money=0;
     	if($sum_total < $set_free_traffic_money)
     	   $traffic_money=$set_traffic_money;


     	$update_info=array();
     	$update_info['traffic_money']=$traffic_money;
     	$where_clause="Fmain_id = '".$order_info['Fmain_id']."' ";
     	$tbl_name="sys_portal_y100";
     	update_data($tbl_name, $where_clause, $update_info);


      return $traffic_money;

  }

  function get_addbuy_info($addbuy_id_arr)
  {
     global $MYSQL_VARS,$dblink,$MYSQL_TABS;


     $j=0;
     $return_arr=array();
     for($i=0;$i<count($addbuy_id_arr);$i++)
     {
        if($addbuy_id_arr[$i] != "")
        {
            $addbuy_info=array();
            $where_clause="Fmain_id='".$addbuy_id_arr[$i]."'";
            //print $where_clause."<br>";
            $tbl_name="sys_portal_x100_cnt_add_buy";
            get_data($tbl_name, $where_clause, $addbuy_info);
            //show_array($addbuy_info);

/*
            if($addbuy_info['product_id'] != "")
            {
               $x100_info=array();
               $where_clause="Fmain_id='".$addbuy_info['product_id']."'";
               $tbl_name="sys_portal_x100_cnt";
               get_data($tbl_name, $where_clause, $x100_info);
               // show_array($x100_info);

               $addbuy_text_pic=$x100_info['pic_field_6'];
               $addbuy_text=$x100_info['text_field_0'];
               $addbuy_num=$x100_info['text_field_1'];
               $addbuy_price=$addbuy_info['add_money'];
               $addbuy_pic=$x100_info['pic_field_6'];

            }
            else
            {
*/

               $addbuy_text_pic=$addbuy_info['product_pic'];
               $addbuy_text=$addbuy_info['product_name'];
               $addbuy_num=$addbuy_info['product_num'];
               $addbuy_price=$addbuy_info['add_money'];
               $addbuy_pic=$addbuy_info['product_pic'];
//             }



            $return_arr[$j]['addbuy_text']=$addbuy_text;
            $return_arr[$j]['addbuy_text_pic']=$addbuy_text_pic;
            $return_arr[$j]['addbuy_num']=$addbuy_num;
            $return_arr[$j]['add_money']=$addbuy_price;
            $return_arr[$j]['product_pic']=$addbuy_pic;

            $j++;

        }

     }

     return $return_arr;



  }

  function get_give_info($give_id_arr)
  {
      global $MYSQL_VARS,$dblink,$MYSQL_TABS;
	  #show_array($give_id_arr);
	  $give_text_pic = "";	$give_text = "";	$give_num = "";
	  foreach($give_id_arr as $give_id){
		  $give_info=array();
	      $where_clause="Fmain_id='".$give_id."'";
	      $tbl_name="sys_portal_x100_cnt_gift";
	      get_data($tbl_name, $where_clause, $give_info);
	      #show_array($give_info);
	      $give_text_pic.=$give_info['product_pic']."`";
		  $give_text.=$give_info['product_name']."`";
		  $give_num.=$give_info['product_num']."`";
	  }


      $return_arr=array();
      $return_arr['give_text']= substr($give_text, 0, strlen($give_text)-1);
      $return_arr['give_text_pic']=substr($give_text_pic, 0, strlen($give_text_pic)-1);
      $return_arr['give_num']=substr($give_num, 0, strlen($give_num)-1);
      return $return_arr;




  }

  function get_j3_give_info($give_id_arr)
  {
      global $MYSQL_VARS,$dblink,$MYSQL_TABS;


	  $give_text_pic = "";	$give_text = "";	$give_num = "";
	  foreach($give_id_arr as $give_id){
		  $give_info=array();
	      $where_clause="Fmain_id='".$give_id."'";
	      $tbl_name="sys_portal_j3_gift";
	      get_data($tbl_name, $where_clause, $give_info);
	      // show_array($give_info);
	      $give_text_pic.=$give_info['product_pic']."`";
		  $give_text.=$give_info['product_name']."`";
		  $give_num.=$give_info['product_num']."`";
	  }


      $return_arr=array();
      $return_arr['give_text']= substr($give_text, 0, strlen($give_text)-1);
      $return_arr['give_text_pic']=substr($give_text_pic, 0, strlen($give_text_pic)-1);
      $return_arr['give_num']=substr($give_num, 0, strlen($give_num)-1);


      return $return_arr;

  }

  function get_bonus_max($userid,$website_language_id,$d12_id){ //取得當前可折抵最大額度


    $login_userid = $_COOKIE['member_userid'];

    $d5_info = array(); //會員資訊
    $where_clause="userid = '".$userid."' and member_userid = '".$login_userid."'";
    $tbl_name="sys_portal_d5";
    get_data($tbl_name, $where_clause, $d5_info);
    // show_array($d5_info);
    $now_bonus_num =  $d5_info['bonus_num']; //現有紅利

    ###################################################################
    #################### 紅利條件
    ###################################################################

    $web_data_info = array();
    $where_clause="userid = '".$userid."' and website_language_id = '".$website_language_id."'";
    $tbl_name="sys_website_data";
    get_data($tbl_name, $where_clause, $web_data_info);
    // show_array($web_data_info);

    $today = date("Y-m-d H:i:s");

    if($web_data_info['set_product_bonus_start']>$today && $web_data_info['set_product_bonus_end']<$today){
      return 0;
    }


    $least_amount = 0; // 最低購買金額
    if($web_data_info['set_product_bonus_money_one']!=""){
      $least_amount = $web_data_info['set_product_bonus_money_one'];
    }


    $bonus_kind_sql = "";  //可使用紅利分類  -> 全品項  特定分類
    if($web_data_info['set_product_bonus_for_c1_id']!=""){ //全品項
      $kind_arr = explode(",",$web_data_info['set_product_bonus_for_c1_id']); //特定分類

      $bonus_kind_sql = " and product_folder_id in (";

      for($iii=0;$iii<count($kind_arr);$iii++){
        if($iii>0){
          $bonus_kind_sql .= ",";
        }
        $bonus_kind_sql .= "'".$kind_arr[$iii]."'";
      }

      $bonus_kind_sql .= ")";

    }

    ###################################################################
    ###################################################################

    $d12_info = array();
    $where_clause="userid = '".$userid."' and Fmain_id = '".$d12_id."' and sum_total >='".$least_amount."'";
    $tbl_name="sys_portal_y100";
    get_data($tbl_name, $where_clause, $d12_info);
    // show_array($d12_info);

    if(count($d12_info)<1){
      return "0"; //not_bonus
    }

    $d12_cnt_info = array();
    $where_clause="userid = '".$userid."' and portal_d12_id = '".$d12_id."'".$bonus_kind_sql;
    $tbl_name="sys_portal_y100_cnt";
    getall_data($tbl_name, $where_clause, $d12_cnt_info);
    // show_array($d12_cnt_info);

    if(count($d12_cnt_info)<1){
      return "0"; //not_bonus
    }


    ###################################################################
    #################### 折扣金額
    ###################################################################

    $max_amount_discount = ""; // 最高折扣金額
    if($web_data_info['set_product_bonus_money_max']!=""){
      $max_amount_discount = $web_data_info['set_product_bonus_money_max'];
    }

    $max_amount_discount_percent = ""; // 最高折扣金額 %
    if($web_data_info['set_product_bonus_money_max_rate']!=""){
      $max_amount_discount_percent = $d12_info['sum_total']*$web_data_info['set_product_bonus_money_max_rate']/100;
    }


    $finally_max_discount = ""; //無上限
    if($max_amount_discount!=""&&$max_amount_discount_percent!=""){ // 最高折扣金額 及 最高折扣金額 % 皆有

      if($max_amount_discount>=$max_amount_discount_percent){
        $finally_max_discount = $max_amount_discount_percent;
      }elseif($max_amount_discount<=$max_amount_discount_percent){
        $finally_max_discount = $max_amount_discount;
      }

    }elseif($max_amount_discount!=""){ // 最高折扣金額
      $finally_max_discount = $max_amount_discount;
    }elseif($max_amount_discount_percent!=""){ // 最高折扣金額 %
      $finally_max_discount = $max_amount_discount_percent;
    }


    // if($web_data_info['set_product_bonus_money_type']=="3"){ // 自動捨去
    //   $now_bonus_money = floor($now_bonus_num/$web_data_info['set_product_bonus_money_point']);
    // }elseif($web_data_info['set_product_bonus_money_type']=="2"){ // 自動進位
    //   $now_bonus_money = ceil($now_bonus_num/$web_data_info['set_product_bonus_money_point']);
    // }else{//1 四捨五入
    //   $now_bonus_money = round($now_bonus_num/$web_data_info['set_product_bonus_money_point']);
    // }

    $now_bonus_money = bonus_money_trans($now_bonus_num,$web_data_info['set_product_bonus_money_point'],$web_data_info['set_product_bonus_money_type']);

    if($finally_max_discount==""){ //無上限
      return $now_bonus_money;
    }else{

      if($finally_max_discount>=$now_bonus_money){
        return $now_bonus_money;
      }elseif($finally_max_discount<=$now_bonus_money){
        return $finally_max_discount;
      }

    }


    ###################################################################
    ###################################################################

  }


  function bonus_money_trans($value,$exchange_rate,$num){

    if($num=="3"){ // 自動捨去
      return floor($value/$exchange_rate);
    }elseif($num=="2"){ // 自動進位
      returnceil($value/$exchange_rate);
    }else{//1 四捨五入
      return round($value/$exchange_rate);
    }

  }

	function new_d12_ordernum($num=1){
    //do{
      $num_1 = date("ymd");
      $select_info=array();
      $where_clause=" order_num like '%".$num_1."%' ";
      $tbl_name="sys_portal_y100";
      getall_data($tbl_name, $where_clause, $select_info);

      $num_2 = count($select_info)+$num;
      $num_2 = str_pad($num_2,3,'0',STR_PAD_LEFT);
      $rand_9 = $num_1.$num_2;

      $rand_9="JHT".$rand_9;

      $each_info=array();
//      $where_clause="order_num='".$rand_9."' and is_confirm='1' ";
      $where_clause="order_num='".$rand_9."'  ";
      $tbl_name="sys_portal_y100";
      get_data($tbl_name, $where_clause, $each_info);
      // show_array($each_info);

    //}while(count($each_info)>0);
	if(count($each_info)>0){
		new_d12_ordernum($num+1);
	}
    return $rand_9;

  }

    function new_d12_uniqid_str(){
      return md5(uniqid(rand()));
    }

    function new_d12_owner_num_other($global_website_userid){
      $rand_8 = str_pad(rand(0,99999999), "8");

      return $global_website_userid.$rand_8;
    }


    function get_c1_cnt_price_normal($c1_cnt_id,$size_id,$login_userid){  //價格確認

      // kol_id > 加購價 = 指定價 > 規格價 > 一般價


      $c1_cnt_info=array();
      $where_clause="Fmain_id='".$c1_cnt_id."'";
      $tbl_name="sys_portal_x100_cnt";
      get_data($tbl_name, $where_clause, $c1_cnt_info);
      //show_array($c1_cnt_info);


      $kol_order_info=array();
      $where_clause="uniqid_str = '".$_SESSION['uniqid_str']."' and order_num='".$_SESSION['order_num']."' and kol_id!='' ";
      $tbl_name="sys_portal_y100";
      get_data($tbl_name, $where_clause, $kol_order_info);
      // show_array($kol_order_info);


      if(count($kol_order_info)>0){ //KOL 特定價

        $j3_info=array();
        $where_clause="product_id='".$c1_cnt_id."' and Fmain_id='".$kol_order_info['kol_id']."'";
        $tbl_name="sys_portal_j3";
        get_data($tbl_name, $where_clause, $j3_info);
        // show_array($j3_info);

        if(count($j3_info)>0 && $j3_info['price']>0){
          return $j3_info['price'];
        }

      }



      if($login_userid != "" && trim($c1_cnt_info['text_field_8']) != ""){ //一般價
        $price=trim($c1_cnt_info['text_field_8']);
      }elseif(trim($c1_cnt_info['text_field_3']) != ""){
        $price=trim($c1_cnt_info['text_field_3']);
      }elseif( trim($c1_cnt_info['text_field_2']) != "" ){
        $price=trim($c1_cnt_info['text_field_2']);
      }


      // if($c1_cnt_info['is_show_size']=="是"){

      //   $size_info=array();
      //   $where_clause="portal_x100_cnt_id='".$c1_cnt_info['Fmain_id']."' and Fmain_id='".$size_id."'";
      //   //print $where_clause;
      //   $tbl_name="sys_portal_x100_cnt_size";
      //   get_data($tbl_name, $where_clause, $size_info);
      //   //show_array($size_info);

      //   if($login_userid!='' && $size_info['member_price']!=""){ //會員價
      //     $price = trim($size_info['member_price']);
      //   }elseif($size_info['price']!=""){
      //     $price = trim($size_info['price']);
      //   }

      // }



      return $price;
    }




    function update_d12_total($d12_id,$is_sub_total){

     global $MYSQL_VARS,$dblink,$MYSQL_TABS;

    	$order_info=array();
    	$where_clause="Fmain_id='".$d12_id."'"; // userid='".$global_website_userid."' and
//    	print $where_clause;
//    	exit;
    	$tbl_name="sys_portal_y100";
    	get_data($tbl_name, $where_clause, $order_info);
    	// show_array($order_info);

    	$order_cnt_info=array();
    	$where_clause="portal_y100_id='".$order_info['Fmain_id']."'"; // userid='".$global_website_userid."' and
    	$tbl_name="sys_portal_y100_cnt";
    	getall_data($tbl_name, $where_clause, $order_cnt_info);
//show_array($order_cnt_info);
//exit;
		$kol_info=array();
		if($order_info['kol_id']){
	        $where_clause="Fmain_id = '".AddSlashes($order_info['kol_id'])."' ";# and is_hide='2'
	    //    print $where_clause;
	        $tbl_name="sys_portal_j3";
	        get_data($tbl_name, $where_clause, $kol_info);
	        //show_array($kol_info);
		}

    	$small_total= 0;
    	for($iii=0;$iii<count($order_cnt_info);$iii++){
      		if(1){
	      		if($order_cnt_info[$iii]['is_addbuy']=="2")	$product_id = $order_cnt_info[$iii]['product_id'];
	      		else{
		      		$old_product = array();
		      		$where_clause="Fmain_id='".$order_cnt_info[$iii]['s_product_id']."'";
				    $tbl_name="sys_portal_y100_cnt";
				    get_data($tbl_name, $where_clause, $old_product);
				    $product_id = $old_product['product_id'];
	      		}
	      		$c1_cnt_info=array();
		  		$where_clause="Fmain_id='".$product_id."'";
			    $tbl_name="sys_portal_x100_cnt";
			    get_data($tbl_name, $where_clause, $c1_cnt_info);
			    if($c1_cnt_info['is_hide'] == "1" && $kol_info['product_id']!=$c1_cnt_info['Fmain_id']){
			    	$cant_save = 1;
			    	$upd_info = array();
		        	$upd_info['amount'] = 0;
		        	$upd_info['small_price'] = 0;
		        	$where_clause = " Fmain_id = '".$order_cnt_info[$iii]['Fmain_id']."' ";
		        	$tbl_name="sys_portal_y100_cnt";
		        	update_data($tbl_name, $where_clause, $upd_info);
			    }
				else if(time()<strtotime($c1_cnt_info['sys_start_date']." 00:00:00")){
			    	$cant_save = 1;
			    	$upd_info = array();
		        	$upd_info['amount'] = 0;
		        	$upd_info['small_price'] = 0;
		        	$where_clause = " Fmain_id = '".$order_cnt_info[$iii]['Fmain_id']."' ";
		        	$tbl_name="sys_portal_y100_cnt";
		        	update_data($tbl_name, $where_clause, $upd_info);
			    }
				else if(time()>strtotime($c1_cnt_info['sys_end_date']." 23:59:59")){
			    	$cant_save = 1;
			    	$upd_info = array();
		        	$upd_info['amount'] = 0;
		        	$upd_info['small_price'] = 0;
		        	$where_clause = " Fmain_id = '".$order_cnt_info[$iii]['Fmain_id']."' ";
		        	$tbl_name="sys_portal_y100_cnt";
		        	update_data($tbl_name, $where_clause, $upd_info);
			    }
			    else if($c1_cnt_info['is_show_size']=="是"){
		    		$size_info=array();
			        $where_clause="portal_x100_cnt_id='".$c1_cnt_info['Fmain_id']."' and Fmain_id='".$order_cnt_info[$iii]['size_id']."'";
			        $tbl_name="sys_portal_x100_cnt_size";
			        get_data($tbl_name, $where_clause, $size_info);
			        //show_array($size_info);

			        if($size_info['text_field_10']<=$order_cnt_info[$iii]['amount'] && $size_info['text_field_10']!=""){
			        	$cant_save = 1;
			        	$upd_info = array();
			        	$upd_info['amount'] = $size_info['text_field_10'];
			        	$upd_info['small_price'] = (($size_info['text_field_10']==0)?0:$order_cnt_info[$iii]['price']*$size_info['text_field_10']);
			        	$where_clause = " Fmain_id = '".$order_cnt_info[$iii]['Fmain_id']."' ";
			        	$tbl_name="sys_portal_y100_cnt";
			        	update_data($tbl_name, $where_clause, $upd_info);
			        }
			        else{
				        if($order_cnt_info[$iii]['amount']==0 && $size_info['text_field_10']!=0){
					        $upd_info = array();
				        	$upd_info['amount'] = 1;
				        	$upd_info['small_price'] = $order_cnt_info[$iii]['price'];
				        	$where_clause = " Fmain_id = '".$order_cnt_info[$iii]['Fmain_id']."' ";
				        	$tbl_name="sys_portal_y100_cnt";
				        	update_data($tbl_name, $where_clause, $upd_info);
				        	$order_cnt_info[$iii]['small_price'] = $upd_info['small_price'];
				        }
				        $small_total += $order_cnt_info[$iii]['small_price'];
			        }
		        }
		        else{
			        if($c1_cnt_info['stock']<=$order_cnt_info[$iii]['amount'] && $c1_cnt_info['stock']!=""){
			        	$cant_save = 1;
			        	$upd_info = array();
			        	$upd_info['amount'] = $c1_cnt_info['stock'];
			        	$upd_info['small_price'] = (($c1_cnt_info['stock']==0)?0:$order_cnt_info[$iii]['price']*$c1_cnt_info['stock']);
			        	$where_clause = " Fmain_id = '".$order_cnt_info[$iii]['Fmain_id']."' ";
			        	$tbl_name="sys_portal_y100_cnt";
			        	update_data($tbl_name, $where_clause, $upd_info);
			        }
			        else{
				        if($order_cnt_info[$iii]['amount']==0 && $c1_cnt_info['stock']!=0){
					        $upd_info = array();
				        	$upd_info['amount'] = 1;
				        	$upd_info['small_price'] = $order_cnt_info[$iii]['price'];
				        	$where_clause = " Fmain_id = '".$order_cnt_info[$iii]['Fmain_id']."' ";
				        	$tbl_name="sys_portal_y100_cnt";
				        	update_data($tbl_name, $where_clause, $upd_info);
				        	$order_cnt_info[$iii]['small_price'] = $upd_info['small_price'];
				        }
				        $small_total += $order_cnt_info[$iii]['small_price'];
			        }
		        }
      		}

    	}



      $total = $small_total; //商品合計
      $total -= $order_info['amount_sale_info_money'];      // 滿件優惠費用
      $total -= $order_info['use_bonus'];	#購物金
      $total -= $order_info['coupon_money'];	#折價券
      $total -= $order_info['code_money'];	#折扣碼
      $total -= $order_info['sale_info_money'];  // 滿額優惠費用
      $total += $order_info['traffic_money'];



    	$update_info=array();
    	$update_info['sum_total']=AddSlashes($total);
    	$update_info['old_sum_total']=AddSlashes($small_total);
    	// $where_clause="uniqid_str = '".$_SESSION['uniqid_str']."' and order_num='".$_SESSION['order_num']."'  ";
      $where_clause="Fmain_id='".$d12_id."'";
    	$tbl_name="sys_portal_y100";
    	update_data($tbl_name, $where_clause, $update_info);
//    	show_array($update_info);exit;


      ##################################################
      $order_info=array();
      $where_clause="Fmain_id='".$d12_id."'"; // userid='".$global_website_userid."' and
      $tbl_name="sys_portal_y100";
      get_data($tbl_name, $where_clause, $order_info);
      // show_array($order_info);


      /******************************
        KOL資訊
      *******************************/
      if($order_info['kol_id'] != "")
      {
          $kol_info=array();
          $where_clause="Fmain_id = '".AddSlashes($order_info['kol_id'])."' ";# and is_hide='2'
//          print $where_clause;
          $tbl_name="sys_portal_j3";
          get_data($tbl_name, $where_clause, $kol_info);
//          show_array($kol_info);

          $order_cnt_info=array();
         	$where_clause=" portal_y100_id='".$order_info['Fmain_id']."' order by Fmain_id asc";

         	$tbl_name=$MYSQL_TABS['portal_y100_cnt'];
//         	print $tbl_name;
         	getall_data($tbl_name, $where_clause, $order_cnt_info);
//         	show_array($order_cnt_info);

          $s_order_cnt_info=array();
          $s_order_cnt_info=$order_cnt_info;
          $order_cnt_info=array();

         	$s=0;
         	for($r=0;$r<count($s_order_cnt_info);$r++)
         	{
         	   if($kol_info['product_id'] != $s_order_cnt_info[$r]['product_id'])
         	   {
         	      $order_cnt_info[$s]=$s_order_cnt_info[$r];

         	      $s++;
         	   }

         	}

      }

//      show_array($order_cnt_info);
//      exit;

//      if($order_info['kol_id'] == "")
//      {
        get_set_product_sale_amount($order_info,$order_cnt_info);// 滿件優惠費用
        get_set_product_sale($order_info,$order_cnt_info); // 滿額優惠費用
//      }

      $order_cnt_info=array();
      $order_cnt_info=$s_order_cnt_info;


      $order_info=array(); //重新取得訂單
      $where_clause="Fmain_id='".$d12_id."'"; // userid='".$global_website_userid."' and
      $tbl_name="sys_portal_y100";
      get_data($tbl_name, $where_clause, $order_info);
      // show_array($order_info);

      $set_shop_info2=array(); // 免運條件
      $where_clause=" Fmain_id = '2'";
      $tbl_name="sys_portal_j5";
      get_data($tbl_name, $where_clause, $set_shop_info2);
      // show_array($set_shop_info2);

      if((int)$set_shop_info2['text_field_1'] <= $order_info['sum_total']){ //有免運

        $update_info=array();
        $update_info['traffic_money']=0;
        // $where_clause="uniqid_str = '".$_SESSION['uniqid_str']."' and order_num='".$_SESSION['order_num']."'  ";
        $where_clause="Fmain_id='".$d12_id."'";
        $tbl_name="sys_portal_y100";
        update_data($tbl_name, $where_clause, $update_info);

      }else{

        // print (int)$set_shop_info2['text_field_1']." - ".$order_info['sum_total']."|||";

        $set_shop_info1=array();
        $where_clause=" Fmain_id = '1'";
        $tbl_name="sys_portal_j5";
        get_data($tbl_name, $where_clause, $set_shop_info1);
        // show_array($set_shop_info1);

        $update_info=array();
        $update_info['traffic_money']=(int)$set_shop_info1['text_field_1'];
        // $where_clause="uniqid_str = '".$_SESSION['uniqid_str']."' and order_num='".$_SESSION['order_num']."'  ";
        $where_clause="Fmain_id='".$d12_id."'";
        $tbl_name="sys_portal_y100";
        update_data($tbl_name, $where_clause, $update_info);
      }

      $order_cnt_info=array();
     	$where_clause="portal_y100_id='".$order_info['Fmain_id']."'"; // userid='".$global_website_userid."' and
     	$tbl_name="sys_portal_y100_cnt";
     	getall_data($tbl_name, $where_clause, $order_cnt_info);
 //show_array($order_cnt_info);

      /******************************
        取得運費並更新
      *******************************/
			   $traffic_money=0;
      $traffic_money=get_traffic_money($order_info,$order_cnt_info);
//      print $traffic_money;
//      exit;


      $order_info=array(); //重新取得訂單
      $where_clause="Fmain_id='".$d12_id."'"; // userid='".$global_website_userid."' and
      $tbl_name="sys_portal_y100";
      get_data($tbl_name, $where_clause, $order_info);
      // show_array($order_info);

      $discount = 0;
      $discount += $order_info['sale_info_money'];
      $discount += $order_info['amount_sale_info_money'];

      $small_total= 0;
      for($iii=0;$iii<count($order_cnt_info);$iii++){
        $small_total += $order_cnt_info[$iii]['small_price'];
      }


      $total = $small_total; //商品合計
      $total -= $order_info['amount_sale_info_money'];      // 滿件優惠費用
      $total -= $order_info['use_bonus'];	#購物金
      $total -= $order_info['coupon_money'];	#折價券
      $total -= $order_info['code_money'];	#折扣碼
      $total -= $order_info['sale_info_money'];  // 滿額優惠費用
      $total += $order_info['traffic_money'];

	  if($total < 0)	$total = 0;

      $update_info=array();
      $update_info['sum_total']=$total;
      $update_info['old_sum_total']=AddSlashes($small_total);
      // $where_clause="uniqid_str = '".$_SESSION['uniqid_str']."' and order_num='".$_SESSION['order_num']."'  ";
      $where_clause="Fmain_id='".$d12_id."'";
      $tbl_name="sys_portal_y100";
      update_data($tbl_name, $where_clause, $update_info);

      ##################################################

      if($is_sub_total){
        return $total."_".$small_total."_".$discount."_".$order_info['traffic_money'];
      }else{
        return $total;
      }

    }








/******************************
      滿額優惠  kol使用  只顯示優惠不適用  不優惠
    *******************************/
  function get_set_product_sale_kol($order_info,$order_cnt_info)
  {
      global $MYSQL_VARS,$dblink,$MYSQL_TABS;
      global $set_product_sale_end;

      $order_id = $order_info['Fmain_id'];

      $order_info=array();
      $where_clause="Fmain_id = '".$order_id."'  ";
      $tbl_name=$MYSQL_TABS['portal_y100'];
      get_data($tbl_name, $where_clause, $order_info);
//      show_array($order_info);

      // 判斷是否有滿件優惠了(只判斷有沒有優惠到金額)
      $is_sale_sn=0;
      if( $order_info['amount_sale_info_money'] > 0 or $order_info['amount_sale_info_money_give_name'] != "" )	{
        $is_sale_sn=1;
      }

      $today=date("Y-m-d");

      // 返回的活動名稱
      $return_title="";


      if($is_sale_sn == 1){   // 已經有滿件優惠  滿額不再做優惠




     	}

        $sale_money_list=array();
        $where_clause="website_language_id = '1' and (set_product_sale_start <= '$today' and set_product_sale_end >= '$today')";
        $tbl_name="sys_set_sale_money_list";
        getall_data($tbl_name, $where_clause, $sale_money_list);
        // show_array($sale_money_list);


        $final_sale_money = 0;
        $final_sale_giveaway_info_arr = "";
        $return_str = "";	$return_str_save = "";

        for ($iii=0; $iii < count($sale_money_list); $iii++) {

            // 是否需要會員
            if($sale_money_list[$iii]['set_product_sale_is_member'] == "1"){
                if($order_info['member_userid'] == ""){
                  continue;
                }
            }


               $set_product_sale_end=$sale_money_list[$iii]['set_product_sale_end'];

               /*******************
                  取得判斷判斷"滿額"的金額
               **********************/
              // 判斷設定滿額的範圍
              if($sale_money_list[$iii]['set_product_sale_range'] == "2")  // 有設定範圍
              {
                    $set_product_sale_range_product_id_arr=array();
                    $set_product_sale_range_product_id_arr=explode(",",$sale_money_list[$iii]['set_product_sale_range_product_id']);

                    $product_total=0;
                     for($i=0;$i<count($order_cnt_info);$i++)
                    {
                        if(in_array($order_cnt_info[$i]['product_id'],$set_product_sale_range_product_id_arr))
                        $product_total=$product_total+$order_cnt_info[$i]['small_price'];

                    }
              }
              else  // 全部商品
              {
                   $product_total=0;
                   for($i=0;$i<count($order_cnt_info);$i++)
                    {
                        $product_total=$product_total+$order_cnt_info[$i]['small_price'];
                    }

              }
        //          print $product_total;
        //          exit;

              /*******************
                  優惠方式
               **********************/

              $sale_money=""; // 被優惠了多少錢
              $sale_giveaway_id=""; // 贈品id
              if($sale_money_list[$iii]['set_product_sale_full'] == "1")  // 自訂級距
              {
                  $set_product_sale_info=array();
                  if($sale_money_list[$iii]['is_add'] == "1"){
	                  $where_clause=" website_data_id = '".$sale_money_list[$iii]['Fmain_id']."' and set_product_sale_moneylimit <= '$product_total' order by set_product_sale_moneylimit desc";
                  }
                  else{
	                  $where_clause=" website_data_id = '".$sale_money_list[$iii]['Fmain_id']."' and set_product_sale_moneylimit <= '$product_total' order by set_product_sale_moneylimit desc limit 1";
                  }

                  $tbl_name="sys_website_data_set_product_sale";
                  getall_data($tbl_name, $where_clause, $set_product_sale_info);
                  //show_array($set_product_sale_info);
                  //exit;

                  if(count($set_product_sale_info) > 0)
                  {
                      $sale_giveaway_info_arr=array();
					  for($ss=0;$ss<count($set_product_sale_info);$ss++){
	                      if($set_product_sale_info[$ss]['set_product_sale'] != "" && $rate_sale_money == "")  // 幾折
	                      {
	                           $set_product_sale_rate=$set_product_sale_info[$ss]['set_product_sale'] / 10;
	                           $rate_sale_money=round($product_total*$set_product_sale_rate);
	                           $sale_money=$product_total-$rate_sale_money;

	                      }
	                      elseif(trim($set_product_sale_info[$ss]['set_product_sale_money']) != "" && $sale_money == "")  // 折抵
	                      {
	                           $set_product_sale_money=trim($set_product_sale_info[$ss]['set_product_sale_money']);
	                           $sale_money=$set_product_sale_money;
	                      }
	                      elseif(trim($set_product_sale_info[$ss]['giveaway_id']) != "")   // 贈品
	                      {
	                           $sale_giveaway_id=$set_product_sale_info[$ss]['giveaway_id'];

	                           $sale_giveaway_info_arr[]=get_giveaway_info($sale_giveaway_id);
	                      }
                      }
                  }
              }
              else   // 固定滿多少折抵多少
              {
                  $a=Floor((int)$product_total / (int)$sale_money_list[$iii]['set_product_sale_fixed_money']);
                  $b=$a*(int)$sale_money_list[$iii]['set_product_sale_fixed_deductible'];
                  $sale_money=$b;
              }

//show_array($sale_giveaway_info_arr);
//exit;
//            if($final_sale_money <= $sale_money)
            $final_sale_save = "";
            if($sale_money != "" or count($sale_giveaway_info_arr) > 0)
            {
              $final_sale_money = $final_sale_money+$sale_money;

              if(count($sale_giveaway_info_arr) > 0)
              {
                 foreach($sale_giveaway_info_arr as $sale_giveaway_info){
	                 if($save_sale_info_give_name == "")
	                 $save_sale_info_give_name=$sale_giveaway_info['text_field_0'];
	                 else
	                 $save_sale_info_give_name=$save_sale_info_give_name.",".$sale_giveaway_info['text_field_0'];

	                 $final_sale_giveaway_info_arr .= "###".$sale_giveaway_info['text_field_0']."。";
	                 $final_sale_save .= "###".$sale_giveaway_info['text_field_0']."。";
                 }



              }
              else if($is_sale_sn == 0){
	              #$final_sale_giveaway_info_arr="折抵".$sale_money."元";
	              $final_sale_giveaway_info_arr="";
	              $final_sale_save = "折抵".$sale_money."元";
              }
              else{
	              $final_sale_giveaway_info_arr="";
	              $final_sale_save = "";
              }


              if($return_str == "")
              $return_str =$sale_money_list[$iii]['set_product_sale_title'].$final_sale_giveaway_info_arr;
              else
              $return_str =$return_str."@@@".$sale_money_list[$iii]['set_product_sale_title'].$final_sale_giveaway_info_arr;

			  if($return_str_save == "")
              $return_str_save =$sale_money_list[$iii]['set_product_sale_title'].$final_sale_save;
              else
              $return_str_save =$return_str."@@@".$sale_money_list[$iii]['set_product_sale_title'].$final_sale_save;

            }





        }




        if(count($order_info) > 0){

          if($is_sale_sn == 0)
          {

          }
		  else{

		  }
          if(($final_sale_money != 0 and $final_sale_money != "") or $final_sale_giveaway_info_arr['text_field_0'] != "")
          {
            $return_title = $return_str;

//            if($final_sale_giveaway_info_arr['text_field_0'] != "")
//               $return_title=$return_title."贈送".$final_sale_giveaway_info_arr['text_field_0']."";

          }
        }


        if($is_sale_sn == 1 ){   // 已經有滿件優惠  滿額不再做優惠
            if($return_title != "")
            {
            	$return_title_arr = explode("@@@", $return_title);
				foreach($return_title_arr as $return_key => $return_str){
					if(substr_count($return_str,"###")>=1){
						$return_str = str_replace("###", "贈送", $return_str);
					}
					else{
//						$return_str = "<font style='color:#333;'>".$return_str."(不適用)</font>";
						$return_str = "<font style='color:#a5a5a5;'>".$return_str."</font>";
					}
					$return_title_arr[$return_key] = $return_str;
				}
	            $return_title = implode ("<br>", $return_title_arr);
	            $return_title = "<p>".$return_title."</p>";
	            $sale_money="";

	            $save_title_arr = explode("@@@", $return_str_save);
	            foreach($save_title_arr as $return_key => $return_str){
					if(substr_count($return_str,"###")>=1){
						$return_str = str_replace("###", "贈送", $return_str);
					}
					else{
//						$return_str = "<font style='color:#333;'>".$return_str."(不適用)</font>";
						$return_str = "<font style='color:#333;'>".$return_str."</font>";
					}
					$save_title_arr[$return_key] = $return_str;
				}
	            $return_str_save = implode ("<br>", $save_title_arr);
            }

        }
        else
        {
            $return_title = str_replace("@@@", "<br>", $return_title);
            $return_title = str_replace("###", "贈送", $return_title);

            $return_str_save = str_replace("@@@", "<br>", $return_str_save);
            $return_str_save = str_replace("###", "贈送", $return_str_save);
        }

        if(count($order_info) > 0){

        }

        if($return_title != "")
        $return_title="<span style='color:#7d7d7d'>".$return_title."(不適用)</span>";

        return $return_title;



//     	}



  }






  /******************************
      滿件優惠  kol使用  只顯示優惠不適用  不優惠
    *******************************/
function get_set_product_sale_amount_kol($order_info,$order_cnt_info)
{
  global $MYSQL_VARS,$dblink,$MYSQL_TABS;
  global $set_sale_amount_end;

  $today=date("Y-m-d");

  // 返回的活動名稱
  $return_title="";


  $sale_amount_list=array();
  $where_clause="website_language_id = '1' and (set_sale_amount_start <= '$today' and set_sale_amount_end >= '$today')";
  $tbl_name="sys_set_sale_amount_list";
  getall_data($tbl_name, $where_clause, $sale_amount_list);
  #show_array($sale_amount_list);

  $final_sale_money = 0;#折多少錢
  $final_sale_money_2 = 0;#幾折
  $final_sale_name_arr = array();
  $return_str_arr = array();
  $in_sale_id = array();	#已計算的商品(若不在其中就可以計算進去)

  for($iii=0;$iii<count($sale_amount_list);$iii++)
  {

    // 是否需要會員
    $sn=0;
    if($sale_amount_list[$iii]['set_sale_amount_is_member'] == "1"){
      if($order_info['member_userid'] == ""){
        $sn=1;
      }
    }

    if(count($sale_amount_list[$iii]) > 0 and $sn == 0){
         $set_sale_amount_end=$sale_amount_list[$iii]['set_sale_amount_end'];

         /*******************
            取得判斷判斷"滿額"的金額
         **********************/
        // 判斷設定滿額的範圍
        if($sale_amount_list[$iii]['set_sale_amount_range'] == "2")  // 有設定範圍
        {
          $set_product_sale_range_product_id_arr=array();
          $set_product_sale_range_product_id_arr=explode(",",$sale_amount_list[$iii]['set_sale_amount_range_product_id']);
		  #show_array($set_product_sale_range_product_id_arr);


          $product_total=0;
          $product_total2=0;
           for($i=0;$i<count($order_cnt_info);$i++)
          {
              if(in_array($order_cnt_info[$i]['product_id'],$set_product_sale_range_product_id_arr)){
	              $product_total=$product_total+$order_cnt_info[$i]['amount'];
				  $product_total2=$product_total2+$order_cnt_info[$i]['small_price'];


              }


          }

        }
        else  // 全部商品
        {

         $product_total=0;
         $product_total2=0;
         for($i=0;$i<count($order_cnt_info);$i++)
          {
              $product_total=$product_total+$order_cnt_info[$i]['amount'];
              $product_total2=$product_total2+$order_cnt_info[$i]['small_price'];

          }



        }


        /*******************
            優惠方式
         **********************/

        $sale_money=0; // 被優惠了多少錢
        $sale_giveaway_id=""; // 贈品id
        $rate_sale_money = "";
        if($sale_amount_list[$iii]['set_sale_amount_full'] == "1"){  // 自訂級距

          $set_product_sale_info=array();
          if($sale_amount_list[$iii]['is_add'] == "1"){
	          $where_clause=" website_data_id = '".$sale_amount_list[$iii]['Fmain_id']."' and CAST(`set_sale_amount_moneylimit` AS DECIMAL(10,2)) <= '$product_total' order by CAST(`set_sale_amount_moneylimit` AS DECIMAL(10,2)) desc";
	      }
	      else{
		      $where_clause=" website_data_id = '".$sale_amount_list[$iii]['Fmain_id']."' and CAST(`set_sale_amount_moneylimit` AS DECIMAL(10,2)) <= '$product_total' order by CAST(`set_sale_amount_moneylimit` AS DECIMAL(10,2)) desc limit 1";
	      }

//          print $where_clause."<br>";
          $tbl_name="sys_website_data_set_sale_amount";
          getall_data($tbl_name, $where_clause, $set_product_sale_info);
		  #show_array($set_product_sale_info);
          //exit;


          $sale_giveaway_info_arr=array();
          if(count($set_product_sale_info) > 0){
		    for($ss=0;$ss<count($set_product_sale_info);$ss++){
			    if($set_product_sale_info[$ss]['set_sale_amount'] != "" && ($rate_sale_money == "" || $set_product_sale_info[$ss]['set_sale_amount'] < $rate_sale_money))  // 幾折
	            {
	                 $set_product_sale_rate=$set_product_sale_info[$ss]['set_sale_amount'] / 10;

	                 $rate_sale_money=round($product_total2*$set_product_sale_rate);

	                 $sale_money+=$product_total2-$rate_sale_money;


	            }
	            elseif(trim($set_product_sale_info[$ss]['set_sale_amount_money']) != "")  // 折抵
	            {
	                 $set_product_sale_money=trim($set_product_sale_info[$ss]['set_sale_amount_money']);
	                 $sale_money+=$set_product_sale_money;
	            }
	            elseif(trim($set_product_sale_info[$ss]['giveaway_id']) != "")   // 贈品
	            {
	                 $sale_giveaway_id=$set_product_sale_info[$ss]['giveaway_id'];
	                 $sale_giveaway_info_arr[$sale_amount_list[$iii]['Fmain_id']]=get_giveaway_info($sale_giveaway_id);
	            }
		    }
          }
          else{
/*
	          if($_SERVER['REMOTE_ADDR']=="114.35.245.43"){
	          	unset($sale_amount_list[$iii]);
	          }
*/
          }

        }else{   // 固定滿多少折抵多少

          $a=Floor((int)$product_total / (int)$sale_amount_list[$iii]['set_sale_amount_fixed_money']);
          $b=$a*(int)$sale_amount_list[$iii]['set_sale_amount_fixed_deductible'];
          $sale_money=$b;

        }

		#print $sale_money."_".$sale_amount_list[$iii]['set_product_sale_amount_title'];
		if($sale_money != "" and $rate_sale_money != ""){
			if($final_sale_money_2 <= $sale_money){
				if($return_str_arr['p'] != ""){
//					$return_str_arr['n'] .= "<font style='color:#333;'>".$return_str_arr['p']."(不適用)</font>";
					$return_str_arr['n'] .= "<font style='color:#333;'>".$return_str_arr['p']."</font>";
				}
				$final_sale_money_2 = $sale_money;
				$return_str_arr['p'] = $sale_amount_list[$iii]['set_product_sale_amount_title'];
			}
			else{
//				$return_str_arr['n'] .= "<font style='color:#333;'>".$sale_amount_list[$iii]['set_product_sale_amount_title']."(不適用)</font>";
				$return_str_arr['n'] .= "<font style='color:#333;'>".$sale_amount_list[$iii]['set_product_sale_amount_title']."</font>";
			}
		}
	    else if( $sale_money != "" )
	    {
			if($final_sale_money <= $sale_money){
				$can_count = 0;
				if(count($set_product_sale_range_product_id_arr)){
					foreach($set_product_sale_range_product_id_arr as $product_id){
						if(!in_array($product_id, $in_sale_id)){
							$in_sale_id[] = $product_id;
							$can_count = 1;
						}
					}

				}
				if($return_str_arr['m'] != "" && $can_count == 0){
//					$return_str_arr['n'] .= "<font style='color:#333;'>".$return_str_arr['m']."(不適用)</font>";
					$return_str_arr['n'] .= "<font style='color:#333;'>".$return_str_arr['m']."</font>";
					$final_sale_money = $sale_money;
					$return_str_arr['m'] = $sale_amount_list[$iii]['set_product_sale_amount_title'];
				}
				else{
					$final_sale_money += $sale_money;
					if($return_str_arr['m'] != "")			$return_str_arr['m'] .=  "<br>";
					$return_str_arr['m'] .= $sale_amount_list[$iii]['set_product_sale_amount_title'];
				}

			}
			else{
//				$return_str_arr['n'] .= "<font style='color:#333;'>".$sale_amount_list[$iii]['set_product_sale_amount_title']."(不適用)</font>";
				if($return_str_arr['n'] != "")	$return_str_arr['n'] .= "<br>";
				$return_str_arr['n'] .= "<font style='color:#333;'>".$sale_amount_list[$iii]['set_product_sale_amount_title']."</font>";
			}
	    }
	    elseif(count($sale_giveaway_info_arr) > 0)
	    {
	        foreach($sale_giveaway_info_arr as $sale_giveaway_key => $sale_giveaway_info)
	        {
	           #$return_str_gift = $sale_amount_list[$iii]['set_product_sale_amount_title']."贈送".$sale_giveaway_info_arr['text_field_0'];
	           if($sale_giveaway_key == $sale_amount_list[$iii]['Fmain_id']){
		           $return_str_arr[$sale_amount_list[$iii]['Fmain_id']] = $sale_amount_list[$iii]['set_product_sale_amount_title']."贈送".$sale_giveaway_info['text_field_0'];
				   $final_sale_giveaway_info_arr[] = "".$sale_giveaway_info['text_field_0'];
	           }

	        }


	    }
    }





  }

  if(count($order_info) > 0){

	    $return_title = implode ("<br>", $return_str_arr);
  }

  if(count($order_info) > 0){

	}

 if($return_title != "")
	$return_title="<span style='color:#a5a5a5'>".$return_title."(不適用)</span>";

  return $return_title;

}



?>