<?php
session_start();
include 'connection.php';

if(isset($_POST['text'])){
    $text = $_POST['text'];
    $user_id = $_SESSION["user_id"];

    $INSERT = "INSERT INTO todo (user_id, text) VALUES (?, ?)";
    $statement = $con -> prepare($INSERT);

    if($statement -> execute([$user_id, $text])){
        $SELECT = "SELECT * FROM todo WHERE text = ? AND user_id = ?";
        $statement2 = $con -> prepare($SELECT);
        $statement2 -> execute([$text, $user_id]);
        $fetch = $statement2 -> fetch();?>
        <li>
        <div class="form-check">
        <label class="form-check-label">
            <input class="checkbox" type="checkbox" value="<?php echo $fetch['id']?>" /><?php echo $fetch['text']?><i class='input-helper'></i>
        </label>
        </div>
        <i class="remove fa fa-times-circle delete-todo"><input type="hidden" value="<?php echo $fetch['id']?>"></i>
    </li>
    <?php
    }
}