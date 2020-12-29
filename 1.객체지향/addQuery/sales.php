<?php
    $sdate = empty($_REQUEST['sdate'])?$_REQUEST['sdate']:date("Y-m-d", time());
    
    $addUrl = "sdate=$sdate";
?>