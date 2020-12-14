<?php

// if($_SESSION['userid']=="admin"){
//     header("Location: ./management_product/index.php");
// }
//2020-12-06
//index.php에서 검증해준다
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="author" content="BONHEUR"/>
<meta name="ROBOTS" content="NOINDEX,NOFOLLOW"/>
<meta name="keyword" content="BONHEUR"/>
<title><?=$title?>BONHEUR</title>
<?php require ($_SERVER['DOCUMENT_ROOT'] ."/wine/comm/common_resource.php");?>

</head>
<body>
	<?=$output?>
</body>
</html>