<?php
include 'connection.php';

if(isset($_GET['tenant_id'])){
    $tenant_id = $_GET['tenant_id'];

    $SELECT = "SELECT * FROM tenants WHERE id = ?";
    $st = $con -> prepare($SELECT);
    $st -> execute([$tenant_id]);
    $fetch = $st ->  fetch();

    $name = $fetch['name'];
    $id = $fetch['id_number'];
    $house_size = $fetch['size'];
    $phone = $fetch['phone'];
    $email = $fetch['email'];
    
    //fetching house number
    $house = "SELECT * FROM houses WHERE id = ?";
    $statement = $con -> prepare($house);
    $statement -> execute([$fetch['house_id']]);
    $fetch2 = $statement -> fetch();

    $house_number = $fetch2['number'];
    $house_id = $fetch2['id'];

    $data = array(
        'name' => "$name",
        'id' => "$id",
        'house_size' => "$house_size",
        'phone' => "$phone",
        'email' => "$email",
        'house_number' => "$house_number", 
        'house_id' => "$house_id"
    );

    $data = json_encode($data);

    echo $data;
}
?>