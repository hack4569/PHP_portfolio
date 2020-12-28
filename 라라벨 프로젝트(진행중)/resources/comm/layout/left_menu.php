<?php
if(!defined('_BONHEUR_')) exit; // 개별 페이지 접근 불가
?>
	<div id="leftmenu" class="left_menu">

		<ul>
			<li><a href="<?php echo $http_url?>/product/product_list.php?fst_cate=snack">간식</a>&nbsp; &nbsp; |&nbsp; &nbsp;<a href="<?php echo $http_url?>/product/product_list.php?fst_cate=cs">Champagne & Sparkling</a>&nbsp; &nbsp; |&nbsp; &nbsp; <a href="<?php echo $http_url?>/product/product_list.php?fst_cate=sw">Sweet Wines</a>&nbsp; &nbsp; |&nbsp; &nbsp; <a href="<?php echo $http_url?>/product/product_list.php?fst_cate=ww">White Wine</a>&nbsp; &nbsp; |&nbsp; &nbsp; <a href="<?php echo $http_url?>/product/product_list.php?fst_cate=rw">Red Wine</a>
			</li>
		</ul>


	</div>
	
	<div class="clear"></div>	
		
	<div class="search_box">
		<form name="skeyForm" action="<?php echo $http_url?>/product/product_list.php" method="get">
			<p class="searchTxt">Search&nbsp;&nbsp;</p>
			<input type="text" name="skey" class="skey" id="skey">
			<div class="skey_submit" id="skey_submit">
                <img src="../images/Search.png" alt="와인검색">
            </div>
		</form>
	</div>
	
	<script type="text/javascript">
    	$(document).ready(function(){
			var f = document.skeyForm;
			
			$("#skey_submit").click(function(){
				if($("#skey").val()==""){
					alert("키워드를 입력해주세요");
					return false;
				}
				f.submit();
			});
			//검색 시 enter치면 검색되도록
			$("#skey").keydown(function(key){
				if(key.keyCode == 13){
					if($("#skey").val()==""){
						alert("키워드를 입력해주세요");
						return false;
					}
					$("#skeyForm").submit();
		        }
			});
        });
    </script>
		