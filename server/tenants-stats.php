<?php
session_start();
include 'connection.php';

$sql= "SELECT * FROM houses WHERE rental_id = ?";
$rental_id = $_SESSION["rental_id"];
$statement = $con -> prepare($sql);
$statement -> execute([$rental_id]);
$tenants_with_balances = 0;
$tenants_without_balances = 0;
$recent_tenants = 0;
$fined_tenants = 0;
$fine_amount = 0;
$fine_paid = 0;
$total_paid_rent = 0;
$fetch = $statement -> fetchAll();
    foreach($fetch as $fetch){
    $house_id = $fetch["id"];
    $select = "SELECT * FROM tenants";
    $st = $con -> prepare($select);
    $st -> execute();
    $fetch2 = $st -> fetchAll();
        foreach($fetch2 as $fetch2){
            $house_id2 = $fetch2["house_id"];
            if($house_id == $house_id2){
                $house_size = $fetch2["size"];

                //recent tenants
                $timestamp = $fetch2['date'];
                $date = new DateTime($timestamp);
                $month = $date->format("m");
                $current_month = date('m');
                $year = $date -> format('Y');
                if($month == $current_month || $month == $current_month - 1 && $year == date('Y')){
                    $recent_tenants += 1;
                }

                //fined tenants
                $query = "SELECT * FROM fined WHERE tenant_id = ?";
                $st2 = $con -> prepare($query);
                $st2 -> execute([$fetch2['id']]);
                $fine = $st2 -> fetchAll();
                foreach($fine as $fine){
                    $fine_amount += $fine['amount'];
                    $fine_paid += $fine['paid'];
                    if($fine_amount != $fine['paid']){
                        $fined_tenants += 1;
                    }
                }

                $query = "SELECT DISTINCT * FROM rent WHERE rental_id = ? AND house_size = ?";
                $st2 = $con -> prepare($query);
                $st2 -> execute([$rental_id, $house_size]);
                $rent = $st2 -> fetch();

                $payment = "SELECT * FROM payment WHERE tenant_id = ? OR house_id = ?";
                $st3 = $con -> prepare($payment);
                $st3 -> execute([$fetch2["id"], $fetch['id']]);
                $fetch3 = $st3 -> fetchAll();
                foreach($fetch3 as $fetch3){
                    $month2 = date('m', strtotime($fetch3["for_month"]));
                    $current_month = date('m');
                    if ($month2 == $current_month && $fetch3["for_year"] == date('Y')) {
                        $total_paid_rent += $fetch3['amount'];
                    }
                }

                if ($total_paid_rent < $rent['amount']) {
                    $tenants_with_balances += 1;
                } else {
                    $tenants_without_balances += 1;
                }
            }
        }
    }

//calculating percentages
$total = ($tenants_with_balances + $tenants_without_balances + $fined_tenants + $recent_tenants);

$tenants_with_balances = ($tenants_with_balances/$total) * 100;

$tenants_without_balances = ($tenants_without_balances/$total) * 100;

$fined_tenants = ($fined_tenants/$total) * 100;

$recent_tenants = ($recent_tenants/$total) *100;

$stats =[ceil($tenants_without_balances), ceil($tenants_with_balances), ceil($recent_tenants), ceil($fined_tenants)];
$stats = json_encode($stats);
echo $stats;