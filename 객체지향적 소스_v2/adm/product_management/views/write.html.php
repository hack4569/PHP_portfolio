<div class="layout">
    			<p class="manager_cate_font">상품명(eng)</p>
            	<input type="text" name="eng_name" value="" class="rg_input" id="eng_name">
				<input type="hidden" name="product_code" value="">
			</div>
			<div class="layout">
    			<p class="manager_cate_font">상품명(kor)</p>
            	<input type="text" name="kor_name" value="" class="rg_input" id="kor_name">
			</div>
			<div class="layout">
    			<p class="manager_cate_font">와이너리</p>
            	<input type="text" name="origin" value="" class="rg_input" id="origin">
			</div>
			<div class="layout">
    			<p class="manager_cate_font">국가</p>
            	<input type="text" name="type" value="" class="rg_input" id="type">
			</div>
			<div class="layout">
    			<p class="manager_cate_font">품종</p>
            	<input type="text" name="personality" value="" class="rg_input" id="personality">
			</div>
			<div class="layout">
    			<p class="manager_cate_font">상품이미지</p>
            	<input type="file" id="img_upload" name="image" title="직인사진 파일첨부 : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능">
			</div>
			<div class="layout">
    			<p class="manager_cate_font">재고수량</p>
            	<input type="text" name="stock" value="" class="rg_input1" id="stock">
			</div>
			<div class="layout">
    			<p class="manager_cate_font">입고가</p>
            	<input type="text" name="in_price" value="" class="rg_input1" id="in_price">
			</div>
			<div class="layout">
    			<p class="manager_cate_font">판매가</p>
            	<input type="text" name="out_price" value="" class="rg_input1" id="out_price">
			</div>
			<div class="layout">
                <p class="manager_cate_font">상세설명</p>
                <textarea name="description" id="description" cols="30" rows="20"></textarea>
			</div>
			<div class="btn_wrap rg_btn_wrap">
				<input type="button" id="reg_btn" class="reg_btn img_upload" value="입력하기">
			</div>
			<div class="btn_wrap rg_btn_wrap">
				<a style='display:inline-block; margin-right:10px' class="reg_btn img_upload" href="./index.php?route=list&<?=$addUrl?>">목록</a>
			</div>