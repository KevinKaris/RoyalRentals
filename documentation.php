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
    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
      <?php include 'pages/layout/heading.php' ?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">Documentation</h3>
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
                            This system makes it easy for you to manage tenants, houses and everthing around there. Each Section of this documentation represents each module (menu) and describes how it works. You can go directly to the section(s) you are interested with.
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="faq-section mt-4">
                    <div class="container-fluid bg-warning py-2 mt-5">
                      <p class="mb-0 text-white">Tenants</p>
                    </div>
                    <div id="accordion-2" class="accordion">
                      <div class="card">
                        <div class="card-header" id="headingOne-2">
                          <h5 class="mb-0">
                            <a data-toggle="collapse" data-target="#collapseOne-2" aria-expanded="false" aria-controls="collapseOne-2">
                              All Tenants
                            </a>
                          </h5>
                        </div>
                        <div id="collapseOne-2" class="collapse" aria-labelledby="headingOne-2" data-parent="#accordion-2">
                          <div class="card-body">
                            Here, you see all tenants in the rental including there balances shown using progress bars. You can search tenants based on anything e.g, name, phone, balance, email etc. You can also <em>edit(reprented by pen looking icon)</em>, <em>fine</em> and <em>delete(represented by trash looking icon)</em> tenant, using options at the far end of each tenant.<br><br>
                            You can add new tenant by clicking <b>New Tenant</b> button and a form will pop up. In the form, your are required to fill names of the tenant, ID number, ID photos (optional), phone number, email (optional), select house size for the tenant, select house number and finally click <b>Register</b> button to save.
                          </div>
                        </div>
                      </div>
                      <div class="card">
                        <div class="card-header" id="headingTwo-2">
                          <h5 class="mb-0">
                            <a data-toggle="collapse" data-target="#collapseTwo-2" aria-expanded="false" aria-controls="collapseTwo-2">
                              Tenants with balances
                            </a>
                          </h5>
                        </div>
                        <div id="collapseTwo-2" class="collapse" aria-labelledby="headingTwo-2" data-parent="#accordion-2">
                          <div class="card-body">
                            All tenants with rent balances are displayed here. You can check which had balance in a certain month and year by selecting month and year at the top of the table. Each tenant has progress bar indicating how much or how far the tenant has paid rent<br>
                          </div>
                        </div>
                      </div>
                      <div class="card">
                        <div class="card-header" id="headingThree-2">
                          <h5 class="mb-0">
                            <a data-toggle="collapse" data-target="#collapseThree-2" aria-expanded="false" aria-controls="collapseThree-2">
                              Tenants without balances
                            </a>
                          </h5>
                        </div>
                        <div id="collapseThree-2" class="collapse" aria-labelledby="headingThree-2" data-parent="#accordion-2">
                          <div class="card-body">
                            All tenants without balances appear here having their progress bars fully filled.
                          </div>
                        </div>
                      </div>
                      <div class="card">
                        <div class="card-header" id="headingFour-2">
                          <h5 class="mb-0">
                            <a data-toggle="collapse" data-target="#collapseFour-2" aria-expanded="false" aria-controls="collapseFour-2">
                              Fined Tenants
                            </a>
                          </h5>
                        </div>
                        <div id="collapseFour-2" class="collapse" aria-labelledby="headingFour-2" data-parent="#accordion-2">
                          <div class="card-body">
                            Once a tenant if fined appears here. So, all fined tenants appear here. At the farthest end of each tenant there are three options. You have option <b>Call (you click there to call the tenant)</b>, <b>Payment (click here to record fine payment by the tenant, enter amount and click submit to save)</b> and <b>Delete(trash like icon).</b> The tenant is deleted from fined list.
                          </div>
                        </div>
                        <div class="card">
                        <div class="card-header" id="headingFive-2">
                          <h5 class="mb-0">
                            <a data-toggle="collapse" data-target="#collapseFive-2" aria-expanded="false" aria-controls="collapseFive-2">
                              Recent Tenants
                            </a>
                          </h5>
                        </div>
                        <div id="collapseFive-2" class="collapse" aria-labelledby="headingFive-2" data-parent="#accordion-2">
                          <div class="card-body">
                            All recently(past two months) registered tenants are displayed here.
                          </div>
                        </div>
                      </div>
                      </div>
                    </div>
                  </div>
                  <div class="faq-section mt-4">
                    <div class="container-fluid bg-danger py-2 mt-5">
                      <p class="mb-0 text-white">Houses</p>
                    </div>
                    <div id="accordion-3" class="accordion">
                      <div class="card">
                        <div class="card-header" id="headingOne-3">
                          <h5 class="mb-0">
                            <a data-toggle="collapse" data-target="#collapseOne-3" aria-expanded="false" aria-controls="collapseOne-3">
                              Houses
                            </a>
                          </h5>
                        </div>
                        <div id="collapseOne-3" class="collapse" aria-labelledby="headingOne-3" data-parent="#accordion-3">
                          <div class="card-body">
                            Here there are three tables, one for <b>occupied houses</b>, another <b>vacant houses</b> and another <b>faulty</b><br><br>
                            <b>Occupied Houses</b> - This list contains all occupied houses. A house becomes vacant once a tenant is deleted<br><br>
                            <b>Vacant Houses</b> - This table shows all vacant houses. In here, if a houses becomes faulty or if you're willing to declare it faulty, click <b>Faulty</b> button at the far end of the vacant house. <br><br>
                            <b>Faulty Houes</b> - Faulty houses appear here. To remove a house from that list and become vacant, click <b>Renovated</b> button.
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="faq-section mt-4">
                    <div class="container-fluid bg-primary py-2 mt-5">
                      <p class="mb-0 text-white">Rent Payment</p>
                    </div>
                    <div id="accordion-4" class="accordion">
                      <div class="card">
                        <div class="card-header" id="headingOne-4">
                          <h5 class="mb-0">
                            <a data-toggle="collapse" data-target="#collapseOne-4" aria-expanded="false" aria-controls="collapseOne-4">
                              Rent Payment
                            </a>
                          </h5>
                        </div>
                        <div id="collapseOne-4" class="collapse" aria-labelledby="headingOne-4" data-parent="#accordion-4">
                          <div class="card-body">
                              In this module, rent paid by tenants is recorded here. To record payment made, select <b>Registered based on</b>(register based on house number or tenant name) in <b>New Rent Payment</b> form, select <b>month paid for</b>(this is the month the tenant has paid for) and year too (current month and year are selected by default), enter <b>amount</b> and click <b>submit</b> to save payment. Click <b>reset</b> button to reset the form.<br><br>
                              Below New Payment Form, there is a table showing a list of all past payments (Payment History). This can be helpful to referrence payment made in the past. You can search a tenant to view their payment history.
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="faq-section mt-4">
                    <div class="container-fluid bg-info py-2 mt-5">
                      <p class="mb-0 text-white">Expenses</p>
                    </div>
                    <div id="accordion-5" class="accordion">
                      <div class="card">
                        <div class="card-header" id="headingOne-5">
                          <h5 class="mb-0">
                            <a data-toggle="collapse" data-target="#collapseOne-5" aria-expanded="false" aria-controls="collapseOne-5">
                              Expenses
                            </a>
                          </h5>
                        </div>
                        <div id="collapseOne-5" class="collapse" aria-labelledby="headingOne-5" data-parent="#accordion-5">
                          <div class="card-body">
                              This module shows expenses concerning the rental incurred in the current month. Expenses incurred in past months won't be indicated there but remain saved.<br>
                              The first section having the title <b>Current Month Expenses</b> shows a summation of all expenses for the current month.<br>
                              The second section is a table that shows all expenses added in the current month and in the past months.
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="faq-section mt-4">
                    <div class="container-fluid bg-secondary py-2 mt-5">
                      <p class="mb-0 text-dark">Email Services</p>
                    </div>
                    <div id="accordion-6" class="accordion">
                      <div class="card">
                        <div class="card-header" id="headingOne-6">
                          <h5 class="mb-0">
                            <a data-toggle="collapse" data-target="#collapseOne-6" aria-expanded="false" aria-controls="collapseOne-6">
                              Email Services
                            </a>
                          </h5>
                        </div>
                        <div id="collapseOne-6" class="collapse" aria-labelledby="headingOne-6" data-parent="#accordion-6">
                          <div class="card-body">
                              This module provides a platform where you can send email messages to your tenants for free of charge. <b>Note: </b>Only tenants who have email addresses registered alongside with they information receives the message.<br> All you need to do is composing an email message and clicking Send, but before that before are the options your have to choose:<br><br>
                              <b>All Tenants</b> - Sends email to all tenants.<br>
                              <b>Tenants With Balances</b> - Sends email to tenants who have balances. <br>
                              <b>Tenants Without Balances</b> - Sends email to tenants who do not have balances. <br>
                              <b>Specific Tenant</b> - This sends email to a specific tenant. You select the tenant, compose the message and send. <br>
                              <b>Tenants with Specific Balance Range</b> - This option is used to send email to tenants having specific range of balances. First, you select the <b>Criteria</b> (Greater than, Less than or Equal to), enter amount, write the message and send.
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="faq-section mt-4">
                    <div class="container-fluid bg-warning py-2 mt-5">
                      <p class="mb-0 text-light">SMS Services</p>
                    </div>
                    <div id="accordion-7" class="accordion">
                      <div class="card">
                        <div class="card-header" id="headingOne-7">
                          <h5 class="mb-0">
                            <a data-toggle="collapse" data-target="#collapseOne-7" aria-expanded="false" aria-controls="collapseOne-7">
                              SMS Services
                            </a>
                          </h5>
                        </div>
                        <div id="collapseOne-7" class="collapse" aria-labelledby="headingOne-7" data-parent="#accordion-7">
                          <div class="card-body">
                              Currently not active
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="faq-section mt-4">
                    <div class="container-fluid bg-dark py-2 mt-5">
                      <p class="mb-0 text-light">Inquiry</p>
                    </div>
                    <div id="accordion-8" class="accordion">
                      <div class="card">
                        <div class="card-header" id="headingOne-8">
                          <h5 class="mb-0">
                            <a data-toggle="collapse" data-target="#collapseOne-8" aria-expanded="false" aria-controls="collapseOne-8">
                              Inquiry
                            </a>
                          </h5>
                        </div>
                        <div id="collapseOne-8" class="collapse" aria-labelledby="headingOne-8" data-parent="#accordion-8">
                          <div class="card-body">
                              To inquire all information about a specific tenant in a certain house, this is the module to do that. What you have to do is to select house number from a list of occupied houses, and the module retrieves house status, tenant name(s), phone number, ID number, how long the tenant has rented in the rental, rent the tenant is obligated to pay monthly, tenant balance, fine if there is any and displays tenant's ID photos if there are for you.
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="faq-section mt-4">
                    <div class="container-fluid bg-success py-2 mt-5">
                      <p class="mb-0 text-light">Receipts</p>
                    </div>
                    <div id="accordion-9" class="accordion">
                      <div class="card">
                        <div class="card-header" id="headingOne-9">
                          <h5 class="mb-0">
                            <a data-toggle="collapse" data-target="#collapseOne-9" aria-expanded="false" aria-controls="collapseOne-9">
                              Individual Tenant Receipt
                            </a>
                          </h5>
                        </div>
                        <div id="collapseOne-9" class="collapse" aria-labelledby="headingOne-9" data-parent="#accordion-9">
                          <div class="card-body">
                              Here, you generate and print individual tenant receipt. <br>
                              Select tenant and click <b>Generate Receipt</b> and a receipt is generated. Once generated, you can print receipt to PDF.
                          </div>
                        </div>
                      </div>
                      <div class="card">
                        <div class="card-header" id="headingTwo-9">
                          <h5 class="mb-0">
                            <a data-toggle="collapse" data-target="#collapseTwo-9" aria-expanded="false" aria-controls="collapseTwo-9">
                              All Tenants Receipts
                            </a>
                          </h5>
                        </div>
                        <div id="collapseTwo-9" class="collapse" aria-labelledby="headingTwo-9" data-parent="#accordion-9">
                          <div class="card-body">
                              Here, you generate and print receipts for all tenants. <br>
                              <b>Choose receipt generation criteria</b> (All tenants, Tenants with balances or Tenants without balances) and a receipts are generated. Once generated, you can print receipts to PDF.<br>
                              At the bottom of the page has a table showing receipts generated in the past and from that table you can search receipts for specific tenant, reprint and delete them.
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
          <?php include 'pages/layout/footer.php' ?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
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
  </body>
</html>
