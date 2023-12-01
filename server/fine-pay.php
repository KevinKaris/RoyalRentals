<?php
include 'connection.php';
if(isset($_POST["fine_id"]) && isset($_POST["amount"])){
    $fine_id = $_POST["fine_id"];
    $amount = $_POST["amount"];

    $sql = "SELECT * FROM fined WHERE id = ?";
    $st = $con -> prepare($sql);
    $st -> execute([$fine_id]);
    $details = $st -> fetch();
    $paid = $details["paid"] + $amount;

    $update = "UPDATE fined SET paid = ? WHERE id = ?";
    $statement = $con -> prepare($update);
    $statement -> execute([$paid, $fine_id]);
    echo '1';
}
?>