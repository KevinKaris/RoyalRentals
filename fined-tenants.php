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
      .update-outer{
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
      .new-payment-form, #new-tenant > form{
        height: fit-content;
        width: 40%;
        position: absolute;
        top: 25%;
        left: 50%;
        transform: translateX(-50%);
        background: #fff;
      }
      #new-tenant > form{
      top: 10%;
      padding: 20px;
    }
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
            .new-payment-form, #new-tenant > form{
              width: 70%;
            }
        }
        @media (max-width: 575.98px){
            .card-body input{
                width: 100%;
            }
            .new-payment-form, #new-tenant > form{
              width: 95%;
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
              <h3 class="page-title">Fined Tenants</h3>
              <!-- <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="tel:">Tables</a></li>
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
                  <h4 class="card-title">Fined Tenants</h4>
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Tenant Name</th>
                          <th>Phone No.</th>
                          <th>Fine Amount</th>
                          <th>Balance</th>
                          <th>Status</th>
                          <th>Action</th>
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
                                $tenant_id = $fetch2["id"];
                                $house_size = $fetch2["size"];

                                $query = "SELECT DISTINCT * FROM rent WHERE rental_id = ? AND house_size = ?";
                                $st2 = $con -> prepare($query);
                                $st2 -> execute([$rental_id, $house_size]);
                                $rent = $st2 -> fetch();

                                $query = "SELECT * FROM fined WHERE tenant_id = ?";
                                $st2 = $con -> prepare($query);
                                $st2 -> execute([$tenant_id]);
                                $fine = $st2 -> fetchAll();
                                $fine_amount = 0;
                                $paid = 0;
                                $fine_id = 0;
                                foreach($fine as $fine){
                                  $fine_amount += $fine["amount"];
                                  $paid += $fine["paid"];
                                  $fine_id = $fine["id"];
                        ?>
                        <tr>
                          <td><?php echo $fetch2["name"]?></td>
                          <td><?php echo '0'.$fetch2["phone"]?></td>
                          <td><?php echo $fine_amount?></td>
                          <td><?php echo $fine_amount - $paid?></td>
                          <td>
                            <?php
                            if($paid == 0){?>
                              <label class="badge badge-danger badge-pill">Not paid</label>
                              <?php
                            }
                            else if($paid > 0 && $paid < $fine_amount){?>
                            <label class="badge badge-warning badge-pill">Partially paid</label>
                            <?php
                            }
                            else if($paid >= $fine_amount){?>
                            <label class="badge badge-success badge-pill">Fully paid</label>
                              <?php
                            }
                            ?>
                          </td>
                          <td><a href="tel:<?php echo '0'.$fetch2["phone"]?>" class="btn py-1 btn-outline-primary">Call</a>
                          <button class="btn btn-outline-success py-1 pay" value="<?php echo $fine_id?>">payment</button>
                          <button class="btn btn-outline-danger py-1 delete" value="<?php echo $fine_id?>" onclick="return showSwal('warning-message-and-cancel')"><i class="fas fa-trash"></i></button>
                        </td>
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

    <div class="update-outer">
            <div class="card-body new-payment-form">
                  <h4 class="card-title">Enter Fine Amount</h4>
                  <form class="forms-sample">
                    <div class="form-group">
                      <label for="fine-amount">Fine Amount</label>
                      <input type="number" class="form-control w-100 mb-3" id="pay-amount" placeholder="Amount...">
                    </div>
                    <button type="submit" id="fine-pay" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light" id="cancel">Cancel</button>
                  </form>
                </div>
        </div>

    <script>
      $(window).ready(function(){
        $(".delete").on("click", function(){
          var fine_id = $(this).val();
          $.ajax({
            type: "POST",
            url: "server/delete-fine.php",
            data: {fine_id: fine_id},
            success: function (response) {
              if(response == '1'){
                location.reload();
              }
            }
          });
        })

        $(".pay").on("click", function(){
          var fine_id = $(this).val();
            $('.update-outer').fadeIn(300);
            $('.update-outer #cancel').on('click', function(e){
                e.preventDefault();
                $('.update-outer').fadeOut(300);
            })
          $("#fine-pay").on('click', function(e){
            e.preventDefault();
            if($('#pay-amount').val() == ''){
                e.preventDefault();
                $('#pay-amount').css('border', '1px solid red');
            }
            else{
                $('#pay-amount').css('border', '1px solid green');
                var amount = $('#pay-amount').val();
                $.ajax({
                  type: "POST",
                  url: "server/fine-pay.php",
                  data: {fine_id: fine_id, amount: amount},
                  success: function (response) {
                    if(response == '1'){
                      location.reload();
                    }
                  },
                  error: function(){
                    alert('Error happened!');
                  }
                });
            }
          })
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
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <!-- End custom js for this page-->
  </body>
</html>
