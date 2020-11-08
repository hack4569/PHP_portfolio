<?php

class DatabaseComm{
    private $pdo = null;
    protected $tableName = null;

    public function __construct(PDO $pdo, String $tableName){
        $this->pdo = $pdo;    
        $this->tableName = $tableName;
    }

    public function cnt(){
        $query = " select count(*) as cnt from ";
        $query .= $this->tableName;
        $stmt = $this->query($query);
        $cnt = $stmt -> fetchColumn();

        return $cnt;
    }

    protected function query($query, $parameters = []){
        $stmt = $this->pdo->prepare($query);
        foreach($parameters as $name => $value){
            $stmt->bindValue($name,$value);
        }
        echo $query;
        print_r($parameters);
        $stmt->execute();

        return $stmt;
    }
}