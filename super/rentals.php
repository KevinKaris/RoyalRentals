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
     #new-tenant, #edit-tenant{
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, .4);
        z-index: 70;
        display: none;
        overflow: auto;
    }
    #new-tenant > form, #edit-tenant > form{
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
        #new-tenant > form, #edit-tenant > form{
            width: 70%;
        }
    }
    @media (max-width: 500px){
        #new-tenant > form, #edit-tenant > form{
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
    $name = $_POST["name"];
    $county = $_POST["county"];
    $sub_county = $_POST["sub-county"];
    $ward = $_POST["ward"];
    $location = $_POST["location"];
    $size = $_POST["size"];
    $user_id = $_SESSION["user_id"];

    $select = "SELECT * FROM rentals WHERE name = ?";
    $statement = $con -> prepare($select);
    $data = ["$name"];
    $statement -> execute($data);
    $rows = $statement -> rowCount();
    if($rows < 1){
      try{
          $sql = "INSERT INTO rentals (user_id, name, county, sub_county, ward, location, size) VALUES(?, ?, ?, ?, ?, ?, ?)";
          $statement = $con -> prepare($sql);
          $data = ["$user_id", "$name", "$county", "$sub_county", $ward, "$location", $size];
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
              <h3 class="page-title">Rentals</h3>
            </div>
            <div class="row">
              <div class="col-md-12 grid-margin card stretch-card">
                <button class="btn btn-primary mt-2" id="new-rental">New Rental</button>
                <div class="table-responsive mt-3">
                      <table id="order-listing" class="table">
                        <thead>
                          <tr>
                            <th>Order #</th>
                            <th>Rental Name</th>
                            <th>County</th>
                            <th>Sub County</th>
                            <th>Ward</th>
                            <th>Location</th>
                            <th>Size</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          include '../server/connection.php';
                          $user_id = $_SESSION['user_id'];
                          $sql = "SELECT * from rentals where user_id = ?";
                          $statement = $con->prepare($sql);
                          $statement -> execute([$user_id]);
                          $details = $statement -> fetchAll();
                          $order = 0;
                          foreach($details as $details){
                            $order += 1;
                            ?>
                          <tr>
                            <td><?php echo $order;?></td>
                            <td><?php echo $details["name"]?></td>
                            <td><?php echo $details["county"]?></td>
                            <td><?php echo $details["sub_county"]?></td>
                            <td><?php echo $details["ward"]?></td>
                            <td><?php echo $details["location"]?></td>
                            <td><?php echo $details["size"]?></td>
                            <td>
                              <!-- <button class="btn btn-outline-primary">
                                View
                              </button> -->
                              <button class="btn btn-outline-warning edit" value="<?php echo $details["id"]?>">
                                <i class="fas fa-pen"></i>
                              </button>
                              <button class="btn btn-outline-danger delete" value="<?php echo $details["id"]?>">
                                <i class="fas fa-trash"></i>
                              </button>
                            </td>
                          </tr>
                          <?php }?>
                        </tbody>
                      </table>
                    </div>
              </div>
            </div>

            <div id="new-tenant">
            <form action="rentals" method="POST">
              <h4>New Rental <button class="btn close"><i class="fas fa-times"></i></button></h4>
              <div class="class-group mt-3">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Name">
              </div>
              <div class="class-group mt-3">
                <label for="county">County</label>
                <select name="county" id="county" class="form-control">
                  <option value="">--Select county--</option>
                  <?php 
                  $sql = "SELECT DISTINCT county FROM locations";
                  $statement = $con -> prepare($sql);
                  $statement -> execute();
                  $details = $statement -> fetchAll();

                  foreach($details as $details){
                  ?>
                  <option value="<?php echo $details["county"] ?>"><?php echo $details["county"] ?></option>
                  <?php }?>
                </select>
              </div>
              <div class="class-group mt-3">
                <label for="sub-county">Sub County</label>
                <select name="sub-county" id="sub-county" class="form-control">
                </select>
              </div>
              <div class="class-group mt-3">
                <label for="Ward">Ward</label>
                <select name="ward" id="ward" class="form-control"></select>
              </div>
              <div class="class-group mt-3">
                <label for="location">Location</label>
                <input type="text" name="location" class="form-control" id="location" placeholder="Location">
              </div>
              <div class="class-group mt-3">
                <label for="size">Rental Size (optional)</label>
                <input type="text" name="size" class="form-control" id="size" placeholder="Size">
              </div>
              <div class="class-group mt-3">
                <input type="submit" class="form-control btn btn-primary" name="submit" id="submit" value="Add">
              </div>
            </form>
          </div>

          <div id="edit-tenant">
            <form action="rentals" method="POST">
              <h4>Edit Rental <button class="btn close"><i class="fas fa-times"></i></button></h4>
              <div class="class-group mt-3">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Name">
              </div>
              <div class="class-group mt-3">
                <label for="county">County</label>
                <select name="county" id="county" class="form-control">
                  <option value="">--Select county--</option>
                  <?php 
                  $sql = "SELECT DISTINCT county FROM locations";
                  $statement = $con -> prepare($sql);
                  $statement -> execute();
                  $details = $statement -> fetchAll();

                  foreach($details as $details){
                  ?>
                  <option value="<?php echo $details["county"] ?>"><?php echo $details["county"] ?></option>
                  <?php }?>
                </select>
              </div>
              <div class="class-group mt-3">
                <label for="sub-county">Sub County</label>
                <select name="sub-county" id="sub-county" class="form-control">
                </select>
              </div>
              <div class="class-group mt-3">
                <label for="Ward">Ward</label>
                <select name="ward" id="ward" class="form-control"></select>
              </div>
              <div class="class-group mt-3">
                <label for="location">Location</label>
                <input type="text" name="location" class="form-control" id="location" placeholder="Location">
              </div>
              <div class="class-group mt-3">
                <label for="size">Rental Size (optional)</label>
                <input type="text" name="size" class="form-control" id="size" placeholder="Size">
              </div>
              <div class="class-group mt-3">
                <input type="submit" class="form-control btn btn-primary" name="submit" id="submit" value="Save">
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

        //fetching counties, sub-counties, wards, and location
        $("#new-tenant #county").on("change", function(){
          var county = $(this).children("option:selected").val();
          if(county != ''){
              $.ajax({
                type: "GET",
                url: "../server/locations.php",
                data: {county: county},
                success: function (response) {
                  $("#new-tenant #sub-county").html(response);

                  //for wards
                  $("#new-tenant #sub-county").on('change', function(){
                    var sub_county = $("#new-tenant #sub-county").children("option:selected").val();
                    $.ajax({
                      type: "GET",
                      url: "../server/locations.php",
                      data: {sub_county: sub_county},
                      success: function (response) {
                        $("#new-tenant #ward").html(response);
                      }
                    });
                  })
                }
            });
          }
        })

        //fetching counties, sub-counties, wards, and location
        $("#edit-tenant #county").on("change", function(){
          var county = $(this).children("option:selected").val();
          if(county != ''){
              $.ajax({
                type: "GET",
                url: "../server/locations.php",
                data: {county: county},
                success: function (response) {
                  $("#edit-tenant #sub-county").html(response);

                  //for wards
                  $("#edit-tenant #sub-county").on('change', function(){
                    var sub_county = $("#edit-tenant #sub-county").children("option:selected").val();
                    $.ajax({
                      type: "GET",
                      url: "../server/locations.php",
                      data: {sub_county: sub_county},
                      success: function (response) {
                        $("#edit-tenant #ward").html(response);
                      }
                    });
                  })
                }
            });
          }
        })

        //edit rental
        $('.edit').on('click', function(){
          var rental_id = $(this).val();
          $.ajax({
            type: "get",
            url: "../server/edit-rental.php",
            data: {rental_id: rental_id},
            dataType: "json",
            success: function (response) {
              $('#edit-tenant #name').val(response.name);
              $('#edit-tenant #county').val(response.county);
              $('#edit-tenant #sub-county').val(response.sub_county);
              $('#edit-tenant #ward').val(response.ward);
              $('#edit-tenant #location').val(response.location);
              $('#edit-tenant #size').val(response.size);
              $('#edit-tenant').fadeIn(500);
              $('.close').on('click', function(e){
                e.preventDefault();
                $('#edit-tenant').fadeOut(500);
              })
              $('#edit-tenant #submit').on('click', function(e){
                e.preventDefault();
                if($('#edit-tenant #name').val() != '' && $('#edit-tenant #county').children('option:selected').val() != '' && $('#edit-tenant #sub-county').children('option:selected').val() != '' && $('#edit-tenant #ward').children('option:selected').val() != '' && $('#edit-tenant #location').val() != ''){
                  $.ajax({
                    type: "post",
                    url: "../server/edit-rental2.php",
                    data: {name: $('#edit-tenant #name').val(), county: $('#edit-tenant #county').children('option:selected').val(), sub_county: $('#edit-tenant #sub-county').children('option:selected').val(), ward: $('#edit-tenant #ward').children('option:selected').val(), location: $('#edit-tenant #location').val(), rental_id: rental_id},
                    dataType: "text",
                    success: function (response) {
                      if(response == '1'){
                        $('#edit-tenant').fadeOut(500);
                        return showSwal('success-message');
                      }
                    }
                  });
                }
                else{
                  alert('Fill all fields!');
                }
              })
            }
          });
        })

        //delete rental
        $('.delete').on('click', function(){
          var rental_id = $(this).val();
            swal({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3f51b5",
            cancelButtonColor: "#ff4081",
            confirmButtonText: "Great ",
            buttons: {
              cancel: {
                text: "Cancel",
                value: null,
                visible: true,
                className: "btn btn-danger",
                closeModal: true,
              },
              confirm: {
                text: "OK",
                value: true,
                visible: true,
                className: "btn btn-primary",
                closeModal: true,
              },
            },
          }).then(function(result){
            if(result){
              $.ajax({
                type: "post",
                url: "../server/delete-rental.php",
                data: { rental_id: rental_id},
                dataType: "text",
                success: function (response) {
                  console.log(response);
                  if(response == '1'){
                    swal({
                      title: "Successfull!",
                      text: "",
                      icon: "success",
                      button: {
                        text: "Okay",
                        value: true,
                        visible: true,
                        className: "btn btn-primary",
                      },
                    }).then(function(result){
                      if(result){
                        location.reload();
                      }
                    })
                  }
                }
              });
            }
          })
        })
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
