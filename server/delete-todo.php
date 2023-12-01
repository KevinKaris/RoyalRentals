<?php
session_start();
include 'connection.php';

if(isset($_POST['todo_id'])){
    $id = $_POST['todo_id'];
    $user_id = $_SESSION["user_id"];

    $DELETE = "DELETE FROM todo WHERE id = ? AND user_id = ?";
    $statement = $con -> prepare($DELETE);
    $statement -> execute([$id, $user_id]);
}