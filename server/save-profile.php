<?php
session_start();
include 'connection.php';

if(isset($_POST['f_name']) && isset($_POST['l_name']) && isset($_POST['username']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['password']) && !isset($_POST['image'])){
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $rental_id = $_SESSION['rental_id'];
    $user_id = $_SESSION["user_id"];

    $sql = "UPDATE users SET f_name = ?, l_name = ?, username = ?, phone = ?, email = ?, password = ? WHERE id = ? AND rental_id = ?";

    $statement = $con -> prepare($sql);
    $data = [$f_name, $l_name, $username, $phone, $email, $password, $user_id, $rental_id];
    $st = $statement -> execute($data);

    if($st !== false){
        echo '1';
    }
    else{
        echo '0';
    }
}
else if(isset($_POST['f_name']) && isset($_POST['l_name']) && isset($_POST['username']) && isset($_POST['phone']) && isset($_POST['email']) && !isset($_POST['password']) && !isset($_POST['image'])){
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $rental_id = $_SESSION['rental_id'];
    $user_id = $_SESSION["user_id"];

    $sql = "UPDATE users SET f_name = ?, l_name = ?, username = ?, phone = ?, email = ? WHERE id = ? AND rental_id = ?";

    $statement = $con -> prepare($sql);
    $data = [$f_name, $l_name, $username, $phone, $email, $user_id, $rental_id];
    $st = $statement -> execute($data);

    if($st !== false){
        echo '1';
    }
    else{
        echo '0';
    }
}
else if(isset($_POST['image'])){
    //editing image name
    // $modifier = md5(time());

    // //image resizing function
    // function compressImage($source, $destination, $quality)
    // {
    //     $imgInfo = getimagesize($source);
    //     $dataMine = $imgInfo['mime'];

    //     switch ($dataMine) {
    //         case 'image/jpeg':
    //             $image = imagecreatefromjpeg($source);
    //             break;
    //         case 'image/png':
    //             $image = imagecreatefrompng($source);
    //             break;
    //         case 'image/webp':
    //             $image = imagecreatefromwebp($source);
    //             break;
    //         case 'image/jpg':
    //             $image = imagecreatefromjpeg($source);
    //             break;
    //         default:
    //             $image = imagecreatefromjpeg($source);
    //     }

    //     imagejpeg($image, $destination, $quality);

    //     // final Return compressed image 
    //     return $destination;
    // }

    //$image_name = $modifier.$_FILES['image']['name'];
    //$target_directory = "../images/profile-photos/" . $image_name;
    //$stored_directory = $image_name;

    //compress image
    //$compressedImage = compressImage($_FILES['image']['tmp_name'], $target_directory, 30);

    $base64data = $_POST['image'];
    $filename = md5(time()).$_POST['filename'];

    // Decode base64 data
    $decodedData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64data));

    // Specify the folder where you want to save the image
    $folder = '../images/profile-photos/';

    // Save the file
    $filePath = $folder . $filename;

    $rental_id = $_SESSION['rental_id'];
    $user_id = $_SESSION["user_id"];

    $SELECT = "SELECT photo FROM users WHERE id = ? AND rental_id = ?";
    $statement2 = $con -> prepare($SELECT);
    $statement2 -> execute([$user_id, $rental_id]);
    $fetch = $statement2 -> fetch();
    $previous_photo = '';

     if($fetch['photo'] != null){
        $previous_photo = $fetch['photo'];
     }
    
    $sql = "UPDATE users SET photo = ? WHERE id = ? AND rental_id = ?";
    $statement = $con -> prepare($sql);
    $st = $statement -> execute([$filename, $user_id, $rental_id]);
    file_put_contents($filePath, $decodedData);
    if($st !== false){
        if($previous_photo != ''){
            unlink('../images/profile-photos/'.$previous_photo);
        }
        echo $filename;
    }
}