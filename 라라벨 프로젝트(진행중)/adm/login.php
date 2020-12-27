<?php
include_once  $_SERVER['DOCUMENT_ROOT'] ."/wine/common.php";

// if($_SESSION['userid']=="admin"){
//     header("Location: ./management_product/index.php");
// }
//2020-12-06
//index.php에서 검증해준다
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="author" content="BONHEUR"/>
<meta name="ROBOTS" content="NOINDEX,NOFOLLOW"/>
<meta name="keyword" content="BONHEUR"/>
<title>BONHEUR</title>
<?php require ($_SERVER['DOCUMENT_ROOT'] ."/wine/comm/common_resource.php");?>

</head>
<body>
	<form id = "loginForm" name="loginForm" action="./login_proc.php" method="post" onsubmit="return checkForm(this);" >
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
</body>
</html>