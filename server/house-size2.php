<?php
session_start();
include 'connection.php';

if(!empty($_SESSION["rental_id"])){
    $rental_id = $_SESSION["rental_id"];

    $sql = "SELECT * FROM houses WHERE rental_id = ? AND status = ?";
    $run = $con -> prepare($sql);
    $run -> execute([$rental_id, 'Okay']);
    $column = $run -> fetchAll();
    $rows = $run-> rowCount();
    if($rows > 0){
    ?>
    <option>--select house number--</option>
<?php
    foreach($column as $column){
        $select = "SELECT house_id FROM tenants WHERE house_id = ?";
        $st = $con -> prepare($select);
        $house_id = $column['id'];
        $st -> execute([$house_id]);
        $st -> fetchAll();
        $count = $st -> rowCount();

        if($count > 0){?>
        <option value="<?php echo $column['id'] ?>"><?php echo $column['number']?></option>
        <?php
        }
    }
}
}
?>