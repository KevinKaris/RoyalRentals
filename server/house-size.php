<?php
session_start();
include 'connection.php';

if(!empty($_GET["size"])){
    $size = $_GET["size"];
    $rental_id = $_SESSION["rental_id"];

    $sql = "SELECT * FROM houses WHERE size = ? AND rental_id = ? AND status = ?";
    $run = $con -> prepare($sql);
    $run -> execute([$size, $rental_id, 'Okay']);
    $column = $run -> fetchAll();
    $rows = $run-> rowCount();
    if($rows > 0){
    ?>
    <option>--select house number--</option>
<?php
    foreach($column as $column){
        $select = "SELECT house_id FROM tenants WHERE house_id = ? AND size = ?";
        $st = $con -> prepare($select);
        $house_id = $column['id'];
        $house_size = $column['size'];
        $st -> execute([$house_id, $house_size]);
        $st -> fetchAll();
        $count = $st -> rowCount();

        if($count == 0){?>
        <option value="<?php echo $column['id'] ?>"><?php echo $column['number']?></option>
        <?php
        }
    }
}
}
?>