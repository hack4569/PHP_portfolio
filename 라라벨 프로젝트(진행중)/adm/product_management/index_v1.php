<?php
    include_once  $_SERVER['DOCUMENT_ROOT'] ."/wine/autoloader.php";
    include_once  $_SERVER['DOCUMENT_ROOT'] ."/wine/common.php";
    //include $_SERVER['DOCUMENT_ROOT'] ."/wine/dao/Product_managementDAO.php";
    //namespace로 대체

    $addquery = "";//추가쿼리
    $paramArr = array();//query함수를 사용하기 위한 배열
    include $_SERVER['DOCUMENT_ROOT'] ."/wine/addQuery/salesProduct.php";

    //route
    //strtok($_SERVER['REQUEST_URI'],'?');
    //$route = ltrim(strtok($_SERVER['REQUEST_URI'],'?'),'/');
    $route = isset($_GET['route']) ? trim($_GET['route']) : "list";
    //$route = rtrim(strtok($_SERVER['REQUEST_URI'],'?'),'/');

    $method = $_SERVER['REQUEST_METHOD'];
    // 객체생성
    $product_info = new \Product_management\Product_managementDAO($pdo);
    if($route == '' || $route == 'list'){
        try{
            $listcnt = $product_info -> salesPdtCnt($addquery, $paramArr);
            $lists = $product_info -> salesPdtList($addquery, $paramArr);

            include "./views/list.php";
        
        }catch(\PDOException $e){
            $result = $e -> getMessage();
        }
    }else if($route =='change' && $method=='GET'){
        try{
            $product_code = isset($_GET['product_code'])?trim($_GET['product_code']): Util::error_back("상품정보가 없습니다.");

            if(!empty($product_code)){
                $row = $product_info->salesPdtDetail($product_code);
                extract($row);
            }

            $title = "상품정보수정";
            $route = "change";
            include "./views/write.php";
        }catch(\PDOException $e){
            $result = $e -> getMessage();
        }
        
    }else if($route =='add' && $method=='GET'){
        $title = "상품정보추가";
        $route = "add";
        include "./views/write.php";
    }else if(($route =='change' || $route =='add') && $method=='POST'){
        $redirect_url="adm/product_management/index.php?route=change&sfst_cate=$sfst_cate&ssnd_cate=$ssnd_cate&skey=$skey";
        $SavePath = $_SERVER["DOCUMENT_ROOT"] . "/wine/data/file/";		// 첨부파일 저장경로

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
        $prdStockArr['stock'] = empty($_POST['stock'])?0:trim($_POST['stock']);
        if($route == 'add'){
            try{
                $key = $salesPrdArr['eng_name'];
                $list_cnt = $product_info ->salesPdtDetailCnt($key);
                
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
    
                //상품정보 삽입
                $salesPrdArr['product_code'] = $product_info -> cntProduct()+1;
                $product_info -> salesPdtInsert($salesPrdArr);
                //상품재고 삽입
                $product_info -> stockInsert($salesPrdArr, $prdStockArr);
                
                $route = 'change';
                Util::alert_redirect("상품이 등록되었습니다.", "./index.php?route=$route&product_code=$salesPrdArr[product_code]&$addUrl");
            }catch(\PDOException $e){
                $output = "데이터베이스 오류".$e->getMessage()."\n위치".$e->getFile().":".$e->getLine();
                echo $output;
                exit;
            }
        }else if($rooute='change'){
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
                
                //$update_stock =$row['initial_stock'] + ($stock - ($row['initial_stock']-$row['quantity']));
                $row = $product_info->salesPdtDetail($product_code);
                extract($row);
                $update_stock = (int)$prdStockArr['stock'] + (int)$quantity;

                $stockArr = array(
                    ':update_stock'=>$update_stock,
                    ':product_code' =>$product_code
                );
        
                $product_info -> stockUpdate($stockArr);

                $route="change";
                Util::alert_redirect("상품정보가 수정되었습니다.", "./index.php?route=$route&product_code=$product_code&$addUrl");
            }catch(\PDOException $e){
                $output = "데이터베이스 오류".$e->getMessage()."\n위치".$e->getFile().":".$e->getLine();
                Util::error_back("상품정보를 다시 입력해주세요.");
            }
        }
    }else if($route == 'delete'){
        
        $selectDel = isset($_POST['selectdel'])?$_POST['selectdel']: Util::error_back("상품정보가 없습니다.");

        $cntSelectedDel = count($selectDel);
        for($i=0; $i<$cntSelectedDel; $i++){
            $product_info->salesPdtDelete($selectDel[$i]);
        }

        for($i=0; $i<$cntSelectedDel; $i++){
            $product_info->salesStockDelete($selectDel[$i]);
        }
        $route="list";
        Util::alert_redirect("상품정보가 삭제되었습니다.", "./index.php?route=$route&$addUrl");
    }
?>