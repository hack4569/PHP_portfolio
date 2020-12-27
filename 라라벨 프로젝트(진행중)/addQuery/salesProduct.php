<?php 
$sfst_cate = !empty($_REQUEST['sfst_cate'])?trim($_REQUEST['sfst_cate']):"";
$sfst_cate = urldecode($sfst_cate);
$ssnd_cate = !empty($_REQUEST['ssnd_cate'])?trim($_REQUEST['ssnd_cate']):"";
$ssnd_cate = urldecode($ssnd_cate);
if($ssnd_cate=="All"){ $ssnd_cate="";}
$skey = !empty($_REQUEST['skey'])?trim($_REQUEST['skey']):"";
$skey = urldecode($skey);
if($sfst_cate){ 
	$addquery .= " and a.fst_cate like concat(concat('%', :sfst_cate),'%') ";
	$paramArr[':sfst_cate']=$sfst_cate;
}
if($ssnd_cate){
	$addquery .= " and a.snd_cate like concat(concat('%', :ssnd_cate),'%') ";
	$paramArr[':ssnd_cate']=$ssnd_cate;
}
if($skey){
	$addquery .= " and a.eng_name like concat(concat('%', :skey),'%') ";
	$paramArr[':skey']=$skey;
}
$addUrl = "sfst_cate=$sfst_cate&ssnd_cate=$ssnd_cate&skey=".urlencode($skey);
?>