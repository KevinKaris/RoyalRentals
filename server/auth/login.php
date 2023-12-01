<?php
session_start();
include "../connection.php";

if(!empty($_GET['username']) && !empty($_GET['password'])){
    $username = $_GET['username'];
    $password = $_GET['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    
    $statement = $con -> prepare($sql);
    $statement -> execute([$username]);
    $details = $statement -> fetch();
    $rows = $statement -> rowCount();

    if($rows > 0){
        if(password_verify($password, $details['password'])){
            $_SESSION['username'] = $details['username'];
            $_SESSION['user_id'] = $details['id'];
            $_SESSION['login-time'] = time();
            $_SESSION["user-group"] = $details["user_group"];
            echo $details["user_group"];
        }
        else{
            echo 'wrong-password';
        }
    }
    else if($rows == 0){
        echo "!exist";
    }
    else{
        echo "error";
    }
}