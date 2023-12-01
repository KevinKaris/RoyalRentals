<?php
session_start();

include 'connection.php';

if(isset($_POST['house_id'])){
    $house_id = $_POST['house_id'];
    $rental_id = $_SESSION['rental_id'];

    $select = "SELECT * FROM houses WHERE id = ? AND rental_id = ?";
    $st = $con -> prepare($select);
    $st-> execute([$house_id, $rental_id]);
    $fetch = $st -> fetch();

    $tenant = "SELECT * FROM tenants WHERE house_id = ?";
    $statement = $con -> prepare($tenant);
    $statement -> execute([$house_id]);
    $fetch2 = $statement -> fetch();

    $fine = "SELECT * FROM fined WHERE tenant_id = ?";
    $fn = $con -> prepare($fine);
    $fn -> execute([$fetch2['id']]);
    $fetch4 = $fn -> fetch();

    $query = "SELECT DISTINCT * FROM rent WHERE rental_id = ? AND house_size = ?";
    $st2 = $con -> prepare($query);
    $st2 -> execute([$rental_id, $fetch['size']]);
    $rent = $st2 -> fetch();

    $payment = "SELECT * FROM payment WHERE tenant_id = ? OR house_id = ?";
    $st3 = $con -> prepare($payment);
    $st3 -> execute([$fetch2["id"], $house_id]);
    $fetch3 = $st3 -> fetchAll();
    $rows = $st3 -> rowCount();
    $total_paid_rent = 0;
    if($rows > 0){
        foreach($fetch3 as $fetch3){
            // $timestamp = $fetch3["date"];
            // $date = date("Y-m-d",strtotime($timestamp));
            // $month = date("m", strtotime($date));
            $month = date('m', strtotime($fetch3["for_month"], '1'));
            $current_month = date('m');
            if($month == $current_month && $fetch3["for_year"] == date('Y')){
                $total_paid_rent += $fetch3["amount"];
            }
        }
    }

    //getting date differences
    $reg_date = $fetch2['date'];
    $reg = "SELECT YEAR(NOW()) - YEAR(STR_TO_DATE(?, '%Y-%m-%d')) AS years, MONTH(NOW()) - MONTH(STR_TO_DATE(?, '%Y-%m-%d')) AS months, DAY(NOW()) - DAY(STR_TO_DATE(?, '%Y-%m-%d')) AS days
    FROM tenants WHERE house_id = ?";
    $column = $con -> prepare($reg);
    $column -> execute([$reg_date, $reg_date, $reg_date, $fetch['id']]);
    $reg_fetch = $column -> fetch();

    $renting_time = 0;
    if($reg_fetch['years'] == 0 && $reg_fetch['months'] != 0){
        $renting_time = $reg_fetch['months'].' Months';
    }
    else if($reg_fetch['years'] == 0 && $reg_fetch['months'] == 0){
        $renting_time = $reg_fetch['days'].' Days';
    }
    else if($reg_fetch['years'] != 0){
        $renting_time = $reg_fetch['years'].' Years';
    }

    $house_status = $fetch['status'];
    $tenant_name = $fetch2['name'];
    $phone = '0'.$fetch2['phone'];
    $id = $fetch2['id_number'];
    $rent_amount = $rent['amount'];
    $balance = ($rent['amount'] - $total_paid_rent);
    $pictures;
    $first_pic;
    $second_pic;
    $fine2 = 0;
    $data;
    if($fetch4 !== false){
        $fine2 = $fetch4['amount'];
    }
    if($fetch2['id_photos'] != ''){
        $pictures = explode(',', $fetch2['id_photos']);
        $first_pic = $pictures[0];
        $second_pic = $pictures[1];
        
        $data = array(
            'house_status' => "$house_status",
            'tenant_name' => "$tenant_name",
            'phone' => "$phone",
            'id' => "$id",
            'rent' => "$rent_amount",
            'balance' => "$balance",
            'renting_time' => "$renting_time",
            'first_pic' => "$first_pic",
            'second_pic' => "$second_pic",
            'fine' => "$fine2"
        );
    }
    else{
        $data = array(
            'house_status' => "$house_status",
            'tenant_name' => "$tenant_name",
            'phone' => "$phone",
            'id' => "$id",
            'rent' => "$rent_amount",
            'balance' => "$balance",
            'renting_time' => "$renting_time",
            'first_pic' => "",
            'second_pic' => "",
            'fine' => "$fine2"
        );
    }

    $data = json_encode($data);
    echo $data;
}
?>