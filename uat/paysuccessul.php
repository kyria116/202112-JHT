<?

  require_once ("global_include_file.php");

  $order_id=$_GET['order_id'];

  $order_info=array();
 	$where_clause="  Fmain_id = '".AddSlashes($order_id)."' and is_confirm = '1' ";
 	$tbl_name=$MYSQL_TABS['portal_y100'];
 	get_data($tbl_name, $where_clause, $order_info);
 	session_destroy();
 	if(count($order_info) <= 0)
 	{
 	    print "<script>";
 		print " alert('付款失敗請重新下訂');";
 		print " window.location.href='index.php';";
 		print "</script>";
 		exit;
 	}


	$cnt_info=array();
	$where_clause=" portal_y100_id = '".$order_info['Fmain_id']."' ";
	$tbl_name="sys_portal_y100_cnt";
	getall_data($tbl_name, $where_clause, $cnt_info);
	$ga_even_js = "";
   if(trim($google_analytics_id) != "")
   {
	$ga_even_js.="<script>\n";
	$ga_even_js.="  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){";
	$ga_even_js.="  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),";
	$ga_even_js.="  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)";
	$ga_even_js.=" })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');\n";
	$ga_even_js.="  ga('create', '".$google_analytics_id."', 'auto');\n";
	$ga_even_js.="  ga('send', 'pageview');\n";
	$ga_even_js.="  ga('require', 'ec');\n";
      for($j=0;$j<count($cnt_info);$j++)
      {
           $ga_even_js.="ga('ec:addProduct',{\n";
           $ga_even_js.="  'id':'".$cnt_info[$j]['product_num']."',\n";
           $ga_even_js.="  'name':'".$cnt_info[$j]['product_name']."',\n";
           $ga_even_js.="  'price':'".$cnt_info[$j]['small_price']."',\n";
           $ga_even_js.="  'quantity':'".$cnt_info[$j]['amount']."'\n";
           $ga_even_js.="});\n";
      }
  $ga_even_js.="ga('ec:setAction', 'purchase',{\n";
  $ga_even_js.="  'id':'".$order_info['order_num']."',\n";
  if($order_info['traffic_money'])	$ga_even_js.="  'shipping':'".$order_info['traffic_money']."',\n";
  $ga_even_js.="  'revenue':'".$order_info['sum_total']."'\n";
  $ga_even_js.="});\n";
  $ga_even_js.="ga('send','pageview');\n";
  $ga_even_js.="</script>\n";
  }


  $ga_even_js2.="<script>\n";
  $ga_even_js2.="  dataLayer = [{\n";
  $ga_even_js2.="    'orderValue': '".$order_info['sum_total']."',\n";
  $ga_even_js2.="  }];\n";
  $ga_even_js2.="</script>\n";


  $ga_even_js.="<script>\n";
  $ga_even_js.="fbq('track', 'Purchase', {\n";
  $ga_even_js.="value: ".$order_info['sum_total'].",\n";
  $ga_even_js.="currency: 'TWD'\n";
  $ga_even_js.="});\n";
  $ga_even_js.="</script>\n";


?>
<?php include "quote/template/head.php"; ?>
<link rel="stylesheet" href="dist/css/main.css">
<link rel="stylesheet" href="dist/css/registration.css">
</head>

<body class="paysuccessulPage">
    <?php
        include "quote/template/added.php";
        include "quote/template/nav.php";
        print $ga_even_js;
    ?>
    <div id="Wrapper">
        <main role="main">
            <div class="sh-banner">
                <img class="pc" src="dist/images/pay/line_1_pc.png">
                <img class="mo" src="dist/images/pay/line_1_mb.png">
                <div class="container">
                    <h2>
                        <div class="e-ti">PAY <br class="mo"> SUCCESSFUL</div>
                        <div class="t-ti">購物成功</div>
                    </h2>
                </div>
            </div>
            <section class="item1">
                <div class="container">
                    <div class="it1-bx">
                        <div class="l-bx">
                            <img src="dist/images/pay/illustration.png">
                        </div>
                        <div class="form-bx">
                            <div class="form-ti">
                                <div class="f16">
                                    您已完成訂購   訂單編號為 <span><?=$order_info['order_num']?></span>
                                    <br>
                                    感謝您對JHT的支持!
                                </div>
                                <div class="f14">
                                    本公司保留接受訂單與否的權利，若因交易條件有誤、商品無庫存或有其他本公司無法接受訂單之情形，本公司將以email通知您訂單不成立/取消訂單。
                                </div>
                                <iframe src="<?=$global_website_url?>login_admin/print_code.php?id=<?=$order_info['Fmain_id']?>" name="mainframe" width="100%" marginwidth="0" marginheight="0" onload="Javascript:SetCwinHeight()"  scrolling="No" frameborder="0" id="mainframe">
                        </iframe>
<script type="text/javascript">
function SetCwinHeight()
{
var iframeid=document.getElementById("mainframe"); //iframe id
  if (document.getElementById)
  {
   if (iframeid && !window.opera)
   {
    if (iframeid.contentDocument && iframeid.contentDocument.body.offsetHeight)
     {
       iframeid.height = iframeid.contentDocument.body.offsetHeight;
     }else if(iframeid.Document && iframeid.Document.body.scrollHeight)
     {
       iframeid.height = iframeid.Document.body.scrollHeight;
      }
    }
   }
}
</script>
                            </div>
                            <a href="./" class="sh-btn send-btn">
                                <div class="ar"></div>
                                回首頁
                            </a>
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
    <script src="dist/js/jquery.twzipcode.min.js"></script>
    <script>
          $("#twzipcode").twzipcode({
            onCountySelect: function() {
            if($(this).val() == ""){
                $("#county").addClass('nonsel');
                $("#district").removeClass('nonsel');
            }else {
                    $("#county").removeClass('nonsel');
                    $("#district").addClass('nonsel');
                }
            },
            zipcodeIntoDistrict: true,
            });

            $('#demand,#status,#contacttime').change(function(){
            $(this).addClass('chcol');
        })
    </script>
</body>

</html>