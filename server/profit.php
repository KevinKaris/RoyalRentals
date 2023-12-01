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

        $Jan_exp = 0;$Feb_exp = 0;$Mar_exp = 0;$Apr_exp = 0;$May_exp = 0;$Jun_exp = 0;$Jul_exp = 0;$Aug_exp = 0;$Sep_exp = 0;$Oct_exp = 0;$Nov_exp = 0;$Dec_exp = 0;

        //fetching expected rent
        $expenses = "SELECT * FROM expenses WHERE rental_id = ?";
        $st4 = $con -> prepare($expenses);
        $st4 -> execute([$rental_id]);
        $fetch4 = $st4 -> fetchAll();

        foreach($fetch4 as $fetch4){
            $timestamp = $fetch4["date"];
            $date = new DateTime($timestamp);
            $month = $date->format("m");
            $year = $date->format("Y");
            $current_year = date('Y');

            if($year == $current_year){
                if($month == 1){
                    $Jan_exp += $fetch4['amount'];
                }
                if($month == 2){
                    $Feb_exp += $fetch4['amount'];
                }
                if($month == 3){
                    $Mar_exp = $fetch4['amount'];
                }
                if($month == 4){
                    $Apr_exp += $fetch4['amount'];
                }
                if ($month == 5) {
                    $May_exp += $fetch4['amount'];
                }
                if ($month == 6) {
                    $Jun_exp += $fetch4['amount'];
                }
                if ($month == 7) {
                    $Jul_exp += $fetch4['amount'];
                }
                if ($month == 8) {
                    $Aug_exp += $fetch4['amount'];
                }
                if ($month == 9) {
                    $Sep_exp += $fetch4['amount'];
                }
                if ($month == 10) {
                    $Oct_exp += $fetch4['amount'];
                }
                if ($month == 11) {
                    $Nov_exp += $fetch4['amount'];
                }
                if ($month == 12) {
                    $Dec_exp += $fetch4['amount'];
                }
            }
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
                }elseif ($month == 2) {
                    $Feb += $fetch3['amount'];
                } elseif ($month == 3) {
                    $Mar += $fetch3['amount'];
                } elseif ($month == 4) {
                    $Apr += $fetch3['amount'];
                } elseif ($month == 5) {
                    $May += $fetch3['amount'];
                } elseif ($month == 6) {
                    $Jun += $fetch3['amount'];
                } elseif ($month == 7) {
                    $Jul += $fetch3['amount'];
                } elseif ($month == 8) {
                    $Aug += $fetch3['amount'];
                } elseif ($month == 9) {
                    $Sep += $fetch3['amount'];
                } elseif ($month == 10) {
                    $Oct += $fetch3['amount'];
                } elseif ($month == 11) {
                    $Nov += $fetch3['amount'];
                } elseif ($month == 12) {
                    $Dec += $fetch3['amount'];
                }
            }
        }
    }
    }
}
$collected = [$Jan, $Feb, $Mar, $Apr, $May, $Jun, $Jul, $Aug, $Sep, $Oct, $Nov, $Dec];
$profit = [$Jan - $Jan_exp, $Feb - $Feb_exp, $Mar - $Mar_exp, $Apr - $Apr_exp, $May - $May_exp, $Jun - $Jun_exp, $Jul - $Jul_exp, $Aug - $Aug_exp, $Sep - $Sep_exp, $Oct - $Oct_exp, $Nov - $Nov_exp, $Dec - $Dec_exp];

$array = [
    "collected" => $collected,
    "profit" => $profit
];
$array = json_encode($array);
echo $array;