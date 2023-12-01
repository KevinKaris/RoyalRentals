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
    #new-tenant > form #name, #county, #sub-county, #location, #rent, #manager, #size, #houses, #money, #occupied-houses, #expenses, #profit{
        background: linear-gradient(85deg, #392c70, #6a005b);
        color: #fff;
    }
</style>

  <body>
    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
      <?php include 'heading.php' ?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">Inquiry</h3>
            </div>
            <div class="row">
                <div id="new-tenant" class="col-md-6 grid-margin card stretch-card">
            <form action="#" class="my-3 d-flex flex-row justify-content-between flex-wrap">
              <div class="class-group mt-3 col-md-12">
                <p class="m-0 w-100 text-danger" id="output"></p>
                <label for="code">Select Rental</label>
                <select name="rental" id="rental" class="form-control">
                  <option value=""></option>
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
              <div class="class-group mt-3 col-md-6">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" disabled>
              </div>
              <div class="class-group mt-3 col-md-6">
                <label for="county">County</label>
                <input type="text" class="form-control" id="county" disabled>
              </div>
              <div class="class-group mt-3 col-md-6">
                <label for="sub-county">Sub County</label>
                <input type="text" class="form-control" id="sub-county" disabled>
              </div>
              <div class="class-group mt-3 col-md-6">
                <label for="location">Location</label>
                <input type="text" class="form-control" id="location" disabled>
              </div>
              <div class="class-group mt-3 col-md-6">
                <label for="size">Rental Size</label>
                <input type="text" class="form-control" id="size" disabled>
              </div>
              <div class="class-group mt-3 col-md-6">
                <label for="manager">Manager</label>
                <input type="text" class="form-control" id="manager" disabled>
              </div>
              <div class="class-group mt-3 col-md-6">
                <label for="houses">No. of Houses</label>
                <input type="text" class="form-control" id="houses" disabled>
              </div>
              <div class="class-group mt-3 col-md-6">
                <label for="occupied-houses">Occupied Houses</label>
                <input type="text" class="form-control" id="occupied-houses" disabled>
              </div>
              <div class="class-group mt-3 col-md-6">
                <label for="expenses">Total Expenses</label>
                <input type="number" class="form-control" id="expenses" disabled>
              </div>
              <div class="class-group mt-3 col-md-6">
                <label for="money">Total Money Collected this Month (Ksh)</label>
                <input type="number" class="form-control" id="money" disabled>
              </div>
              <div class="class-group mt-3 col-md-6">
                <label for="profit">Profit</label>
                <input type="number" class="form-control" id="profit" disabled>
              </div>
            </form>
          </div>
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

        //query rental details
        $("#rental").on("change", function(){
          if($(this).children("option:selected").val() != ''){
            var rental = $(this).children("option:selected").val();
            $.ajax({
              type: "GET",
              url: "../server/inquiry.php",
              data: {rental: rental},
              dataType: 'json',
              success: function (response) {
                $('#name').val(response.rental_name);
                $('#county').val(response.county);
                $('#sub-county').val(response.sub_county);
                $('#location').val(response.location);
                $('#size').val(response.size);
                $('#manager').val(response.manager);
                $('#houses').val(response.total_houses);
                $('#occupied-houses').val(response.occupied_houses);
                $('#expenses').val(response.total_expenses);
                $('#money').val(response.total_rent_collected);
                $('#profit').val(response.profit);
              },
              error: function (){
                $("#output").text("An error occurred! Something went wrong...")
              }
            });
          }
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
