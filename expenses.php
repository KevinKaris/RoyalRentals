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
<style>
    .new-payment-outer, .update-outer{
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, .4);
        z-index: 50;
        display: none;
    }
    .new-payment-form{
        height: fit-content;
        width: 40%;
        position: absolute;
        top: 20%;
        left: 50%;
        transform: translateX(-50%);
        background: #fff;
    }
    @media (max-width: 900px){
        .new-payment-form{
            width: 70%;
        }
    }
    @media (max-width: 500px){
        .new-payment-form{
            width: 90%;
        }
    }
</style>

  <body>
    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
      <?php include 'pages/layout/heading.php' ?>
        <!-- partial -->
<?php
  if(!empty($_POST["amount"]) && !empty($_POST["name"])){
    $amount = $_POST["amount"];
    $name = $_POST["name"];
    $rental_id = $_SESSION["rental_id"];
            
    $select = "SELECT id FROM expenses WHERE rental_id = ? AND name = ?";
    $statement2 = $con -> prepare($select);
    $data2 = [$rental_id, $name];
    $statement2 -> execute($data2);
    $rows = $statement2 -> rowCount();

    if($rows == 0 ){
      try{
          $sql = "INSERT INTO expenses (rental_id, name, amount) VALUES (?, ?, ?)";
          $data = [$rental_id, $name, $amount];
          $statement = $con -> prepare($sql);
          $statement -> execute($data);
          echo "<script>window.location.assign('../expenses')</script>";
      }
      catch(Exception $e){
        $e -> getMessage();
        echo "<script>window.location.assign('../expenses')</script>"; 
      }
    }
  }
?>


        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">Expenses</h3>
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
            <div class="col-md-5 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-0">Current Month Expenses</h4>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-inline-block pt-3">
                                    <div class="d-md-flex">
                                        <h2 class="mb-0">
                                          <?php
                                          $sql = "SELECT * FROM expenses WHERE rental_id = ?";
                                          $rental_id = $_SESSION["rental_id"];
                                          $statement = $con -> prepare($sql);
                                          $statement -> execute([$rental_id]);
                                          $details = $statement -> fetchAll();
                                          $amount = 0;
                                          $month = '';
                                          $current_month = '';
                                          foreach($details as $details){
                                            $timestamp = $details["date"];
                                            $date = date("Y-m-d",strtotime($timestamp));
                                            $month = date("m", strtotime($date));
                                            $current_month = date('m');
                                            $year = date("Y", strtotime($date));
                                            if($month == $current_month && $year == date('Y')){
                                              $amount += $details["amount"];
                                            }
                                          }
                                          echo 'Ksh '.$amount;
                                          ?>
                                        </h2>
                                        <div class="d-flex align-items-center ml-md-2 mt-2 mt-md-0">
                                            <!-- <i class="far fa-clock text-muted"></i>
                                            <small class=" ml-1 mb-0"></small> -->
                                        </div>
                                    </div>
                                    <small class="text-gray">Total expenses.</small>
                                </div>
                                <div class="d-inline-block">
                                       <i class="fas fa-file-invoice-dollar text-warning icon-lg"></i>                                 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="col-lg-7 stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Expenses</h4>
                  <button class="btn nav-link mb-2" id="new-payment" style="float: right; background: #392c70; color: #fff;">Add New</button>
                  <div class="table-responsive">
                    <table id="order-listing" class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            #
                          </th>
                          <th>
                            Name
                          </th>
                          <th>
                            Amount
                          </th>
                          <th>
                            Date
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sql = "SELECT * FROM expenses WHERE rental_id = ?";
                        $rental_id = $_SESSION["rental_id"];
                        $statement = $con -> prepare($sql);
                        $statement -> execute([$rental_id]);
                        $details = $statement -> fetchAll();
                        $order = 0;
                        foreach($details as $details){
                          $timestamp = $details["date"];
                          $date = date("Y-m-d",strtotime($timestamp));
                          $month = date("m", strtotime($date));
                          $year = date("Y", strtotime($date));
                          $current_month = date('m');
                          if($month == $current_month && $year == date('Y')){
                            $order += 1;
                        ?>
                        <tr>
                          <td>
                            <?php echo $order;?>
                          </td>
                          <td>
                            <?php echo $details["name"]; ?>
                          </td>
                          <td>
                            <?php echo $details["amount"]; ?>
                          </td>
                          <td>
                            <?php echo date("d/m/Y",strtotime($timestamp)) ?>
                          </td>
                          <!-- <td>
                            <button class="btn py-1 btn-outline-danger delete" value="<?php //echo $details["id"] ?>" onclick="return showSwal('warning-message-and-cancel')">
                                <i class="fas fa-trash"></i>
                              </button>
                          </td> -->
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
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          <?php include 'pages/layout/footer.php' ?>
          <!-- partial -->
        </div>
        <div class="new-payment-outer">
            <div class="card-body new-payment-form">
                  <h4 class="card-title">Add New Expense</h4>
                  <form class="forms-sample" action="server/expense.php" method="POST">
                    <div class="form-group">
                      <label for="exampleInputUsername1">Expense Name</label>
                      <input type="text" class="form-control payment-name" name="name" id="exampleInputUsername1" placeholder="Expense name">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Amount</label>
                      <input type="number" name="amount" class="form-control payment-amount" id="exampleInputEmail1" placeholder="Amount">
                    </div>
                    <button type="submit" id="submit" name="submit" class="btn btn-primary mr-2">Save</button>
                    <a href="#" class="btn btn-light" id="cancel">Cancel</a>
                  </form>
                </div>
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <script src="js/jquery_3.6.0.min.js"></script>
    <script>
        //opening forms
        $('#new-payment').on('click', function(){
            $('.new-payment-outer').fadeIn(300);
            $('.new-payment-outer #cancel').on('click', function(e){
                e.preventDefault();
                $('.new-payment-outer').fadeOut(300);
            })
            $('.new-payment-outer #submit').on('click', function(e){
                if($('.payment-name').val() == ''){
                    e.preventDefault();
                    $('.payment-name').css('border', '1px solid red');
                }
                else{
                    $('.payment-name').css('border', '1px solid green');
                }

                if($('.payment-amount').val() == ''){
                    e.preventDefault();
                    $('.payment-amount').css('border', '1px solid red');
                }
                else{
                    $('.payment-amount').css('border', '1px solid green');
                }
            })
        })

        //submitting expense

    </script>



    <!-- container-scroller -->
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
  <!-- End custom js for this page-->
  <script src="js/data-table.js"></script>
  </body>

  <!-- Mirrored from www.urbanui.com/melody/template/pages/tables/data-table.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 15 Sep 2018 06:08:41 GMT -->
</html>
