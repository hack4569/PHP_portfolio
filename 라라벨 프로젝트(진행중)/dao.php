<?php
    function query($pdo, $query, $parameters = []){
        $stmt = $pdo->prepare($query);

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
                on a.eng_name = b.eng_name
            where b.isnew = 'new' $addquery
        ";
        $stmt = query($pdo, $query, $paramArr);
        $listcnt = $stmt -> fetchColumn();

        return $listcnt;
    }

    function salesPdtList($pdo, $addquery, $paramArr = []){
        $query = "
        select *
        from  product_info a
            left outer join sales_info b
            on a.eng_name = b.eng_name
        where b.isnew='new' $addquery order by a.eng_name
        ";

        $stmt = query($pdo, $query, $paramArr);
        $lists = $stmt->fetchAll();

        return $lists;
    }
?>