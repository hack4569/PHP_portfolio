<?php
include_once  $_SERVER['DOCUMENT_ROOT'] ."/wine/common.php";
//include $_SERVER['DOCUMENT_ROOT'] ."/wine/dao/product_management.php"; v1
include $_SERVER['DOCUMENT_ROOT'] ."/wine/dao/Product_managementDAO.php"; //v2 클래스, 생성자생성(메소드 매개변수x)

// if($_SESSION['userid']!="admin"){
//     Util::alert_redirect("권한이 없습니다.", "../../login.php");
// }

// 첨부파일 최대 갯수

function utf2euc($str) { return iconv("UTF-8","cp949//IGNORE", $str); }

$mode = isset($_POST['mode'])?trim($_POST['mode']):"";
$sfst_cate = isset($_POST['sfst_cate'])?trim($_POST['sfst_cate']):"";
$ssnd_cate = isset($_POST['ssnd_cate'])?trim($_POST['ssnd_cate']):"";
$skey = isset($_POST['skey'])?$_POST['skey']:"";
$redirect_url="/adm/product_management/list.php?sfst_cate=$sfst_cate&ssnd_cate=$ssnd_cate&skey=$skey";

// file
$SavePath = $_SERVER["DOCUMENT_ROOT"] . "/wine/data/file/";		// 첨부파일 저장경로
if($mode=="insert" || $mode=="update"){
    $salesPrdArr = array();
    
    $salesPrdArr['kor_name'] = empty($_POST['kor_name'])?Util::error_back("한글 상품명이 없습니다."):trim($_POST['kor_name']);
    $salesPrdArr['eng_name'] = empty($_POST['eng_name'])?Util::error_back("영문 상품명이 없습니다."):trim($_POST['eng_name']);
    $salesPrdArr['fst_cate'] = empty($_POST['fst_cate'])?Util::error_back("1차 카테고리를 선택하지 않았습니다."):trim($_POST['fst_cate']);
    $salesPrdArr['snd_cate'] = empty($_POST['snd_cate'])?Util::error_back("2차 카테고리를 선택하지 않았습니다."):trim($_POST['snd_cate']);
    $salesPrdArr['origin'] = empty($_POST['origin'])?Util::error_back("원산지를 입력해주세요"):trim($_POST['origin']);
    $salesPrdArr['in_price'] = empty($_POST['in_price'])?Util::error_back("입고가를 입력해주세요"):trim($_POST['in_price']);
    $salesPrdArr['out_price'] = empty($_POST['out_price'])?Util::error_back("출고가를 입력해주세요"):trim($_POST['out_price']);
    $salesPrdArr['type'] = empty($_POST['type'])?Util::error_back("혈액형을 입력해주세요"):trim($_POST['type']);
    $salesPrdArr['personality'] = empty($_POST['personality'])?Util::error_back("특징을 입력해주세요."):trim($_POST['personality']);
    empty($_POST['description']) ? "" : $salesPrdArr['descr'] = $_POST['description'];
    $prdStockArr['stock'] = empty($_POST['stock'])?Util::error_back("재고를 입력해주세요."):trim($_POST['stock']);

    $product_info = new Product_managementDAO($pdo, 'product_info');
    //생성자를 아래처럼 작성하면 발생하는 일
    // $product_info = new Product_managementDAO($pdo, $salesPrdArr, $prdStockArr);
    // $salesPrdArr['product_code'] = $product_info -> cntSalesPdt()+1;
    // $product_info = new Product_managementDAO($pdo, $salesPrdArr, $prdStockArr);

    // $kor_name = empty($_POST['kor_name'])?Util::error_back("한글 상품명이 없습니다."):trim($_POST['kor_name']);
    // $eng_name = empty($_POST['eng_name'])?Util::error_back("영문 상품명이 없습니다."):trim($_POST['eng_name']);
    // $fst_cate = empty($_POST['fst_cate'])?Util::error_back("1차 카테고리를 선택하지 않았습니다."):trim($_POST['fst_cate']);
    // $snd_cate = empty($_POST['snd_cate'])?Util::error_back("2차 카테고리를 선택하지 않았습니다."):trim($_POST['snd_cate']);
    // $origin = empty($_POST['origin'])?Util::error_back("원산지를 입력해주세요"):trim($_POST['origin']);
    // $in_price = empty($_POST['in_price'])?Util::error_back("입고가를 입력해주세요"):trim($_POST['in_price']);
    // $out_price = empty($_POST['out_price'])?Util::error_back("출고가를 입력해주세요"):trim($_POST['out_price']);
    // $type = empty($_POST['type'])?Util::error_back("혈액형을 입력해주세요"):trim($_POST['type']);
    // $personality = empty($_POST['personality'])?Util::error_back("특징을 입력해주세요."):trim($_POST['personality']);
    // $descr = empty($_POST['description'])?Util::error_back("상세설명을 입력해주세요."):convert_content(trim($_POST['description']));
    // $stock = empty($_POST['stock'])?Util::error_back("재고를 입력해주세요."):trim($_POST['stock']);
}
if($mode == "insert") {
    try{
        //상품명 중복 검증
        // $query = "
        // select count(*) as cnt
        // from product_info 
        // where eng_name = '$eng_name'"
        // ;
        
        //$list_cnt = salesPdtDetailCnt($pdo, $salesPrdArr);
        $key = $salesPrdArr['eng_name'];
        $list_cnt = $product_info ->salesPdtDetailCnt($key);
        echo "0//";
        if($list_cnt>0){
            Util::error_back("해당상품이 이미 존재합니다.");
        }

        if($_FILES['image']['name']!= "") {
            $upfile_name = $_FILES['image']['name'];
            $upfile_size = $_FILES['image']['size'];
            $upfile_tmp_name = $_FILES['image']['tmp_name'];
            
            $ext = pathinfo($upfile_name, PATHINFO_EXTENSION);
            
            $fupfile_name = md5(microtime()).'.'.$ext;
            $max_size = 5*6.6* 1024 * 1024;//200mb
            
            //validate
            $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
            if(!in_array($ext, $allowed_ext)){
                Util::alert("허용되지 않는 확장자입니다.");
            }
            if($upfile_size>$max_size){
                Util::alert("200MB까지 업로드 가능합니다.");
                
            }
            // 파일 업로드
            move_uploaded_file($upfile_tmp_name, "$SavePath".$fupfile_name);
        }else{
            $upfile_name = "";
            $fupfile_name="";
        }
        
        // $query = "
        // 		INSERT INTO product_info
        //             ( eng_name,
        //               kor_name,
        //               fst_cate,
        //               snd_cate,
        //               origin,
        //               type,
        //               personality,
        //               image,
        //               fimage,
        //               in_price,
        //               out_price,
        //               descr,
        //               regist_date
        //             )
        // 		VALUES('".$eng_name."','".$kor_name."','".$fst_cate."','".$snd_cate."','".$origin."','".$type."','".$personality."','".$upfile_name."','".$fupfile_name."','".$in_price."','".$out_price."','".$descr."',NOW())
        // 	";

        // mysqli_query($db_conn, $query);
        //상품코드 생성

        //상품정보 삽입
        $salesPrdArr['product_code'] = $product_info -> cnt()+1;
        $product_info -> salesPdtInsert($salesPrdArr);
        //상품재고 삽입
        $product_info -> stockInsert($salesPrdArr, $prdStockArr);

        Util::alert_redirect("상품이 등록되었습니다.", $http_url."/adm/product_management/list.php");
        // $query = "
        // 		insert into sales_info
        //             ( eng_name,
        //                 initial_stock,
        //                 regist_time,
        //                 isnew
        //             )
        // 		values('".$eng_name."','".$stock."',now(),'new')
        //     ";
        // mysqli_query($db_conn, $query);
        

        //트랜잭션 종료(성공)
    }catch(PDOException $e){
        $output = "데이터베이스 오류".$e->getMessage()."\n위치".$e->getFile().":".$e->getLine();
        echo $output;
        exit;
        
    }
} else if($mode == "update") {
    try{
    //리스트 조회
        $product_code = empty($_POST['product_code'])?Util::error_back("상품코드가 없습니다."):trim($_POST['product_code']);
        $row = $product_info->salesPdtDetail($product_code);
        $origin_img = isset($_POST['origin_img'])?trim($_POST['origin_img']):"";
        $origin_fimg = isset($_POST['origin_fimg'])?trim($_POST['origin_fimg']):"";
        $delete_file = isset($_POST['delete_file'])?trim($_POST['delete_file']):"";
        if($_FILES['image']['name']!= "") {
            $upfile_name = $_FILES['image']['name'];
            $upfile_size = $_FILES['image']['size'];
            
            $upfile_tmp_name = $_FILES['image']['tmp_name'];
            
            $ext = pathinfo($upfile_name, PATHINFO_EXTENSION);
            
            $fupfile_name = md5(microtime()).'.'.$ext;
            $update_fimg = $fupfile_name;
            $update_img = $upfile_name;
            $max_size = 5*6.6* 1024 * 1024;//200mb
            
            //validate
            $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
            if(!in_array($ext, $allowed_ext)){
                Util::alert("허용되지 않는 확장자입니다.");
            }
            if($upfile_size>$max_size){
                Util::alert("200MB까지 업로드 가능합니다.");
                
            }
            // 파일 업로드
            move_uploaded_file($upfile_tmp_name, "$SavePath".$fupfile_name);
        }else{
            //파일변수
            if($origin_img){
                if($delete_file){
                    $delFile_dir = $SavePath.$origin_fimg;
                    if(file_exists($delFile_dir)){
                        @unlink($delFile_dir);
                    }
                    $update_img = "";
                    $update_fimg = "";
                }else{
                    $update_img = $origin_img;
                    $update_fimg = $origin_fimg;
                }
            }
        }
        
        // $productArr = array(
        //     ':kor_name'=>$kor_name,
        //     ':fst_cate'=>$fst_cate,
        //     ':snd_cate'=>$snd_cate,
        //     ':origin'=>$origin,
        //     ':type'=>$type,
        //     ':personality'=>$personality,
        //     ':in_price'=>$in_price,
        //     ':out_price'=>$out_price,
        //     ':descr'=>$descr,
        //     ':eng_name'=>$eng_name
        // );
        $product_info->salesPdtUpdate($salesPrdArr, $product_code);
        
        $update_stock =$row['initial_stock'] + ($stock - ($row['initial_stock']-$row['quantity']));

        $stockArr = array(
            ':update_stock'=>$update_stock,
            ':product_code' =>$product_code
        );

        $product_info -> stockUpdate($stockArr);
        Util::alert_redirect("상품정보가 수정되었습니다.", $http_url.$redirect_url);
    }catch(PDOException $e){
        $output = "데이터베이스 오류".$e->getMessage()."\n위치".$e->getFile().":".$e->getLine();
        echo $output;
        exit;
        Util::error_back("상품정보를 다시 입력해주세요.");
    }
   
}elseif($mode == "seldel"){
    
    //변수셋팅. 필수값체크
    $chk_array = array();
    $chk_array = isset($_POST['selectdel'])?$_POST['selectdel']:"";

    if($chk_array == ""){
        Util::error_back("삭제할 상품을 선택하세요.");
    }
    
    //트랜잭션 시작
    mysqli_autocommit($db_conn, FALSE);

    for($i=0; $i <count($chk_array); $i++){
        
        $eng_name = $chk_array[$i];
        $eng_name = str_replace("'","\'",$eng_name);
        /*매출정보 삭제*/
        $query = "delete from sales_info where eng_name = '$eng_name'";
        mysqli_query($db_conn, $query);
        
        //상품안에 업로드한 상품명삭제
        $query = "select fimage FROM product_info WHERE eng_name = '$eng_name'";
        $result = mysqli_query($db_conn, $query);
        $row = mysqli_fetch_assoc($result);
        $origin_fimg = $row['fimage'];
        $delFile_dir = $SavePath.$origin_fimg;
        if(file_exists($delFile_dir)){
            @unlink($delFile_dir);
        }
        
        /*상품정보삭제*/
        $query = "delete from product_info where eng_name = '$eng_name'";
        mysqli_query($db_conn, $query);
    }
    
    //트랜잭션 종료(성공)
    mysqli_commit($db_conn);
    Util::alert_redirect("상품 정보가 삭제되었습니다.", $http_url.$redirect_url);
}
?>