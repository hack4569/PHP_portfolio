<?php
namespace Comm;

class DatabaseComm{
    private $pdo = null;

    public function __construct(\PDO $pdo){
        $this->pdo = $pdo;    
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