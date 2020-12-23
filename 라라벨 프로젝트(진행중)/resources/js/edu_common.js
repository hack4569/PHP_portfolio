//관리자 - 자기정보 수정
function openMyInfoModifyPopup(csrf){
	var url = "/member/myinfo_modify_form.php?CSRF_TOKEN="+csrf;
	var win = window.open(url, "MyInfoModify", "width=1015,height=660,scrollbars=no,resizable=yes");
	win.focus();
}

//푸터 - family사이트이동
function openFamilyWin(select_id) {
	var selectObj = document.getElementById(select_id);
	var ObjUrl = "";
	if(selectObj){
		ObjUrl = selectObj.value;
		if(ObjUrl!=""){
			window.open(ObjUrl, "openFamilyWin", "");
		}
	}
}