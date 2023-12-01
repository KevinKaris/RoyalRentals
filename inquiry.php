<?php session_start() ?>
<!DOCTYPE html>
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
  <link rel="shortcut icon" href="images/logo_mini.png" />
</head>
<style>
    #new-rental{
      width: fit-content;
    }
    #tenant-name, #status, #period, #balance, #fine, #phone, #rent, #id{
        background: linear-gradient(85deg, #392c70, #6a005b);
        color: #fff;
    }
    #pic1 > img, #pic2 > img{
      width: 100%;
      height: auto;
    }
</style>

  <body>
    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
      <?php include 'pages/layout/heading.php' ?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">Inquiry</h3>
            </div>
            <div class="row">
              <div id="new-tenant" class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <form action="#" class="my-3 d-flex flex-row justify-content-between flex-wrap">
                    <div class="class-group mt-3 col-md-12">
                      <label for="number">House Number</label>
                      <select name="" id="number" class="form-control"></select>
                    </div>
                    <div class="class-group mt-3 col-md-6">
                      <label for="status">House Status</label>
                      <input type="text" class="form-control" id="status" disabled>
                    </div>
                    <div class="class-group mt-3 col-md-6">
                      <label for="tenant-name">Tenant Name</label>
                      <input type="text" class="form-control" id="tenant-name" disabled>
                    </div>
                    <div class="class-group mt-3 col-md-6">
                      <label for="fine">Phone</label>
                      <input type="number" class="form-control" id="phone" disabled>
                    </div>
                    <div class="class-group mt-3 col-md-6">
                      <label for="fine">ID Number</label>
                      <input type="number" class="form-control" id="id" disabled>
                    </div>
                    <div class="class-group mt-3 col-md-6">
                      <label for="period">Tenant Renting Period</label>
                      <input type="text" class="form-control" id="period" disabled>
                    </div>
                    <div class="class-group mt-3 col-md-6">
                      <label for="balance">Rent (Ksh)</label>
                      <input type="number" class="form-control" id="rent" disabled>
                    </div>
                    <div class="class-group mt-3 col-md-6">
                      <label for="balance">Balance (Ksh)</label>
                      <input type="number" class="form-control" id="balance" disabled>
                    </div>
                    <div class="class-group mt-3 col-md-6">
                      <label for="fine">Fine (Ksh)</label>
                      <input type="number" class="form-control" id="fine" disabled>
                    </div>
                  </form>
                </div>
              </div>
              </div>
              <div id="new-tenant2" class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="col-12 mb-1" id="pic1"></div>
                    <div class="col-12" id="pic2"></div>
                  </div>
                </div>
              </div>
            </div>

            
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          <!-- partial -->
        </div>
        <?php include 'pages/layout/footer.php' ?>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <script src="js/jquery_3.6.0.min.js"></script>
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

        //fetching house number
        $.ajax({
          type: "GET",
          url: "server/house-size2.php",
          success: function (response) {
            $("#number").html(response);
          }
        });

        $('#number').on('change', function(){
          var house_id = $(this).children('option:selected').val();
          if(house_id != ''){
            $.ajax({
              type: "POST",
              url: "server/inquiry2.php",
              data: {house_id: house_id},
              dataType: 'json',
              success: function (response){
                $('#status').val(response.house_status);
                $('#tenant-name').val(response.tenant_name);
                $('#phone').val(response.phone);
                $('#id').val(response.id);
                $('#period').val(response.renting_time);
                $('#rent').val(response.rent);
                $('#balance').val(response.balance);
                $('#fine').val(response.fine);

                if(response.second_pic != ''){
                  $('#pic1').html('<img src="'+response.first_pic+'" alt="'+response.first_pic+'">');
                  $('#pic2').html('<img src="'+response.second_pic+'" alt="'+response.second_pic+'">');
                }
                else{
                  $('#pic1').html('');
                  $('#pic2').html('');
                  $('#pic1').text('No ID photos');
                }
              }
            });
          }
        })
      })
    </script>

    <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/misc.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <script src="js/alerts.js"></script>
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <script src="js/data-table.js"></script>
  <!-- End custom js for this page-->
  </body>
</html>
