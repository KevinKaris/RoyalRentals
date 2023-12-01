<?php
session_start();
include '../connection.php';

if(isset($_POST['user_id']) && isset($_POST['password'])){
    $password = $_POST['password'];
    $user_id = $_POST['user_id'];

    $SELECT = "SELECT password FROM users WHERE id = ?";
    $statement = $con -> prepare($SELECT);
    $statement -> execute([$user_id]);
    $fetch = $statement -> fetch();
    if($fetch == true){
        if(password_verify($password, $fetch['password'])){
            unset($_SESSION['lock']);
            echo '1';
        }
        else{
            echo 'Invalid Unlock!';
        }
    }
}