<?php
include_once  $_SERVER['DOCUMENT_ROOT'] ."/wine/common.php";

// if($_SESSION['userid']!="admin"){
//     Util::alert_redirect("권한이 없습니다.", "../login.php");
// }

$num = isset($_GET['num'])?trim($_GET['num']):"";
$eng_name = isset($_GET['eng_name'])?trim($_GET['eng_name']):"";
$eng_name = str_replace("'","\'",$_GET['eng_name']);
$order = isset($_GET['order'])?trim($_GET['order']):"";
$quantity = isset($_GET['quantity'])?trim($_GET['quantity']):"";
$redirect_url="/adm/sales/sales_state.php";
if(!isset($order)){
    Util::error_back("잘못된 요청입니다.");
}

//현재 매출정보 가져오기
$now_query = "select key_id, quantity, count, regist_time from sales_info where eng_name='$eng_name' order by regist_time desc limit 0,1";

$now_result = mysqli_query($db_conn, $now_query);
$now_row = mysqli_fetch_assoc($now_result);

if($order=="cancle"){
    $query = "delete from sales_state where eng_name='$eng_name' and num='$num'" ;
    mysqli_query($db_conn, $query);
    util::alert_redirect("주문이 취소되었습니다.", $http_url.$redirect_url);
    mysqli_close($db_conn);
}else if($order=="order"){
    $query = "update sales_info set count=".(((int)$now_row['count'])+1).", quantity=".((int)$now_row['quantity']+(int)$quantity)." where eng_name='$eng_name' and key_id='".$now_row['key_id']."'";
    mysqli_query($db_conn, $query);
    
    $query = "delete from sales_state where eng_name='$eng_name' and num='$num'" ;
    mysqli_query($db_conn, $query);
    util::alert_redirect("주문을 완료하었습니다.", $http_url.$redirect_url);
    mysqli_close($db_conn);
}else if($order=="refund"){
    $query = "update sales_info set count=".(((int)$now_row['count'])-1).", quantity=".((int)$now_row['quantity']-(int)$quantity)." where eng_name='$eng_name' and key_id='".$now_row['key_id']."'" ;
    mysqli_query($db_conn, $query);
    $query = "delete from sales_state where eng_name='$eng_name' and num='$num'" ;
    mysqli_query($db_conn, $query);
    util::alert_redirect("환불되었습니다.", $http_url.$redirect_url);
    mysqli_close($db_conn);
}
?>