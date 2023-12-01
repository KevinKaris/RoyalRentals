<?php
include 'connection.php';
  if(isset($_POST["register"])){
    $name = $_POST["name"];
    $id_number = $_POST["id_number"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $house_id = $_POST["house_id"];
    $size = $_POST["size"];

    $select = "SELECT * FROM tenants WHERE phone = ? OR email = ? OR id_number = ?";
    $statement = $con -> prepare($select);
    $data = [$phone, $email, $id_number];
    $statement -> execute($data);
    $rows = $statement -> rowCount();
    $details = $statement -> fetch();
    if($rows == 0){
      try{
        //image resizing function
        function compressImage($source, $destination, $quality)
        {
            $imgInfo = getimagesize($source);
            $dataMine = $imgInfo['mime'];

            switch ($dataMine) {
                case 'image/jpeg':
                    $image = imagecreatefromjpeg($source);
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($source);
                    break;
                case 'image/webp':
                    $image = imagecreatefromwebp($source);
                    break;
                case 'image/jpg':
                    $image = imagecreatefromjpeg($source);
                    break;
                default:
                    $image = imagecreatefromjpeg($source);
            }

            imagejpeg($image, $destination, $quality);

            // final Return compressed image 
            return $destination;
        }

        //image name modifier
        $modifier = md5(time());

        if(count($_FILES['id_photos']['name']) > 0 && is_array($_FILES['id_photos']['name']) && $_FILES['id_photos']['name'][0] != ''){
            for ($i = 0; $i < count($_FILES['id_photos']['name']); $i++) {

                $image_name1 = $_FILES['id_photos']['name'];
                $target_directory = "../images/ids/" . $modifier . $image_name1[$i];
                $array[] = "images/ids/" . $modifier . $image_name1[$i];
                $image_name = implode(',', $array);
                $stored_directory = $image_name;

                if ($_FILES['id_photos']['size'][$i] <= 4000000) {
                    //compressed image
                    //move_uploaded_file($_FILES['id_photos']['tmp_name'], $target_directory);
                    $compressedImage = compressImage($_FILES['id_photos']['tmp_name'][$i], $target_directory, 30);
                } else {
                    $_SESSION['image-size'] = 'Your image is too large (more than 4mbs). Select an image of size 4mbs or less';
                    $_SESSION['update-status'] = 'Tenant was added successfully!';
                    echo '<script>window.location.assign("../all-tenants")</script>';
                }
            }

            $sql = "INSERT INTO tenants (name, house_id, size, id_number, id_photos, phone, email) VALUES(?, ?, ?, ?, ?, ?, ?)";
            $statement = $con -> prepare($sql);
            $data = ["$name", "$house_id", "$size", "$id_number", "$stored_directory", $phone, "$email"];
            $statement -> execute($data);
            echo '<script>window.location.assign("../all-tenants")</script>';
        }
        else{
            $sql = "INSERT INTO tenants (name, house_id, size, id_number, phone, email) VALUES(?, ?, ?, ?, ?, ?)";
            $statement = $con -> prepare($sql);
            $data = ["$name", "$house_id", "$size", "$id_number", $phone, "$email"];
            $statement -> execute($data);
            echo '<script>window.location.assign("../all-tenants")</script>';
        }
      }
      catch(Exception $e){
          $e -> getMessage();
      }
    }
    echo '<script>alert("Tenant exists")</script>';
    echo '<script>window.location.assign("../all-tenants")</script>';
}
?>