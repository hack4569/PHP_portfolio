<?php
include_once  $_SERVER['DOCUMENT_ROOT'] ."/wine/common.php";

// if($_SESSION['userid']!="admin"){
//     Util::alert_redirect("권한이 없습니다.", "../../login.php");
// }

$sfst_cate = isset($_GET['sfst_cate'])?trim($_GET['sfst_cate']):"";
$ssnd_cate = isset($_GET['ssnd_cate'])?trim($_GET['ssnd_cate']):"";
if($ssnd_cate=="All"){ $ssnd_cate="";}
$skey = isset($_GET['skey'])?trim($_GET['skey']):"";

$addquery = "";
if($sfst_cate){ 
    $addquery .= " and a.fst_cate like concat(concat('%', '".$sfst_cate."'),'%') ";
}
if($ssnd_cate){
    $addquery .= " and a.snd_cate like concat(concat('%', '".$ssnd_cate."'),'%') ";
}
if($skey){
    $addquery .= " and a.eng_name like concat(concat('%', '".$skey."'),'%') ";
}
//리스트 카운트 조회
$query = "
	select count(*) as cnt
	from product_info a
		left outer join sales_info b
		on a.eng_name = b.eng_name
	where b.isnew = 'new' $addquery
    ";

 $result = mysqli_query($db_conn, $query);
 $row = mysqli_fetch_assoc($result);
 $listcnt =  $row['cnt'];

//리스트 조회
 $query = "
	select *
	from  product_info a
		left outer join sales_info b
		on a.eng_name = b.eng_name
	where b.isnew='new' $addquery order by a.eng_name
    ";

 $result = mysqli_query($db_conn, $query);

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="author" content="BONHEUR"/>
<meta name="ROBOTS" content="NOINDEX,NOFOLLOW"/>
<meta name="keyword" content="BONHEUR"/>

<title>상품관리 BONHEUR</title>

<?php require ("../../comm/common_resource.php");?>

</head>
<body>
<div class="manager_main_content">

<div id="manager_leftmenu" class="manager_left_menu">
    <div class="logo">
        <img src="../../images/manager_logo.png">
    </div>
    <ul class="left_sub_menu">
        <li class="active_menu"><a href="<?php echo $http_url?>/adm/product_management/list.php">제품관리</a></li>
        <li><a href="<?php echo $http_url?>/adm/sales/sales_day.php">매출현황</a></li>
		<li><a href="<?php echo $http_url?>/adm/sales/sales_state.php">주문현황</a></li>
    </ul>
