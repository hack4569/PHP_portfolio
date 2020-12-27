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

<!-- left_menu -->
<?php include "../layout/left_menu.php";?>
<script type="text/javascript">
	//<![CDATA[
	autoChildMenuOpen($('#lnb > li'),'1'); //]]>
</script>

<div class="manager_rightmenu">
	<div class="main_content">
    		<div class="main_title">
    			<h2>제품목록</h2>
    		</div>
            <?php echo $result;?>
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