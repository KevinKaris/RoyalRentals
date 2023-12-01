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

  <body>
    <style>
      #new-rental{
        width: fit-content;
      }
      #new-tenant > form #name, #county, #sub-county, #location, #rent, #manager, #size, #houses, #money, #occupied-houses{
          background: linear-gradient(85deg, #392c70, #6a005b);
          color: #fff;
      }
      #report1, #report2{
          border: 2px gray dotted;
      }
      #report2 span{
          font-size: 18px !important;
      }
      .print{
          display: none;
      }
      #report1{
          max-height: 0;
          visibility: hidden;
          transition: 1s ease-in-out;
      }
      .report-hidden{
        display: none;
      }
      #order-listing{
        max-height: 420px;
        overflow: scroll;
      }
    </style>
    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
      <?php include 'heading.php' ?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">Monthly Report</h3>
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
                <div id="new-tenant" class="col-md-6 grid-margin card stretch-card">
                    <form action="#" class="my-3 d-flex flex-row justify-content-between flex-wrap">
                        <div class="class-group mt-3 col-md-12">
                            <label for="rental2">Select Rental</label>
                            <select name="rental" id="rental2" class="form-control">
                              <option value="">-- select rental --</option>
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
                        <div class="class-group mt-3 col-md-5">
                            <label for="month2">Select Month</label>
                            <select name="month" id="month2" class="form-control">
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
                        </div>
                        <div class="class-group mt-3 col-md-5">
                            <label for="year2">Select Year</label>
                            <select name="year" id="year2" class="form-control">
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
                    </form>
                </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Monthly Report</h4>
                    <button class="btn btn-sm btn-outline-danger mx-3 mb-2 pdf" style="float:right;">Export PDF</button>
                    <button class="btn btn-sm btn-outline-success mb-2 excel" style="float:right;">Export Excel</button>
                    <div class="table-responsive">
                      <table id="order-listing" class="table">
                          <tr class="bg-primary text-white">
                              <th>Tenant</th>
                              <th>House No</th>
                              <th>House Size</th>
                              <th>Rent</th>
                              <th>Paid</th>
                              <th>Balance</th>
                          </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php include '../pages/layout/footer.php' ?>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
        <!-- main-panel ends -->
      </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>
    <script src="../js/jquery_3.6.0.min.js"></script>
    <script src="../js/saveAsExcel.js"></script>
    <script>
        $(document).ready(function(){
            //loading report
            $('#rental2, #month2, #year2').on('change', function(){
              var rental = $('#rental2 option:selected').val();
              var month = $('#month2 option:selected').val();
              var year = $('#year2 option:selected').val();
              if(rental != ''){
                $.ajax({
                  type: "get",
                  url: "../server/report.php",
                  data: {rental: rental, month: month, year: year},
                  dataType: "html",
                  success: function (response){
                    $('#order-listing').html(response);
                  }
                })
              }
            })

            //exporting report to excel
            $('.excel').on('click', function(){
              var rental_name = $('.rental_name_hidden').val();
              var month = $('#month2 option:selected').val();
              var year = $('#year2 option:selected').val();
              if($('.rental_name_hidden').length > 0 && rental_name != ''){
                $('.report-hidden').show();
                saveAsExcel('order-listing', rental_name+' report_'+month+'-'+year);
                $('.report-hidden').hide();
              }
              else{
                alert('Rental required!');
              }
            })

            //exporting report to pdf
            $(".pdf").on('click', function(){
              var rental_name = $('.rental_name_hidden').val();
              var month = $('#month2 option:selected').val();
              var year = $('#year2 option:selected').val();
              if($('.rental_name_hidden').length > 0 && rental_name != ''){
                var doc = new jsPDF();
        
                // Add header
                doc.setFontSize(12);
                doc.setFont("helvetica", "bold");
                doc.text("Monthly Report", 14, 6);
                doc.text('Rental: '+rental_name, 14, 12);
                doc.text(month+'-'+year, 14, 18);

                // Add footer
                var pageCount = doc.internal.getNumberOfPages();
                for (var i = 1; i <= pageCount; i++) {
                  doc.setPage(i);
                  doc.setFont("helvetica", "normal");
                  doc.text("Page " + i + " of " + pageCount, 20, doc.internal.pageSize.height - 10);
                  doc.setFontSize(10);
                  doc.setFont("helvetica", "italic");
                  doc.text('© RoyalRentals', 50, doc.internal.pageSize.height - 10);
                  doc.text('Printed by: <?php echo $_SESSION['username']?>', 90, doc.internal.pageSize.height - 10);
                }
                

                // Export table to PDF
                doc.autoTable({
                  html: '#order-listing',
                  theme: 'grid',
                  margin: { top: 20 },
                  headStyles: { fillColor: [0, 51, 102], textColor: 255, fontSize: 12 },
                  bodyStyles: { textColor: 0, fontSize: 10 },
                  didDrawPage: function (data) {
                    // Add additional styling or content on each page if needed
                  }
                });

                doc.save('Monthly Report '+rental_name+'_'+month+'-'+year);
              }
              else{
                alert('Rental required!');
              }
            })
         })
    </script>
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
  <!-- Custom js for this page-->
  <script src="../js/dashboard.js"></script>

  <script src="../js/alerts.js"></script>
  <script src="../js/avgrund.js"></script>
  <!-- End custom js for this page-->
  </body>

</html>
