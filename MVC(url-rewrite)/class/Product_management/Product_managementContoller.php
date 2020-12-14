<?php
namespace Product_management;

class Product_managementContoller{
    private $product_info = null;
    private $searchVO = null;

    public function __construct($product_info, $searchVO){
        $this -> product_info = $product_info;
        $this -> searchVO = $searchVO;
    }

    public function product_list(){
        // if($this->searchVO->getSfst_cate()){ 
        //     $paramArr[':sfst_cate']=$this->searchVO->getSfst_cate();
        // }
        // if($this->searchVO->getSsnd_cate()){
        //     $paramArr[':ssnd_cate']=$this->searchVO->getSsnd_cate();
        // }
        // if($this->searchVO->getSkey()){
        //     $paramArr[':skey']=$this->searchVO->getSkey();
        // }
        
        $listcnt = $this->product_info -> salesPdtCnt($this->searchVO->getAddQuery(), $this->searchVO->getParamArr());
        $lists = $this->product_info -> salesPdtList($this->searchVO->getAddQuery(), $this->searchVO->getParamArr());
        $addUrl = $this->searchVO->getAddUrl();
        return [
            'variables'=>[
                'listcnt'=>$listcnt,
                'lists'=>$lists
            ],
            'title'=>'제품 목록',
            'template'=>'admin/product.list.php'
        ];
    }
    public function product_add(){

        return [
            'title'=>'제품 추가',
            'template'=>'admin/product.write.php'
        ];
    }
    public function product_update(){
        $product_code = isset($_GET['product_code']) ? htmlspecialchars($_GET['product_code']) : "";
        $product_item = $this->product_info -> salesPdtDetail($product_code);

        return [
            'variables'=> [
                'product_item'=>$product_item
            ],
            'title'=>'제품 수정',
            'template'=>'admin/product.update.php'
        ];
    }
    public function product_insert(){

        $salesPrdArr = array();
        $salesPrdArr['kor_name'] = empty($_POST['kor_name'])?\Util::error_back("한글 상품명이 없습니다."):trim($_POST['kor_name']);
        $salesPrdArr['eng_name'] = empty($_POST['eng_name'])?\Util::error_back("영문 상품명이 없습니다."):trim($_POST['eng_name']);
        $salesPrdArr['fst_cate'] = empty($_POST['fst_cate'])?\Util::error_back("1차 카테고리를 선택하지 않았습니다."):trim($_POST['fst_cate']);
        $salesPrdArr['snd_cate'] = empty($_POST['snd_cate'])?\Util::error_back("2차 카테고리를 선택하지 않았습니다."):trim($_POST['snd_cate']);
        $salesPrdArr['origin'] = empty($_POST['origin'])?\Util::error_back("원산지를 입력해주세요"):trim($_POST['origin']);
        $salesPrdArr['in_price'] = empty($_POST['in_price'])?\Util::error_back("입고가를 입력해주세요"):trim($_POST['in_price']);
        $salesPrdArr['out_price'] = empty($_POST['out_price'])?\Util::error_back("출고가를 입력해주세요"):trim($_POST['out_price']);
        $salesPrdArr['type'] = empty($_POST['type'])?\Util::error_back("혈액형을 입력해주세요"):trim($_POST['type']);
        $salesPrdArr['personality'] = empty($_POST['personality'])?\Util::error_back("특징을 입력해주세요."):trim($_POST['personality']);
        empty($_POST['description']) ? "" : $salesPrdArr['descr'] = $_POST['description'];
        $prdStockArr['stock'] = empty($_POST['stock'])?0:trim($_POST['stock']);

        $key = $salesPrdArr['eng_name'];
        $list_cnt = $this->product_info ->salesPdtDetailCnt($key);
        
        if($list_cnt>0){
            \Util::error_back("해당상품이 이미 존재합니다.");
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
                \Util::alert("허용되지 않는 확장자입니다.");
            }
            if($upfile_size>$max_size){
                \Util::alert("300MB까지 업로드 가능합니다.");
                
            }
            // 파일 업로드
            move_uploaded_file($upfile_tmp_name, "$SavePath".$fupfile_name);
        }else{
            $upfile_name = "";
            $fupfile_name="";
        }

