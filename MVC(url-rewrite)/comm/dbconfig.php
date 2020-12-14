<?php
if(!defined('_BONHEUR_')) exit; // 개별 페이지 접근 불가
?>
<?php 

//운영
// $lib_host = "localhost";
// $lib_user = "geum2111";
// $lib_password = "geumsoojang00";
// $lib_db = "geum2111";

//테스트 db
$lib_host = "127.0.0.1";
$lib_user = "root";
$lib_password = "dkflfkd1";
$lib_db = "wine";

try{
	$pdo = new PDO('mysql:host=localhost;dbname=wine;charset=utf8', 'root', 'dkflfkd1');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
	echo $e->getMessage();
}

// // 에러 출력하지 않음
// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
// // Warning만 출력
// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
// // 에러 출력
// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

