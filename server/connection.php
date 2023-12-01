<?php
try{
    $server_name = "localhost";
    $dbname = "rental";
    $username = "kevin";
    $password = "35852744";

    $con = new PDO("mysql:host=$server_name; dbname=$dbname", $username, $password);

    $con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    $e -> getMessage();
}