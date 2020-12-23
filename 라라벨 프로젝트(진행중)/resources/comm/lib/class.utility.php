<?php

class Util {
	/**
	 * UTF-8 문자열을 EUC-KR 문자열로 변환한다.
	 * @param unknown $input
	 * @return string
	 */
	static function utf8ToEuckr($input) {
		if($input == null) return '';
		return iconv('utf-8', 'euc-kr', $input);
	}
	
	/**
	 * EUC-KR 문자열을 UTF-8 문자열로 변환한다.
	 * @param unknown $input
	 * @return string
	 */
	static function euckrToUtf8($input) {
		if($input == null) return '';
		return iconv('euc-kr', 'utf-8', $input);
	}
	
	/**
	 * CSRF용 토큰을 생성한다.
	 * @return string
	 */

	static function createCSRFToken() {
		return md5(uniqid(rand(), TRUE));
	}
	
	/**
	 * 세션의 CSRF 토큰을 가져온다.
	 * @return string
	 */
	static function getCSRFToken() {
// 		$_SESSION['_CSRF_TOKEN_'] = Util::createCSRFToken();
		return $_SESSION['_CSRF_TOKEN_'];
	}
	
	/**
	 * 세션에 CSRF Token 을 설정한다.
	 */
	static function setCSRFToken() {
		$_SESSION['_CSRF_TOKEN_'] = Util::createCSRFToken();
	}
	
	/**
	 * CSRF 토큰을 체크한다.
	 * @param unknown $token
	 */
	static function checkCSRFToken($token) {
		if(!isset($_SESSION['_CSRF_TOKEN_']) || !$_SESSION['_CSRF_TOKEN_']) {
			return false;
		}
		
		if($_SESSION['_CSRF_TOKEN_'] == $token) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * 에러 메세지를 출력하고 history back 한다.
	 *
	 * @param unknown $msg
	 */
	static function error_back($msg, $back = 1) {
		$msg = str_replace("\"", "&quot;", $msg);
		echo <<<END
<script type="text/javascript">
//<![CDATA[
alert("$msg");
history.go(-$back);
//]]>
</script>
END;
		exit;
	}
	
	static function error_back2($msg, $back) {
		$msg = str_replace("\"", "&quot;", $msg);
		echo <<<END
<script type="text/javascript">
//<![CDATA[
alert("$msg");
history.go(-$back);
//]]>
</script>
END;
		exit;
	}
	
	/**
	 * 전체 html 페이지 생성
	 * @param unknown $msg
	 * @param number $back
	 */
	static function error_back_html($msg, $back = 1) {
		$msg = str_replace("\"", "&quot;", $msg);
		echo <<<END
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>ERROR</title>
<script type="text/javascript">
//<![CDATA[
alert("$msg");
history.go(-$back);
//]]>
</script>
</head>
<body>
</body>
</html>
END;
		exit;
	}
	
	/**
	 * 메세지만 출력
	 * @param unknown $msg
	 */
	static function alert($msg) {
		$msg = str_replace("\"", "&quot;", $msg);
		echo <<<END
<script type="text/javascript">
//<![CDATA[
alert("$msg");
//]]>
</script>
END;
		  exit;
	}
	
	/**
	 * 메세지 팝업후 리다이렉트 한다.
	 * @param unknown $msg
	 * @param unknown $url
	 */
	static function alert_redirect($msg, $url, $script='') {
		$msg = str_replace("\"", "&quot;", $msg);
		echo <<<END
<script type="text/javascript">
//<![CDATA[
alert('$msg');
$script
document.location.href = "$url";
//]]>
</script>
END;
		exit;
	}
	
	/**
	 * 전체 페이지 구조를 가진다.
	 * @param unknown $msg
	 * @param unknown $url
	 * @param string $script
	 */
	static function alert_redirect_html($msg, $url, $script='') {
		$msg = str_replace("\"", "&quot;", $msg);
		echo <<<END
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>REDIRECT</title>
<script type="text/javascript">
//<![CDATA[
alert("$msg");
$script
window.location.href = "$url";
//]]>
</script>
</head>
<body>
</body>
</html>
END;
		exit;
	}
	
	static function alert_close($msg, $script = '') {
		$msg = str_replace("\"", "&quot;", $msg);
		echo <<<END
<script type="text/javascript">
//<![CDATA[
alert("$msg");
$script
self.close();
//]]>
</script>
END;
		exit;
	}
	
	
	/**
	 * 메세지 팝업후 부모창을 새로고침한다.
	 * @param unknown $msg
	 */
	static function alert_close_parent($msg) {
		$msg = str_replace("\"", "&quot;", $msg);
		echo <<<END
<script type="text/javascript">
//<![CDATA[
alert("$msg");
if(window.opener && !window.opener.closed){
        opener.parent.window.location.reload();
}
self.close();
//]]>
</script>
END;
		exit;
	}
	
	/**
	 * URL 이동
	 * @param unknown $url
	 */
	static function gotoUrl($url) {
		$url = str_replace ( "&amp;", "&", $url );
		$url = str_ireplace(array("%0D%0A", "%0D", "%0A"),'',$url);
		$url = str_replace(array("\r\n", "\r", "\n"),'',$url);
		$url = str_ireplace("trinitysoftinjected",'',$url);
		if (! headers_sent ()) {
			header ( 'Location: ' . $url );
		} else {
			echo '<script>';
			echo "document.location.href = '".$url."'";
			echo '</script>';
		}
		exit ();
	}
	
	/**
	 * 알파벳,숫자,_ 이외의 문자를 필터링
	 * @param string $input
	 * @return string|mixed
	 */
	static function onlyAlphaNumUnderbar($input) {
		if($input === null || $input == '') return '';
		
		$input = preg_replace('/[^a-z0-9_]/i', '', trim($input));
		
		return $input;
	}
	
	/**
	 * 알파벳,숫자 이외의 문자를 필터링
	 * @param string $input
	 * @return string|mixed
	 */
	static function onlyAlphaNum($input) {
		if($input === null || $input == '') return '';
		
		$input = preg_replace('/[^a-z0-9]/i', '', trim($input));
		
		return $input;
	}
	/**
	 * 에러 페이지로 리다이렉트 한다.
	 */
	static function redirectErrorPage() {
		global $settings;
		header("location: ".$settings['error_page']);
		exit;
	}
	
}
?>