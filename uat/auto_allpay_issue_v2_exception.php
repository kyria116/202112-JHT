<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>購物車</title>
<link href="shop.css" rel="stylesheet" type="text/css" />
<script>

</script>
</head>

<body><!--  onload="auto_submit();" -->

<?
    include_once("global_include_file.php");
	#include_once ("ECPay.Payment.Integration.php");   // 綠界 API
	#include_once ("ECPay.Logistics.Integration.php");   // 綠界 API
	#exit;




	mb_http_output ("UTF-8");
	mb_internal_encoding("UTF-8");
	ob_start ("mb_output_handler");

    $order_id=$_GET['order_id'];


	if(0){ //測試發票
		$szMerchantID = "2000132";
		$szHashKey = "ejCk326UnaZWKisg";
		$szHashIV = "q9jcZX8Ib9LM8wYk";
		$Url = "https://einvoice-stage.ecpay.com.tw/B2CInvoice/Issue";
	}else{ //正式
		$szMerchantID = "3240237";
		$szHashKey = "feP9i0xwvEitzS00";
		$szHashIV = "KPA6n8rGZDLEsC1q";
		$Url="https://einvoice.ecpay.com.tw/B2CInvoice/Issue";
	}


//	print $szHashKey;
//	exit;
//
	/*************************************愛心碼設定 ************************************************************/
	### https://www.einvoice.nat.gov.tw/APMEMBERVAN/XcaOrgPreserveCodeQuery/XcaOrgPreserveCodeQuery ###

	$LoveCode_arr = array();
	$LoveCode_arr['財團法人華山社會福利慈善事業基金會'] = "111";
	$LoveCode_arr['財團法人人安社會福利慈善事業基金會'] = "918";
	$LoveCode_arr['財團法人陽光社會福利基金會'] = "13579";

    $order_info=array();
    $where_clause="Fmain_id = '$order_id'";
    $tbl_name="sys_portal_y100";
    get_data($tbl_name, $where_clause, $order_info);
    //show_array($order_info);
	print "<center><button name='close' onclick='opener.location.reload();window.close();'>關閉視窗</button></center>";
    if($order_info['invoice_num']!=""){
    	print "發票號碼：".$order_info['invoice_num'];
    	exit;
    }

    $order_cnt_info=array();
    $where_clause="portal_y100_id = '".$order_info['Fmain_id']."'";
    $tbl_name="sys_portal_y100_cnt";
    getall_data($tbl_name, $where_clause, $order_cnt_info);
    //show_array($order_cnt_info);


    // 取得本頁面URL
    $now_url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];


    $now_time = time();

    $Donation = "0";	#捐贈時：1。不捐贈或統一編號[CustomerIdentifier]有值時：2。
	$LoveCode = "";		#愛心碼。1. 若捐贈註記[Donation]= '1' (捐贈)時，此欄位須有值。	2. 長度限制為 3 至 7 碼。	3. 格式為大小寫「X」加上 2 至 6 碼數字或全數字。

/*
	if($order_info['send_invoice_type'] == "捐贈" and $order_info['send_invoice_donation'] == "")
	{
	    $order_info['send_invoice_donation']="財團法人陽光社會福利基金會";
	}

	if($order_info['send_invoice_type'] == "捐贈" && $LoveCode_arr[$order_info['send_invoice_donation']]){
		$LoveCode = $LoveCode_arr[$order_info['send_invoice_donation']];
		$Donation = "1";
	}

	if($order_info['send_invoice_type'] == "愛心捐贈"){

		$LoveCode = $order_info['send_invoice_lovecode'];
		if($LoveCode==""){
			$LoveCode = "111";
		}

		$Donation = "1";
	}
*/
	#先把單價改為總金額除商品數開始#
	$total_amount = 0;	#總商品數
	for($i=0;$i<count($order_cnt_info);$i++)
	{
      $total_amount=$total_amount+(int)$order_cnt_info[$i]['amount'];
 	}
 	$price = ceil(($order_info['sum_total']-$order_info['traffic_money']) / $total_amount);
 	for($i=0;$i<count($order_cnt_info);$i++)
	{
      $order_cnt_info[$i]['price'] = $price;
      $order_cnt_info[$i]['small_price'] = $price*$order_cnt_info[$i]['amount'];
 	}
	#先把單價改為總金額除商品數結束#


	// 先檢查訂單金額 有沒有等於商品總額+運費
 $sum_total=$order_info['sum_total'];

 $product_sum_total=0;
 for($i=0;$i<count($order_cnt_info);$i++)
 {
      $product_sum_total=$product_sum_total+(int)$order_cnt_info[$i]['small_price'];
 }

