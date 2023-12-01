<?php
include 'connection.php';

if(isset($_POST['user_id'])){
    $user_id = $_POST['user_id'];

    $SELECT = "SELECT photo FROM users WHERE id = ?";
    $st = $con -> prepare($SELECT);
    $st -> execute([$user_id]);
    $fetch = $st -> fetch();

    $photo = $fetch['photo'];

    $UPDATE = "UPDATE users SET photo = null WHERE id = ?";
    $st2 = $con -> prepare($UPDATE);
    $run = $st2 -> execute([$user_id]);

    if($run == true){
        if(unlink('../images/profile-photos/'.$photo)){
            echo '1';
        }
    }
}