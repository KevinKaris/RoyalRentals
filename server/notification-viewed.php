<?php
session_start();

include 'connection.php';
if(isset($_POST['id'])){
    $id = $_POST['id'];
    $user_id = $_SESSION['user_id'];

    $UPDATE = "UPDATE notifications SET view = ? WHERE id = ? AND user_id = ?";
    $statement = $con -> prepare($UPDATE);
    $run = $statement -> execute(['viewed', $id, $user_id]);

    if($run == true){
        echo '1';
    }
}