<?php session_start() ?>
<!DOCTYPE html>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>RoyalRentals</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../vendors/iconfonts/font-awesome/css/all.min.css">
  <link rel="stylesheet" href="../vendors/iconfonts/simple-line-icon/css/simple-line-icons.css">
  <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../vendors/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../css/style.css">
  <link rel="shortcut icon" href="../images/logo_mini.png" />
</head>
<style>
    #new-rental{
      width: fit-content;
    }
     #new-tenant{
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, .4);
        z-index: 50;
        display: none;
        overflow-y: auto;
    }
    #new-tenant > form{
        height: fit-content;
        width: 40%;
        position: absolute;
        top: 15%;
        left: 50%;
        transform: translateX(-50%);
        background: #fff;
        padding: 20px;
    }
    .close{
      float: right;
    }
    @media (max-width: 900px){
        #new-tenant > form{
            width: 70%;
        }
    }
    @media (max-width: 500px){
        #new-tenant > form{
            width: 95%;
        }
    }
</style>

  <body>
    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
      <?php include 'heading.php' ?>


      <?php
            if(isset($_POST["submit"])){
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $username = $_POST["username"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $assign = $_POST["assign"];
    $password = $_POST["password"];
    $user_id = $_SESSION["user_id"];

    $password = password_hash($password, PASSWORD_DEFAULT);

    $select = "SELECT * FROM users WHERE username = ? AND email = ?";
    $statement = $con -> prepare($select);
    $data = ["$username", "$email"];
    $statement -> execute($data);
    $rows = $statement -> rowCount();
    if($rows < 1){
      try{
        $sql = "INSERT INTO users (f_name, l_name, username, phone, email, user_group, user_id, rental_id, password) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $statement = $con -> prepare($sql);
        $data = ["$fname", "$lname", "$username", $phone, "$email", 2, $user_id, $assign, "$password"];
        $statement -> execute($data);
        echo "<script>location.reload();</script>";
      }
      catch(Exception $e){
          $e -> getMessage();
      }
    }
}
?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">Managers</h3>
            </div>
            <div class="row">
              <input type="hidden" name="" id="user_id" value="<?php $_SESSION['user_id']?>">
              <div class="col-md-12 grid-margin card stretch-card">
                <button class="btn btn-primary mt-2" id="new-rental">New Manager</button>
                <div class="table-responsive mt-3">
                      <table id="order-listing" class="table">
                        <thead>
                          <tr>
                            <th>Order #</th>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Rental Assigned</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $user_id = $_SESSION['user_id'];
                          $sql = "SELECT * from users where user_id = ? AND user_group = ?";
                          $statement = $con->prepare($sql);
                          $statement -> execute([$user_id, 2]);
                          $details = $statement -> fetchAll();
                          $order = 0;
                          foreach($details as $details){
                            $order += 1;
                            $rental = $details['rental_id'];
                            $sql2 = "SELECT name from rentals where id = ?";
                            $run = $con -> prepare($sql2);
                            $run -> execute([$rental]);
                            $details2 = $run -> fetch();
                            ?>
                          <tr>
                            <td><?php echo $order;?></td>
                            <td><?php if($details['photo'] != null){ ?><img src="<?php echo '../images/profile-photos/'.$details['photo'] ?>" class="mx-2"><?php }else{ ?><img src="../images/profile-photos/default-profile-pic.jpg" class="mx-2"> <?php } echo $details["f_name"].' '.$details["l_name"];?></td>
                            <td><?php echo $details["phone"];?></td>
                            <td><?php echo $details["email"];?></td>
                            <td><?php echo $details2["name"];?></td>
                            <td>
                              <a href="tel:<?php echo '+254'.$details["phone"]?>" class="btn btn-outline-primary">
                                <i class="fas fa-phone"></i>
                            </a>
                              <button class="btn btn-outline-danger" value="<?php echo $details["id"]?>" onclick="return showSwal('warning-message-and-cancel')">
                                <i class="fas fa-trash"></i>
                              </button>
                            </td>
                          </tr><?php }?>
                        </tbody>
                      </table>
                    </div>
              </div>
            </div>
            

            <div id="new-tenant">
            <form action="managers" method="POST">
              <h4>New Manager<button class="btn close"><i class="fas fa-times"></i></button></h4>
              <div class="row">
                <div class="class-group mt-3 col-md-6">
                <label for="name">First Name</label>
                <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name">
              </div>
              <div class="class-group mt-3 col-md-6">
                <label for="name">Last Name</label>
                <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name">
              </div>
              </div>
              <div class="class-group mt-3">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username">
              </div>
              <div class="class-group mt-3">
                <label for="phone">Phone</label>
                <input type="phone" class="form-control" id="phone" name="phone" placeholder="Phone">
              </div>
              <div class="class-group mt-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
              </div>
              <div class="class-group mt-3">
                <label for="assign">Assign Rental</label>
                <select name="assign" id="assign" class="form-control">
                  <option value="">--select rental--</option>
                  <?php
                          include '../server/connection.php';
                          $user_id = $_SESSION['user_id'];
                          $sql = "SELECT * from rentals where user_id = ?";
                          $statement = $con->prepare($sql);
                          $statement -> execute([$user_id]);
                          $details = $statement -> fetchAll();
                          foreach($details as $details){?>
                          <option value="<?php echo $details["id"]?>"><?php echo $details["name"]?></option>
                          <?php }?>
                </select>
              </div>
              <div class="class-group mt-3">
                <label for="password">Password (The manager can always change it on his/her side)</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
              </div>
              <div class="class-group mt-3">
                <input type="submit" class="form-control btn btn-primary" name="submit" id="submit" value="Add">
              </div>
            </form>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          <!-- partial -->
        </div>
        <?php include '../pages/layout/footer.php' ?>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <script src="../js/jquery_3.6.0.min.js"></script>
    <!-- container-scroller -->

    <script>
      $(document).ready(function(){
        $('#new-rental').on('click', function(){
          $('#new-tenant').fadeIn(500);
          $('.close').on('click', function(e){
            e.preventDefault();
            $('#new-tenant').fadeOut(500);
          })
        });
      })
    </script>

    <!-- plugins:js -->
  <script src="../vendors/js/vendor.bundle.base.js"></script>
  <script src="../vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../js/off-canvas.js"></script>
  <script src="../js/hoverable-collapse.js"></script>
  <script src="../js/misc.js"></script>
  <script src="../js/settings.js"></script>
  <script src="../js/todolist.js"></script>
  <!-- endinject -->
  <script src="../js/alerts.js"></script>
  <!-- Custom js for this page-->
  <script src="../js/dashboard.js"></script>
  <script src="../js/data-table.js"></script>
  <!-- End custom js for this page-->
  </body>
</html>
