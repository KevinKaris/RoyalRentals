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
  #house-number, #tenant-name{
    display: none;
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
              <h3 class="page-title">New Rent Payment</h3>
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
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Register New Payment</h4>
                  <form action="" class="forms-sample rent-payment" id="rent-payment">
                    <div class="form-group">
                      <label for="exampleInputUsername3">Register based on</label>
                      <select name="" class="form-control" id="exampleInputUsername3">
                        <option value="">--</option>
                        <option value="tenant-name">Tenant Name</option>
                        <option value="house-number">House Number</option>
                      </select>
                    </div>
                    <div class="form-group" id="tenant-name">
                      <label for="exampleInputUsername1">Tenant Name</label>
                      <select name="" class="form-control" id="exampleInputUsername1">
                        <option value="">--</option>
                        <?php
                        $sql = "SELECT * FROM houses WHERE rental_id = ?";
                        $statement = $con -> prepare($sql);
                        $rental_id = $_SESSION["rental_id"];
                        $statement -> execute([$rental_id]);
                        $details = $statement -> fetchAll();
                        foreach($details as $details){
                          $house_id = $details["id"];
                          $select = "SELECT * FROM tenants";
                          $st = $con -> prepare($select);
                          $st -> execute();
                          $columns = $st -> fetchAll();
                          foreach($columns as $columns){
                            $house_id2 = $columns["house_id"];
                            if($house_id == $house_id2){
                        ?>
                        <option value="<?php echo $columns["id"]; ?>"><?php echo $columns["name"]; ?></option>
                        <?php }}}?>
                      </select>
                    </div>
                    <div class="form-group" id="house-number">
                      <label for="exampleInputUsername2">House Number</label>
                      <select name="" class="form-control" id="exampleInputUsername2">
                        <option value="">--</option>
                        <?php
                          $select = "SELECT * FROM tenants";
                          $st = $con -> prepare($select);
                          $st -> execute();
                          $columns = $st -> fetchAll();
                          $rental_id = $_SESSION["rental_id"];
                          foreach($columns as $columns){
                            $sql = "SELECT * FROM houses WHERE id = ? AND rental_id = ?";
                            $statement = $con -> prepare($sql);
                            $id = $columns["house_id"];
                            $statement -> execute([$id, $rental_id]);
                            $details = $statement -> fetchAll();
                            foreach($details as $details){
                              if($details["id"] == $columns["house_id"]){
                        ?>
                        <option value="<?php echo $details["id"] ?>"><?php echo $details["number"] ?></option>
                        <?php
                              }}}
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="date">Month Paid For</label>
                      <select name="month" id="month" class="form-control mb-3">
                      <script>
                        var currentDate = new Date();
                        var currentMonth = currentDate.getMonth() + 1; // JavaScript months are 0-based, so we add 1
                        for (var month = 1; month <= 12; month++) {
                          var monthName = new Date(currentDate.getFullYear(), month - 1, 1).toLocaleString('default', { month: 'short' });
                          var selected = (currentMonth == month) ? 'selected' : '';
                          document.write("<option value='" + monthName + "' " + selected + ">" + monthName + "</option>");
                        }
                      </script>
                    </select>
                    <select name="year" id="year" class="form-control">
                      <?php
                      $currentYear = date('Y');
                      $start_year = $currentYear - 10;
                      $end_year = $currentYear + 10;
                      for($year = $start_year; $year <= $end_year; $year++){
                        $selected = ($currentYear == $year) ? 'selected' : '';
                        echo "<option value=".$year." $selected>".$year."</option>";
                      }
                      ?>
                    </select>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Amount</label>
                      <input type="number" class="form-control" id="exampleInputEmail1" placeholder="Amount">
                    </div>
                    <button type="submit" class="btn btn-primary mr-2" id="submit">Submit</button>
                    <button class="btn btn-light" id="reset">Reset</button>
                  </form>
                </div>
              </div>
            </div>
            </div>
            <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Payments History</h4>
                  <!-- <div class="row grid-margin">
                    <div class="col-12">
                      <div class="alert alert-warning" role="alert">
                          <strong>Heads up!</strong> This alert needs your attention, but it's not super important.
                      </div>
                    </div>
                  </div> -->
                  <div class="row">
                    <div class="col-12">
                      <div class="table-responsive">
                        <table id="order-listing" class="table">
                          <thead>
                            <tr class="bg-primary text-white">
                                <th>Order #</th>
                                <th>House Number</th>
                                <th>Tenant Name</th>
                                <th>Amount</th>
                                <th>Payment For</th>
                                <th>Date Recorded</th>
                                <!-- <th>Action</th> -->
                            </tr>
                          </thead>
                          <tbody>
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
          
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          <?php include 'pages/layout/footer.php' ?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <script src="js/jquery_3.6.0.min.js"></script>
    <script>
      $(document).ready(function(){
        //validating form
            $('.rent-payment #submit').on('click', function(e){
                if($('#exampleInputUsername3').children('option:selected').val() == ''){
                    e.preventDefault();
                    $('#exampleInputUsername3').css('border', '1px solid red');
                }
                else{
                    $('#exampleInputUsername3').css('border', '1px solid green');
                    if($('#tenant-name').css('display') !== 'none'){
                      if($('#exampleInputUsername1').children('option:selected').val() == ''){
                        e.preventDefault();
                        $('#exampleInputUsername1').css('border', '1px solid red');
                      }
                      else{
                        $('#exampleInputUsername1').css('border', '1px solid green');
                      }
                    }

                    if($('#house-number').css('display') !== 'none'){
                      if($('#exampleInputUsername2').children('option:selected').val() == ''){
                        e.preventDefault();
                        $('#exampleInputUsername2').css('border', '1px solid red');
                      }
                      else{
                        $('#exampleInputUsername2').css('border', '1px solid green');
                      }
                    }
                }
                if($('#exampleInputEmail1').val() == ''){
                  e.preventDefault();
                  $('#exampleInputEmail1').css('border', '1px solid red');
                }
                else{
                  $('#exampleInputEmail1').css('border', '1px solid green');
                }
            })

        //opening an tenant names and house numbers
        $('#exampleInputUsername3').on('change', function(){
          if($(this).children('option:selected').val() == 'tenant-name'){
            $('#tenant-name').fadeIn(500);
            $('#house-number').hide();
            $("#submit").on("click", function(e){
              $(this).prop('disabled', true);
              e.preventDefault();
              var tenant_id = $("#exampleInputUsername1").val();
              var amount = $("#exampleInputEmail1").val();
              var month = $("#month").children('option:selected').val();
              var year = $("#year").children('option:selected').val();
              if(month != '' || month != 0){
                $.ajax({
                  type: "POST",
                  url: "server/payment.php",
                  data: { tenant_id: tenant_id, amount: amount, month: month, year: year},
                  success: function (response) {
                    if(response == "1"){
                      added_payments();
                      $("#submit").prop('disabled', false);
                      return showSwal('success-message');
                    }
                    else if(response == "0"){
                      alert("An empty submittion was attempted!!");
                      $("#submit").prop('disabled', false);
                    }
                  },
                  error: function(){
                    $("#submit").prop('disabled', false);
                    return showSwal('server-message-without-cancel');
                  }
                });
              }
            })
          }
          else if($(this).children('option:selected').val() == 'house-number'){
            $('#house-number').fadeIn(500);
            $('#tenant-name').hide();
            $("#submit").on("click", function(e){
              $(this).prop('disabled', true);
              e.preventDefault();
              var house_id = $("#exampleInputUsername2").val();
              var amount = $("#exampleInputEmail1").val();
              var month = $("#month").val();
              var year = $("#year").val();
              if(month != '' || month != 0){
                $.ajax({
                  type: "POST",
                  url: "server/payment.php",
                  data: { house_id: house_id, amount: amount, month: month, year: year},
                  success: function (response) {
                    if(response == "1"){
                      added_payments();
                      $("#submit").prop('disabled', false);
                      return showSwal('success-message');
                    }
                    else if(response == "0"){
                      alert("An empty submittion was attempted!!");
                      $("#submit").prop('disabled', false);
                    }
                  },
                  error: function(){
                    $("#submit").prop('disabled', false);
                    return showSwal('server-message-without-cancel');
                  }
                });
              }
            })
          }
          else{
            $('#house-number').hide();
            $('#tenant-name').hide();
          }
        })

        //fetching added payments (for updating table)
        function added_payments(){
          $.ajax({
            type: "GET",
            url: "server/payment-history.php",
            success: function (response) {
              $('table > tbody').html(response);
            }
          });
        }

          //fetch payment history
          function payments(){
            $.ajax({
              type: "GET",
              url: "server/payment-history.php",
              success: function (response) {
                $('table > tbody').html(response);
                $('#order-listing').DataTable({
                  "aLengthMenu": [
                    [5, 10, 15, -1],
                    [5, 10, 15, "All"]
                  ],
                  "iDisplayLength": 10,
                  "language": {
                    search: ""
                  }
                });
                $('#order-listing').each(function() {
                  var datatable = $(this);
                  // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                  var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                  search_input.attr('placeholder', 'Search');
                  search_input.removeClass('form-control-sm');
                  // LENGTH - Inline-Form control
                  var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                  length_sel.removeClass('form-control-sm');
                });

                //deleting payment
                // $('tbody tr .delete').on('click', function(){
                //   var id = $(this).val();
                //   swal({
                //         title: "Are you sure?",
                //         text: "You won't be able to revert this!",
                //         icon: "warning",
                //         showCancelButton: true,
                //         confirmButtonColor: "#3f51b5",
                //         cancelButtonColor: "#ff4081",
                //         confirmButtonText: "Great ",
                //         buttons: {
                //           cancel: {
                //             text: "Cancel",
                //             value: null,
                //             visible: true,
                //             className: "btn btn-danger",
                //             closeModal: true,
                //           },
                //           confirm: {
                //             text: "OK",
                //             value: true,
                //             visible: true,
                //             className: "btn btn-primary",
                //             closeModal: true,
                //           },
                //         },
                //       }).then(function(result){
                //         if(result){
                //           $.ajax({
                //             type: "POST",
                //             url: "server/delete-payment.php",
                //             data: {id: id},
                //             success: function (response) {
                //               if(response == '1'){
                //                 added_payments();
                //                 return showSwal('success-message');
                //               }
                //             },
                //             error: function (){
                //               return showSwal('server-message-without-cancel');
                //             }
                //           });
                //         }
                //       });
                // });
              }
            });
          }
          payments();
          // $(document).ready(function(){
        })


        //reseting form
        $('#reset').on('click', function(e){
          e.preventDefault();
          $('#exampleInputUsername3').prop('selectedIndex', 0);
          $('#exampleInputUsername2').prop('selectedIndex', 0);
          $('#exampleInputUsername1').prop('selectedIndex', 0);
          $('#exampleInputEmail1').val('');
        })
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
  <!-- <script src="js/data-table.js"></script> -->
  <!-- End custom js for this page-->
  </body>
</html>
