<?php
session_start();
include 'connection.php';

if(isset($_POST['rent_id'])){
    $rent_id = $_POST['rent_id'];
    $amount =$_POST['amount'];

    $update = "UPDATE rent SET amount = ? WHERE id = ?";
    $st = $con -> prepare($update);
    if($st -> execute([$amount, $rent_id])){
        echo '1';
    }

}