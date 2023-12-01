<?php
session_start();
include 'connection.php';

$user_id = $_SESSION["user_id"];

$sql = "SELECT * FROM rentals WHERE user_id = ?";
$statement = $con -> prepare($sql);
$statement -> execute([$user_id]);
$rows = $statement -> rowCount();
$fetch_rental = $statement -> fetchAll();
$rentals = array();
$collected = array();
$expected = array();
if($rows > 0){
    foreach($fetch_rental as $fetch_rental){
        $rent_paid = 0;
        $expected_rent = 0;
        $statement2 = $con -> prepare("SELECT * FROM houses WHERE rental_id = ?");
        $statement2 -> execute([$fetch_rental['id']]);
        $houses_fetch = $statement2 -> fetchAll();
        if($houses_fetch != null){
            foreach($houses_fetch as $houses_fetch){
                $statement3 = $con -> prepare("SELECT * FROM tenants WHERE house_id = ?");
                $statement3 -> execute([$houses_fetch['id']]);
                $tenants_fetch = $statement3 -> fetchAll();
                if($tenants_fetch != null){
                    foreach($tenants_fetch as $tenants_fetch){
                        $statement4 = $con -> prepare("SELECT * FROM payment WHERE house_id = ? OR tenant_id = ?");
                        $statement4 -> execute([$houses_fetch['id'], $tenants_fetch['id']]);
                        $payment_fetch = $statement4 -> fetchAll();

                        $statement5 = $con -> prepare("SELECT * FROM rent WHERE house_size = ? AND rental_id = ?");
                        $statement5 -> execute([$houses_fetch['size'], $fetch_rental['id']]);
                        $rent_fetch = $statement5 -> fetch();
                        if($rent_fetch != null){
                            $expected_rent += $rent_fetch['amount'];
                        }

                        if($payment_fetch != null){
                            foreach($payment_fetch as $payment_fetch){
                                $month = date('m', strtotime($payment_fetch["for_month"], '1'));
                                $current_month = date('m');
                                if($month = $current_month){
                                    $rent_paid += $payment_fetch['amount'];
                                }
                            }
                        }
                    }
                }
            }
        }
        $rentals[] = $fetch_rental['name'];
        $collected[] = $rent_paid;
        $expected[] = $expected_rent;
    }
}
$combined = array(
    "rentals" => $rentals,
    "collected" => $collected,
    "expected" => $expected
);
echo json_encode($combined);