<?php
    function query($pdo, $query, $parameters = []){
        $stmt = $pdo->prepare($query);

        foreach($parameters as $name => $value){
            $stmt->bindValue($name,$value);
        }
        
        $stmt->execute();

        return $stmt;
    }
?>