<?php
session_start();
include 'connection.php';

if(isset($_POST['receipt_no']) && isset($_POST['rental_name']) && isset($_POST['tel']) && isset($_POST['location']) && isset($_POST['tenant_name']) && isset($_POST['tenant_phone']) && isset($_POST['house_number']) && isset($_POST['amount_received']) && isset($_POST['balance']) && isset($_POST['latest_payment']) && isset($_POST['payment_for'])){
    $rental_id = $_SESSION['rental_id'];
    $receipt_no = $_POST['receipt_no'];
    $rental_name = $_POST['rental_name'];
    $tel = $_POST['tel'];
    $location = $_POST['location'];
    $tenant_name = $_POST['tenant_name'];
    $tenant_phone = $_POST['tenant_phone'];
    $house_number = $_POST['house_number'];
    $amount_received = $_POST['amount_received'];
    $balance = $_POST['balance'];
    $latest_payment = $_POST['latest_payment'];
    $payment_for = $_POST['payment_for'];

    $sql = "INSERT INTO receipts (rental_id, receipt_no, rental_name, tel, location, tenant_name, tenant_phone, house_number, amount_received, balance, latest_payment, payment_for) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $statement =  $con -> prepare($sql);
    $data = [$rental_id, $receipt_no, $rental_name, $tel, $location, $tenant_name, $tenant_phone, $house_number, $amount_received, $balance, $latest_payment, $payment_for];
    $statement -> execute($data);
}
?>