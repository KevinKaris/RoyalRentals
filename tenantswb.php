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
  <!-- endinject -->
  <link rel="shortcut icon" href="images/logo_mini.png" />
</head>

  <body>
    <style>
        .card-body input{
            float: right;
            height: 40px;
            border-radius: 2px;
            padding: 10px;
            width: 20%;
            font-size: 14px;
            border: 1px solid gainsboro;
        }
        @media (max-width: 991px){
            .card-body input{
                width: 50%;
            }
        }
        @media (max-width: 575.98px){
            .card-body input{
                width: 100%;
            }
        }
    </style>
    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
      <?php include 'pages/layout/heading.php' ?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">Tenants without balance</h3>
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
              <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Tenants without balance</h4>
                  <input type="text" name="tenant-search" id="tenant-search" placeholder="Search...">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>
                            Tenant Name
                          </th>
                          <th>
                            Phone No.
                          </th>
                          <th>
                            Payment Progress
                          </th>
                          <th>
                            Rent Amount
                          </th>
                          <th>
                            Balance
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sql= "SELECT * FROM houses WHERE rental_id = ?";
                          $rental_id = $_SESSION["rental_id"];
                          $statement = $con -> prepare($sql);
                          $statement -> execute([$rental_id]);
                          $fetch = $statement -> fetchAll();
                          foreach($fetch as $fetch){
                            $house_id = $fetch["id"];
                            $select = "SELECT * FROM tenants";
                            $st = $con -> prepare($select);
                            $st -> execute();
                            $fetch2 = $st -> fetchAll();
                            foreach($fetch2 as $fetch2){
                              $house_id2 = $fetch2["house_id"];
                              if($house_id == $house_id2){
                                $house_size = $fetch2["size"];
                                $query = "SELECT DISTINCT * FROM rent WHERE rental_id = ? AND house_size = ?";
                                $st2 = $con -> prepare($query);
                                $st2 -> execute([$rental_id, $house_size]);
                                $rent = $st2 -> fetch();
                                $payment = "SELECT * FROM payment WHERE tenant_id = ? OR house_id = ? AND rent = ?";
                                    $st3 = $con -> prepare($payment);
                                    $st3 -> execute([$fetch2["id"], $house_id2, $rent['amount']]);
                                    $fetch3 = $st3 -> fetchAll();
                                    $rows = $st3 -> rowCount();
                                    $total_paid_rent = 0;
                                    if($rows > 0){
                                      foreach($fetch3 as $fetch3){
                                        // $timestamp = $fetch3["date"];
                                        // $date = new DateTime($timestamp);
                                        $month = $fetch3["for_month"];
                                        $current_month = date('M');
                                        if($month == $current_month && $fetch3["for_year"] == date('Y')){
                                          $total_paid_rent += $fetch3["amount"];
                                        }
                                      }
                                    }
                                          if($total_paid_rent >= $rent["amount"]){
                        ?>
                        <tr>
                          <td><?php echo $fetch2["name"]?></td>
                          <td><?php echo '0'.$fetch2["phone"]?></td>
                          <td>
                            <div class="progress">
                              <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </td>
                          <td><?php echo $rent["amount"]?></td>
                          <td><?php echo $rent["amount"] - $total_paid_rent?></td>
                        </tr>
                        <?php
                                    }
                                  }
                                }
                              }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          <?php include 'pages/layout/footer.php' ?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

<script>
  $(window).ready(function(){
    $('#tenant-search').keyup(function(){
      var search_word = $(this).val().toLowerCase();

        $("table > tbody tr").each(function() {
            var rowData = $(this).text().toLowerCase();
            if (rowData.indexOf(search_word) === -1) {
                $(this).hide(); // Hide rows that don't match the search
            } else {
                $(this).show(); // Show rows that match the search
            }
        });
    })

    // var currentDate = new Date().getMonth() + 1;
    // alert(currentMonth);
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
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <!-- End custom js for this page-->
  </body>
</html>
