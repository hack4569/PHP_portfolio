<form id = "loginForm" name="loginForm" action="/wine/adm/login" method="post" onsubmit="return checkForm(this);" >
        <div class="login">
            <div class="main_logo">
            	<img src="../images/main_logo.png">
            </div>
            <div class="login_box">
                <span>ID </span><input type="text" name="userid" class="userid"><br>
                <span>PW </span><input type="password" name="password" class="password">
                <input type="submit" class="enter" value="로그인">	
            </div>
        </div>
	</form>
<script type="text/javascript">
//<![CDATA[
function checkForm(frm){
	var userid = document.loginForm.userid.value;
	var password = document.loginForm.password.value;
	if(userid == ""){
		alert("아이디을 입력해주십시오");
		return false;
	}
	if(password == ""){
		alert("비밀번호를 입력해주십시오.");
		return false;			
	}
	var blank_pattern = /[\s]/g;
	if( blank_pattern.test(userid) == true){
	    alert("공백은 사용할 수 없습니다.");
	    return false;
	}
	if( blank_pattern.test(password) == true){
	    alert("공백은 사용할 수 없습니다.");
	    return false;
	} 
	return true;
}

//]]>
</script>