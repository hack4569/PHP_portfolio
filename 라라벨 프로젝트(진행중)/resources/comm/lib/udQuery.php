<?php
    function udQuery($pdo, $query, $parameters = []){
        $stmt = $pdo->prepare($query);

        foreach($parameters as $name => $value){
            $stmt->bindParam($name,$value);
        }
        
        $stmt->execute();
    }
?>