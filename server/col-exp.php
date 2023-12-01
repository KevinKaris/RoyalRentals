<?php
session_start();
include 'connection.php';

$sql= "SELECT * FROM houses WHERE rental_id = ?";
$rental_id = $_SESSION["rental_id"];
$statement = $con -> prepare($sql);
$statement -> execute([$rental_id]);
$fetch = $statement -> fetchAll();
$total_paid_rent = 0;
$total_paid_rent2 = 0;
$expected_amount = 0;
$expected_amount_last = 0;
$expected_amount_current = 0;
$Jan = 0;$Feb = 0;$Mar = 0;$Apr = 0;$May = 0;$Jun = 0;$Jul = 0;$Aug = 0;$Sep = 0;$Oct = 0;$Nov = 0;$Dec = 0;
$Jan_exp = 0;$Feb_exp = 0;$Mar_exp = 0;$Apr_exp = 0;$May_exp = 0;$Jun_exp = 0;$Jul_exp = 0;$Aug_exp = 0;$Sep_exp = 0;$Oct_exp = 0;$Nov_exp = 0;$Dec_exp = 0;

foreach($fetch as $fetch){
$house_id = $fetch["id"];
$select = "SELECT * FROM tenants";
$st = $con -> prepare($select);
$st -> execute();
$fetch2 = $st -> fetchAll();

foreach($fetch2 as $fetch2){
    $house_id2 = $fetch2["house_id"];
    $house_size = $fetch['size'];
    if($house_id == $house_id2){

        $timestamp = $fetch2["date"];
        $date = new DateTime($timestamp);
        $month = $date->format("m");
        $year = $date->format("Y");
        $current_year = date('Y');

        //fetching expected rent
        $rent = "SELECT DISTINCT * FROM rent WHERE rental_id = ? AND house_size = ?";
        $st4 = $con -> prepare($rent);
        $st4 -> execute([$rental_id, $house_size]);
        $fetch4 = $st4 -> fetch();
        $rows4 = $st4 -> rowCount();

        if($year != $current_year || $month == 01){
            $Jan_exp += $fetch4['amount'];
        }
        if($month <= 2){
            $Feb_exp += $fetch4['amount'];
        }
        if($month <= 3){
            $Mar_exp += $fetch4['amount'];
        }
        if($month <= 4){
            $Apr_exp += $fetch4['amount'];
        }
        if ($month <= 5) {
            $May_exp += $fetch4['amount'];
        }
        if ($month <= 6) {
            $Jun_exp += $fetch4['amount'];
        }
        if ($month <= 7) {
            $Jul_exp += $fetch4['amount'];
        }
        if ($month <= 8) {
            $Aug_exp += $fetch4['amount'];
        }
        if ($month <= 9) {
            $Sep_exp += $fetch4['amount'];
        }
        if ($month <= 10) {
            $Oct_exp += $fetch4['amount'];
        }
        if ($month <= 11) {
            $Nov_exp += $fetch4['amount'];
        }
        if ($month <= 12) {
            $Dec_exp += $fetch4['amount'];
        }


        //payment
        $payment = "SELECT * FROM payment WHERE tenant_id = ? OR house_id = ?";
        $st3 = $con -> prepare($payment);
        $st3 -> execute([$fetch2["id"], $house_id2]);
        $fetch3 = $st3 -> fetchAll();
        $rows = $st3 -> rowCount();
        if($rows > 0){
            foreach($fetch3 as $fetch3){
                // $timestamp = $fetch3["date"];
                // $date = new DateTime($timestamp);
                // $month = $date->format("m");
                $month = date('m', strtotime($fetch3["for_month"], '1'));
                $year = $fetch3["for_year"];

                if($month == 1 && $year == date('Y')){
                    $Jan += $fetch3['amount'];
                }elseif ($month == 2 && $year == date('Y')) {
                    $Feb += $fetch3['amount'];
                } elseif ($month == 3 && $year == date('Y')) {
                    $Mar += $fetch3['amount'];
                } elseif ($month == 4 && $year == date('Y')) {
                    $Apr += $fetch3['amount'];
                } elseif ($month == 5 && $year == date('Y')) {
                    $May += $fetch3['amount'];
                } elseif ($month == 6 && $year == date('Y')) {
                    $Jun += $fetch3['amount'];
                } elseif ($month == 7 && $year == date('Y')) {
                    $Jul += $fetch3['amount'];
                } elseif ($month == 8 && $year == date('Y')) {
                    $Aug += $fetch3['amount'];
                } elseif ($month == 9 && $year == date('Y')) {
                    $Sep += $fetch3['amount'];
                } elseif ($month == 10 && $year == date('Y')) {
                    $Oct += $fetch3['amount'];
                } elseif ($month == 11 && $year == date('Y')) {
                    $Nov += $fetch3['amount'];
                } elseif ($month == 12 && $year == date('Y')) {
                    $Dec += $fetch3['amount'];
                }
            }
        }
    }
    }
}
$collected = [$Jan, $Feb, $Mar, $Apr, $May, $Jun, $Jul, $Aug, $Sep, $Oct, $Nov, $Dec];
$expected = [$Jan_exp, $Feb_exp, $Mar_exp, $Apr_exp, $May_exp, $Jun_exp, $Jul_exp, $Aug_exp, $Sep_exp, $Oct_exp, $Nov_exp, $Dec_exp];

$array = [
    "collected" => $collected,
    "expected" => $expected
];
$array = json_encode($array);
echo $array;