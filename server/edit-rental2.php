<?php
session_start();
include 'connection.php';

$name = $_POST['name'];
$county = $_POST['county'];
$sub_county = $_POST['sub_county'];
$ward = $_POST['ward'];
$location = $_POST['location'];
$rental_id = $_POST['rental_id'];

$update = "UPDATE rentals SET name = ?, county = ?, sub_county = ?, ward = ?, location = ? WHERE id = ?";
$st = $con -> prepare($update);
if($st -> execute([$name, $county, $sub_county, $ward, $location, $rental_id])){
    echo '1';
}