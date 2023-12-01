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
              <h3 class="page-title">Owner Documentation</h3>
            </div>
            <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <div class="faq-section">
                    <div class="container-fluid bg-dark py-2">
                      <p class="mb-0 text-white">Introduction</p>
                    </div>
                    <div id="accordion-1" class="accordion">
                      <div class="card">
                        <div class="card-header" id="headingOne">
                          <h5 class="mb-0">
                            <a data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                Introduction
                            </a>
                          </h5>
                        </div>
                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion-1">
                          <div class="card-body">
                            This system makes it easy for you to manage rentals. Each Section of this documentation represents each module (menu) and describes how it works. You can go directly to the section(s) you are interested with.
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="faq-section mt-4">
                    <div class="container-fluid bg-warning py-2 mt-5">
                      <p class="mb-0 text-white">My Rentals</p>
                    </div>
                    <div id="accordion-2" class="accordion">
                      <div class="card">
                        <div class="card-header" id="headingOne-2">
                          <h5 class="mb-0">
                            <a data-toggle="collapse" data-target="#collapseOne-2" aria-expanded="false" aria-controls="collapseOne-2">
                              My Rentals
                            </a>
                          </h5>
                        </div>
                        <div id="collapseOne-2" class="collapse" aria-labelledby="headingOne-2" data-parent="#accordion-2">
                          <div class="card-body">
                            Here, all your rentals are listed here. <br>
                            To create new rental, click <b>New Rental</b>, fill name, county, sub county, ward, location, rental size(optional) and click add to save. Once a rental is created, you can now add a manager as described in the following section. <br>
                            Click edit icon to edit rental, and delete icon to delete the rental.
                          </div>
                        </div>
                      </div>
                      </div>
                    </div>
                  </div>
                  <div class="faq-section mt-4">
                    <div class="container-fluid bg-danger py-2 mt-5">
                      <p class="mb-0 text-white">Managers</p>
                    </div>
                    <div id="accordion-3" class="accordion">
                      <div class="card">
                        <div class="card-header" id="headingOne-3">
                          <h5 class="mb-0">
                            <a data-toggle="collapse" data-target="#collapseOne-3" aria-expanded="false" aria-controls="collapseOne-3">
                              Managers
                            </a>
                          </h5>
                        </div>
                        <div id="collapseOne-3" class="collapse" aria-labelledby="headingOne-3" data-parent="#accordion-3">
                          <div class="card-body">
                            Created managers are listed here. <br>
                            To create a new manager, first make sure you have already created a rental, then fill manager information (First name, last name, username, phone, email, assign rental(selected the rental you want to assign that person to)), temporary password and click Save. <b>Note:</b> Once the manager is able to login, he/she can change the password and other information apart from rental assign to. <br><br>
                            From the list of mangers in the table, you can call the managers and also delete them.
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="faq-section mt-4">
                    <div class="container-fluid bg-primary py-2 mt-5">
                      <p class="mb-0 text-white">Set Rents</p>
                    </div>
                    <div id="accordion-4" class="accordion">
                      <div class="card">
                        <div class="card-header" id="headingOne-4">
                          <h5 class="mb-0">
                            <a data-toggle="collapse" data-target="#collapseOne-4" aria-expanded="false" aria-controls="collapseOne-4">
                              Set Rents
                            </a>
                          </h5>
                        </div>
                        <div id="collapseOne-4" class="collapse" aria-labelledby="headingOne-4" data-parent="#accordion-4">
                          <div class="card-body">
                              In this module, you set rent for different house sizes in your rentals. All rents set are listed in the table. <br>
                              To set new rent, click <b>New Rent</b>, choose rental, select house size, enter amount and click <b>set</b> <br>
                              Once rent set, you can edit amount by clicking edit icon of the rent set in the table. Similary, you can delete the rent by clicking delete icon.
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="faq-section mt-4">
                    <div class="container-fluid bg-info py-2 mt-5">
                      <p class="mb-0 text-white">Inquiry</p>
                    </div>
                    <div id="accordion-5" class="accordion">
                      <div class="card">
                        <div class="card-header" id="headingOne-5">
                          <h5 class="mb-0">
                            <a data-toggle="collapse" data-target="#collapseOne-5" aria-expanded="false" aria-controls="collapseOne-5">
                              Inquiry
                            </a>
                          </h5>
                        </div>
                        <div id="collapseOne-5" class="collapse" aria-labelledby="headingOne-5" data-parent="#accordion-5">
                          <div class="card-body">
                              To inquire all information about a specific rental, this is the module to do that for you. What you have to do is to select the rental from a list of your rentals, and the module retrieves rental name, county, sub county, location, rental size, manager's name, number of houses, number of occupied houses, total expenses of the current month, total rent collected current month, and profit (Calculated from total expected rent of the current month minus total expenses of the current month);
                          </div>
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
          <!-- partial -->
          <?php include '../pages/layout/footer.php' ?>
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
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
