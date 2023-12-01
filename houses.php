<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
  <!-- Mirrored from www.urbanui.com/melody/template/pages/tables/data-table.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 15 Sep 2018 06:08:40 GMT -->
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <title>RoyalRentals</title>
    <!-- plugins:css -->
    <link
      rel="stylesheet"
      href="vendors/iconfonts/font-awesome/css/all.min.css"
    />
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css" />
    <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css" />
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="css/style.css" />
    <!-- endinject -->
    <link rel="shortcut icon" href="images/logo_mini.png" />
  </head>

  <style>
    .page-header{
      position: relative;
    }
    .page-header .new-house{
      position: absolute;
      right: 0;
      top: 0;
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
    }
    #new-tenant > form{
        height: fit-content;
        width: 40%;
        position: absolute;
        top: 20%;
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
      <?php include 'pages/layout/heading.php'?>
        <!-- partial -->

        <?php
        if(isset($_POST["submit"]) && !empty($_POST["number"])){
            $number = $_POST["number"];
            $size = $_POST["size"];
            $rental_id = $_SESSION["rental_id"];

            $select = "SELECT * FROM houses WHERE rental_id = ? AND number = ?";
            $statement2 = $con -> prepare($select);
            $data2 = ["$rental_id", "$number"];
            $statement2 -> execute($data2);
            $rows = $statement2 -> rowCount();

            if($rows == 0){
              try{
                  $sql = "INSERT INTO houses (rental_id, number, size) VALUES (?, ?, ?)";
                  $data = ["$rental_id", "$number", "$size"];
                  $statement = $con -> prepare($sql);
                  $statement -> execute($data);
              }
              catch(Exception $e){
                $e -> getMessage();
              }
            }
            else{
              //echo "<script>alert('House already exists!')</script>";
            }
            
          }?>

        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">Houses</h3>
              <button class="btn btn-primary new-house">New House</button>
              <!-- <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Tables</a></li>
                  <li class="breadcrumb-item active" aria-current="page">
                    Data table
                  </li>
                </ol>
              </nav> -->
            </div>

            <div class="row">
                <!--Occcupied houses -->
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
              <div class="card-body">
                <h4 class="card-title">Occupied Houses</h4>
                <div class="row">
                  <div class="col-12">
                    <div class="table-responsive">
                      <table id="order-listing" class="table">
                        <thead>
                          <tr>
                            <th>Order #</th>
                            <th>House No.</th>
                            <th>House Size</th>
                            <th>House Rent</th>
                            <th>Tenant Name</th>
                            <th>Tenant Phone</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          //fetching rent for rental
                            $rental_id = $_SESSION["rental_id"];
                            $sql = "SELECT * FROM houses WHERE rental_id = ?";
                            $statement = $con -> prepare($sql);
                            $statement -> execute([$rental_id]);
                            $house = $statement -> fetchAll();
                            $order = 0;
                            foreach($house as $house){
                              $house_id = $house["id"];
                              $sql2 = "SELECT * FROM tenants WHERE house_id = ?";
                              $data2 = [$house_id];
                              $statement2 = $con -> prepare($sql2);
                              $statement2 -> execute($data2);
                              $tenant = $statement2 -> fetch(PDO::FETCH_ASSOC);

                              $sql3 = "SELECT * FROM rent WHERE rental_id = ? AND house_size = ?";
                              $data3 = [$rental_id, $house['size']];
                              $statement3 = $con -> prepare($sql3);
                              $statement3 -> execute($data3);
                              $rent = $statement3 -> fetch();
                              if($tenant !== false){
                                if($tenant["house_id"] != ''){
                                  $order += 1;
                            ?>
                            <tr>
                              <td><?php echo $order ?></td>
                              <td><?php echo $house["number"] ?></td>
                              <td><?php echo $house["size"] ?></td>
                              <td><?php echo $rent["amount"] ?></td>
                              <td><?php echo $tenant["name"] ?></td>
                              <td><?php echo '0'.$tenant["phone"] ?></td>
                            </tr>
                          <?php }}}?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </div>
            </div>
            <div class="row">
                <!--vacant houses -->
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
              <div class="card-body">
                <h4 class="card-title">Vacant Houses</h4>
                <div class="row">
                  <div class="col-12">
                    <div class="table-responsive">
                      <table id="order-listing" class="table">
                        <thead>
                          <tr>
                            <th>Order #</th>
                            <th>House No.</th>
                            <th>Status</th>
                            <th>Size</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          //fetching rent for rental
                            $sql = "SELECT * FROM houses WHERE rental_id = ?";
                            $statement = $con -> prepare($sql);
                            $rental_id = $_SESSION["rental_id"];
                            $data = [$rental_id];
                            $statement -> execute($data);
                            $house = $statement -> fetchAll();
                            $order = 0;
                            foreach($house as $house){
                              $house_id = $house["id"];
                              $sql2 = "SELECT * FROM tenants WHERE house_id = ?";
                              $data2 = [$house_id];
                              $statement2 = $con -> prepare($sql2);
                              $statement2 -> execute($data2);
                              $tenant = $statement2 -> fetch();
                              if($tenant === false && $house['status'] == 'Okay'){
                                //if($tenant["house_id"] == null && $house['status'] == 'Okay'){
                                  $order += 1;
                            ?>
                            <tr>
                              <td><?php echo $order ?></td>
                              <td><?php echo $house["number"] ?></td>
                              <td><?php echo $house["status"] ?></td>
                              <td><?php echo $house["size"] ?></td>
                              <td>
                                <button class="btn btn-sm btn-outline-warning faulty" value="<?php echo $house["id"]?>">Faulty</button>
                                <button class="btn btn-sm btn-outline-danger delete" value="<?php echo $house["id"]?>">
                                  <i class="fas fa-trash"></i>
                                </button>
                              </td>
                            </tr>
                          <?php }}//}?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </div>
            <!--Faulty houses-->
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
              <div class="card-body">
                <h4 class="card-title">Faulty Houses</h4>
                <div class="row">
                  <div class="col-12">
                    <div class="table-responsive">
                      <table id="order-listing" class="table">
                        <thead>
                          <tr>
                            <th>Order #</th>
                            <th>House No.</th>
                            <th>Status</th>
                            <th>Size</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          //fetching rent for rental
                            $sql = "SELECT * FROM houses WHERE rental_id = ?";
                            $statement = $con -> prepare($sql);
                            $rental_id = $_SESSION["rental_id"];
                            $data = [$rental_id];
                            $statement -> execute($data);
                            $house = $statement -> fetchAll();
                            $order = 0;
                            foreach($house as $house){
                              if($house["status"] == "Faulty"){
                                $order += 1;
                          ?>
                          <tr>
                            <td><?php echo $order ?></td>
                            <td><?php echo $house["number"] ?></td>
                            <td><?php echo $house["status"] ?></td>
                            <td><?php echo $house["size"] ?></td>
                            <td>
                              <button class="btn btn-sm btn-outline-success renovated" value="<?php echo $house["id"]?>">Renovated</button>
                            </td>
                          </tr>
                          <?php }}?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </div>
            </div>

          <div id="new-tenant">
            <form action="houses" method="POST">
              <h4>New House <button class="btn close"><i class="fas fa-times"></i></button></h4>
              <div class="class-group mt-3">
                <label for="number">House Number</label>
                <input type="text" class="form-control" id="number" name="number" placeholder="House number">
              </div>
              <div class="class-group mt-3">
                <label for="name">House Size</label>
                <select name="size" id="size" class="form-control">
                  <option value="">--house size--</option>
                  <option value="Single">Single</option>
                  <option value="Double">Double</option>
                  <option value="Bed-Sitter">Bed-Sitter</option>
                  <option value="One-Bedroom">One-Bedroom</option>
                  <option value="Two-Bedroom">Two-Bedroom</option>
                  <option value="Three-Bedroom">Three-Bedroom</option>
                  <option value="Four-Bedroom">Four-Bedroom</option>
                </select>
              </div>
              <div class="class-group mt-3">
                <input type="submit" class="form-control btn btn-primary" name="submit" id="add" value="Add">
              </div>
            </form>
          </div>
        </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          <?php include 'pages/layout/footer.php' ?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
    <script>
      $(document).ready(function(){
            //new tenant form modal
            $('.new-house').on('click', function(){
              $('#new-tenant').fadeIn(500);
              $.ajax({
                type: "get",
                url: "server/latest-house-number.php",
                dataType: "text",
                success: function (response) {
                  var house_number = response;

                  // Function to increment string based on its format
                  function incrementString(inputString) {
                    // Check if the string starts with a letter
                    if(/^[a-zA-Z]/.test(inputString)){
                      var nonNumericPart = inputString.replace(/[0-9]/g, '');
                      var numericPart = parseInt(inputString.replace(/\D/g, ''), 10);
                      var newNumericPart = numericPart + 1;
                      return nonNumericPart + newNumericPart;
                    }
                    // Check if the string starts with zeros
                    else if(/^0/.test(inputString)){
                      var originalLength = inputString.length;
                      var numericValue = parseInt(inputString, 10);
                      var incrementedValue = numericValue + 1;
                      return pad(incrementedValue, originalLength);
                    }
                    // Default case: return the input string as is
                    else {
                      return inputString;
                    }
                  }

                  // Function to pad a number with leading zeros
                  function pad(num, size){
                    var s = num + "";
                    while (s.length < size) s = "0" + s;
                    return s;
                  }

                  $('#new-tenant #number').val(incrementString(house_number));
                  $('.close').on('click', function(e){
                      e.preventDefault();
                      $('#new-tenant').fadeOut(500);
                  })
                }
              });
            })

            //faulty implementation
            $('.faulty').on('click', function(){
              var house_id = $(this).val();
              $.ajax({
                type: "POST",
                url: "server/faulty.php",
                data: {house_id: house_id},
                success: function (response) {
                  if(response == '1'){
                    location.reload();
                  }
                }
              });
            })

            //renovated implemeantion
            $('.renovated').on('click', function(){
              var house_id = $(this).val();
              $.ajax({
                type: "POST",
                url: "server/renovated.php",
                data: {house_id: house_id},
                success: function (response) {
                  if(response == '1'){
                    location.reload();
                  }
                }
              });
            })

            //deleting implementation
            $('.delete').on('click', function(){
              var house_id = $(this).val();
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
                    type: "POST",
                    url: "server/delete-house.php",
                    data: {house_id: house_id},
                    success: function (response) {
                      if(response == '1'){
                        location.reload();
                      }
                    },
                    error: function(){
                      return showSwal('server-message-without-cancel');
                    }
                  });
                }
              });
            });
      })

          $("#add").on("click", function(e){
            if($("#number").val() == ''){
              alert("House number required!");
              e.preventDefault();
            }
          })
    </script>
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
    <script src="js/alerts.js"></script>
    <!-- Custom js for this page-->
    <script src="js/data-table.js"></script>
    <!-- End custom js for this page-->
  </body>
</html>
