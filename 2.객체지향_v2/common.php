<?php
/*******************************************************************************
 ** 공통 변수, 상수, 코드
 *******************************************************************************/
//==============================================================================
//에러 레포팅
//------------------------------------------------------------------------------
error_reporting(E_ALL ^ E_NOTICE);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING );

//==============================================================================
// 보안설정이나 프레임이 달라도 쿠키가 통하도록 설정
//------------------------------------------------------------------------------
// header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
// header('P3P: CP="NOI CURa ADMa DEVa TAIa OUR DELa BUS IND PHY ONL UNI COM NAV INT DEM PRE"');
header('P3P: CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');

//==============================================================================
// 개별페이지 접근불가
//------------------------------------------------------------------------------
    
    define('_BONHEUR_', true); 

//$http_url = 'http://localhost:20510/wine';
// 운영서버 올릴 때
//$http_url = 'http://geum2111.cafe24.com/wine';
$http_url = 'http://localhost:2121/wine/';
//==============================================================================
// 타임존
//------------------------------------------------------------------------------
date_default_timezone_set("Asia/Seoul");

//==============================================================================
// 유틸리티
//------------------------------------------------------------------------------

require_once($_SERVER['DOCUMENT_ROOT'].'/wine/comm/lib/class.utility.php');

//==============================================================================
// 공통함수
//------------------------------------------------------------------------------
include_once $_SERVER['DOCUMENT_ROOT']."/wine/comm/lib/public.php";

//==============================================================================
// 공통함수
//------------------------------------------------------------------------------
include_once $_SERVER['DOCUMENT_ROOT']."/wine/comm/global_variables.php"; 
//==============================================================================
// extract
//------------------------------------------------------------------------------
// extract($_GET, EXTR_SKIP);
// extract($_POST, EXTR_SKIP);

//==============================================================================
// DB연결
//------------------------------------------------------------------------------
include_once $_SERVER['DOCUMENT_ROOT']."/wine/comm/dbconfig.php";

//==============================================================================
// SESSION 설정
//------------------------------------------------------------------------------
@ini_set("session.use_trans_sid", 0);    // PHPSESSID를 자동으로 넘기지 않음
@ini_set("url_rewriter.tags",""); // 링크에 PHPSESSID가 따라다니는것을 무력화함 (해뜰녘님께서 알려주셨습니다.)


ini_set("session.gc_probability", 1); // session.gc_probability는 session.gc_divisor와 연계하여 gc(쓰레기 수거) 루틴의 시작 확률을 관리합니다. 기본값은 1입니다. 자세한 내용은 session.gc_divisor를 참고하십시오.
ini_set("session.gc_divisor", 100); // session.gc_divisor는 session.gc_probability와 결합하여 각 세션 초기화 시에 gc(쓰레기 수거) 프로세스를 시작할 확률을 정의합니다. 확률은 gc_probability/gc_divisor를 사용하여 계산합니다. 즉, 1/100은 각 요청시에 GC 프로세스를 시작할 확률이 1%입니다. session.gc_divisor의 기본값은 100입니다.
	
session_set_cookie_params(0, '/');
	
@session_start();
	
// ==============================================================================
// 로그인 세션 체크 define("_PUBLIC_SESSION_", true);
// ------------------------------------------------------------------------------

// if (!defined('_PUBLIC_SESSION_')) {
// 	if (!isset($_SESSION['edu_userid']) || $_SESSION['edu_userid'] == '') {
// 		session_unset();
// 		session_destroy();
// 		header("location:".$http_url."/member/login.php");
// 		exit;
// 	}
// }

header("Content-Type: text/html; charset=UTF-8");
?>