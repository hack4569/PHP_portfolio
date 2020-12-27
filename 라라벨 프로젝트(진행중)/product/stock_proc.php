<?php
include_once  $_SERVER['DOCUMENT_ROOT'] ."/wine/common.php";

// if($_SESSION['userid']!="admin"){
//     Util::alert_redirect("권한이 없습니다.", "../login.php");
// }

$fst_cate = isset($_POST['fst_cate'])?trim($_POST['fst_cate']):"";
$snd_cate = isset($_POST['snd_cate'])?trim($_POST['snd_cate']):"";
$skey = isset($_POST['skey'])?trim($_POST['skey']):"";
$eng_name = isset($_POST['eng_name'])?trim($_POST['eng_name']):"";

$order = isset($_POST['order'])?trim($_POST['order']):"";
$quantity = isset($_POST['quantity'])?trim($_POST['quantity']):"";
$redirect_url="/product/product_list.php?fst_cate=$fst_cate&snd_cate=$snd_cate&skey=$skey";
if(!isset($order)){
    Util::error_back("잘못된 요청입니다.");
}

if($order == "order" || $order=="cancle") {
    
    //지난 매출정보 가져오기
    $past_query = "select key_id, regist_time, (initial_stock-quantity) as re_stock from sales_info where eng_name = '$eng_name' order by regist_time desc limit 0,1";
    $past_result = mysqli_query($db_conn, $past_query);
    $past_row = mysqli_fetch_assoc($past_result);
    $now = date("Ymd",time());
    
    
    
    if(date("Ymd",strtotime($past_row['regist_time']))!=date("Ymd",time())){
        //지난 매출 상태 업데이트
        $past_keyId = $past_row['key_id'];
        $dnew_query ="update sales_info set isnew ='' where eng_name = '$eng_name' and key_id='$past_keyId' and isnew='new'";
        mysqli_query($db_conn, $dnew_query);
        $query = "
    		insert into sales_info
                ( eng_name,
                  quantity,
                  count,
                  initial_stock,
                  regist_time,
                  isnew
                )
    		values('".$eng_name."','0','0','".$past_row['re_stock']."',now(),'new')
    	";
        mysqli_query($db_conn, $query);
    }
    
    //현재 매출정보 가져오기
    $now_query = "select key_id, quantity, count, regist_time from sales_info where eng_name='$eng_name' order by regist_time desc limit 0,1";
    $now_result = mysqli_query($db_conn, $now_query);
    $now_row = mysqli_fetch_assoc($now_result);

}


if($order=="cancle"){
    $query = "update sales_info set count=".(((int)$now_row['count'])-1).", quantity=".((int)$now_row['quantity']-(int)$quantity)." where eng_name='$eng_name' and key_id='".$now_row['key_id']."'" ;
    mysqli_query($db_conn, $query);
    util::alert_redirect("주문이 취소되었습니다.", $http_url.$redirect_url);
    mysqli_close($db_conn);
}else if($order=="order"){
    // $query = "update sales_info set count=".(((int)$now_row['count'])+1).", quantity=".((int)$now_row['quantity']+(int)$quantity)." where eng_name='$eng_name' and key_id='".$now_row['key_id']."'";
    $query = "insert into sales_state ( eng_name, fst_cate, quantity, regist_datetime ) values('".$eng_name."','".$fst_cate."','".$quantity."',now())";
    mysqli_query($db_conn, $query);
    util::alert_redirect("주문을 완료하었습니다.", $http_url.$redirect_url);
    mysqli_close($db_conn);
}
?>