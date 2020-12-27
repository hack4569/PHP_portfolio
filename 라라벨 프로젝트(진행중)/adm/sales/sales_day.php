<?php
include_once  $_SERVER['DOCUMENT_ROOT'] ."/wine/common.php";

// if($_SESSION['userid']!="admin"){
//     Util::alert_redirect("권한이 없습니다.", "../../login.php");
// }
$sdate = $_GET['sdate']?$_GET['sdate']:date("Y-m-d", time());

// $uid = $_SESSION['member_id'];


//리스트 카운트 조회
$query = "
	select count(*) as cnt
	from product_info a left outer join sales_info b on a.eng_name = b.eng_name
	where date_format(regist_time,'%Y-%m-%d') = '$sdate' and b.count <> 0
    ";
$result = $result = mysqli_query($db_conn, $query);
$row = mysqli_fetch_assoc($result);
$listcnt =  $row['cnt'];

if($listcnt>0){
    //리스트 조회
    $query = "
    	select b.eng_name, b.initial_stock, b.quantity, b.count, (b.initial_stock-b.quantity) as re_stock, a.fst_cate , a.out_price
    	from product_info a left outer join sales_info b on a.eng_name = b.eng_name
    	where date_format(regist_time,'%Y-%m-%d') = '$sdate' and b.count <> 0
        order by b.eng_name desc
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

<title>매출현황 BONHEUR</title>

<?php require ("../../comm/common_resource.php");?>

</head>
<body>
<div class="manager_main_content">
    <div id="manager_leftmenu" class="manager_left_menu">
        <div class="logo">
            <img src="../../images/manager_logo.png">
        </div>
        <ul class="left_sub_menu">
            <li ><a href="<?php echo $http_url?>/adm/product_management/list.php">제품관리</a></li>
        	<li><a href="<?php echo $http_url?>/adm/sales/index.php">매출현황</a></li>
            <li class="active_menu"><a href="<?php echo $http_url?>/adm/sales/index.php">일별조회</a></li>
            <li><a href="<?php echo $http_url?>/adm/sales/sales_month.php">월별조회</a></li>
			<li><a href="<?php echo $http_url?>/adm/sales/sales_state.php">주문현황</a></li>
        </ul>
    </div>
	<div class="main_content">
        <div class="main_title">
            <h2>일 매출현황</h2>
        </div>
        <div class="product_list_cate">
        	<form name="rForm" id="rForm" method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
                <div class="product_list_keyword">
                    <p class="manager_cate_font">
                        	기간조회
                    </p>
                    <input type="date" name="sdate" value="<?php echo $sdate;?>" class="sdate">
                    <div class="skey_submit" id="skey_submit">
                        <img src="../../images/Search.png" alt="">
                    </div>
                </div>
            </form>
        </div>
		<div class="productlist_content">
        <table summary="진행현황목록표" class="table_list">
            <caption>진행현황 목록표</caption>
            <colgroup>
                <col width="12.5%"/>
                <col width="12.5%"/>
                <col width="12.5%"/>
                <col width="12.5%"/>
                <col width="12.5%"/>
                <col width="12.5%"/>
                <col width="12.5%"/>
                <col width="12.5%"/>
            </colgroup>
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">1depth</th>
                    <th scope="col">제품명</th>
                    <th scope="col">판매건수</th>
                    <th scope="col">판매수량</th>
                    <th scope="col">제품단가</th>
                    <th scope="col">남은재고</th>
                    <th scope="col">매출합계</th>
                </tr>
            </thead>
            <tbody>
                	<?php if($listcnt == 0){?>
        				<tr>
        					<td colspan="<?php echo "8";?>">자료가 없습니다.</td>
        				</tr>
        			<?php 
                        }else{
                            $sum_count=0;
                            $sum_sales=0;
                            $sum_quantity=0;
                            while($row = mysqli_fetch_assoc($result)){
        			?>
        			<tr>
        				<td><?php echo $listcnt; ?></td>
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
        				</td>
        				<td><?php echo $row['eng_name'];?></td>
        				<td style="text-align:center"><?php echo $row['count'];?></td>
        				<td><?php echo number_format($row['quantity']);?></td>
        				<td><?php echo number_format($row['out_price']);?></td>
        				<td><?php echo number_format($row['re_stock']);?></td>
        				<td><?php echo number_format((int)$row['quantity']*(int)$row['out_price']);?></td>
        			</tr>
        			<?php 
        					$listcnt--;
        					$sum_count += $row['count'];
        					$sum_sales += (int)$row['quantity']*(int)$row['out_price'];
        					$sum_quantity += $row['quantity'];
                            }
        				}
        			 ?>
            </tbody>
            <tfoot>
            	<tr>
            		<td>매출합계</td>
            		<td></td>
            		<td></td>
            		<td style="text-align: center"><?php echo number_format($sum_count);?></td>
            		<td><?php echo number_format($sum_quantity);?></td>
            		<td></td>
            		<td></td>
            		<td><?php echo number_format($sum_sales);?></td>
            	</tr>
            </tfoot>
        </table>
        <div class="btn_wrap">
        	<button id="btn_del" class="btn_del fr">엑셀다운로드</button>
        </div>
        <form action="<?php echo $http_url;?>/adm/sales/excel_download_sales.php" method="get" id="eForm" name="eForm">
        	<input type="hidden" name="sdate" value="<?php echo $sdate;?>">
        	<input type="hidden" name="down_type_fst" value="sales">
        	<input type="hidden" name="down_type_snd" value="day">            	
        </form>
	 	</div><!-- productlist_content -->
    </div><!-- main_content -->
</div><!-- manager_main_content -->
<script>
	var f = document.querySelector("#rForm");
	var btn_sbm = document.querySelector("#skey_submit");
	btn_sbm.addEventListener("click", function(){
		f.submit();
	});
	//엑셀파일 다운로드
	$("#btn_del").click(function(){
 		$("#eForm").submit();
	});
</script>
</body>
</html>