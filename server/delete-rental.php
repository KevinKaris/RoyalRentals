<?php
session_start();

include 'connection.php';
if(isset($_POST['rental_id'])){
    $rental_id = $_POST['rental_id'];

    $delete_receipts = "DELETE FROM receipts WHERE rental_id = ?";
    $st6 = $con -> prepare($delete_receipts);
    $st6 -> execute([$rental_id]);

    $delete_rent = "DELETE FROM rent WHERE rental_id = ?";
    $st7 = $con -> prepare($delete_rent);
    $st7 -> execute([$rental_id]);

    $delete_expenses = "DELETE FROM expenses WHERE rental_id = ?";
    $st8 = $con -> prepare($delete_expenses);
    $st8 -> execute([$rental_id]);

    $select_user = "SELECT * FROM users WHERE rental_id = ?";
    $st10 = $con -> prepare($select_user);
    $st10 -> execute([$rental_id]);
    $fetch3 = $st10 -> fetch();

    $houses = "SELECT * FROM houses WHERE rental_id = ?";
    $st = $con -> prepare($houses);
    $st -> execute([$rental_id]);
    $fetch = $st ->fetchAll();
    foreach($fetch as $fetch){
        $delete_payment = "DELETE FROM payment WHERE house_id = ?";
        $st5 = $con -> prepare($delete_payment);
        $st5 -> execute([$fetch['id']]);

        $tenant = "SELECT * FROM tenants WHERE house_id = ?";
        $st2 = $con -> prepare($tenant);
        $st2 -> execute([$fetch['id']]);
        $fetch2 = $st2 -> fetchAll();
        foreach($fetch2 as $fetch2){
            $delete_todo = "DELETE FROM todo WHERE user_id = ?";
            $st16 = $con -> prepare($delete_todo);
            $st16 -> execute([$fetch2['id']]);

            $delete_notification = "DELETE FROM notifications WHERE user_id = ?";
            $st11 = $con -> prepare($delete_notification);
            if($st11 -> execute([$fetch3['id']])){
                $delete_user = "DELETE FROM users WHERE rental_id = ?";
                $st12 = $con -> prepare($delete_user);
                $st12 -> execute([$rental_id]);
                $path = "../images/profile-photos/" . $fetch3['photo'];
                unlink($path);
            }

            $delete_payment2 = "DELETE FROM payment WHERE tenant_id = ?";
            $st4 = $con -> prepare($delete_payment2);
            $st4 -> execute([$fetch2['id']]);

            $delete_fined = "DELETE FROM fined WHERE tenant_id = ?";
            $st9 = $con -> prepare($delete_fined);
            $st9 -> execute([$fetch2['id']]);

            $delete_tenant = "DELETE FROM tenants WHERE id = ?";
            $st13 = $con -> prepare($delete_tenant);
            $st13 -> execute([$fetch2['id']]);

            if($fetch2['id_photos'] != ''){
                $string = explode(',', $fetch2['id_photos']);
                for ($i = 0; $i < count($string); $i++) {
                    $path = "../" . $string[$i];
                    unlink($path);
                }
            }
        }
        $delete_house = "DELETE FROM houses WHERE id = ?";
        $st14 = $con -> prepare($delete_house);
        $st14 -> execute([$fetch['id']]);
    }
    $delete_rental = "DELETE FROM rentals WHERE id = ?";
    $st15 = $con -> prepare($delete_rental);
    if($st15 -> execute([$rental_id])){
        echo '1';
    }
}