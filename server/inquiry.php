<?php
include 'connection.php';

if(!empty($_GET["rental"])){
    $rental = $_GET["rental"];

    //fetching rental details
    $sql = "SELECT name, county, sub_county, location, size FROM rentals WHERE id = ?";
    $run = $con -> prepare($sql);
    $run -> execute([$rental]);
    $details = $run -> fetch();
    $county = $details["county"];
    $sub_county = $details["sub_county"];
    $location = $details["location"];
    $size = $details["size"];
    $name = $details['name'];

    //fetching manager
    $sql2 = "SELECT f_name, l_name FROM users WHERE rental_id = ?";
    $run2 = $con -> prepare($sql2);
    $run2 -> execute([$rental]);
    $details2 = $run2 -> fetch();
    $manager = $details2["f_name"].' '.$details2["l_name"];

    //fetching houses in the rental and occupied houses
    $sql3 = "SELECT * FROM houses WHERE rental_id = ?";
    $run3 = $con -> prepare($sql3);
    $run3 -> execute([$rental]);
    $house = $run3 -> fetchAll();
    $total_houses = $run3 -> rowCount();
    $occupied_houses = 0;
    $total_rent_collected = 0;
    foreach($house as $house){
        $house_id = $house["id"];
        $sql4 = "SELECT * FROM tenants WHERE house_id = ?";
        $run4 = $con -> prepare($sql4);
        $run4 -> execute([$house_id]);
        $details4 = $run4 -> fetch();
        if($details4 != null){
            $occupied_houses += 1;

            //current month rent collected
            $rent = "SELECT * FROM payment WHERE tenant_id = ? OR house_id = ?";
            $st = $con -> prepare($rent);
            $st -> execute([$details4['id'], $house['id']]);
            $column = $st -> fetchAll();
            if($column != null){
                foreach($column as $column){
                    $payment_month = $column['for_month'];
                    $current_month = date('M');
                    if($payment_month == $current_month && $column['for_year'] == date('Y')){
                        $total_rent_collected += $column['amount'];
                    }
                }
            }
        }
    }
    //Fetching rent
    $sql5 = "SELECT * FROM expenses WHERE rental_id = ?";
    $run5 = $con -> prepare($sql5);
    $run5 -> execute([$rental]);
    $details5 = $run5 -> fetchAll();
    $total_expenses = 0;
    foreach($details5 as $details5){
        $total_expenses += $details5['amount'];
    }

    $profit = $total_rent_collected - $total_expenses;
    $data = array(
        "rental_name" => $name,
        "county" => $county,
        "sub_county" => $sub_county,
        "location" => $location,
        "size" => $size,
        "manager" => $manager,
        "total_houses" => $total_houses,
        "occupied_houses" => $occupied_houses,
        "total_expenses" => $total_expenses,
        "total_rent_collected" => $total_rent_collected,
        "profit" => $profit
    );
    echo (json_encode($data));
}