<?php
include $_SERVER['DOCUMENT_ROOT'] ."/wine/dao/DatabaseComm.php";

class Product_managementDAO extends DatabaseComm{
    private $salesPrdArr = null;
    private $prdStockArr = null;
    private $product_code = null;

    public function __construct(PDO $pdo, String $tableName){
        parent::__construct($pdo, $tableName);
        // $this -> product_code[':product_code'] = $this -> salesPrdArr['product_code'];
    }

    public function salesPdtDetail($product_code){
        $query = "
        select *
        from  product_info a
            left outer join sales_info b
            on a.eng_name = b.eng_name
        where b.isnew='new' and a.product_code = :product_code
        group by a.eng_name
        ";
        $paramArr = array(':product_code'=>$product_code);
        $stmt = $this->query($query, $paramArr);
        $lists = $stmt->fetchAll();
        print_r($lists);
        return $lists;
    }

    public function salesPdtDetailCnt($key){
        $query = "select count(*) as cnt from ";
        $query.= $this->tableName;
        $query.=" where eng_name = :eng_name";
        
        $paramArr[':eng_name'] = $key;
        $stmt = $this->query($query, $paramArr);
        $listcnt = $stmt -> fetchColumn();

        return $listcnt;
    }

    public function salesPdtUpdate($salesPrdArr, $product_code){
        // $query = "
        // update product_info
        // set
        //     `kor_name`= :kor_name , `fst_cate`= :fst_cate , `snd_cate`= :snd_cate , `origin`= :origin , `type`= :type , `personality`= :personality , `in_price`= :in_price , `out_price`= :out_price , `descr`= :descr , `regist_date`=CURDATE()
        // where `eng_name` =  :eng_name 
        // ";
        
        $query = "update product_info set";
        foreach($salesPrdArr as $key => $value){
            $query .= '`'.$key.'` = :'.$key.",";
        }
        $query .= '`regist_date` = CURDATE() where `product_code`=:product_code';

        $salesPrdArr[':product_code'] = $product_code;

        $this->query($query, $salesPrdArr);
    }

    public function stockInsert($salesPrdArr, $prdStockArr){
        // $query = "
        //     insert into sales_info
        //         ( eng_name,
        //             product_code,
        //             initial_stock,
        //             regist_time,
        //             isnew
        //         )
        //     values(:eng_name, :product_code, :stock, now(), 'new')
        // ";
        //쿼리 시작
        $query = "insert into sales_info ( ";
        //상품, 재고 column
        $query .= "eng_name, product_code,";
        foreach($prdStockArr as $key => $value){
            //배열key와 테이블 컬럼이 동일하지 않아서 발생하는 현상
            if($key == 'stock'){
                $key = 'initial_stock';
            }
            $query .= $key.",";
        }
        $query .= "regist_time, isnew";
        $query .= ") values (";
        $query .= ":eng_name, :product_code,";
        foreach($prdStockArr as $key => $value){
            if($key == 'stock'){
                $key = 'initial_stock';
            }
            $key = ":".$key;
            $query .= $key.",";
        }
        $query .= "now(), 'new')";

        $paramArr = array(
            ":eng_name" => $salesPrdArr['eng_name'],
            ":product_code" => $salesPrdArr['product_code']
        );
        foreach($prdStockArr as $key => $value){
            if($key == 'stock'){
                $key = 'initial_stock';
            }
            $key = ":".$key;
            $paramArr[$key] = $value;
        }

        $this->query($query, $paramArr);
    }

    public function stockUpdate($stockArr){
        $query = "
            update sales_info set
                `initial_stock`= :update_stock , `regist_time`=CURDATE()
            where `product_code` =  :product_code
        ";
        $this->query($query, $stockArr);
    }

    public function salesPdtInsert($salesPrdArr){
        $query = "INSERT INTO PRODUCT_INFO (";
        foreach($salesPrdArr as $key => $value){
            $query .= "`".$key."`,";
        }
        $query .= "`regist_date`";
        $query .= ") VALUES (";
        foreach($salesPrdArr as $key => $value){
            $key = ":".$key;
            $query .= $key.",";
        }
        $query.="now())";

        foreach($salesPrdArr as $key =>$value){
            $key = ":".$key;
            $paramArr[$key]=$value;
        }

        $this->query($query, $paramArr);
    }

    //Search
    public function salesPdtCnt($addquery, $paramArr){
        $query = "
            select count(*) as cnt
            from product_info a
                left outer join sales_info b
                on a.product_code = b.product_code
            where b.isnew = 'new' $addquery
        ";
        $stmt = $this->query($query, $paramArr);
        $listcnt = $stmt -> fetchColumn();

        return $listcnt;
    }

    public function salesPdtList($addquery, $paramArr){
        $query = "
        select *
        from  product_info a
            left outer join sales_info b
            on a.product_code = b.product_code
        where b.isnew='new' $addquery order by a.eng_name
        ";
        
        $stmt = $this->query($query, $paramArr);
        $lists = $stmt->fetchAll();

        return $lists;
    }
}
?>