<?php
include 'connection.php';
if(isset($_POST['house_id'])){
    $house_id = $_POST['house_id'];

    $delete = "DELETE FROM houses WHERE id = ?";
    $st = $con -> prepare($delete);
    $st -> execute([$house_id]);
    echo '1';
}
?>