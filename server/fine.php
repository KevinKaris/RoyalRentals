<?php
session_start();

include 'connection.php';

if(isset($_POST["amount"]) && isset($_POST["tenant_id"])){
    $tenant_id = $_POST["tenant_id"];
    $amount = $_POST["amount"];

    $select = "SELECT * FROM fined WHERE tenant_id = ?";
    $statement = $con -> prepare($select);
    $statement -> execute([$tenant_id]);
    $rows = $statement -> rowCount();

    if($rows == 0){
        $sql= "INSERT INTO fined (tenant_id, amount) VALUES (?, ?)";
        $st = $con -> prepare($sql);
        $st -> execute([$tenant_id, $amount]);
        echo '1';
    }
    else{
        echo '0';
    }
}
?>