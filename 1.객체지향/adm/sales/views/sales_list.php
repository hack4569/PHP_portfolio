<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="author" content="BONHEUR"/>
<meta name="ROBOTS" content="NOINDEX,NOFOLLOW"/>
<meta name="keyword" content="BONHEUR"/>

<title>매출관리 BONHEUR</title>

<?php require ("../../comm/common_resource.php");?>

</head>
<body>
<div class="manager_main_content">
    <div id="manager_leftmenu" class="manager_left_menu">
        <div class="logo">
            <img src="../../images/manager_logo.png">
        </div>
        <ul class="left_sub_menu">
            <!-- left_menu -->
            <?php include "../layout/left_menu.php";?>
            <script type="text/javascript">
                //<![CDATA[
                autoChildMenuOpen($('#lnb > li'),'2'); //]]>
            </script>
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
                            foreach($lists as $list):
        			?>
        			<tr>
        				<td><?php echo $listcnt ?></td>
        				<td>
                            <?php 
                                echo $wine_name[$list['fst_cate']];
                            ?>
        				</td>
        				<td><?php echo $list['eng_name'];?></td>
        				<td style="text-align:center"><?php echo $list['count'];?></td>
        				<td><?php echo number_format($list['quantity']);?></td>
        				<td><?php echo number_format($list['out_price']);?></td>
        				<td><?php echo number_format($list['re_stock']);?></td>
        				<td><?php echo number_format((int)$list['quantity']*(int)$list['out_price']);?></td>
        			</tr>
        			<?php 
        					$listcnt--;
        					$sum_count += $list['count'];
        					$sum_sales += (int)$list['quantity']*(int)$list['out_price'];
        					$sum_quantity += $list['quantity'];
                            endforeach;
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