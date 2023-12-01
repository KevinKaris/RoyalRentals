<?php
session_start();
include 'connection.php';

if(isset($_POST['submit']) && $_POST['name'] != '' && $_POST['amount'] != ''){
    $name = $_POST['name'];
    $amount = $_POST['amount'];
    $rental = $_SESSION["rental_id"];

    $sql = "INSERT INTO expenses (rental_id, name, amount) VALUES (?, ?, ?)";
    $st = $con -> prepare($sql);
    $st -> execute([$rental, $name, $amount]);
    echo '<script>window.location.assign("../expenses")</script>';
}
