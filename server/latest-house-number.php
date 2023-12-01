<?php
session_start();
include 'connection.php';

$rental_id = $_SESSION["rental_id"];

$houses = "SELECT *
FROM houses
WHERE rental_id = ? 
ORDER BY 
  CASE 
    WHEN number REGEXP '^[0-9]+$' THEN CAST(number AS SIGNED)
    ELSE 0
  END DESC,
  number DESC
LIMIT 1";
$statement = $con -> prepare($houses);
$statement -> execute([$rental_id]);
$fetch = $statement -> fetch();

echo $fetch['number'];