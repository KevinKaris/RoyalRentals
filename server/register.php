<?php
include 'connection.php';
if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['username']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['password'])){
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $select = "SELECT DISTINCT * FROM users WHERE username = ? OR phone = ?";
    $st = $con -> prepare($select);
    $st -> execute([$username, ltrim($phone, '0')]);
    $fetch = $st -> fetch();
    if($fetch == null){
        $password = password_hash($password, PASSWORD_DEFAULT);
        $insert = "INSERT INTO users (f_name, l_name, username, phone, email, user_group, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $st2 = $con -> prepare($insert);
        if($st2 -> execute([$first_name, $last_name, $username, $phone, $email, '1', $password])){
            echo '1';
        }
    }
    else{
        echo 'User exists!';
    }
}