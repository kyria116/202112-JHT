<?
    $info=array();
    $where_clause="1";
    $tbl_name="sys_portal_k5";
    get_data($tbl_name, $where_clause, $info);
    // show_array($info);


    $info['content'] = str_replace("<p>", "", $info['content']);
    $info['content'] = str_replace("</p>", "", $info['content']);

    $phone_info=array();
    $where_clause=" 1 order by Fmain_id asc ";
    $tbl_name="sys_portal_k6";
    getall_data($tbl_name, $where_clause, $phone_info);
    // show_array($phone_info);

    $social_info=array();
    $where_clause="1 order by rank desc";
    $tbl_name="sys_portal_k7";
    getall_data($tbl_name, $where_clause, $social_info);
    // show_array($social_info);
    
    $website_seo_info=array();
	$where_clause="Fmain_id = '1'";
	$tbl_name="sys_website_seo";
	get_data($tbl_name, $where_clause, $website_seo_info);
?>
<?=$website_seo_info['body_code']?>
<footer>
    <div class="f-bx">
        <div class="l-bx">
            <div class="f-logo"></div>
            <ul class="da-list">
                <li>
                    <a href="tel:<?=$phone_info[0]['text_field_1']?>">
                        客服電話
                        <span><?=$phone_info[0]['text_field_1']?></span>
                    </a>
                </li>
                <li>
                    <span>上舜科技有限公司</span><span>統一編號 24966798</span><a href="https://maps.app.goo.gl/v8rjoSconHPxJS5u8" target="_blank" class="addrFooter">台北市松山區南京東路五段198號3樓-1</a>
                </li>
            </ul>
        </div>
        <div class="r-bx">
<!--
            <ul class="da-list">
                <li>
                    <a href="tel:<?=$phone_info[0]['text_field_1']?>">
                        客服電話
                        <span><?=$phone_info[0]['text_field_1']?></span>
                    </a>
                </li>
                <li>
                    <a href="mailto:<?=$phone_info[1]['text_field_1']?>">
                        客服信箱
                        <span><?=$phone_info[1]['text_field_1']?></span>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="https://www.google.com.tw/maps/place/<?=$phone_info[2]['text_field_1']?>">
                        門市地址
                        <span><?=$phone_info[2]['text_field_1']?></span>
                    </a>
                </li>
            </ul>
-->
            <div class="des-bx">
                <div class="flex-bx">
                    <a href="terms.php" class="term-btn">本站條款</a>
                    <div class="link-group">
            <?for($iii=0;$iii<count($social_info);$iii++){

                $pic_url = "";
                $pic_arr = get_pic_path($social_info[$iii]['pic_field_0']);
                if(count($pic_arr)>0){
                    $pic_url = "./login_admin/upload_file/".$pic_arr['pic_file'];
                }

                print "<a href='".$social_info[$iii]['text_field_1']."' target='_blank'><img src='".$pic_url."'></a>";
            }?>
<!--
                        <a href="javascript:;" target="_blank">
                            <img src="dist/images/h_icon.png">
                        </a>
                        <a href="javascript:;" target="_blank">
                            <img src="dist/images/fb_icon.png">
                        </a>
                        <a href="javascript:;" target="_blank">
                            <img src="dist/images/yu_icon.png">
                        </a>
-->
                    </div>
                </div>
                <div class="copyright">
                    <?=$phone_info[3]['text_field_1']?> <br class="mo"> All Rights Reserved. | <a target="_blank" href="https://mak66design.com/">Designed by M.A.K</a>
                </div>
            </div>
        </div>
    </div>
</footer>