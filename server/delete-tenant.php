<?php
include 'connection.php';
if(isset($_POST['tenant_id'])){
    $tenant_id = $_POST['tenant_id'];

    //delete in fined table
    $delete = "DELETE FROM fined WHERE tenant_id = ?";
    $st = $con -> prepare($delete);
    $st -> execute([$tenant_id]);

    //taking house number
    $select = "SELECT * FROM tenants WHERE id = ?";
    $st2 = $con -> prepare($select);
    $st2 -> execute([$tenant_id]);
    $fetch = $st2 -> fetch();

    //delete in payment table
    $delete2 = "DELETE FROM payment WHERE tenant_id = ? OR house_id = ?";
    $st3 = $con -> prepare($delete2);
    $st3 -> execute([$tenant_id, $fetch['house_id']]);

    //delete in tenants table
    $select = "SELECT * FROM tenants WHERE id = ?";
    $select_st = $con -> prepare($select);
    $select_st -> execute([$tenant_id]);
    $fetch2 = $select_st -> fetch();
    if($fetch2['id_photos'] != ''){
        $string = explode(',', $fetch2['id_photos']);
        for ($i = 0; $i < count($string); $i++) {
            $path = "../" . $string[$i];
            unlink($path);
        }
    }

    $delete3 = "DELETE FROM tenants WHERE id = ?";
    $st4 = $con -> prepare($delete3);
    if($st4 -> execute([$tenant_id])){
        echo '1';
    }
}
?>