<?php
include_once  $_SERVER['DOCUMENT_ROOT'] ."/wine/common.php";

// if($_SESSION['userid']!="admin"){
//     Util::alert_redirect("권한이 없습니다.", "../../login.php");
// }

// $uid = $_SESSION['member_id'];
$mode = isset($_GET['mode'])?trim($_GET['mode']):"";



//리스트 카운트 조회
$query = "
	select count(*) as cnt from sales_state
    ";

$result = mysqli_query($db_conn, $query);
$row = mysqli_fetch_assoc($result);
$listcnt =  $row['cnt'];

if($listcnt>0){
    //리스트 조회
    $query = "
		select * from sales_state a left outer join product_info b on a.eng_name = b.eng_name
		order by regist_datetime desc
        ";

    $result = mysqli_query($db_conn, $query);
}


?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="author" content="BONHEUR"/>
<meta name="ROBOTS" content="NOINDEX,NOFOLLOW"/>
<meta name="keyword" content="BONHEUR"/>
<META HTTP-EQUIV="refresh" CONTENT="10">
<title>주문현황 BONHEUR</title>

<?php require ("../../comm/common_resource.php");?>

</head>
<body>
<div class="manager_main_content">

	<div id="manager_leftmenu" class="manager_left_menu">
		<div class="logo">
			<img src="../../images/manager_logo.png">
		</div>
		<ul class="left_sub_menu">
			<li><a href="<?php echo $http_url?>/adm/product_management/list.php">제품관리</a></li>
			<li><a href="<?php echo $http_url?>/adm/sales/sales_day.php?sdate=">매출현황</a></li>
			<li class="active_menu"><a href="<?php echo $http_url?>/adm/sales/sales_state.php">주문현황</a></li>
		</ul>
	</div>
	<div class="main_content">
        <div class="main_title">
            <h2>주문 현황</h2>
        </div>
		<div class="productlist_content product_state">
			<table summary="주문현황목록표" class="table_list">
				<caption>주문현황 목록표</caption>
				<colgroup>
					<col width="20%"/>
					<col width="10%"/>
					<col width="30%"/>
					<col width="10%"/>
					<col width="10%"/>
					<col width="*"/>
				</colgroup>
				<thead>
					<tr>
						<th scope="col">주문시간</th>
						<th scope="col">카테고리</th>
						<th scope="col">상품명</th>
						<th scope="col">주문수량</th>
						<th scope="col">판매가</th>
						<th scope="col"></th>
					</tr>
					
				</thead>
				<tbody>
						<?php if($listcnt == 0){?>
							<tr>
								<td colspan="<?php echo "6";?>">자료가 없습니다.</td>
							</tr>
						<?php 
							}else{
								$i=1;
								while($row = mysqli_fetch_assoc($result)){
						?>
						<tr>
							<td>
								<?php if($i==1){?>
									<?php echo date("Y-m-d",strtotime($row['regist_datetime'])); ?>
									<br>
									<?php echo date("H:i:s",strtotime($row['regist_datetime']));?>
								<?php }else{?>
									<?php echo date("Y-m-d H:i:s",strtotime($row['regist_datetime'])); ?>
								<?php } ?>
							</td>
							<td>
								<?php
									switch ($row['fst_cate']){
										case 'snack' : 
											echo '간식';
											break;
										case 'cs' :
											echo 'Champagne & Sparkling';
											break;
										case 'sw' :
											echo 'Sweet Wines';
											break;
										case 'ww':
											echo 'White Wine';
											break;
										case 'rw':
											echo 'Red Wine';
											break;
									}
								?>
							</td >
							<td><?php echo $row['eng_name'];?></td>
							<td style="text-align: center"><?php echo $row['quantity'];?></td>
							<td><?php echo number_format($row['out_price']);?></td>
							<td>
								<a href="./stock_proc.php?eng_name=<?php echo $row['eng_name'];?>&num=<?php echo $row['num'];?>&order=cancle&quantity=<?php echo $row['quantity'];?>" class="btn_modify" style="margin-right:5px">주문철회</a>
								<a href="./stock_proc.php?eng_name=<?php echo $row['eng_name'];?>&num=<?php echo $row['num'];?>&order=refund&quantity=<?php echo $row['quantity'];?>" class="btn_modify" style="margin-right:5px">환불</a>
								<a href="./stock_proc.php?eng_name=<?php echo $row['eng_name'];?>&num=<?php echo $row['num'];?>&order=order&quantity=<?php echo $row['quantity'];?>" class="btn_approval">승인</a>
							</td>
						</tr>
						<?php 
								$i++;
								}
							}
						?>
				</tbody>
			</table>
			<div class="reg_btn">
				<p>* 주문 현황 조회 및 취소 승인 절차 가능</p>
			</div>
		</div><!-- productlist_content -->
    </div><!-- main_content -->
</div><!-- manager_main_content -->
</body>
</html>