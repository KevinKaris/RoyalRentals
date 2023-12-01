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
  <!-- endinject -->
  <link rel="shortcut icon" href="../images/logo_mini.png" />
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
    #new-tenant, #rent-edit{
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, .4);
        z-index: 50;
        display: none;
    }
    #new-tenant > form, #rent-edit > form{
        height: fit-content;
        width: 40%;
        position: absolute;
        top: 20%;
        left: 50%;
        transform: translateX(-50%);
        background: #fff;
        padding: 20px;
    }
    #new-tenant .close, #rent-edit .close{
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
          if(isset($_POST["submit"]) && !empty($_POST)){
            $amount = $_POST["amount"];
            $rental = $_POST["rental"];
            $user_id = $_SESSION["user_id"];
            $size = $_POST["size"];

            $select = "SELECT * FROM rent WHERE rental_id = ? AND house_size = ?";
            $statement2 = $con -> prepare($select);
            $data2 = ["$rental", "$size"];
            $statement2 -> execute($data2);
            $rows = $statement2 -> rowCount();

            if($rows == 0){
              try{
                  $sql = "INSERT INTO rent (user_id, rental_id, house_size, amount) VALUES (?, ?, ?, ?)";
                  $data = ["$user_id", "$rental", "$size", "$amount"];
                  $statement = $con -> prepare($sql);
                  $statement -> execute($data);
                  //echo "<script>location.reload();</script>";
              }
              catch(Exception $e){
                $e -> getMessage();
              }
            }
            else{
              echo "<script>alert('Rent for that rental is already set. Use 'UPDATE' option instead!')</script>";
            }
          }
          ?>

          <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">Houses</h3>
              <button class="btn btn-primary new-house">New Rent</button>
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
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
              <div class="card-body">
                <h4 class="card-title">Rent</h4>
                <div class="row">
                  <div class="col-12">
                    <div class="table-responsive">
                      <table id="order-listing" class="table">
                        <thead>
                          <tr>
                            <th>Order #</th>
                            <th>Rental Name</th>
                            <th>House Size</th>
                            <th>Rent (Ksh)</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $sql = "SELECT * FROM rent WHERE user_id = ? ORDER BY rental_id";
                            $user_id = $_SESSION["user_id"];
                            $statement = $con -> prepare($sql);
                            $statement -> execute(["$user_id"]);
                            $house = $statement -> fetchAll();
                            $order = 0;
                            foreach($house as $house){
                              $order += 1;
                              $rental_id = $house["rental_id"];
                              $sql2 = "SELECT * FROM rentals WHERE id = ?";
                              $statement2 = $con -> prepare($sql2);
                              $statement2 -> execute(["$rental_id"]);
                              $rental = $statement2 -> fetch();
                          ?>
                          <tr>
                            <td><?php echo $order ?></td>
                            <td><?php echo $rental["name"] ?></td>
                            <td><?php echo $house["house_size"] ?></td>
                            <td><?php echo $house["amount"] ?></td>
                            <td>
                              <button class="btn py-1 btn-outline-primary edit" value="<?php echo $house['id']?>">
                                <i class="fas fa-pen"></i>
                            </button>
                              <button class="btn py-1 btn-outline-danger delete" value="<?php echo $house['id']?>">
                                <i class="fas fa-trash"></i>
                            </button>
                          </tr>
                          <?php }?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </div>
            </div>
          </div>
          

          <div id="new-tenant">
            <form action="set-rent" method="POST">
              <h4>New Rent <button class="btn close"><i class="fas fa-times"></i></button></h4>
              <div class="class-group mt-3">
                <label for="number">Choose Rental</label>
                <select name="rental" id="rental" class="form-control">
                  <option value=""></option>
                  <?php
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
                <label for="size">House Size</label>
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
                <label for="name">Rent/month (Ksh)</label>
                <input type="number" min="0" step="0.01" class="form-control" id="id" name="amount" placeholder="Amount">
              </div>
              <div class="class-group mt-3">
                <input type="submit" class="form-control btn btn-primary" name="submit" id="add" value="Set">
              </div>
            </form>
          </div>

          <div id="rent-edit">
            <form>
              <h4>Edit Rent <button class="btn close"><i class="fas fa-times"></i></button></h4>
              <div class="class-group mt-3">
                <label for="size">House Size</label>
                <select name="size" id="size" class="form-control" disabled>
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
                <label for="name">Rent/month (Ksh)</label>
                <input type="number" min="0" step="0.01" class="form-control" id="amount" name="amount" placeholder="Amount">
              </div>
              <div class="class-group mt-3">
                <input type="submit" class="form-control btn btn-primary" id="save" value="Save">
              </div>
            </form>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          <?php include '../pages/layout/footer.php' ?>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
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
  <!-- <script src="../js/alerts.js"></script> -->
  <!-- Custom js for this page-->
  <script src="../js/dashboard.js"></script>
  <script src="../js/data-table.js"></script>
  <!-- End custom js for this page-->
  <script src="../js/jquery_3.6.0.min.js"></script>
  </body>
  <script>
      $(document).ready(function(){
          //new tenant form modal
          $('.new-house').on('click', function(){
            $('#new-tenant').fadeIn(500);

            $('#new-tenant .close').on('click', function(e){
              e.preventDefault();
              $('#new-tenant').fadeOut(500);
            })
          });

        $("#add").on("click", function(e){
          if($("#number").val() == ''){
            alert("House number required!");
            e.preventDefault();
          }
        })
      })


      $(document).ready(function(){
        $('#order-listing').on('click', '.delete', function(e){
          e.preventDefault();
          var result = confirm('Are you sure you want to proceed?');
          if(result){
            var rent_id = $(this).val();
            $.ajax({
              type: "get",
              url: "../server/delete-rent.php",
              data: {rent_id: rent_id},
              success: function (response) {
                if(response == '1'){
                  location.reload();
                }
              },
              error: function(){
                alert('Something went wrong');
              }
            });
          }
        });

        $('#order-listing').on('click', '.edit', function(e){
          e.preventDefault();
          var rent_id = $(this).val();
            $.ajax({
              type: "get",
              url: "../server/fetch-rent.php",
              data: {rent_id: rent_id},
              dataType: 'json',
              success: function (response) {
                $('#rent-edit #size').val(response.house_size);
                $('#rent-edit #amount').val(response.amount);
                $('#rent-edit').fadeIn(500);

                $('#rent-edit .close').on('click', function(e){
                  e.preventDefault();
                  $('#rent-edit').fadeOut(500);
                });

                //saving rent
                $('#rent-edit #save').on('click', function(e){
                  e.preventDefault();
                  var amount = $('#rent-edit #amount').val();
                  if(amount != '' || amount != 0){
                    $.ajax({
                      type: "post",
                      url: "../server/edit-fetch.php",
                      data: {amount: amount, rent_id: rent_id},
                      dataType: "dataType",
                      success: function (response) {
                        if(response == '1'){
                          location.reload();
                        }
                      }
                    });
                  }
                  else{
                    alert('Amount required!');
                  }
                })
              },
              error: function(){
                alert('Something went wrong');
              }
            });
        });
      })
    </script>
</html>
