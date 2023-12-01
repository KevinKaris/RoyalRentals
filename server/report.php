<?php
session_start();

include 'connection.php';
if(isset($_GET['rental'])){
    $rental_id = $_GET['rental'];
    $month = $_GET['month'];
    $year = $_GET['year'];

    $rental= "SELECT * FROM rentals WHERE id = ?";
    $st5 = $con -> prepare($rental);
    $st5 -> execute([$rental_id]);
    $fetch5 = $st5 -> fetch();

    $sql= "SELECT * FROM houses WHERE rental_id = ?";
    $statement = $con -> prepare($sql);
    $statement -> execute([$rental_id]);
    $fetch = $statement -> fetchAll();
    $total_rent = 0;
    $total_paid = 0;?>
    <tr class="report-hidden"><td><h4>Monthly Report</h4></td><td></td><td></td><td></td><td></td><td></td></tr>
    <tr class="report-hidden"><td><b><?php echo 'Rental: '.$fetch5['name']?></b></td><td></td><td></td><td></td><td></td><td></td></tr>
    <tr class="report-hidden"><td><b><?php echo 'Report for: '.$month.'-'.$year?></b></td><td></td><td></td><td></td><td></td><td></td></tr>
    <tr></tr>
    <tr class="bg-primary text-white">
        <th>Tenant</th>
        <th>House No</th>
        <th>House Size</th>
        <th>Rent</th>
        <th>Paid</th>
        <th>Balance</th>
    </tr>
    <?php
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

                //payment
                $payment = "SELECT * FROM payment WHERE tenant_id = ? OR house_id = ?";
                $st3 = $con -> prepare($payment);
                $st3 -> execute([$fetch2["id"], $fetch['id']]);
                $fetch3 = $st3 -> fetchAll();
                $rows = $st3 -> rowCount();
                $paid = 0;
                if($rows > 0){
                    foreach($fetch3 as $fetch3){
                        $month2 = $fetch3["for_month"];
                        $year2 = $fetch3['for_year'];
                        if($month == $month2 && $year2 == $year){
                            $paid += $fetch3["amount"];
                            $total_paid += $fetch3["amount"];
                        }
                    }
                }

                //rent
                $rent = "SELECT DISTINCT * FROM rent WHERE rental_id = ? AND house_size = ?";
                $st4 = $con -> prepare($rent);
                $st4 -> execute([$rental_id, $house_size]);
                $fetch4 = $st4 -> fetch();
                $total_rent += $fetch4['amount'];?>
                <tr>
                    <td><?php echo $fetch2['name']?><input class="rental_name_hidden" type="hidden" value="<?php echo $fetch5['name']?>"></td>
                    <td><?php echo $fetch['number']?></td>
                    <td><?php echo $house_size?></td>
                    <td><?php echo $fetch4['amount']?></td>
                    <td><?php echo $paid?></td>
                    <td><?php echo $fetch4['amount'] - $paid?></td>
                </tr>
                <?php
            }
        }
    }?>
    <tr></tr>
    <tr class="report-hidden">
        <td><b>Totals:</b></td>
        <td></td>
        <td></td>
        <td><b><?php echo $total_rent?></b></td>
        <td><b><?php echo $total_paid?></b></td>
        <td><b><?php echo $total_rent - $total_paid?></b></td>
    </tr>
    <tr class="report-hidden"><td><i>Printed by:<?php echo ' '.$_SESSION['username']?></i></td><td></td><td></td><td></td><td></td><td></td></tr>
    <tr class="report-hidden"><td><?php echo '© '.date('Y').' RoyalRentals'?></td><td></td><td></td><td></td><td></td><td></td></tr>
    <?php
}