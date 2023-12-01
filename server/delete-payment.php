<?php
include 'connection.php';
if(!empty($_POST['id'])){
    $id = $_POST['id'];
    $sql = "DELETE FROM payment WHERE id = ?";
    $st = $con -> prepare($sql);
    $st -> execute([$id]);
    
    echo '1';
}
?>