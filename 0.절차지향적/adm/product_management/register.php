<?php
include_once  $_SERVER['DOCUMENT_ROOT'] ."/wine/common.php";

// if($_SESSION['userid']!="admin"){
//     Util::alert_redirect("권한이 없습니다.", "../../login.php");
// }
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
    <input type="hidden" name="mode" value="insert"/>
    	<div class="main_content">
        		<div class="main_title">
        			<h2>상품정보입력</h2>
        		</div>
                <div class="product_list_cate layout">
                    <p class="manager_cate_font">
                       	 카테고리
                    </p>
                    <select name="fst_cate" value="1차 카테고리" class="sfst_cate">
						<option value="snack">간식</option>
                    	<option value="cs" selected>Champagne & Sparkling</option>
                        <option value="sw">Sweet Wines</option>
                        <option value="ww">White Wine</option>
                        <option value="rw">Red Wine</option>
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
                        			<option value="<?php echo $wine_cate[$key][$i]?>"><?php echo $wine_cate[$key][$i];?></option>
                        <?php 
                                }
                        ?>
                        	</optgroup>
                        <?php
                            }
                        ?>
                    </select>
                </div>
    			<div class="layout">
        			<p class="manager_cate_font">상품명(eng)</p>
                	<input type="text" name="eng_name" id="eng_name" class="rg_input">
    			</div>
    			<div class="layout">
        			<p class="manager_cate_font">상품명(kor)</p>
                	<input type="text" name="kor_name" id="kor_name" class="rg_input">
    			</div>
    			<div class="layout">
        			<p class="manager_cate_font">와이너리</p>
                	<input type="text" name="origin" id="origin" class="rg_input">
    			</div>
    			<div class="layout">
        			<p class="manager_cate_font">타입</p>
                	<input type="text" name="type" id="type" class="rg_input">
    			</div>
    			<div class="layout">
        			<p class="manager_cate_font">품종</p>
                	<input type="text" name="personality" id="personality" class="rg_input">
    			</div>
    			<div class="layout">
        			<p class="manager_cate_font">상품이미지</p>
                	<input type="file" id="img_upload" name="image">
    			</div>
    			<div class="layout">
        			<p class="manager_cate_font">재고수량</p>
                	<input type="text" name="stock" id="stock" class="rg_input1" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
    			</div>
    			<div class="layout">
        			<p class="manager_cate_font">입고가</p>
                	<input type="text" name="in_price" class="rg_input1" id="in_price" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
    			</div>
    			<div class="layout">
        			<p class="manager_cate_font">판매가</p>
                	<input type="text" name="out_price" class="rg_input1" id="out_price" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
    			</div>
    			<div class="layout">
                    <p class="manager_cate_font">상세설명</p>
                    <textarea name="description" id="description" cols="30" rows="20"></textarea>
    			</div>
    			<div class="btn_wrap rg_btn_wrap">
    				<input type="button" id="reg_btn" class="reg_btn img_upload" value="입력하기">
    			</div>
        		
    	 	</div>
    </form>
    </div><!-- manager_rightmenu -->
</div><!-- main_content -->	

<script tyle="text/javascript">


//<![CDATA[
$(document).ready(function() {
	
	$("#reg_btn").click(function(){
		var invalid = " "; 
		var f = document.rForm;

		if (f.eng_name.value == "")
    	{
    		alert("상품명(eng)을 입력해주십시오.");
    		f.eng_name.focus();
    		return;
    	}
		if (f.kor_name.value == "")
    	{
    		alert("상품명(kor)을 입력해주십시오.");
    		f.kor_name.focus();
    		return;
    	}

		if (f.origin.value == "")
    	{
    		alert("출생지를 입력해주십시오.");
    		f.origin.focus();
    		return;
    	}

		if (f.type.value == "")
    	{
    		alert("혈액형을 입력해주십시오.");
    		f.type.focus();
    		return;
    	}

		if (f.personality.value == "")
    	{
    		alert("특징을 입력해주십시오.");
    		f.personality.focus();
    		return;
    	}

		if (f.stock.value == "")
    	{
    		alert("재고수량을 입력해주십시오.");
    		f.stock.focus();
    		return;
    	}

		if (f.in_price.value == "")
    	{
    		alert("입고가를 입력해주십시오.");
    		f.in_price.focus();
    		return;
    	}
		if (f.out_price.value == "")
    	{
    		alert("판매가를 입력해주십시오.");
    		f.out_price.focus();
    		return;
    	}
		if (f.description.value == "")
    	{
    		alert("상세설명을 입력해주십시오.");
    		f.description.focus();
    		return;
    	}
		$("#rForm").submit();
		
	});
});
//]]>

</script>
</body>
</html>