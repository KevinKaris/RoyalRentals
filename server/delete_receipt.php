<?php
include 'connection.php';
if(isset($_GET['receipt_id'])){
    $receipt_id = $_GET['receipt_id'];
    $sql = "DELETE FROM receipts WHERE id = ?";
    $st = $con -> prepare($sql);
    $st -> execute([$receipt_id]);
    echo 'ok';
}
?>