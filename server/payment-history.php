<?php
session_start();
include 'connection.php';

$sql= "SELECT * FROM houses WHERE rental_id = ?";
$rental_id = $_SESSION["rental_id"];
$statement = $con -> prepare($sql);
$statement -> execute([$rental_id]);
$fetch = $statement -> fetchAll();
$order = 0;
foreach($fetch as $fetch){
    $house_id = $fetch["id"];
    $select = "SELECT * FROM tenants";
    $st = $con -> prepare($select);
    $st -> execute();
    $fetch2 = $st -> fetchAll();
    foreach($fetch2 as $fetch2){
        $house_id2 = $fetch2["house_id"];
        if($house_id == $house_id2){
            $payment = "SELECT * FROM payment WHERE tenant_id = ? OR house_id = ?";
            $st3 = $con -> prepare($payment);
            $st3 -> execute([$fetch2["id"], $house_id2]);
            $fetch3 = $st3 -> fetchAll();
            $rows = $st3 -> rowCount();
            if($rows > 0){
                foreach($fetch3 as $fetch3){
                    $order += 1;
                    $date = date("d-m-Y",strtotime($fetch3['date']));?>
                    <tr>
                        <td><?php echo 'P-'.$order?></td>
                        <td><?php echo $fetch['number']?></td>
                        <td><?php echo $fetch2['name']?></td>
                        <td><?php echo $fetch3['amount']?></td>
                        <td><?php echo $fetch3['for_month'].'-'.$fetch3['for_year']?></td>
                        <td><?php echo $date?></td>
                        <!-- <td class="text-right">
                            <button class="btn btn-light delete" value="<?php //echo $fetch3['id']?>">
                                <i class="fa fa-times text-danger"></i>Delete
                            </button>
                        </td> -->
                    </tr>
                    <?php
                }
            }
        }
    }
}