</div>
<div class="manager_rightmenu">

	<div class="main_content">
    		<div class="main_title">
    			<h2>제품목록</h2>
    		</div>
            <div class="layout1"><a href="./register.php" class="btn_add">제품 추가</a></div>
            <div class="product_list_cate">
            	<form name="rForm" id="rForm" method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
            	
                    <p class="manager_cate_font">
                       	 카테고리
					</p>
                    <select name="sfst_cate" value="1차 카테고리" class="sfst_cate">
						<option value="snack" <?php if($sfst_cate=="snack"){ echo "selected";}?>>간식</option>
                    	<option value="cs" <?php if($sfst_cate=="cs"){ echo "selected";}?>>Champagne & Sparkling</option>
                        <option value="sw" <?php if($sfst_cate=="sw"){echo "selected";}?>>Sweet Wines</option>
						<option value="ww" <?php if($sfst_cate=="ww"){echo "selected";}?>>White Wine</option>
                        <option value="rw" <?php if($sfst_cate=="rw"){echo "selected";}?>>Red Wine</option>
                    </select>
                    <select name="ssnd_cate" value="2차 카테고리" class="ssnd_cate">
						<?php
                            foreach($wine_cate as $key => $value){
                        ?>
                        	<optgroup label="
                        	<?php 
                        	   switch ($key){
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
                        	">
						<?php 
								
                                for($i=0; $i<count($wine_cate[$key]); $i++){
                        ?>
                        			<option value="<?php echo $wine_cate[$key][$i]?>" <?php if($wine_cate[$key][$i]==$ssnd_cate){echo "selected";}?> > <?php echo $wine_cate[$key][$i];?></option>
                        <?php 
                                }
                        ?>
                        	</optgroup>
                        <?php
                            }
                        ?>
                    </select>
                    <div class="product_list_keyword">
                        <p class="manager_cate_font">
                            	상품검색
                        </p>
                        <input type="text" name="skey" value="<?php echo $skey?>" class="skey">
                        <div class="skey_submit" id="skey_submit">
                            <img src="../../images/Search.png" alt="">
                        </div>
                    </div>
                </form>
            </div>
            
			<form action="./proc.php" name="delForm" id="delForm" method="post">
			<input type="hidden" name="sfst_cate" value="<?php echo $sfst_cate;?>">
			<input type="hidden" name="ssnd_cate" value="<?php echo $ssnd_cate;?>">
			<input type="hidden" name="skey" value="<?php echo $skey;?>">
			<input type="hidden" name="mode" value="seldel">
        		<div class="productlist_content">
                <table summary="진행현황목록표" class="table_list">
                    <caption>진행현황 목록표</caption>
                    <colgroup>
                        <col width="6%"/>
                        <col width="8%"/>
                        <col width="14%"/>
                        <col width="*"/>
                        <col width="11%"/>
                        <col width="11%"/>
                        <col width="11%"/>
                        <col width="10%"/>
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col"><input type="checkbox" name="allchk" onclick="if (this.checked) all_check(true); else all_check(false);" id="checkAll" value="전체선택" title="전체선택"/></th>
                            <th scope="col">NO</th>
                            <th scope="col">카테고리</th>
                            <th scope="col">상품명</th>
                            <th scope="col">수량</th>
                            <th scope="col">입고가</th>
                            <th scope="col">판매가</th>
                            <th scope="col"></th>
                        </tr>
                        
                    </thead>
                    <tbody>
                        	<?php if($listcnt == 0){?>
                				<tr>
                					<td colspan="<?php echo "8";?>">자료가 없습니다.</td>
                				</tr>
                			<?php 
                                }else{
                                    while($row = mysqli_fetch_assoc($result)){
                			?>
                			<tr>
                				<td><input type="checkbox" name="selectdel[]" value="<?php echo $row['eng_name']; ?>" title="선택"/></td>
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
                				<td style="padding-left:30px"><?php echo $row['eng_name']; ?></td>
                				<td><?php echo $row['initial_stock']-$row['quantity'];?></td>
                				<td><?php echo $row['in_price'];?></td>
                				<td><?php echo $row['out_price'];?></td>
                				<td>
                					<a href="./update.php?fst_cate=<?php echo $row['fst_cate'];?>&snd_cate=<?php echo $row['snd_cate'];?>&skey=<?php echo $skey;?>&eng_name=<?php echo htmlspecialchars($row['eng_name']);?>" name="btn_modify"  class="btn_modify" id="btn_modify">수정</a>
                				</td>
                			</tr>
                			<?php 
                					$listcnt--;
                                    }
                				}
                				mysqli_free_result($result);
                			 ?>
                    </tbody>
                </table>
        			<div class="btn_wrap">
        				<button id="btn_seldel" class="btn_del">삭제</button>
        			</div>
        	 	</div><!-- productlist_content -->
    	 	</form>
        </div>
    </div>
</div>

<script>
//<![CDATA[
$(document).ready(function(){
	// 등록버튼
	$("#skey_submit").click(function(){
		$("#rForm").submit();
	});

	//선택삭제버튼
	$("#btn_seldel").click(function(){
		var chk_count = 0;
		var msg = "";

		var f = document.forms.delForm;
		for (var i=0; i<f.length; i++) {
			if (f.elements[i].name == "selectdel[]" && f.elements[i].checked)
				chk_count++;
		}

		if(!chk_count){
			alert("삭제하려는 상품을 한개 이상 선택하세요.");
			return false;
		}

		var msg = "선택한 상품을 삭제하시겠습니까?\n삭제 후에는 복구할 수 없습니다." 
		if(confirm(msg)) {
			$("#delForm").submit();
		}	
	});
});
//전체선택
function all_check(val){
    var f = document.forms.delForm;
    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "selectdel[]")
            f.elements[i].checked = val;
    }
}
//]]>
</script>
</body>
</html>