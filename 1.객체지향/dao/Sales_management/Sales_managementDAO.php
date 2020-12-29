<?php
    namespace Sales_management;
    use \Comm\DatabaseComm;

    class Sales_managementDAO extends \Comm\DatabaseComm{
        public function __construct(\PDO $pdo){
            parent::__construct($pdo);
        }

        public function salesSearchCnt($sdate){
            $query = "
                select count(*) as cnt
                from product_info a left outer join sales_info b on a.product_code = b.product_code
                where date_format(b.regist_time,'%Y-%m-%d') = :sdate and b.count <> 0
            ";

            $paramArr = [':sdate'=>$sdate];
            $stmt = $this ->query($query,$paramArr);
            $cnt = $stmt->fetchColumn();
            return $cnt;
        }

        public function salesList($sdate){
            $query = "
                select b.eng_name, b.initial_stock, b.quantity, b.count, (b.initial_stock-b.quantity) as re_stock, a.fst_cate , a.out_price
                from product_info a left outer join sales_info b on a.product_code = b.product_code
                where date_format(b.regist_time,'%Y-%m-%d') = :sdate and b.count <> 0
                order by b.eng_name desc
            ";
            $paramArr = ['sdate'=>$sdate];
            $stmt = $this -> query($query,$paramArr);
            $lists = $stmt ->fetchAll();
            return $lists;
        }
    }
?>