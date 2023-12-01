<?php
include 'connection.php';

if(isset($_POST["fine_id"])){
    $fine_id = $_POST["fine_id"];

    $sql = "DELETE FROM fined WHERE id = ?";
    $st = $con -> prepare($sql);
    $st -> execute([$fine_id]);
    echo '1';
}
?>