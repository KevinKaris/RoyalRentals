<?php
include "connection.php";

//fetching sub counties
if(!empty($_GET["county"]) && isset($_GET["county"])){
$county = $_GET["county"];

$sql = "SELECT sub_county FROM locations WHERE county LIKE ?";
$statement = $con -> prepare($sql);
$statement -> execute([$county]);
$details = $statement -> fetchAll();?>

<option value="">--select sub county--</option>
<?php
foreach($details as $details){?>
    <option value="<?php echo $details["sub_county"]?>"><?php echo $details["sub_county"]?></option>
<?php
}
}
//for fetching wards
if(!empty($_GET["sub_county"]) && isset($_GET["sub_county"])){
    $sub_county = $_GET["sub_county"];

    $sql = "SELECT ward FROM locations WHERE sub_county LIKE ?";
    $statement = $con -> prepare($sql);
    $statement -> execute([$sub_county]);
    $details = $statement -> fetchAll();?>

    <option value="">--select ward--</option>
    <?php
    foreach($details as $details){?>
        <option value="<?php echo $details["ward"]?>"><?php echo $details["ward"]?></option>
<?php
    }
}?>