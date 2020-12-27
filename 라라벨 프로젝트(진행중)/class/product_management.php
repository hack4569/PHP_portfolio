<?php
    function query($pdo, $query, $parameters = []){
        $stmt = $pdo->prepare($query);
        print_r($parameters);

        echo $query;
        foreach($parameters as $name => $value){
            $stmt->bindValue($name,$value);
        }

        $stmt->execute();

        return $stmt;
    }

    function salesPdtCnt($pdo, $addquery, $paramArr = []){
        $query = "
            select count(*) as cnt
            from product_info a
                left outer join sales_info b
                on a.product_code = b.product_code
            where b.isnew = 'new' $addquery
        ";
        $stmt = query($pdo, $query, $paramArr);
        $listcnt = $stmt -> fetchColumn();

        return $listcnt;
    }

    function cntSalesPdt($pdo){
        $query = " select count(*) as cnt from product_info";
        $stmt = query($pdo, $query);
        $cnt = $stmt -> fetchColumn();

        return $cnt;
    }

    function salesPdtList($pdo, $addquery, $paramArr = []){
        $query = "
        select *
        from  product_info a
            left outer join sales_info b
            on a.product_code = b.product_code
        where b.isnew='new' $addquery order by a.eng_name
        ";
        
        $stmt = query($pdo, $query, $paramArr);
        $lists = $stmt->fetchAll();

        return $lists;
    }

    function salesPdtDetail($pdo, $paramArr = []){
        $query = "
        select *
        from  product_info a
            left outer join sales_info b
            on a.eng_name = b.eng_name
        where b.isnew='new' and a.product_code = :product_code
        group by a.eng_name
        ";

        $stmt = query($pdo, $query, $paramArr);
        $lists = $stmt->fetchAll();
        print_r($lists);
        return $lists;
    }

    function salesPdtDetailCnt($pdo, $salesPrdArr){
        $query = "
        select count(*) as cnt
        from  product_info 
        where eng_name = :eng_name
        ";
        $paramArr = array(":eng_name" => $salesPrdArr['eng_name']);
        $stmt = query($pdo, $query, $paramArr);
        $listcnt = $stmt -> fetchColumn();

        return $listcnt;
    }

    function salesPdtUpdate($pdo, $columns, $paramArr){
        // $query = "
        // update product_info
        // set
        //     `kor_name`= :kor_name , `fst_cate`= :fst_cate , `snd_cate`= :snd_cate , `origin`= :origin , `type`= :type , `personality`= :personality , `in_price`= :in_price , `out_price`= :out_price , `descr`= :descr , `regist_date`=CURDATE()
        // where `eng_name` =  :eng_name 
        // ";
        $query = "update product_info set";
        foreach($columns as $key => $value){
            $query .= '`'.$key.'` = :'.$key.",";
        }
        $query .= '`regist_date` = CURDATE() where `product_code`=:product_code';
        query($pdo, $query, $paramArr);
    }

    function stockInsert($pdo, $salesPrdArr, $prdStockArr){
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
            $key = ":".$key;
            $query .= $key.",";
        }
        $query .= "now(), 'new')";

        $paramArr = array(
            ":eng_name" => $salesPrdArr['eng_name'],
            ":product_code" => $salesPrdArr['product_code']
        );
        foreach($prdStockArr as $key => $value){
            $key = ":".$key;
            $paramArr[$key] = $value;
        }

        query($pdo, $query, $paramArr);
    }
    function stockUpdate($pdo, $paramArr){
        $query = "
            update sales_info
            set
                `initial_stock`= :update_stock , `regist_time`=CURDATE()
            where `product_code` =  :product_code
        ";
        query($pdo, $query, $paramArr);
    }

    function salesPdtInsert($pdo, $columns){
        $query = "INSERT INTO PRODUCT_INFO(";
        foreach($columns as $key => $value){
            $query .= "`".$key."`,";
        }
        $query .= "`regist_date`";
        $query .= ") VALUES (";
        foreach($columns as $key => $value){
            $key = ":".$key;
            $query .= $key.",";
        }
        $query.="now())";

        foreach($columns as $key =>$value){
            $key = ":".$key;
            $paramArr[$key]=$value;
        }

        query($pdo,$query, $paramArr);
    }
?>