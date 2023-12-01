<?php
include "connection.php";

if(!empty($_POST["password"])){
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $username = $_POST["username"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $user_id = $_POST["user_id"];
    $password = $_POST["password"];
    $password = password_hash($password, PASSWORD_DEFAULT);

    $select = "SELECT * FROM users WHERE username = ? AND NOT id = ?";
    $statement = $con -> prepare($select);
    $statement -> execute([$username, $user_id]);
    $rows = $statement -> rowCount();

    if($rows > 0){
        echo "Username already exists";
    }
    else{
        $update = "UPDATE users SET f_name = ?, l_name = ?, username = ?, phone = ?, email = ?, password = ? WHERE id = ?";
        $run = $con -> prepare($update);
        $data = ["$fname", "$lname", "$username", "$phone", "$email", "$password", $user_id];
        $run -> execute($data);
        echo "ok";
    }
}
else{
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $username = $_POST["username"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $user_id = $_POST["user_id"];

    $select = "SELECT * FROM users WHERE username = ? AND NOT id = ?";
    $statement = $con -> prepare($select);
    $statement -> execute([$username, $user_id]);
    $rows = $statement -> rowCount();

    if($rows > 0){
        echo "Username already exists";
    }
    else{
        $update = "UPDATE users SET f_name = ?, l_name = ?, username = ?, phone = ?, email = ? WHERE id = ?";
        $run = $con -> prepare($update);
        $data = ["$fname", "$lname", "$username", "$phone", "$email", $user_id];
        $run -> execute($data);
        echo "ok";
    }
}
?>