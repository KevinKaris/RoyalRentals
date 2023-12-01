<?php
session_start();
include 'connection.php';

if(isset($_GET['rental_id'])){
    $rental_id = $_GET['rental_id'];

    $select = "SELECT * FROM rentals WHERE id = ?";
    $st = $con -> prepare($select);
    $st -> execute([$rental_id]);
    $fetch = $st -> fetch();

    $data = array(
        "name" => $fetch['name'],
        "county" => $fetch['county'],
        "sub_county" => $fetch['sub_county'],
        "location" => $fetch['location'],
        "ward" => $fetch['ward'],
        "size" => $fetch['size']
    );

    echo json_encode($data);
}