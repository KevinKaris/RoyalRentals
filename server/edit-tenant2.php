<?php
include 'connection.php';

if(isset($_POST['name']) && isset($_POST['id']) && isset($_POST['phone']) && isset($_POST['email'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $id = $_POST['id'];
    $size = $_POST['house_size'];
    $house_id = $_POST['house_id'];
    $tenant_id = $_POST['tenant_id'];

    $update = "UPDATE tenants SET name = ?, house_id = ?, size = ?, id_number = ?, phone = ?, email = ? WHERE id = ?";
    $st = $con -> prepare($update);
    $st -> execute([$name, $house_id, $size, $id, $phone, $email, $tenant_id]);
    echo '1';
}

?>