<?php
namespace Product_management;

error_reporting(E_ALL);

ini_set("display_errors", 1);

class SearchVO{
    private $sfst_cate = null;
    private $ssnd_cate = null;
    private $skey = null;
    private $addquery = null;
    private $addUrl = null;
    private $paramArr = array();

    public function __construct(){

        $sfst_cate = !empty($_REQUEST['sfst_cate'])?trim($_REQUEST['sfst_cate']):"";
        $sfst_cate = urldecode($sfst_cate);
        if($sfst_cate){ 
            $this->sfst_cate = $sfst_cate;
            $this->addquery .= " and a.fst_cate like concat(concat('%', :sfst_cate),'%') ";
            $this->paramArr[':sfst_cate']=$sfst_cate;
        }

        $ssnd_cate = !empty($_REQUEST['ssnd_cate'])?trim($_REQUEST['ssnd_cate']):"";
        if($ssnd_cate=="All"){ $ssnd_cate="";}
        $ssnd_cate = urldecode($ssnd_cate);
        if($ssnd_cate){
            $this->ssnd_cate = $ssnd_cate;
            $this->addquery .= " and a.snd_cate like concat(concat('%', :ssnd_cate),'%') ";
            $this->paramArr[':ssnd_cate']=$ssnd_cate;
        }

        $skey = !empty($_REQUEST['skey'])?trim($_REQUEST['skey']):"";
        $skey = urldecode($skey);
        if($skey){
            $this->skey = $skey;
            $this->addquery .= " and a.eng_name like concat(concat('%', :skey),'%') ";
            $this->paramArr['skey']=$skey; 
        }
        $this->addUrl = "sfst_cate=$sfst_cate&ssnd_cate=$ssnd_cate&skey=$skey";
    }

    public function getSfst_cate(){
        return $this->sfst_cate;
    }
    public function getSsnd_cate(){
        return $this->ssnd_cate;
    }
    public function getSkey(){
        return $this->skey;
    }
    public function getAddQuery(){
        return $this->addquery;
    }
    public function getAddUrl(){
        return $this->addUrl;
    }
    public function getParamArr(){
        return $this->paramArr;
    }
}