<?php
include_once  $_SERVER['DOCUMENT_ROOT'] ."/wine/common.php";
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="author" content="BONHEUR"/>
<meta name="ROBOTS" content="NOINDEX,NOFOLLOW"/>
<meta name="keyword" content="BONHEUR"/>

<title>BONHEUR</title>

<?php require ("./comm/common_resource.php");?>

</head>
<body>
<div class="main_content">
    <div class="topmenu">
    	<div  class="tmenu_wrap">
    		<h1><a href="<?php echo $http_url?>/main.php"><img src="./images/logo.png" alt="카페 보네르" /></a></h1>
    		<div class="clear"></div>
    	</div>
    </div> 
	<div class="sub_content">
		<div class="main_box"> 
			<div class="box"><a href="#;" onclick="window.open('./product/product_list.php?fst_cate=cs', '_blank', 'toolbar=no,scrollbars=yes,resizable=yes,top=0,left=0,width=1024,height=768')" >Champagne & Sparkling</a></div>
			<div class="box"><a href="#;" onclick="window.open('./product/product_list.php?fst_cate=sw', '_blank', 'toolbar=no,scrollbars=yes,resizable=yes,top=0,left=0,width=1024,height=768')">Sweet Wines</a></div>
			<div class="box"><a href="#;" onclick="window.open('./product/product_list.php?fst_cate=ww', '_blank', 'toolbar=no,scrollbars=yes,resizable=yes,top=0,left=0,width=1024,height=768')">White Wine</a></div>
			<div class="box"><a href="#;" onclick="window.open('./product/product_list.php?fst_cate=rw', '_blank', 'toolbar=no,scrollbars=yes,resizable=yes,top=0,left=0,width=1024,height=768')">Red Wine</a></div>
		</div>
	</div><!-- sub_content -->
</div><!-- main_content -->	
</div>

</body>
</html>