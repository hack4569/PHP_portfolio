<?php

include_once  $_SERVER['DOCUMENT_ROOT'] ."/wine/common.php";

//리턴 페이지
$ret_url = $http_url."/login.php";
$encpasswd = hash('sha256', $password.$userid);
$userid = trim($_POST['userid']);
$password = trim($_POST['password']);

if(!$userid || !$password){
    Util::alert_redirect("아이디나 비밀번호가 공백이면 안됩니다.", "./login.php");
}

$login = new \Login\Authentication('userid','manager',$userid);
$login->login();
// if($userid=='admin'){
//     $query_cnt = "select count(*) as cnt from manager where id = :userid";
//     $query = "select id, password from manager where id = :userid";
// }else{
//     Util::alert_redirect("아이디를 잘못입력하셨습니다.","./login.php");
// }

// $stmt = $pdo->prepare($query_cnt);
// $stmt->bindValue(':userid',$userid);
// $stmt->execute();
// $rowcnt = $stmt->fetchColumn();

// $stmt = $pdo->prepare($query);
// $stmt->bindValue(':userid',$userid);
// $stmt->execute();
// $row = $stmt -> fetch();

// if($rowcnt > 0){
//     if($row["password"] != $encpasswd){
//         Util::alert_redirect("비밀번호를 잘못 입력하였습니다.", "./login.php");
//     }
//     else if($row["password"] == $encpasswd){ //관리자의 경우 무조건 관리자/비밀번호.
//         $_SESSION["userid"] = $row["id"];
//         $_SESSION["auth"] = "admin";
//     }
    
// }else{
//     Util::alert_redirect("아이디를 잘못입력하셨습니다.", "./login.php");
// }


// Util::gotoUrl("./product_management/index.php");
?>