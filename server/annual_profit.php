<?php
session_start();
include 'connection.php';

$user_id = $_SESSION["user_id"];

$sql = "SELECT * FROM rentals WHERE user_id = ?";
$statement = $con -> prepare($sql);
$statement -> execute([$user_id]);
$rows = $statement -> rowCount();
$fetch_rental = $statement -> fetchAll();
$rent_paid = 0;
$total_expenses = 0;
$Jan = 0;$Feb = 0;$Mar = 0;$Apr = 0;$May = 0;$Jun = 0;$Jul = 0;$Aug = 0;$Sep = 0;$Oct = 0;$Nov = 0;$Dec = 0;
$Jan_exp = 0;$Feb_exp = 0;$Mar_exp = 0;$Apr_exp = 0;$May_exp = 0;$Jun_exp = 0;$Jul_exp = 0;$Aug_exp = 0;$Sep_exp = 0;$Oct_exp = 0;$Nov_exp = 0;$Dec_exp = 0;
if($rows > 0){
    foreach($fetch_rental as $fetch_rental){
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

                        if($payment_fetch != null){
                            foreach($payment_fetch as $payment_fetch){
                                $month = date('m', strtotime($payment_fetch["for_month"], '1'));
                                $current_month = date('m');
                                if($month == 1 && $payment_fetch["for_year"] == date('Y')){
                                    $Jan +=$payment_fetch['amount'];
                                }elseif ($month == 2 && $payment_fetch["for_year"] == date('Y')) {
                                    $Feb += $payment_fetch['amount'];
                                } elseif ($month == 3 && $payment_fetch["for_year"] == date('Y')) {
                                    $Mar += $payment_fetch['amount'];
                                } elseif ($month == 4 && $payment_fetch["for_year"] == date('Y')) {
                                    $Apr += $payment_fetch['amount'];
                                } elseif ($month == 5 && $payment_fetch["for_year"] == date('Y')) {
                                    $May += $payment_fetch['amount'];
                                } elseif ($month == 6 && $payment_fetch["for_year"] == date('Y')) {
                                    $Jun += $payment_fetch['amount'];
                                } elseif ($month == 7 && $payment_fetch["for_year"] == date('Y')) {
                                    $Jul += $payment_fetch['amount'];
                                } elseif ($month == 8 && $payment_fetch["for_year"] == date('Y')) {
                                    $Aug += $payment_fetch['amount'];
                                } elseif ($month == 9 && $payment_fetch["for_year"] == date('Y')) {
                                    $Sep += $payment_fetch['amount'];
                                } elseif ($month == 10 && $payment_fetch["for_year"] == date('Y')) {
                                    $Oct += $payment_fetch['amount'];
                                } elseif ($month == 11 && $payment_fetch["for_year"] == date('Y')) {
                                    $Nov += $payment_fetch['amount'];
                                } elseif ($month == 12 && $payment_fetch["for_year"] == date('Y')) {
                                    $Dec += $payment_fetch['amount'];
                                }
                            }
                        }
                    }
                }
            }
        }
        $statement5 = $con -> prepare("SELECT * FROM expenses WHERE rental_id = ?");
        $statement5 -> execute([$fetch_rental['id']]);
        $expense_fetch = $statement5 -> fetchAll();
        foreach($expense_fetch as $expense_fetch){
            $year = date('Y', strtotime($expense_fetch["date"]));
            $exp_month = date('m', strtotime($expense_fetch["date"]));

            if($exp_month == 1 && $year == date('Y')){
                $Jan_exp +=$expense_fetch['amount'];
            }elseif ($exp_month == 2 && $year == date('Y')) {
                $Feb_exp += $expense_fetch['amount'];
            } elseif ($exp_month == 3 && $year == date('Y')) {
                $Mar_exp += $expense_fetch['amount'];
            } elseif ($exp_month == 4 && $year == date('Y')) {
                $Apr_exp += $expense_fetch['amount'];
            } elseif ($exp_month == 5 && $year == date('Y')) {
                $May_exp += $expense_fetch['amount'];
            } elseif ($exp_month == 6 && $year == date('Y')) {
                $Jun_exp += $expense_fetch['amount'];
            } elseif ($exp_month == 7 && $year == date('Y')) {
                $Jul_exp += $expense_fetch['amount'];
            } elseif ($exp_month == 8 && $year == date('Y')) {
                $Aug_exp += $expense_fetch['amount'];
            } elseif ($exp_month == 9 && $year == date('Y')) {
                $Sep_exp += $expense_fetch['amount'];
            } elseif ($exp_month == 10 && $year == date('Y')) {
                $Oct_exp += $expense_fetch['amount'];
            } elseif ($exp_month == 11 && $year == date('Y')) {
                $Nov_exp += $expense_fetch['amount'];
            } elseif ($exp_month == 12 && $year == date('Y')) {
                $Dec_exp += $expense_fetch['amount'];
            }
        }
    }
}
$collected = [$Jan, $Feb, $Mar, $Apr, $May, $Jun, $Jul, $Aug, $Sep, $Oct, $Nov, $Dec];
$profit = [$Jan - $Jan_exp, $Feb-$Feb_exp, $Mar-$Mar_exp, $Apr-$Apr_exp, $May-$May_exp, $Jun-$Jun_exp, $Jul-$Jul_exp, $Aug-$Aug_exp, $Sep-$Sep_exp, $Oct-$Oct_exp, $Nov-$Nov_exp, $Dec-$Dec_exp];

$array = [
    "collected" => $collected,
    "profit" => $profit
];
$array = json_encode($array);
echo $array;