<?php
include 'connection.php';
if(isset($_POST['house_id'])){
    $house_id = $_POST['house_id'];
    $update = "UPDATE houses SET status = ? WHERE id = ?";
    $st = $con -> prepare($update);
    $st -> execute(['Okay', $house_id]);
    echo '1';
}
?>