<?php
include_once  $_SERVER['DOCUMENT_ROOT'] ."/wine/common.php";
include $_SERVER['DOCUMENT_ROOT'] ."/wine/dao/Product_managementDAO.php";
// if($_SESSION['userid']!="admin"){
//     Util::alert_redirect("권한이 없습니다.", "../../login.php");
// }
$sfst_cate = isset($_GET['fst_cate'])?trim($_GET['fst_cate']):"";
$ssnd_cate = isset($_GET['snd_cate'])?trim($_GET['snd_cate']):"";
$skey = isset($_GET['skey'])?trim($_GET['skey']):"";
$product_code = isset($_GET['product_code'])?trim($_GET['product_code']):"";

if(!empty($product_code)){
	$product_info = new Product_managementDAO($pdo, "product_info");
	$rows = $product_info->salesPdtDetail($product_code);
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
<div id="manager_rightmenu" class="manager_rightmenu">
<form id="rForm" name="rForm" action="./proc.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="mode" value="update"/>
<input type="hidden" name="sfst_cate" value="<?php echo $sfst_cate;?>"/>
<input type="hidden" name="ssnd_cate" value="<?php echo $ssnd_cate;?>"/>
<input type="hidden" name="skey" value="<?php echo urlencode($skey);?>"/>
	<div class="main_content">
    		<div class="main_title">
    			<h2>상품정보수정</h2>
    		</div>
            <div class="product_list_cate layout">
                <p class="manager_cate_font">
                   	 카테고리
				</p>
                <select name="fst_cate" value="1차 카테고리" class="sfst_cate">
					<option value="snack" <?= "snack"==$sfst_cate ? "selected" : ""?>>간식</option>
                	<option value="cs" <?php if("cs"==$sfst_cate){echo "selected";}else{echo "";}?>>Champagne & Sparkling</option>
                    <option value="sw" <?php if("sw"==$sfst_cate){echo "selected";}else{echo "";}?>>Sweet Wines</option>
                    <option value="ww" <?php if("ww"==$sfst_cate){echo "selected";}else{echo "";}?>>White Wine</option>
                    <option value="rw" <?php if("rw"==$sfst_cate){echo "selected";}else{echo "";}?>>Red Wine</option>
                </select>
                <select name="snd_cate" value="2차 카테고리" class="ssnd_cate">
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
                                if($wine_cate[$key][$i]=="All") continue;
                    ?>
                    			<option value="<?php echo $wine_cate[$key][$i]?>" <?php if($wine_cate[$key][$i]==$ssnd_cate){echo "selected";}else{echo "";}?> >
                    				<?php echo $wine_cate[$key][$i];?>
                    			</option>
                    <?php 
                            }
                    ?>
                    	</optgroup>
                    <?php
                        }
                    ?>
                </select>
            </div>
			<?php foreach($rows as $row) : ?>
			<div class="layout">
    			<p class="manager_cate_font">상품명(eng)</p>
            	<input type="text" name="eng_name" value="<?php echo htmlspecialchars($row['eng_name']);?>" class="rg_input" id="eng_name">
				<input type="hidden" name="product_code" value="<?=$product_code?>">
			</div>
			<div class="layout">
    			<p class="manager_cate_font">상품명(kor)</p>
            	<input type="text" name="kor_name" value="<?php echo htmlspecialchars($row['kor_name']);?>" class="rg_input" id="kor_name">
			</div>
			<div class="layout">
    			<p class="manager_cate_font">와이너리</p>
            	<input type="text" name="origin" value="<?php echo htmlspecialchars($row['origin']);?>" class="rg_input" id="origin">
			</div>
			<div class="layout">
    			<p class="manager_cate_font">국가</p>
            	<input type="text" name="type" value="<?php echo htmlspecialchars($row['type']);?>" class="rg_input" id="type">
			</div>
			<div class="layout">
    			<p class="manager_cate_font">품종</p>
            	<input type="text" name="personality" value="<?php echo htmlspecialchars($row['personality']);?>" class="rg_input" id="personality">
			</div>
			<div class="layout">
    			<p class="manager_cate_font">상품이미지</p>
            	<input type="file" id="img_upload" name="image" title="직인사진 파일첨부 : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능">
				<?php if($row['image']){?>
					<label for="delete_file">체크 시 <input type="checkbox" id="delete_file" name="delete_file" value="<?php echo $row['image'];?> "> <?php echo $row['image'];?> 파일 삭제</label>
					<input type="hidden" name="origin_img" value="<?php echo $row['image']?>">
					<input type="hidden" name="origin_fimg" value="<?php echo $row['fimage']?>">
				<?php }?>
			</div>
			<div class="layout">
    			<p class="manager_cate_font">재고수량</p>
				<?php 
					if(isset($row['initial_stock']) && isset($row['quantity'])){
						$stock = $initStock - $initQtt;
					}
					else{
						$stock = "";
					}
				?>
            	<input type="text" name="stock" value="<?php echo $stock;?>" class="rg_input1" id="stock">
			</div>
			<div class="layout">
    			<p class="manager_cate_font">입고가</p>
            	<input type="text" name="in_price" value="<?php echo htmlspecialchars($row['in_price']);?>" class="rg_input1" id="in_price">
			</div>
			<div class="layout">
    			<p class="manager_cate_font">판매가</p>
            	<input type="text" name="out_price" value="<?php echo htmlspecialchars($row['out_price']);?>" class="rg_input1" id="out_price">
			</div>
			<div class="layout">
                <p class="manager_cate_font">상세설명</p>
                <textarea name="description" id="description" cols="30" rows="20"><?php echo textarea_replace($row['descr']);?></textarea>
			</div>
			<div class="btn_wrap rg_btn_wrap">
				<input type="button" id="reg_btn" class="reg_btn img_upload" value="입력하기">
			</div>
			<div class="btn_wrap rg_btn_wrap">
				<a style='display:inline-block; margin-right:10px' class="reg_btn img_upload" href="./list.php?sfst_cate=<?php echo $sfst_cate;?>&ssnd_cate=<?php echo $ssnd_cate;?>&skey=<?php echo $skey;?>">목록</a>
			</div>
			<?php endforeach;?>
	 	</div>
</form>
</div>
</div>

<script tyle="text/javascript">
//<![CDATA[
$(document).ready(function(){
	// 등록버튼
	$("#reg_btn").click(function(){
		$("#rForm").submit();
	});
});

//]]>
</script>
</body>
</html>