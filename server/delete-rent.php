<?php
session_start();
include 'connection.php';

if(isset($_GET['rent_id'])){
    $rent_id = $_GET['rent_id'];

    $DELETE = "DELETE FROM rent WHERE id = ?";
    $statement = $con -> prepare($DELETE);
    $statement2 = $statement -> execute([$rent_id]);
    if($statement2 == true){
        echo '1';
    }
}