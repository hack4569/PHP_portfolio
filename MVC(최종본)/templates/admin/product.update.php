<?php
    extract($product_item);
?>
<form id="rForm" name="rForm" action="/wine/adm/product_management/update?<?=$addUrl?>" method="post" enctype="multipart/form-data">
<div class="product_list_cate layout">
                <p class="manager_cate_font">
                   	 카테고리
				</p>
                <select name="fst_cate" value="1차 카테고리" class="sfst_cate">
                    <?php foreach($wine_name as $key =>$value):?>
					<option value="<?=$key?>" <?= ($key==$fst_cate) ? "selected" : ""?>><?=$value?></option>
                    <?php endforeach;?>
                </select>
                <select name="snd_cate" value="2차 카테고리" class="ssnd_cate">
                    <?php 
                        foreach($wine_cate as $key => $value){
                    ?>
                    	<optgroup label="<?=$wine_name[$key];?>">
                    <?php 
                            for($i=0; $i<count($wine_cate[$key]); $i++){
                                if($wine_cate[$key][$i]=="All") continue;
                    ?>
                    			<option value="<?php echo $wine_cate[$key][$i]?>" <?php if($wine_cate[$key][$i]==$snd_cate){echo "selected";}else{echo "";}?> >
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
			
			<div class="layout">
    			<p class="manager_cate_font">상품명(eng)</p>
            	<input type="text" name="eng_name" value="<?php echo htmlspecialchars($eng_name);?>" class="rg_input" id="eng_name">
				<input type="hidden" name="product_code" value="<?=$product_code?>">
			</div>
			<div class="layout">
    			<p class="manager_cate_font">상품명(kor)</p>
            	<input type="text" name="kor_name" value="<?php echo htmlspecialchars($kor_name);?>" class="rg_input" id="kor_name">
			</div>
			<div class="layout">
    			<p class="manager_cate_font">와이너리</p>
            	<input type="text" name="origin" value="<?php echo htmlspecialchars($origin);?>" class="rg_input" id="origin">
			</div>
			<div class="layout">
    			<p class="manager_cate_font">국가</p>
            	<input type="text" name="type" value="<?php echo htmlspecialchars($type);?>" class="rg_input" id="type">
			</div>
			<div class="layout">
    			<p class="manager_cate_font">품종</p>
            	<input type="text" name="personality" value="<?php echo htmlspecialchars($personality);?>" class="rg_input" id="personality">
			</div>
			<div class="layout">
    			<p class="manager_cate_font">상품이미지</p>
            	<input type="file" id="img_upload" name="image" title="직인사진 파일첨부 : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능">
				<?php if($image){?>
					<label for="delete_file">체크 시 <input type="checkbox" id="delete_file" name="delete_file" value="<?php echo $image;?> "> <?php echo image;?> 파일 삭제</label>
					<input type="hidden" name="origin_img" value="<?php echo $image?>">
					<input type="hidden" name="origin_fimg" value="<?php echo $fimage?>">
				<?php }?>
			</div>
			<div class="layout">
    			<p class="manager_cate_font">재고수량</p>
				<?php 
					if(!empty($initial_stock) || !empty($quantity)){
						$stock = $initial_stock - $quantity;
					}
					else{
						$stock = 0;
					}
				?>
            	<input type="text" name="stock" value="<?php echo $stock;?>" class="rg_input1" id="stock">
			</div>
			<div class="layout">
    			<p class="manager_cate_font">입고가</p>
            	<input type="text" name="in_price" value="<?php echo htmlspecialchars($in_price);?>" class="rg_input1" id="in_price">
			</div>
			<div class="layout">
    			<p class="manager_cate_font">판매가</p>
            	<input type="text" name="out_price" value="<?php echo htmlspecialchars($out_price);?>" class="rg_input1" id="out_price">
			</div>
			<div class="layout">
                <p class="manager_cate_font">상세설명</p>
                <textarea name="description" id="description" cols="30" rows="20"><?php echo textarea_replace($descr);?></textarea>
			</div>
			<div class="btn_wrap rg_btn_wrap">
				<input type="button" id="reg_btn" class="reg_btn img_upload" value="입력하기">
			</div>
			<div class="btn_wrap rg_btn_wrap">
				<a style='display:inline-block; margin-right:10px' class="reg_btn img_upload" href="/wine/adm/product_management/list?<?=$addUrl?>">목록</a>
			</div>
</form>
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