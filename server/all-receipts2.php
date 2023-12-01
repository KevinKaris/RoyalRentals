<?php
session_start();
include 'connection.php';

$rental_id = $_SESSION['rental_id'];

if($_POST['criteria'] == 'all'){
    //$tenant_id = $_POST['tenant_id'];
    $select = "SELECT * FROM tenants";
    $statement = $con -> prepare($select);
    $statement -> execute();
    $tenant = $statement -> fetchAll();
    $order = 0;
    foreach($tenant as $tenant){
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
        $order += 1;
        if($rows > 0){
            foreach($payment_fetch as $payment_fetch){
                // $timestamp = $payment_fetch["date"];
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
        //$randomNumber = mt_rand(1900, 9999); // Generate a random number between 10000 and 99999
        //$receiptNumber = $prefix . $timestamp. $order; //. $randomNumber;

        $receipt_number_sql = "SELECT * FROM receipts WHERE date = (SELECT MAX(date) FROM receipts) AND rental_id = ?";
        $run = $con -> prepare($receipt_number_sql);
        $run -> execute([$rental_id]);
        $run_fetch = $run -> fetch();
        $row_count = $run -> rowCount();

        if(!empty($_SESSION['receipt_number']) && isset($_SESSION['receipt_number'])){
            if($order == $row_count){
                //do nothing
                $_SESSION['receipt_number'] = $run_fetch['receipt_no'] + $row_count;
            }else{
                $_SESSION['receipt_number'] += 1;
            }
        }
        else{
            if($row_count > 0){
                $receiptNumber = $run_fetch['receipt_no'];
                $receiptNumber = $receiptNumber + 1;
                $_SESSION['receipt_number'] = $receiptNumber;
                $_SESSION['receipt_number'];
            }
            else{
                $receiptNumber = 10001;
                $_SESSION['receipt_number'] = $receiptNumber;
            }
        }

        $rental_name = $rental_fetch['name'];
        $location = $rental_fetch['county'].', '.$rental_fetch['location'];
        $telephone = $user_fetch['phone'];
        $receipt_number = $_SESSION['receipt_number'];
        $tenant_name = $tenant['name'];
        $tenant_phone = $tenant['phone'];
        $house_number = $house_fetch['number'];
        $amount_received = 'Ksh. '.$total_paid_rent;
        $balance = 'Ksh. '.($rent['amount'] - $total_paid_rent);
        $latest_payment = date("d-m-Y", $latest_date);
        $payment_for = date('M').'-'.date('Y');
        $current_date = date('d-m-Y');?>

        <a class="image-tile">
        <div id="receipt-sheet">
            <div id="receipt-inner">
                <h4 align="center"><?php echo $rental_name?></h4>
                <p id="row"><strong><?php echo $location?></strong><strong><?php echo 'Tel: 0'.$telephone?></strong></p>
                <section style="float: right; margin-right: 7px; font-size: 14px;"><strong>Date: </strong><?php echo $current_date?></section>
                <h6 id="row">Rent Payment Receipt <small class="row mx-1"><strong>Receipt No.&nbsp;</strong><p><?php echo $receipt_number?></p></small></h6>
                <div id="content">
                    <input type="hidden" value="Kevin Kariuki" id="tenant_name">
                    <p><strong>Tenant Name:</strong><?php echo ' '.$tenant_name?></p>
                    <p><strong>Phone Number:</strong><?php echo ' 0'.$tenant_phone?></p>
                    <p><strong>House Number:</strong><?php echo ' '.$house_number?></p>
                    <p id="row"><span><strong>Amount Received: </strong><?php echo $amount_received?></span><span><strong>Balance: </strong><?php echo $balance?></span></p>
                    <p id="row"><span><strong>Latest Payment Date: </strong><?php echo $latest_payment?></span><span><strong>Payment For : </strong><small style="font-size: 13px;" class="payment-for"><?php echo $payment_for?></small></span></p>
                </div>
                <span class="w-100 text-muted text-center d-block d-sm-inline-block m-0 p-0" style="font-size: 6px">Developed by melody</span>
            </div>
        </div>
    </a>
        <?php
    }
    unset($_SESSION['receipt_number']);
}
else if($_POST['criteria'] == 'bal'){
    //$tenant_id = $_POST['tenant_id'];
    $select = "SELECT * FROM tenants";
    $statement = $con -> prepare($select);
    $statement -> execute();
    $tenant = $statement -> fetchAll();
    $order = 0;
    foreach($tenant as $tenant){
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
                // $timestamp = $payment_fetch["date"];
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
        //$randomNumber = mt_rand(10000, 99999); // Generate a random number between 10000 and 99999
        //$receiptNumber = $prefix . $timestamp . $randomNumber;

        $receipt_number_sql = "SELECT * FROM receipts WHERE date = (SELECT MAX(date) FROM receipts) AND rental_id = ?";
        $run = $con -> prepare($receipt_number_sql);
        $run -> execute([$rental_id]);
        $run_fetch = $run -> fetch();
        $row_count = $run -> rowCount();

        if(!empty($_SESSION['receipt_number']) && isset($_SESSION['receipt_number'])){
            if($order == $row_count){
                //do nothing
                $_SESSION['receipt_number'] = $run_fetch['receipt_no'] + $row_count;
            }else{
                $_SESSION['receipt_number'] += 1;
            }
        }
        else{
            if($row_count > 0){
                $receiptNumber = $run_fetch['receipt_no'];
                $receiptNumber = $receiptNumber + 1;
                $_SESSION['receipt_number'] = $receiptNumber;
                $_SESSION['receipt_number'];
            }
            else{
                $receiptNumber = 10001;
                $_SESSION['receipt_number'] = $receiptNumber;
            }
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
        $balance2 = ($rent['amount'] - $total_paid_rent);

        if($balance2 > 0){
        ?>
        <a class="image-tile">
        <div id="receipt-sheet">
            <div id="receipt-inner">
                <h4 align="center"><?php echo $rental_name?></h4>
                <p id="row"><strong><?php echo $location?></strong><strong><?php echo 'Tel: 0'.$telephone?></strong></p>
                <section style="float: right; margin-right: 7px; font-size: 14px;"><strong>Date: </strong><?php echo $current_date?></section>
                <h6 id="row">Rent Payment Receipt <small class="row mx-1"><strong>Receipt No.&nbsp;</strong><p><?php echo $receiptNumber?></p></small></h6>
                <div id="content">
                    <input type="hidden" value="Kevin Kariuki" id="tenant_name">
                    <p><strong>Tenant Name:</strong><?php echo ' '.$tenant_name?></p>
                    <p><strong>Phone Number:</strong><?php echo ' 0'.$tenant_phone?></p>
                    <p><strong>House Number:</strong><?php echo ' '.$house_number?></p>
                    <p id="row"><span><strong>Amount Received: </strong><?php echo $amount_received?></span><span><strong>Balance: </strong><?php echo $balance?></span></p>
                    <p id="row"><span><strong>Latest Payment Date: </strong><?php echo $latest_payment?></span><span><strong>Payment For: </strong><small style="font-size: 13px;" class="payment-for"><?php echo $payment_for?></small></span></p>
                </div>
                <span class="w-100 text-muted text-center d-block d-sm-inline-block m-0 p-0" style="font-size: 6px">Developed by melody</span>
            </div>
        </div>
        </a>
        <?php
        }
    }
    unset($_SESSION['receipt_number']);
}
else if($_POST['criteria'] == 'wbal'){
    //$tenant_id = $_POST['tenant_id'];
    $select = "SELECT * FROM tenants";
    $statement = $con -> prepare($select);
    $statement -> execute();
    $tenant = $statement -> fetchAll();
    $order = 0;
    foreach($tenant as $tenant){
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
                // $timestamp = $payment_fetch["date"];
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
        //$randomNumber = mt_rand(10000, 99999); // Generate a random number between 10000 and 99999
        //$receiptNumber = $prefix . $timestamp . $randomNumber;

        $receipt_number_sql = "SELECT * FROM receipts WHERE date = (SELECT MAX(date) FROM receipts) AND rental_id = ?";
        $run = $con -> prepare($receipt_number_sql);
        $run -> execute([$rental_id]);
        $run_fetch = $run -> fetch();
        $row_count = $run -> rowCount();

        if(!empty($_SESSION['receipt_number']) && isset($_SESSION['receipt_number'])){
            if($order == $row_count){
                //do nothing
                $_SESSION['receipt_number'] = $run_fetch['receipt_no'] + $row_count;
            }else{
                $_SESSION['receipt_number'] += 1;
            }
        }
        else{
            if($row_count > 0){
                $receiptNumber = $run_fetch['receipt_no'];
                $receiptNumber = $receiptNumber + 1;
                $_SESSION['receipt_number'] = $receiptNumber;
                $_SESSION['receipt_number'];
            }
            else{
                $receiptNumber = 10001;
                $_SESSION['receipt_number'] = $receiptNumber;
            }
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
        $balance2 = ($rent['amount'] - $total_paid_rent);

        if($balance2 <= 0){
        ?>
        <a class="image-tile">
        <div id="receipt-sheet">
            <div id="receipt-inner">
                <h4 align="center"><?php echo $rental_name?></h4>
                <p id="row"><strong><?php echo $location?></strong><strong><?php echo 'Tel: 0'.$telephone?></strong></p>
                <section style="float: right; margin-right: 7px; font-size: 14px;"><strong>Date: </strong><?php echo $current_date?></section>
                <h6 id="row">Rent Payment Receipt <small class="row mx-1"><strong>Receipt No.&nbsp;</strong><p><?php echo $receiptNumber?></p></small></h6>
                <div id="content">
                    <input type="hidden" value="Kevin Kariuki" id="tenant_name">
                    <p><strong>Tenant Name:</strong><?php echo ' '.$tenant_name?></p>
                    <p><strong>Phone Number:</strong><?php echo ' 0'.$tenant_phone?></p>
                    <p><strong>House Number:</strong><?php echo ' '.$house_number?></p>
                    <p id="row"><span><strong>Amount Received: </strong><?php echo $amount_received?></span><span><strong>Balance: </strong><?php echo $balance?></span></p>
                    <p id="row"><span><strong>Latest Payment Date: </strong><?php echo $latest_payment?></span><span><strong>Payment For: </strong><small style="font-size: 13px;" class="payment-for"><?php echo $payment_for?></small></span></p>
                </div>
                <span class="w-100 text-muted text-center d-block d-sm-inline-block m-0 p-0" style="font-size: 6px">Developed by melody</span>
            </div>
        </div>
        </a>
        <?php
        }
    }
    unset($_SESSION['receipt_number']);
}
?>