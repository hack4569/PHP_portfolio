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
            'listcnt'=>$listcnt,
            'lists'=>$lists,
            'title'=>'제품 목록',
            'tabIndex'=>'1',
            'view'=>'list.html.php'
        ];
    }
    public function product_add(){

        return [
            'title'=>'제품 추가',
            'tabIndex'=>'1',
            'view'=>'write.html.php'
        ];
    }
}
