<?php
session_start();
include 'connection.php';

if(isset($_GET['id']) && isset($_GET['status']) && $_GET['status'] == 'complete'){
    $id = $_GET['id'];
    $user_id = $_SESSION["user_id"];

    $UPDATE = "UPDATE todo SET completed = ? WHERE id = ? and user_id = ?";
    $statement = $con -> prepare($UPDATE);
    $statement -> execute(['completed', $id, $user_id]);
}
else if(isset($_GET['id']) && isset($_GET['status']) && $_GET['status'] == 'uncomplete'){
    $id = $_GET['id'];
    $user_id = $_SESSION["user_id"];

    $UPDATE = "UPDATE todo SET completed = ? WHERE id = ? and user_id = ?";
    $statement = $con -> prepare($UPDATE);
    $statement -> execute([null, $id, $user_id]);
}