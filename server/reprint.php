<?php
include 'connection.php';
if(isset($_GET['receipt_id'])){
    $receipt_id = $_GET['receipt_id'];
    $sql = "SELECT * FROM receipts WHERE id = ?";
    $st = $con -> prepare($sql);
    $st -> execute([$receipt_id]);
    $fetch = $st -> fetch();?>

    <div id="receipt-sheet">
            <div id="receipt-inner">
                <h4 align="center"><?php echo $fetch['rental_name']?></h4>
                <p id="row"><strong><?php echo $fetch['location']?></strong><strong><?php echo $fetch['tel']?></strong></p>
                <section style="float: right; margin-right: 7px; font-size: 14px;"><strong>Date: </strong><?php $date = date("Y-m-d",strtotime($fetch['date'])); echo $date?></section>
                <h6 id="row">Rent Payment Receipt <small class="row mx-1"><strong>Receipt No.&nbsp;</strong><p><?php echo ''. $fetch['receipt_no']?></p></small></h6>
                <div id="content">
                    <input type="hidden" id="tenant_name" value="<?php echo $fetch['tenant_name']?>">
                    <p><strong>Tenant Name:</strong><?php echo ' '.$fetch['tenant_name']?></p>
                    <p><strong>Phone Number:</strong><?php echo ' '.$fetch['tenant_phone']?></p>
                    <p><strong>House Number:</strong><?php echo ' '.$fetch['house_number']?></p>
                    <p id="row"><span><strong>Amount Received: </strong><?php echo $fetch['amount_received']?></span><span><strong>Balance: </strong><?php echo $fetch['balance']?></span></p>
                    <p id="row"><span><strong>Latest Payment Date: </strong><?php echo $fetch['latest_payment']?></span><span><strong>Payment For : </strong><small style="font-size: 13px;" class="payment-for"><?php echo $fetch['payment_for']?></small></span></p>
                </div>
                <span class="w-100 text-muted text-center d-block d-sm-inline-block m-0 p-0" style="font-size: 10px">Developed by melody</span>
            </div>
        </div>
        <?php
}
?>