//print $product_sum_total."<br>";
 $product_sum_total=$product_sum_total+$order_info['traffic_money'];

 #print $product_sum_total."<br>";print $sum_total."<br>";exit;

 $sale_product_money=0;
 if($product_sum_total > $sum_total)  // 需要一個扣抵的商品
 {
    $sale_product_money=(int)$product_sum_total - (int)$sum_total;
 }

 //print $sale_product_money;exit;
//

 if($sale_product_money > 0)
 {
    for($i=0;$i<count($order_cnt_info);$i++)
    {
	         if((int)$order_cnt_info[$i]['small_price'] >= (int)$sale_product_money)
		       {
		           $order_cnt_info[$i]['small_price'] = (int)$order_cnt_info[$i]['small_price'] - (int)$sale_product_money;
		           $order_cnt_info[$i]['price'] = (int)$order_cnt_info[$i]['price'] - (int)($sale_product_money/$order_cnt_info[$i]['amount'] );
		           $sale_product_money=0;
		       }
	  }
 }
#show_array($order_cnt_info);
//print $sale_product_money;
// exit;
 if($sale_product_money > 0)
 {
    $mod_sale_product_money=$sale_product_money;

    for($i=0;$i<count($order_cnt_info);$i++)
    {
       if((int)$order_cnt_info[$i]['small_price'] >= (int)$mod_sale_product_money)
       {
           $order_cnt_info[$i]['small_price'] = (int)$order_cnt_info[$i]['small_price'] - (int)$mod_sale_product_money;
           $mod_sale_product_money=0;
           break;
       }
       else
       {
           $mod_sale_product_money=(int)$mod_sale_product_money-(int)$order_cnt_info[$i]['small_price'];

           if($mod_sale_product_money > 0)
           {
//              $order_cnt_info[$i]['small_price']="1";
//              $mod_sale_product_money++;
              $order_cnt_info[$i]['small_price']="0";
//              $mod_sale_product_money++;
           }
           else
           {
              $order_cnt_info[$i]['small_price']=$mod_sale_product_money;
              break;
           }

      }
	}
 }

    /*************************************介接資訊************************************************************/
	$oService = new NetworkService();	// // 初始化網路服務物件。
	$oService->ServiceURL = $Url;
	/*************************************POST參數設置************************************************************/
	$szPlatformID = '';
	$szData = '';
	$arData = array();
	$item1 = array();
	$item2 = array();
	$item3 = array();
	$arParameters = array();
	$arFeedback = array();
	$Timestamp=time();
	$szRqHeader=array();
	$RqID= guid();
	$Revision='3.0.0';

	date_default_timezone_set("Asia/Taipei");

	/*************************************產生GUID****************************************************************/
	function guid(){
	    mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
	    $charid = strtoupper(md5(uniqid(rand(), true)));
	    $uuid = substr($charid, 0, 8)
	        .substr($charid, 8, 4)
	        .substr($charid,12, 4)
	        .substr($charid,16, 4)
	        .substr($charid,20,12);
	    return $uuid;
	}

	/*************************************判斷Json****************************************************************/
	function isJson($data = '', $assoc = false) {
	    $data = json_decode($data, $assoc);
	    if ($data && (is_object($data)) || (is_array($data) && !empty($data))) {
	        return $data;
	    }
	    return false;
	}

	/*************************************要傳遞的 ReHeader 參數**************************************************/
	$szRqHeader=array(
		'Timestamp' => $Timestamp,
		'RqID' => $RqID,
		'Revision' => $Revision,
	);

	/*************************************要傳遞的 item1 參數******************************************************/

	$item_arr = array();
	for($i=0;$i<count($order_cnt_info);$i++){
		if($order_cnt_info[$i]['product_name'] != ""){# and $order_cnt_info[$i]['is_addbuy'] == "2"

			$order_cnt_info[$i]['product_name'] = str_replace("【", "", $order_cnt_info[$i]['product_name']);
           	$order_cnt_info[$i]['product_name'] = str_replace("】", "", $order_cnt_info[$i]['product_name']);
           	$order_cnt_info[$i]['product_name'] = str_replace(" ", "", $order_cnt_info[$i]['product_name']);
           	$order_cnt_info[$i]['product_name'] = str_replace("|", "", $order_cnt_info[$i]['product_name']);
           	$order_cnt_info[$i]['product_name'] = str_replace(")", "", $order_cnt_info[$i]['product_name']);
           	$order_cnt_info[$i]['product_name'] = str_replace("(", "", $order_cnt_info[$i]['product_name']);
           	$order_cnt_info[$i]['product_name'] = str_replace("+", "", $order_cnt_info[$i]['product_name']);
           	$order_cnt_info[$i]['product_name'] = str_replace(" ", "", $order_cnt_info[$i]['product_name']);
           	$order_cnt_info[$i]['product_name'] = str_replace("/", "", $order_cnt_info[$i]['product_name']);
           	$order_cnt_info[$i]['product_name'] = str_replace("x", "", $order_cnt_info[$i]['product_name']);

			array_push($item_arr, array('ItemSeq ' =>count($item_arr)+1,'ItemName' => $order_cnt_info[$i]['product_name'], 'ItemCount' => (($order_cnt_info[$i]['amount'])?$order_cnt_info[$i]['amount']:"1"), 'ItemWord' => '個', 'ItemPrice' => $order_cnt_info[$i]['price'], 'ItemTaxType' => 1, 'ItemAmount' => $order_cnt_info[$i]['small_price'], 'ItemRemark' => 'no'  )) ;
		}
	}

	if($order_info['traffic_money'] != "" and $order_info['traffic_money'] != "0"){
	   array_push($item_arr, array('ItemSeq ' =>count($item_arr)+1,'ItemName' => '運費', 'ItemCount' => '1', 'ItemWord' => '元', 'ItemPrice' => $order_info['traffic_money'], 'ItemTaxType' => 1, 'ItemAmount' => $order_info['traffic_money'], 'ItemRemark' => 'no'  )) ;
	}

