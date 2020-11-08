<?php
include_once  $_SERVER['DOCUMENT_ROOT'] ."/wine/common.php";
// include $_SERVER['DOCUMENT_ROOT'] ."/wine/dao/product_management.php";
include $_SERVER['DOCUMENT_ROOT'] ."/wine/dao/Product_managementDAO.php";
// if($_;SESSION['userid']!="admin"){
	//     Util::alert_redirect("권한이 없습니다.", "../../login.php");
	// }
$sfst_cate = isset($_GET['sfst_cate'])?trim($_GET['sfst_cate']):"";
$ssnd_cate = isset($_GET['ssnd_cate'])?trim($_GET['ssnd_cate']):"";
if($ssnd_cate=="All"){ $ssnd_cate="";}
$skey = isset($_GET['skey'])?trim($_GET['skey']):"";

$addquery = "";//추가쿼리
$paramArr = array();//query함수를 사용하기 위한 배열
include $_SERVER['DOCUMENT_ROOT'] ."/wine/addQuery/salesProduct.php";
$product_info = new Product_managementDAO($pdo, "sales_info");

try{
	$listcnt = $product_info -> salesPdtCnt($addquery, $paramArr);
	$lists = $product_info -> salesPdtList($addquery, $paramArr);
	
	include "./views/list.php";

}catch(PDOException $e){
	$result = $e -> getMessage();
}

// if($sfst_cate){ 
// 	$addquery .= " and a.fst_cate like concat(concat('%', :sfst_cate),'%') ";
// 	$paramArr[':sfst_cate']=$sfst_cate;
// }
// if($ssnd_cate){
// 	$addquery .= " and a.snd_cate like concat(concat('%', :ssnd_cate),'%') ";
// 	$paramArr[':ssnd_cate']=$ssnd_cate;
// }
// if($skey){
// 	$addquery .= " and a.eng_name like concat(concat('%', :skey),'%') ";
// 	$paramArr[':skey']=$skey;
// }
//리스트 카운트 조회
// 2 $query = "
// 	select count(*) as cnt
// 	from product_info a
// 		left outer join sales_info b
// 		on a.eng_name = b.eng_name
// 	where b.isnew = 'new' $addquery
// 	";

//주석대신 밑에 query로 정의해서 호출함++
// $stmt = $pdo->prepare($query);
// if($sfst_cate){ 
// 	$stmt->bindParam(":sfst_cate",$sfst_cate,PDO::PARAM_STR);//자동으로 sqlInjection적용됨++
// }
// if($ssnd_cate){
// 	$stmt->bindParam(":ssnd_cate",$ssnd_cate,PDO::PARAM_STR);
// }
// if($skey){
// 	$stmt->bindParam(":skey",$skey,PDO::PARAM_STR);
// }
// $stmt->execute();

//2 $stmt = query($pdo, $query, $paramArr);
//2 $listcnt = $stmt -> fetchColumn();
//3 $listcnt = salesPdtCnt($pdo, $addquery, $paramArr);
// $row = $stmt->fetch(PDO::FETCH_ASSOC);
// $listcnt =  $row['cnt'];

//  $result = mysqli_query($db_conn, $query);
//  $row = mysqli_fetch_assoc($result);

//리스트 조회
//  2 $query = "
// 	select *
// 	from  product_info a
// 		left outer join sales_info b
// 		on a.eng_name = b.eng_name
// 	where b.isnew='new' $addquery order by a.eng_name
//     ";
//$stmt = $pdo->prepare($query);
// if($sfst_cate){ 
// 	$stmt->bindParam(":sfst_cate",$sfst_cate,PDO::PARAM_STR);
// }
// if($ssnd_cate){
// 	$stmt->bindParam(":ssnd_cate",$ssnd_cate,PDO::PARAM_STR);
// }
// if($skey){
// 	$stmt->bindParam(":skey",$skey,PDO::PARAM_STR);
// }
//$stmt->execute();
//$result = mysqli_query($db_conn, $query);
// 2 $stmt = query($pdo, $query, $paramArr);
// 2 $lists = $stmt->fetchAll();

// 3 $lists = salesPdtList($pdo, $addquery, $paramArr);

?>
