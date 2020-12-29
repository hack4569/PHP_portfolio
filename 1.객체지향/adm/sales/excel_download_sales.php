<?php
include_once  $_SERVER['DOCUMENT_ROOT'] ."/wine/common.php";

// if($_SESSION['userid']!="admin"){
//     Util::alert_redirect("권한이 없습니다.", "../../login.php");
// }

$down_type_fst = isset($_GET['down_type_fst'])?trim($_GET['down_type_fst']):"";
$down_type_snd = isset($_GET['down_type_snd'])?trim($_GET['down_type_snd']):"";
$syear = isset($_GET['syear'])?trim($_GET['syear']):date("Y",time());
$smonth = isset($_GET['smonth'])?trim($_GET['smonth']):date("m",time());
$eyear = isset($_GET['eyear'])?trim($_GET['eyear']):date("Y",time());
$emonth = isset($_GET['emonth'])?trim($_GET['emonth']):date("m",time());
$sdate = isset($_GET['sdate'])?$_GET['sdate']:date("Y-m-d", time());
if($smonth<10 && strlen($smonth)==1){
    $smonth = '0'.$smonth;
}
if($emonth<10 && strlen($emonth)==1){
    $emonth = '0'.$emonth;
}


$addquery = "";
if($down_type_fst){
    if($down_type_fst=="sales"){
        if($down_type_snd=="day"){
            $addquery="where date_format(regist_time,'%Y-%m-%d') = '$sdate'
                    order by b.eng_name desc";
            $filename = "$sdate 매출현황.xls";
        }else if($down_type_snd=="month"){
            $addquery="where date_format(regist_time,'%Y%m') >= '$syear$smonth' and date_format(regist_time,'%Y%m') <= '$eyear$emonth'
                order by b.regist_time desc";
            $filename = "$syear$smonth-$eyear$emonth 매출현황.xls";
        }
    }
}else{
    Util::alert("잘못된 접근입니다.");
}

    //리스트 카운트 조회
    $query = "
    	select count(*) as cnt
    	from product_info a left outer join sales_info b on a.eng_name = b.eng_name
    	$addquery
        ";
    $result = mysqli_query($db_conn, $query);
    $row = mysqli_fetch_assoc($result);
    $listcnt =  $row['cnt'];

    if($listcnt>0){
        //리스트 조회
        $query = "
        	select b.eng_name, b.initial_stock, b.quantity, b.count, b.regist_time, (b.initial_stock-b.quantity) as re_stock, a.fst_cate , a.out_price
        	from product_info a left outer join sales_info b on a.eng_name = b.eng_name
        	$addquery
            ";
        	$result = mysqli_query($db_conn, $query);
    }else{
        Util::error_back("데이터가 없습니다.");
    }

$filename = iconv('UTF-8','EUC-KR',$filename);
header( "Content-type: application/vnd.ms-excel; charset=KSC5601" );
header( "Content-Disposition: attachment; filename=$filename" );

echo "<meta http-equiv=\"Content-Type\" content=\"text/xls; charset=utf-8\"/>" ;
echo(" <TABLE border='1' cellpadding='2' cellspacing='5'>
		  <tr height='30' align='center'>
		    <td bgcolor='#DDDDDD' width='100'>NO</td>
		    <td bgcolor='#DDDDDD' width='100'>1depth</td>
		    <td bgcolor='#DDDDDD' width='100'>제품명</td>
		    <td bgcolor='#DDDDDD' width='100'>판매건수</td>
            <td bgcolor='#DDDDDD' width='100'>판매수량</td>
            <td bgcolor='#DDDDDD' width='100'>제품단가</td>
            <td bgcolor='#DDDDDD' width='100'>남은재고</td>
            <td bgcolor='#DDDDDD' width='100'>매출합계</td>
            <td bgcolor='#DDDDDD' width='100'>판매날짜</td>
		  </tr>
");

        $sum_count=0;
        $sum_sales=0;
        $sum_quantity=0;
        while($row = mysqli_fetch_assoc($result)){
?>
	<tr>
		<td style="text-align:center"><?php echo $listcnt; ?></td>
		<td style="text-align:center">
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
		<td style="text-align:center"><?php echo $row['eng_name'];?></td>
		<td style="text-align: center"><?php echo $row['count'];?></td>
		<td style="text-align:center"><?php echo number_format($row['quantity']);?></td>
		<td style="text-align:center"><?php echo number_format($row['out_price']);?></td>
		<td style="text-align:center"><?php echo number_format($row['re_stock']);?></td>
		<td style="text-align:center"><?php echo number_format((int)$row['quantity']*(int)$row['out_price']);?></td>
		<td style="text-align:center"><?php echo date("Y-m-d",strtotime($row['regist_time']));?></td>
	</tr>
<?php
        $listcnt--;
        $sum_count += $row['count'];
        $sum_sales += (int)$row['quantity']*(int)$row['out_price'];
        $sum_quantity += $row['quantity'];
    }
?>
	<tr>
		<td style="text-align:center">매출합계</td>
		<td></td>
		<td></td>
		<td style="text-align: center"><?php echo number_format($sum_count);?></td>
		<td style="text-align:center"><?php echo number_format($sum_quantity);?></td>
		<td></td>
		<td></td>
		<td style="text-align:center"><?php echo number_format($sum_sales);?></td>
		<td></td>
	</tr>
<?php 
mysqli_free_result($result);
    echo(" </TABLE> "); 
?>