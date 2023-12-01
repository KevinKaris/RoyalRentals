<?php
session_start();
include 'connection.php';

//vacant houses
$sql = "SELECT * FROM houses WHERE rental_id = ?";
$statement = $con -> prepare($sql);
$rental_id = $_SESSION["rental_id"];
$data = [$rental_id];
$statement -> execute($data);
$house = $statement -> fetchAll();
$vacant = 0;
foreach($house as $house){
    $house_id = $house["id"];
    $sql2 = "SELECT * FROM tenants WHERE house_id = ?";
    $data2 = [$house_id];
    $statement2 = $con -> prepare($sql2);
    $statement2 -> execute($data2);
    $tenant = $statement2 -> fetch();
    if($tenant === false && $house['status'] == 'Okay'){
        $vacant += 1;
    }
}

//faulty houses
$sql = "SELECT * FROM houses WHERE rental_id = ?";
$statement = $con -> prepare($sql);
$rental_id = $_SESSION["rental_id"];
$data = [$rental_id];
$statement -> execute($data);
$house = $statement -> fetchAll();
$faulty = 0;
foreach($house as $house){
    if($house["status"] == "Faulty"){
        $faulty += 1;
    }
}

//occupied houses
$sql3 = "SELECT * FROM rent WHERE rental_id = ?";
$rental_id = $_SESSION["rental_id"];
$data = [$rental_id];
$statement3 = $con -> prepare($sql3);
$statement3 -> execute($data);
$rent = $statement3 -> fetch();

$sql = "SELECT * FROM houses WHERE rental_id = ?";
$statement = $con -> prepare($sql);
$statement -> execute($data);
$house = $statement -> fetchAll();
$occupied = 0;
foreach($house as $house){
    $house_id = $house["id"];
    $sql2 = "SELECT * FROM tenants WHERE house_id = ?";
    $data2 = [$house_id];
    $statement2 = $con -> prepare($sql2);
    $statement2 -> execute($data2);
    $tenant = $statement2 -> fetch(PDO::FETCH_ASSOC);
    if($tenant !== false){
        if($tenant["house_id"] != ''){
            $occupied += 1;
        }
    }
}

$total = $occupied + $vacant + $faulty;

//percentages
$occupied = ($occupied/$total) * 100;
$faulty = ($faulty/$total) * 100;
$vacant = ($vacant/$total) * 100;

$array = array($occupied, $vacant, $faulty);
$array = json_encode($array);
echo $array;