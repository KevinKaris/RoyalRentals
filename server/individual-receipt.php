<?php
session_start();
include 'connection.php';

$rental_id = $_SESSION['rental_id'];
if(isset($_POST['tenant_id'])){
    $tenant_id = $_POST['tenant_id'];
    $select = "SELECT * FROM tenants WHERE id = ?";
    $statement = $con -> prepare($select);
    $statement -> execute([$tenant_id]);
    $tenant = $statement -> fetch();

    $house = "SELECT * FROM houses WHERE id = ?";
    $st = $con -> prepare($house);
    $st -> execute([$tenant['house_id']]);
    $house_fetch = $st -> fetch();

    $rental = "SELECT * FROM rentals WHERE id = ?";
    $statement2 = $con -> prepare($rental);
    $statement2 -> execute([$rental_id]);
    $rental_fetch = $statement2 -> fetch();

    $query = "SELECT DISTINCT * FROM rent WHERE rental_id = ? AND house_size = ?";
    $st2 = $con -> prepare($query);
    $st2 -> execute([$rental_id, $house_fetch['size']]);
    $rent = $st2 -> fetch();

    $user = "SELECT * FROM users WHERE user_group =? AND rental_id = ?";
    $statement3 = $con -> prepare($user);
    $statement3 -> execute([2 ,$rental_id]);
    $user_fetch = $statement3 -> fetch();

    $payment = "SELECT * FROM payment WHERE tenant_id = ? OR house_id = ? AND rent = ?";
    $st3 = $con -> prepare($payment);
    $st3 -> execute([$tenant["id"], $house_fetch['id'], $rent['amount']]);
    $payment_fetch = $st3 -> fetchAll();
    $rows = $st3 -> rowCount();
    $total_paid_rent = 0;
    $latest_date = null;
    if($rows > 0){
        foreach($payment_fetch as $payment_fetch){
            $timestamp = $payment_fetch["date"];
            // $date = date("Y-m-d",strtotime($timestamp));
            // $month = date("m", strtotime($date));
            $month = date('m', strtotime($payment_fetch["for_month"], '1'));
            $current_month = date('m');
            if($month == $current_month && $payment_fetch["for_year"] == date('Y')){
              $total_paid_rent += $payment_fetch["amount"];
              if(strtotime($timestamp) > $latest_date){
                $latest_date = strtotime($timestamp);
              }
            }
        }
    }


    //generating receipt number
    //$prefix = "R"; // You can customize the prefix
    //$timestamp = time(); // Current Unix timestamp
    //$randomNumber = mt_rand(1000, 9999); // Generate a random number between 10000 and 99999
    $receipt_number_sql = "SELECT * FROM receipts WHERE date = (SELECT MAX(date) FROM receipts) AND rental_id = ?";
    $run = $con -> prepare($receipt_number_sql);
    $run -> execute([$rental_id]);
    $run_fetch = $run -> fetch();
    $row_count = $run -> rowCount();

    if($row_count > 0){
      $receiptNumber = $run_fetch['receipt_no'];
      $receiptNumber = (int)$receiptNumber + 1;
    }
    else{
      $receiptNumber = '10001';
    }

    $rental_name = $rental_fetch['name'];
    $location = $rental_fetch['county'].', '.$rental_fetch['location'];
    $telephone = $user_fetch['phone'];
    $receipt_number = $receiptNumber;
    $tenant_name = $tenant['name'];
    $tenant_phone = $tenant['phone'];
    $house_number = $house_fetch['number'];
    $amount_received = 'Ksh. '.$total_paid_rent;
    $balance = 'Ksh. '.($rent['amount'] - $total_paid_rent);
    $latest_payment = date("d-m-Y", $latest_date);
    $payment_for = date('M').'-'.date('Y');
    $current_date = date('d-m-Y');

    $data =  array(
        'rental_name' => "$rental_name",
        'location' => "$location",
        'tel' => "$telephone",
        'receipt_number' => "$receipt_number",
        'tenant_name' => "$tenant_name",
        'tenant_phone' => "$tenant_phone",
        'house_number' => "$house_number",
        'amount' => "$amount_received",
        'balance' => "$balance",
        'latest_payment' => "$latest_payment",
        'payment_for' => "$payment_for",
        'date' => "$current_date"
    );

    echo json_encode($data);
}
?>