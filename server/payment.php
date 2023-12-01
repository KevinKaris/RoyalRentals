<?php
session_start();

include 'connection.php';
if(isset($_POST["tenant_id"]) && $_POST["tenant_id"] != '' && !empty($_POST["amount"])){
    $tenant_id = $_POST["tenant_id"];
    $amount = $_POST["amount"];
    $month = $_POST['month'];
    $year = $_POST['year'];

    $sql = "SELECT * FROM tenants WHERE id = ?";
    $statement = $con -> prepare($sql);
    $data = [$tenant_id];
    $statement -> execute($data);
    $fetch = $statement -> fetch();

    $house = "SELECT * FROM houses WHERE id = ?";
    $statement2 = $con -> prepare($house);
    $statement2 -> execute([$fetch['house_id']]);
    $fetch2 = $statement2 -> fetch();

    $rent = "SELECT * FROM rent WHERE rental_id = ? AND house_size = ?";
    $statement3 = $con -> prepare($rent);
    $statement3 -> execute([$_SESSION['rental_id'], $fetch2['size']]);
    $fetch3 = $statement3 -> fetch();

    $sql2 = "INSERT INTO payment (tenant_id, rent, amount, for_month, for_year) VALUES (?, ?, ?, ?, ?)";
    $statement4 = $con -> prepare($sql2);
    $data2 = [$tenant_id, $fetch3['amount'], $amount, $month, $year];
    $statement4 -> execute($data2);
    $fetch4 = $statement4 -> fetch();

    echo "1";
}
else if(isset($_POST["house_id"]) && $_POST["house_id"] != '' && !empty($_POST["amount"])){
    $house_id = $_POST["house_id"];
    $amount = $_POST["amount"];
    $month = $_POST['month'];
    $year = $_POST['year'];

    $house = "SELECT * FROM houses WHERE id = ?";
    $statement2 = $con -> prepare($house);
    $statement2 -> execute([$house_id]);
    $fetch2 = $statement2 -> fetch();

    $rent = "SELECT * FROM rent WHERE rental_id = ? AND house_size = ?";
    $statement3 = $con -> prepare($rent);
    $statement3 -> execute([$_SESSION['rental_id'], $fetch2['size']]);
    $fetch3 = $statement3 -> fetch();

    $sql = "INSERT INTO payment (house_id, rent, amount, for_month, for_year) VALUES (?, ?, ?, ?, ?)";
    $statement = $con -> prepare($sql);
    $data = [$house_id, $fetch3['amount'], $amount, $month, $year];
    $statement -> execute($data);

    echo "1";
}
else{
    echo "0";
}
?>