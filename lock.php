<?php session_start();
include 'server/connection.php';
$_SESSION['lock'] = 'lock';

if(isset($_SESSION['username']) && isset($_SESSION['lock']) && isset($_SESSION['user-group']) && $_SESSION['user-group'] == 2 && (time() - $_SESSION['login-time']) <= 28800){
  $user_id = $_SESSION["user_id"];

  $query = "SELECT * FROM users WHERE id = ?";
  $st = $con -> prepare($query);
  $st -> execute(["$user_id"]);
  $row_detail = $st ->fetch();
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>RoyalRentals</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/iconfonts/font-awesome/css/all.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/logo_mini.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth lock-full-bg">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-transparent text-left p-5 text-center">
              <?php
              if($row_detail['photo'] !== null){
              ?>
                <img src="<?php echo 'images/profile-photos/'.$row_detail['photo']?>" class="lock-profile-img" alt="profile" />
                <?php
              }
              else{
                ?>
                <img src="images/profile-photos/default-profile-pic.jpg" class="lock-profile-img" alt="profile" />
                <?php
              }
                ?>
              <form class="pt-5">
                <div class="form-group">
                  <label id="notice" class="text-danger bg-light px-3 h6"></label><br>
                  <label for="examplePassword1">Password to unlock</label>
                  <input type="password" class="form-control text-center text-light" id="examplePassword1" placeholder="Password">
                </div>
                <div class="mt-5">
                  <a class="btn btn-block btn-success btn-lg font-weight-medium" id="unlock" href="javascript:void()">Unlock</a>
                  <input type="hidden" name="" value="<?php echo $user_id?>" id="user_id">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/misc.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <script src="js/jquery_3.6.0.min.js"></script>
</body>
<script>
  $(document).ready(function(){
    $('#unlock').on('click', function(){
      var user_id = $('#user_id').val();
      var password = $('#examplePassword1').val();

      if(password != '' && user_id != ''){
        $.ajax({
          type: "post",
          url: "server/auth/unlock.php",
          data: {user_id: user_id, password: password},
          dataType: "text",
          success: function (response) {
            if(response == '1'){
              window.location.assign("<?php echo $_SESSION['url']?>");
            }
            else{
              $('#notice').text(response);
            }
          },
          error: function(){
            $('#notice').text(response);
          }
        });
      }
      else if(password == ''){
        $('#notice').text('Enter Password');
      }
    })
  })
</script>
</html>
<?php }?>
