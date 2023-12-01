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
      height: 585px;
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
    .blurred{
      color: transparent;
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
              <h3 class="page-title">Individual Receipt Generation</h3>
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
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Print Individual Receipt</h4>
                  <form class="forms-sample">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Select tenant</label>
                      <select name="" class="form-control" id="exampleInputEmail1">
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
                    <button type="" class="btn btn-primary mr-2 btn-sm" id="view">Generate Receipt Preview</button>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-lg-8 pl-lg-5">
                      <div class="d-flex justify-content-between">
                        <div>
                          <h3 id="section-title"></h3>
                        </div>
                        <button class="btn btn-primary print"><i class="fa fa-print"></i></button>
                      </div>
                      <div class="profile-feed">
                        <!-- <div id="edits">
                            <h5 class="mt-3">Edit</h5>
                            <div class="form-group">
                                <label for="startDate">Month Paid For (Enter Month and Year)</label>
                                <input id="startDate" type="text" class="form-control startDate" placeholder="e.g March-2023 or March/2023">
                            </div>
                        </div> -->
                        <div id="receipt-sheet">
                            <div id="receipt-inner" class="blurred">
                              <h4 align="center"></h4>
                              <p id="row"><strong id="location"></strong><strong id="tel"></strong></p>
                              <section style="float: right; margin-right: 7px; font-size: 14px;"><strong id="date"></strong></section>
                              <h6 id="row">Rent Payment Receipt <small class="row mx-1"><strong>Receipt No.&nbsp;</strong><p></p></small></h6>
                              <div id="content">
                                <input type="hidden" value="" id="tenant_name">
                                  <p id="tn"></p>
                                  <p id="tp"></p>
                                  <p id="hn"></p>
                                  <p id="row"><span id="received"></span><span id="balance"></span></p>
                                  <p id="row"><span id="lt"></span><span><strong>Payment For:&nbsp;</strong><small style="font-size: 13px;" id="payment-for"></small></span></p>
                              </div>
                              <span class="w-100 text-muted text-center d-block d-sm-inline-block m-0 p-0" style="font-size: 10px">Developed by melody</span>
                            </div>
                            <input type="hidden" id="tel2">
                            <input type="hidden" id="house_number2">
                            <input type="hidden" id="amount_received2">
                            <input type="hidden" id="balance2">
                            <input type="hidden" id="latest_payment2">
                            <input type="hidden" id="tenant_phone">
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
    <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.js"></script>
    <script>
        $('.reset').on('click', function(e){
            e.preventDefault();
            $(this).parent().find('.ql-editor p').html('');
        })

        $(document).ready(function(){
            // $('#view').on('click', function(e){
            //     if($(this).parent().find('#exampleInputEmail1').children('option:selected').val() == ''){
            //         e.preventDefault();
            //         alert('Select a tenant');
            //     }
            // })

            //generating a receipt
            $('#view').on('click', function(e){
              if($('#exampleInputEmail1').children('option:selected').val() == ''){
                e.preventDefault();
                alert('Select a tenant!');
              }
            })
            $('#exampleInputEmail1').on('change', function(){
              var tenant_id = $('#exampleInputEmail1').children('option:selected').val();
              $('#view').on('click', function(e){
                e.preventDefault();
                if(tenant_id != ''){
                  $.ajax({
                    type: "POST",
                    url: "server/individual-receipt.php",
                    data: {tenant_id: tenant_id},
                    dataType: "json",
                    success: function (response) {
                      $('#receipt-inner').removeClass('blurred');
                      $('#receipt-inner > h4').text(response.rental_name);
                      $('#location').text(response.location);
                      $('#tel').text('Tel: 0'+response.tel);
                      $('#receipt-inner h6 p').text(response.receipt_number);
                      $('#tenant_name').val(response.tenant_name);
                      $('#tn').html('<strong>Tenant Name: </strong>'+response.tenant_name);
                      $('#tp').html('<strong>Phone Number: </strong>0'+response.tenant_phone);
                      $('#hn').html('<strong>House Number: </strong>'+response.house_number);
                      $('#received').html('<strong>Amount Received: </strong>'+response.amount);
                      $('#balance').html('<strong>Balance: </strong>'+response.balance);
                      $('#lt').html('<strong>Latest Payment Date: </strong>'+response.latest_payment);
                      $('#payment-for').text(response.payment_for);
                      $('#section-title').text(response.tenant_name);
                      $('#date').text('Date: '+response.date);

                      $('#latest_payment2').val(response.latest_payment);
                      $('#balance2').val(response.balance);
                      $('#amount_received2').val(response.amount);
                      $('#house_number2').val(response.house_number);
                      $('#tenant_phone').val('0'+response.tenant_phone);
                      $('#tel2').val('0'.response.tel);
                    }
                  });
                }
              })
            })

            //printing receipt
            $('.print').on('click', function(){
              //generateReceipt();
              print();
            })

            function print(){
            const receipt = document.getElementById('receipt-sheet');
            const tenant_name = $('#section-title').text();
            const options = {
                  margin: 0,
                };
                html2pdf()
                .from(receipt)
                .set(options)
                .save(tenant_name);

                //save receipt
                $.ajax({
                    type: "POST",
                    url: "server/save-receipt.php",
                    data: {
                      receipt_no: $('#receipt-inner h6 p').text(),
                      rental_name: $('#receipt-inner > h4').text(),
                      location: $('#location').text(),
                      tel: $('#tel2').val(),
                      tenant_name: $('#tenant_name').val(),
                      tenant_phone: $('#tenant_phone').val(),
                      house_number: $('#house_number2').val(),
                      amount_received: $('#amount_received2').val(),
                      balance: $('#balance2').val(),
                      latest_payment: $('#latest_payment2').val(),
                      payment_for: $('#payment-for').text()
                    },
                    success: function (response) {
                    }
              });
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
    <!--Text Editor-->
    <script src="js/editorDemo.js"></script>
    <!-- plugin js for this page -->
  </body>
</html>