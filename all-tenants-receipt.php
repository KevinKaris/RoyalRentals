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
    <!-- plugin css for this page -->
   <link rel="stylesheet" href="vendors/summernote/dist/summernote-bs4.css"/>
    <link rel="stylesheet" href="vendors/iconfonts/font-awesome/css/all.min.css"/>
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css" />
    <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css" />
    <!-- endinject -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" />
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="css/style.css" />
    <!-- endinject -->
    <link rel="shortcut icon" href="images/logo_mini.png" />
  </head>
<style>
    .ui-datepicker-calendar {
        display: none;
    }
    #startDate{
        width: 40%;
    }
    #receipt-sheet{
      background: #fff;
      padding: 15px;
      border-radius: 7px;
      height: 561px;
    }
    #gallery{
      overflow-x: auto;
      display: none;
    }
    #gallery #receipt-sheet{
      margin-top: 0;
      height: fit-content;
      padding: 0;
    }
    #gallery #receipt-sheet #receipt-inner #content > p, #gallery #receipt-sheet #receipt-inner #content span, #gallery .payment-for, #gallery section{
      font-size: 8px !important;
    }
    #gallery #receipt-sheet #receipt-inner > #row{
      padding: 0 3px 0 3px;
    }
    #gallery #receipt-sheet strong{
      font-size: 8px;
    }
    #gallery #receipt-sheet #receipt-inner > #row strong{
      font-size: 8px;
    }
    #gallery #receipt-sheet #receipt-inner #content strong{
      font-size: 8px;
    }
    #gallery #receipt-sheet #receipt-inner h6{
      margin-top: 10px;
      font-size: 8px;
    }
    #gallery #receipt-sheet #receipt-inner h6 p{
      font-size: 8px !important;
    }
    #gallery #receipt-sheet #receipt-inner h4{
      height: 10px;
      font-size: 8px;
    }
    #print, #print2{
      display: none;
    }
    #receipt-sheet #receipt-inner > #row{
      width: 100%;
      padding: 0 7px 0 7px;
      display: inline-flex;
      justify-content: space-between;
      flex-direction: row;
    }
    #receipt-sheet #receipt-inner > #row strong{
      font-size: 14px;
      font-weight: 600;
    }
    #receipt-sheet #receipt-inner #content > p{
      font-size: 13px;
      width: 100%;
      padding: 0 7px 15px 7px;
      border-bottom: 1px solid #f4f4f4;
    }
    #receipt-sheet #receipt-inner #content #row{
      display: inline-flex;
      justify-content: space-between;
      flex-direction: row;
    }
    #receipt-sheet #receipt-inner #content strong{
      font-size: 14px;
      font-weight: 600;
    }
    #receipt-sheet #receipt-inner #content span{
      font-size: 13px;
      width: fit-content;
    }
    #receipt-sheet #receipt-inner{
      border: 2px solid #aaaaaa;
      border-radius: 7px;
      overflow: hidden;
    }
    #receipt-sheet #receipt-inner h6{
      padding: 0 7px 0 7px;
      margin-bottom: 30px;
      font-weight: 700;
      margin-top: 60px;
    }
    #receipt-sheet #receipt-inner h4{
      width: 100%;
      background: #f4f4f4;
      height: 50px;
      margin-bottom: 5px;
      /* border-bottom: 2px solid #aaaaaa; */
      display: flex;
      justify-content: center;
      align-items: center;
    }
    @media (max-width: 900px){
        #startDate{
            width: 70%;
        }
    }
    @media (max-width: 500px){
        #startDate{
            width: 100%;
        }
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
              <h3 class="page-title">Print receipts for all tenants</h3>
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
            <div class="col-lg-12">
                      <div class="d-flex justify-content-between">
                        <div id="tenant-heading">
                          <h5></h5>
                        </div>
                        <button class="btn btn-primary print"><i class="fa fa-print"></i></button>
                      </div>
                      <div class="profile-feed" id="profile-feed">
                        <div id="edits">
                            <div class="form-group">
                                <select name="" class="form-control" id="startDate">
                                  <option value="">--</option>
                                  <option value="all">All tenants</option>
                                  <option value="wbal">Tenants without Balances</option>
                                  <option value="bal">Tenants With Balances</option>
                                </select>
                            </div>
                        </div>
                        <div class="row grid-margin" id="gallery">
                        <div class="col-lg-12">
                          <div class="card px-3">
                            <div class="card-body">
                              <h4 class="card-title">Review</h4>
                              <div
                                id="lightgallery-without-thumb"
                                class="row lightGallery">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      </div>
                    </div>
            </div>
            <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Receipts History</h4>
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
                                <th>Receipt Number</th>
                                <th>House Number</th>
                                <th>Tenant Name</th>
                                <th>Payment For</th>
                                <th>Date Printed</th>
                                <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $rental_id = $_SESSION["rental_id"];
                            $receipts_query = "SELECT * FROM receipts WHERE rental_id = ?";
                            $statement = $con -> prepare($receipts_query);
                            $statement -> execute([$rental_id]);
                            $row_count = $statement -> rowCount();

                            if($row_count > 0){
                              $fetch = $statement -> fetchAll();
                              foreach($fetch as $fetch){?>
                                <tr>
                                  <td><?php echo $fetch['receipt_no']?></td>
                                  <td><?php echo $fetch['house_number']?></td>
                                  <td><?php echo $fetch['tenant_name']?></td>
                                  <td><?php echo $fetch['payment_for']?></td>
                                  <td><?php $date = date("Y-m-d",strtotime($fetch['date'])); echo $date?></td>
                                  <td><button class="btn btn-warning mb-2 reprint" value="<?php echo $fetch['id']?>">Re-print</button><button class="btn btn-danger mx-2 delete" value="<?php echo $fetch['id']?>">delete</button></td>
                                </tr>
                                <?php
                              }
                            }
                            ?>

                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div id="print">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.js"></script>

    <script>
        $(document).ready(function(){
          //fetching receipts
          //$('#carousel').hide();
          $('#startDate').on('change', function(){
            var criteria = $('#startDate').children('option:selected').val();
            if(criteria != ''){
              $.ajax({
                type: "POST",
                url: "server/all-receipts.php",
                data: {criteria: criteria},
                dataType: 'html',
                success: function(response){
                  $('#print').html(response);
                  // $.each(response, function() { 
                  //   $.ajax({
                  //     type: "POST",
                  //     url: "server/save-receipt.php",
                  //     data: {
                  //       receipt_no: $('#receipt-inner h6 p').text(),
                  //       rental_name: $('#receipt-inner > h4').text(),
                  //       location: $('#location').text(),
                  //       tel: $('#tel2').val(),
                  //       tenant_name: $('#tenant_name').val(),
                  //       tenant_phone: $('#tenant_phone').val(),
                  //       house_number: $('#house_number2').val(),
                  //       amount_received: $('#amount_received2').val(),
                  //       balance: $('#balance2').val(),
                  //       latest_payment: $('#latest_payment2').val(),
                  //       payment_for: $('#payment-for').text();
                  //     },
                  //     success: function (response) {
                  //     }
                  //   });
                  // });
                }
              });
            }
          })

          $('#startDate').on('change', function(){
            var criteria = $('#startDate').children('option:selected').val();
            if(criteria != ''){
              $.ajax({
                type: "POST",
                url: "server/all-receipts2.php",
                data: {criteria: criteria},
                dataType: 'html',
                success: function(response){
                  $('.lightGallery').html(response);
                  $('#gallery').show();
                }
              });
            }
          })


          //reprinting receipt
          $('.reprint').on('click', function(){
            const receipt_id = $(this).val();
            $.ajax({
              type: "get",
              url: "server/reprint.php",
              data: {receipt_id: receipt_id},
              dataType: "html",
              success: function (response) {
                $('#print').html(response);
                $('#print').show();
                print2();
              }
            });
          })

          //deleting receipt
          $('.delete').on('click', function(){
            const receipt_id = $(this).val();
            $.ajax({
              type: "get",
              url: "server/delete_receipt.php",
              data: {receipt_id: receipt_id},
              success: function (response) {
                if(response == 'ok'){
                  location.reload();
                }
              },
              error: function(response){
                alert('Error Occurred!');
              }
            });
          })

          function print(){
            const receipt = document.getElementById('print');
            var display_receipts = $('.receipt-sheet').length;
            for(var i = 0; i < display_receipts; i++){
                $.ajax({
                  type: "POST",
                  url: "server/save-receipt.php",
                  data: {
                    receipt_no: $('.receipt-sheet:eq('+i+')').find('#receipt-inner h6 p').text(),
                    rental_name: $('.receipt-sheet:eq('+i+')').find('#receipt-inner > h4').text(),
                    location: $('.receipt-sheet:eq('+i+')').find('#location').text(),
                    tel: $('.receipt-sheet:eq('+i+')').find('#tel2').val(),
                    tenant_name: $('.receipt-sheet:eq('+i+')').find('#tenant_name').val(),
                    tenant_phone: $('.receipt-sheet:eq('+i+')').find('#tenant_phone').val(),
                    house_number: $('.receipt-sheet:eq('+i+')').find('#house_number2').val(),
                    amount_received: $('.receipt-sheet:eq('+i+')').find('#amount_received2').val(),
                    balance: $('.receipt-sheet:eq('+i+')').find('#balance2').val(),
                    latest_payment: $('.receipt-sheet:eq('+i+')').find('#latest_payment2').val(),
                    payment_for: $('.receipt-sheet:eq('+i+')').find('.payment-for').text()
                  },
                  success: function (response) {
                  }
                });
            }
            const options = {
              margin: 0,
            };
            html2pdf()
            .from(receipt)
            .set(options)
            .save('all_receipts').then(pdf =>{
              $('#print').html('');
            });
          }

            //for reprinting a receipt
            function print2(){
            const receipt = document.getElementById('print');
            const tenant_name = document.getElementById('tenant_name').value;
            const options = {
                  margin: 0,
                };
                html2pdf()
                .from(receipt)
                .set(options)
                .save(tenant_name).then(pdf =>{
                  $('#print').html('');
                });
            }

            //printing receipt
            $('.print').on('click', function(){
              $('#print').show().promise().then(function(){
                if($('#print').html() != ''){
                  print();
                }
                else{
                  alert('No receipt!');
                }
              })
            });

            $('#tenant-heading h5').text('Choose receipt generation criteria');
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
    <!--Text Editor-->
    <script src="js/editorDemo.js"></script>
    <!-- plugin js for this page -->
  </body>
</html>