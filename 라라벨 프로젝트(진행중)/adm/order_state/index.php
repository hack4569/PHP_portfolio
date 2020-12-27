<?php
    include_once  $_SERVER['DOCUMENT_ROOT'] ."/wine/autoloader.php";
    include_once  $_SERVER['DOCUMENT_ROOT'] ."/wine/common.php";

    $sdate = !empty($_REQUEST['sdate'])?trim($_REQUEST['sdate']):date("Y-m-d",time());

    $sales_info = new \Sales_management\Sales_managementDAO($pdo);
    try{
        $listcnt = $sales_info->salesSearchCnt($sdate);

        if($listcnt>0){
            $lists = $sales_info->salesList($sdate);
        }
    }catch(\PDOException $e){
        $result = $e -> getMessage();
    }
    include "./views/state_list.php";
?>