#show_array($item_arr);exit;
	/*************************************要傳遞的 Data 參數******************************************************/
	
$i=0;
do{
	$add_back = "";
	if($i)	$add_back = "-".str_pad($i,3,'0',STR_PAD_LEFT);
	$show = get_issue_v2($add_back);
	if($show!="again"){
		$i=100;
		print $show;
	}
	else{
		$i++;
	}
	#print $i;
} while ( $i<100 );
function get_issue_v2($add_back=""){
	global $MYSQL_VARS,$dblink,$MYSQL_TABS,$global_website_url,$_SESSION,$lineorder_test,$lineorder_setting,$_GET,$order_id,$order_info,$szMerchantID,$szHashKey,$szHashIV,$Url,$Donation,$LoveCode,$item_arr,$szPlatformID,$szRqHeader,$oService;
	$return = "";
	if(substr_count($order_info['invoice_type'],"三聯")>=1){
		$print 				= '1' ;///列印註記 。
		$CustomerAddr 			= ($order_info['recipient_address'])?$order_info['recipient_address']:$order_info['send_address'] ;//客戶地址。
		$CustomerTitle = $order_info['invoice_title'];
	}
	else if(substr_count($order_info['invoice_type'],"紙本")>=1){
		$print 				= '1' ;///列印註記 。
		$CustomerAddr 			= ($order_info['recipient_address'])?$order_info['recipient_address']:$order_info['send_address'] ;//客戶地址。
		$CustomerTitle = $order_info['send_man'];
	}
	else{
		$print				= '0' ;///列印註記 。
		$CustomerAddr 			= '' ;//客戶地址。
		$CustomerTitle = "";
	}

	#$RelateNumber = 'ECPAY'. date('YmdHis') . rand(1000000000,2147483647) ; //產生測試用自訂訂單編號
	$RelateNumber = $order_info['order_num'];
	if($add_back)	$RelateNumber .= $add_back;
	$arData = array(

		//會員編號
		'MerchantID' => $szMerchantID,

		//自訂編號
		'RelateNumber' => $RelateNumber, //$order_info['order_num']
		//'RelateNumber' => $order_info['order_num'],

		//客戶編號
		'CustomerID' => '',

		//統一編號
		'CustomerIdentifier' => $order_info['unification_num'],

		//客戶名稱，當列印註記=1(列印)時，為必填
		'CustomerName' => $CustomerTitle,

		//客戶地址，當列印註記=1(列印)時，為必填
		'CustomerAddr' => $CustomerAddr,

		//客戶手機號碼，當客戶電子信箱為空字串時，為必填
		'CustomerPhone' => $order_info['send_handphone'],

		//客戶電子信箱，當客戶手機號碼為空字串時，為必填
		'CustomerEmail' => $order_info['send_email'],

		//通關方式，當課稅類別[TaxType]=2(零稅率)時，為必填
		'ClearanceMark' => '',

		//列印註記，0：不列印(捐贈註記=1(捐贈)時、載具類別有值時)
		//			1：要列印(統一編號有值時)
	    'Print' => $print,

	    //捐贈註記，0：不捐贈(統一編號有值時、載具類別有值時)
		//			1：要捐贈
	    'Donation' => $Donation,

		//捐贈碼，當捐贈註記=1時，為必填
		'LoveCode' => $LoveCode,

		//載具類別
		'CarrierType' => '' ,

		//載具編號
		'CarrierNum'=>'',

		//課稅類別
		'TaxType'=>'1',

		//發票總金額(含稅)
		'SalesAmount'=>trim($order_info['sum_total']),

		//發票備註
		'InvoiceRemark'=>'發票備註',

		//商品
		'Items'=>$item_arr,

		//字軌類別
		'InvType'=>'07',

		//商品單價是否含稅
		'vat'=>'',
	);

	/******************************************************************************************************************************************/
	 #show_array($arData);exit;
	//轉Json格式
	$szData = json_encode($arData);

	//印出Data參數
	// echo "印出Data參數<br>";echo $szData,"<br>","<br>";

	//做urlencode
	$szData = urlencode($szData);

	//定義AES
	$oCrypter = new AESCrypter($szHashKey, $szHashIV);

	// 加密 Data 參數內容
	$szData = $oCrypter->Encrypt($szData);

	//印出Data加密結果
	#echo "印出Data加密結果<br>";echo $szData,"<br>","<br>";exit;

	//要POST的參數
	$arParameters = array(
		'PlatformID' =>$szPlatformID,
		'MerchantID' => $szMerchantID,
		'RqHeader' => $szRqHeader,
		'Data' => $szData
	);

	//轉Json格式
	$arParameters = json_encode($arParameters);

	//印出POST參數
	#echo "印出POST參數<br>";echo $arParameters,"<br>","<br>";exit;


	// 傳遞參數至遠端。
	$szResult = $oService->ServerPost($arParameters);

	// 顯示接收的參數
	// echo "印出回傳結果<br>";
	#echo $szResult,"<br>","<br>";exit;

	//判斷回傳是否為Json格式
	$ResultisJson=isJson($szResult);

	// print "<br>--------------<br>";
	// print $arParameters;
	// print "<br>--------------<br>";

	#print $ResultisJson;exit;

	if($ResultisJson==TRUE){
	    $DataisNull=json_decode($szResult,true);
	    if(isset($DataisNull["Data"])){
	        if($DataisNull["Data"]!==''){
	            //將Data解密
	            $DataDec = $oCrypter->Decrypt($DataisNull["Data"]);
				$DataDec1=json_decode($DataDec,true);
	            if(isset($DataDec1["RtnCode"])){
					if($DataDec1["RtnCode"]===1){
						//印出Data解密結果
						// echo "成功<br>";
						// echo $DataDec,"<br>";
						$data_arr = json_decode($DataDec,true);

						if($data_arr['InvoiceNo']!=""){
							$return .= "<br><br>發票號碼：".$data_arr['InvoiceNo'];
							$update_info = array();
							$update_info['invoice_num'] = $data_arr['InvoiceNo'];
							$update_info['invoice_time'] = date("Y-m-d H:i:s");
							$where_clause="Fmain_id = '$order_id'";
							$tbl_name="sys_portal_y100";
							update_data($tbl_name, $where_clause, $update_info);
						}#KK20022016

					}
					else if($DataDec1["RtnCode"]===1500046 || $DataDec1["RtnCode"]===5070357){
						$return = "again";
					}
					else{
						$return .= "失敗<br>";
						$return .= $DataDec."<br>";
					}
				}
				else{
					$return .= "Data未含有RtnCode<br>";
				}
				$add_info = array();
				$add_info['order_id'] = $order_id;
				$add_info['log'] = $DataDec;
				$add_info['now_time'] = date("Y-m-d H:i:s");
				$add_info['send_log']  = json_encode($arData);
				$tbl_name = "issue_log";
				$return_arr=add_data($tbl_name,$add_info);
				$return_id=$return_arr['newrid'];
			}
	        else{
	            $return .= "Data回傳空值<br>";
	        }
	    }
	    else{
	        $return .= "回傳沒有Data<br>";
	    }
	}
	else {
		$return .= "回傳格錯誤，非Json格式<br>";
	}
	return $return;
}
	/************************************服務類別*************************************************/


	/**
	 * 呼叫網路服務的類別。
	 */
	class NetworkService {

	    /**
	     * 網路服務類別呼叫的位址。
	     */
	    public $ServiceURL = 'ServiceURL';

	    /**
	     * 網路服務類別的建構式。
	     */
	    function __construct() {
	        $this->NetworkService();
	    }

	    /**
	     * 網路服務類別的實體。
	     */
	    function NetworkService() {

	    }

	    /**
	     * 提供伺服器端呼叫遠端伺服器 Web API 的方法。
	     */
	    function ServerPost($parameters) {
	        $ch = curl_init();

	        curl_setopt($ch, CURLOPT_URL, $this->ServiceURL);
	        curl_setopt($ch, CURLOPT_HEADER, FALSE);
	        //curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	        curl_setopt($ch, CURLOPT_POST, TRUE);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
	        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Content-Length: ' . strlen($parameters)));
	        $rs = curl_exec($ch);

	        curl_close($ch);

	        return $rs;

	    }

	}

	/**
	 * AES 加解密服務的類別。
	 */
	class AesCrypter {

	    #private $Key = '5294y06JbISpM5x9';
	    #private $IV = 'v77hoKGq4kWxNNIS';
	    private $Key = 'ejCk326UnaZWKisg';
	    private $IV = 'q9jcZX8Ib9LM8wYk';
	    #private $Key = $szHashKey;
	    #private $IV = $szHashIV;

	    /**
	     * AES 加解密服務類別的建構式。
	     */
	    function __construct($key, $iv) {
	        $this->AesCrypter($key, $iv);
	    }

	    /**
	     * AES 加解密服務類別的實體。
	     */
	    function AesCrypter($key, $iv) {
	        $this->Key = $key;
	        $this->IV = $iv;
	    }

	    /**
	     * 加密服務的方法。
	     */
	    function Encrypt($data)
	    {
	        $szBlockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
	        $szPad = $szBlockSize - (strlen($data) % $szBlockSize);
	        $szData = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->Key, $data. str_repeat(chr($szPad), $szPad), MCRYPT_MODE_CBC, $this->IV);
	        $szData = base64_encode($szData);

	        return $szData;
	    }

		/**
	     * 解密服務的方法。
	     */
	    function Decrypt($data)
	    {
			$szValue = base64_decode($data);
	        $szValue = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->Key, $szValue, MCRYPT_MODE_CBC, $this->IV);
	        $nLength = strlen($szValue);
	        $nPadding = ord($szValue[$nLength - 1]);
	        $szValue = substr($szValue, 0, $nLength - $nPadding);
			$szValue=urldecode($szValue);
	        return $szValue;
	    }
}
?>
	
</body>
</html>
