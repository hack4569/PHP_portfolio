<?php
include_once  $_SERVER['DOCUMENT_ROOT'] ."/wine/common.php";

// if($_SESSION['userid']!="admin"){
//     Util::alert_redirect("권한이 없습니다.", "../../login.php");
// }

// 첨부파일 최대 갯수

function utf2euc($str) { return iconv("UTF-8","cp949//IGNORE", $str); }


$mode = isset($_POST['mode'])?trim($_POST['mode']):"";
$sfst_cate = isset($_POST['sfst_cate'])?trim($_POST['sfst_cate']):"";
$ssnd_cate = isset($_POST['ssnd_cate'])?trim($_POST['ssnd_cate']):"";
$skey = isset($_POST['skey'])?trim($_POST['skey']):"";
$redirect_url="/adm/product_management/list.php?sfst_cate=$sfst_cate&ssnd=cate=$ssnd_cate&skey=$skey";

// file
$SavePath = $_SERVER["DOCUMENT_ROOT"] . "/wine/data/file/";		// 첨부파일 저장경로
if($mode=="insert" || $mode=="update"){
    $kor_name = empty($_POST['kor_name'])?Util::error_back("한글 상품명이 없습니다."):trim($_POST['kor_name']);
    $kor_name = str_replace("'","\'",$kor_name);
    $eng_name = empty($_POST['eng_name'])?Util::error_back("영문 상품명이 없습니다."):trim($_POST['eng_name']);
    $eng_name = str_replace("'","\'",$eng_name);
    $fst_cate = empty($_POST['fst_cate'])?Util::error_back("1차 카테고리를 선택하지 않았습니다."):trim($_POST['fst_cate']);
    $snd_cate = empty($_POST['snd_cate'])?Util::error_back("2차 카테고리를 선택하지 않았습니다."):trim($_POST['snd_cate']);
    $origin = empty($_POST['origin'])?Util::error_back("원산지를 입력해주세요"):trim($_POST['origin']);
    $origin = str_replace("'","\'",$origin);
    $in_price = empty($_POST['in_price'])?Util::error_back("입고가를 입력해주세요"):trim($_POST['in_price']);
    $out_price = empty($_POST['out_price'])?Util::error_back("출고가를 입력해주세요"):trim($_POST['out_price']);
    $type = empty($_POST['type'])?Util::error_back("혈액형을 입력해주세요"):trim($_POST['type']);
    $type = str_replace("'","\'",$type);
    $personality = empty($_POST['personality'])?Util::error_back("특징을 입력해주세요."):trim($_POST['personality']);
    $personality = str_replace("'","\'",$personality);
    $descr = empty($_POST['description'])?Util::error_back("상세설명을 입력해주세요."):convert_content(trim($_POST['description']));
    $descr = str_replace("'","\'",$descr);
    $stock = empty($_POST['stock'])?Util::error_back("재고를 입력해주세요."):trim($_POST['stock']);

}
if($mode == "insert") {
    //상품명 중복 검증
    $query = "
	select count(*) as cnt
    from product_info 
    where eng_name = '$eng_name'"
    ;
    $result = mysqli_query($db_conn, $query);
    $row = mysqli_fetch_assoc($result); 
    if($row['cnt']>0){
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
    
    //트랜잭션 시작
    mysqli_autocommit($db_conn, FALSE);
    $query = "
    		INSERT INTO product_info
                ( eng_name,
                  kor_name,
                  fst_cate,
                  snd_cate,
                  origin,
                  type,
                  personality,
                  image,
                  fimage,
                  in_price,
                  out_price,
                  descr,
                  regist_date
                )
    		VALUES('".$eng_name."','".$kor_name."','".$fst_cate."','".$snd_cate."','".$origin."','".$type."','".$personality."','".$upfile_name."','".$fupfile_name."','".$in_price."','".$out_price."','".$descr."',NOW())
    	";

    mysqli_query($db_conn, $query);
    $query = "
    		insert into sales_info
                ( eng_name,
                    initial_stock,
                    regist_time,
                    isnew
                )
    		values('".$eng_name."','".$stock."',now(),'new')
        ";
    mysqli_query($db_conn, $query);
    

    //트랜잭션 종료(성공)
    mysqli_commit($db_conn);
    Util::alert_redirect("상품이 등록되었습니다.", $http_url."/adm/product_management/list.php");
    
} else if($mode == "update") {
    $query = "
	select *
	from product_info a
		left outer join sales_info b
		on a.eng_name = b.eng_name
	where b.isnew = 'new' and a.eng_name='$eng_name'
    group by a.eng_name";
    
    $result = mysqli_query($db_conn, $query);
    $row = mysqli_fetch_assoc($result);
    
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
    $query = "
        update product_info
        set
            eng_name='$eng_name', kor_name='$kor_name', fst_cate='$fst_cate', snd_cate='$snd_cate', origin='$origin', type='$type', personality='$personality', image='$update_img', fimage='$update_fimg', in_price='$in_price', out_price='$out_price', descr='$descr', regist_date=now()
        where eng_name='$eng_name'
    ";
    mysqli_query($db_conn, $query);

    $update_stock =$row['initial_stock'] + ($stock - ($row['initial_stock']-$row['quantity']));
    $query = "
        update sales_info
        set
            initial_stock='$update_stock', regist_time=now()
        where eng_name='$eng_name'
    ";
    mysqli_query($db_conn, $query);
    
    mysqli_commit($db_conn);
    
    Util::alert_redirect("상품정보가 수정되었습니다.", $http_url.$redirect_url);
   
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