<?php
class Product_searchDAO{
    private $pdo = null;
    private $addquery = null;
    private $paramArr = null;

    public function __construct($pdo, $addquery, $paramArr){
        $this -> pdo = $pdo;
        $this -> addquery = $addquery;
        $this -> paramArr = $paramArr;
    }

    public function query($query, $parameters = []){
        $stmt = $this->pdo->prepare($query);
        print_r($parameters);

        echo $query;
        foreach($parameters as $name => $value){
            $stmt->bindValue($name,$value);
        }

        $stmt->execute();

        return $stmt;
    }


}