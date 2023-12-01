<?php
session_start();
include 'connection.php';

if(isset($_GET['rent_id'])){
    $rent_id = $_GET['rent_id'];

    $sql = "SELECT * FROM rent WHERE id = ?";
    $st = $con -> prepare($sql);
    $st -> execute([$rent_id]);
    $fetch = $st -> fetch();

    if($fetch == true){
        $data = array(
            "house_size" => $fetch['house_size'],
            "amount" => $fetch['amount']
        );
        echo json_encode($data);
    }
}