        //상품정보 삽입
        $salesPrdArr['product_code'] = $this->product_info -> cntProduct()+1;
        $this->product_info -> salesPdtInsert($salesPrdArr);
        //상품재고 삽입
        $this->product_info -> stockInsert($salesPrdArr, $prdStockArr);
        
        //$route = 'product_list';
        $addUrl = $this->searchVO -> getAddUrl();
        //\Util::alert_redirect("상품이 등록되었습니다.", "./index.php?route=$route&$addUrl");
        \Util::alert_redirect("상품이 등록되었습니다.", "/wine/adm/product_management/list?$addUrl");
    }
    public function product_modify(){
        $salesPrdArr = array();
        $salesPrdArr['kor_name'] = empty($_POST['kor_name'])?\Util::error_back("한글 상품명이 없습니다."):trim($_POST['kor_name']);
        $salesPrdArr['eng_name'] = empty($_POST['eng_name'])?\Util::error_back("영문 상품명이 없습니다."):trim($_POST['eng_name']);
        $salesPrdArr['fst_cate'] = empty($_POST['fst_cate'])?\Util::error_back("1차 카테고리를 선택하지 않았습니다."):trim($_POST['fst_cate']);
        $salesPrdArr['snd_cate'] = empty($_POST['snd_cate'])?\Util::error_back("2차 카테고리를 선택하지 않았습니다."):trim($_POST['snd_cate']);
        $salesPrdArr['origin'] = empty($_POST['origin'])?\Util::error_back("원산지를 입력해주세요"):trim($_POST['origin']);
        $salesPrdArr['in_price'] = empty($_POST['in_price'])?\Util::error_back("입고가를 입력해주세요"):trim($_POST['in_price']);
        $salesPrdArr['out_price'] = empty($_POST['out_price'])?\Util::error_back("출고가를 입력해주세요"):trim($_POST['out_price']);
        $salesPrdArr['type'] = empty($_POST['type'])?\Util::error_back("혈액형을 입력해주세요"):trim($_POST['type']);
        $salesPrdArr['personality'] = empty($_POST['personality'])?\Util::error_back("특징을 입력해주세요."):trim($_POST['personality']);
        empty($_POST['description']) ? "" : $salesPrdArr['descr'] = $_POST['description'];
        $prdStockArr['stock'] = empty($_POST['stock'])?0:trim($_POST['stock']);

        $key = $salesPrdArr['eng_name'];

        //리스트 조회
                $product_code = empty($_POST['product_code'])?Util::error_back("상품코드가 없습니다."):trim($_POST['product_code']);
                $row = $this->product_info->salesPdtDetail($product_code);
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
                        \Util::alert("허용되지 않는 확장자입니다.");
                    }
                    if($upfile_size>$max_size){
                        \Util::alert("200MB까지 업로드 가능합니다.");
                        
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
                $this->product_info->salesPdtUpdate($salesPrdArr, $product_code);
                
                //$update_stock =$row['initial_stock'] + ($stock - ($row['initial_stock']-$row['quantity']));
                $row = $this->product_info->salesPdtDetail($product_code);
                extract($row);
                $update_stock = (int)$prdStockArr['stock'] + (int)$quantity;

                $stockArr = array(
                    ':update_stock'=>$update_stock,
                    ':product_code' =>$product_code
                );
        
                $this->product_info -> stockUpdate($stockArr);

                $route="product_update";
                $addUrl = $this->searchVO -> getAddUrl();
                \Util::alert_redirect("상품정보가 수정되었습니다.", "/wine/adm/product_management/list?product_code=$product_code&$addUrl");
    }
    public function product_delete(){
        if(count($_POST['selectdel']) <= 0){
            Util::error_back("상품코드가 없습니다.");
        }
        foreach($_POST['selectdel'] as $deleteItem){
            $this->product_info->salesPdtDelete($deleteItem);
            $this->product_info->salesStockDelete($deleteItem);
        }
        
        \Util::alert_redirect("상품정보가 삭제되었습니다.", "/wine/adm/product_management/list?$addUrl");
    }
}
