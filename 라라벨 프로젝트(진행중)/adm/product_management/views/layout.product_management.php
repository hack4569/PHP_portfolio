<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="author" content="BONHEUR"/>
<meta name="ROBOTS" content="NOINDEX,NOFOLLOW"/>
<meta name="keyword" content="BONHEUR"/>

<title><?=$title?> | 보네르</title>

<?php require ("../../comm/common_resource.php");?>

</head>
<body>
<div class="manager_main_content">

<!-- left_menu -->
<?php include "../layout/left_menu.php";?>
<script type="text/javascript">
	//<![CDATA[
	autoChildMenuOpen($('#lnb > li'),'1'); //]]>
</script>

<div class="manager_rightmenu">
	<div class="main_content">
    		<div class="main_title">
    			<h2><?=$title?></h2>
    		</div>
            <?=$output?>
        </div>
    </div>
</div>


</body>
</html>
