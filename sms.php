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
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="css/style.css" />
    <!-- endinject -->
    <link rel="shortcut icon" href="images/logo_mini.png" />
  </head>

  <style>
    .all, .with, .without, .specific-t, .specific-amount{
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
              <h3 class="page-title">SMS Services</h3>
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
              <div class="col-md-6 grid-margin stretch-card bg-transparent d-flex flex-column">
                <a href="javascript:void()" class="my-3 text-dark" id="all" style="text-decoration: none;">All Tenants</a>
                <a href="javascript:void()" class="my-3 text-dark" id="with" style="text-decoration: none;">Tenants with Balances</a>
                <a href="javascript:void()" class="my-3 text-dark" id="without" style="text-decoration: none;">Tenants without Balances</a>
                <a href="javascript:void()" class="my-3 text-dark" id="specific-t" style="text-decoration: none;">Specific Tenant</a>
                <a href="javascript:void()" class="my-3 text-dark" id="specific-amount" style="text-decoration: none;">Tenants with Specific Balance Range</a>
              </div>
            <div class="col-md-6 grid-margin stretch-card all">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">SMS all tenants</h4>
                  <form class="forms-sample">
                    <div class="form-group">
                      <label for="summernoteExample">Message</label>
                      <div class="row grid-margin">
                        <div class="col-lg-12">
                        <div class="card">
                            <div id="quillExample1" class="quill-container">
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2" id="send1">Send</button>
                    <button class="btn btn-light reset">Reset</button>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card with">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">SMS tenants with balances</h4>
                  <form class="forms-sample">
                    <div class="form-group">
                      <label for="summernoteExample">Message</label>
                      <div class="row grid-margin">
                        <div class="col-lg-12">
                        <div class="card">
                            <div id="quillExample2" class="quill-container">
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2" id="send2">Send</button>
                    <button class="btn btn-light reset">Reset</button>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card without">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">SMS tenants without balances</h4>
                  <form class="forms-sample">
                    <div class="form-group">
                      <label for="summernoteExample">Message</label>
                      <div class="row grid-margin">
                        <div class="col-lg-12">
                        <div class="card">
                            <div id="quillExample3" class="quill-container">
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2" id="send3">Send</button>
                    <button class="btn btn-light reset">Reset</button>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card specific-t">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">SMS specific tenant</h4>
                  <form class="forms-sample">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Identify tenant by</label>
                      <select name="" class="form-control" id="exampleInputEmail1">
                        <option value="">--</option>
                        <option value="name">name</option>
                        <option value="house-number">house number</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail2">Value</label>
                      <input type="text" class="form-control payment-amount" id="exampleInputEmail2" placeholder="Value">
                    </div>
                    <div class="form-group">
                      <label for="summernoteExample">Message</label>
                      <div class="row grid-margin">
                        <div class="col-lg-12">
                        <div class="card">
                            <div id="quillExample4" class="quill-container">
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2" id="send4">Send</button>
                    <button class="btn btn-light reset">Reset</button>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card specific-amount">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">SMS tenants with specific balance range</h4>
                  <form class="forms-sample">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Choose Criteria</label>
                      <select name="" class="form-control" id="exampleInputEmail1">
                        <option value="">--</option>
                        <option value=">">greater than</option>
                        <option value="=">equal to</option>
                        <option value="<">less than</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail2">Amount</label>
                      <input type="number" class="form-control payment-amount" id="exampleInputEmail2" placeholder="Amount">
                    </div>
                    <div class="form-group">
                      <label for="summernoteExample">Message</label>
                      <div class="row grid-margin">
                        <div class="col-lg-12">
                        <div class="card">
                            <div id="quillExample5" class="quill-container">
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2" id="send5">Send</button>
                    <button class="btn btn-light reset">Reset</button>
                  </form>
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
        $('.reset').on('click', function(e){
            e.preventDefault();
            $(this).parent().find('.ql-editor').html('');
        })

        $(window).ready(function(){
            $('#send1').on('click', function(e){
                if($(this).parent().find('.ql-editor p').text() == ''){
                    e.preventDefault();
                    alert('Write a message');
                }
            })
            $('#send2').on('click', function(e){
                if($(this).parent().find('.ql-editor p').text() == ''){
                    e.preventDefault();
                    alert('Write a message');
                }
            })
            $('#send3').on('click', function(e){
                if($(this).parent().find('.ql-editor p').text() == ''){
                    e.preventDefault();
                    alert('Write a message');
                }
            })
            $('#send4').on('click', function(e){
                if($(this).parent().find('#exampleInputEmail1').children('option:selected').val() == ''){
                    e.preventDefault();
                    alert('Identify tenant by not selected');
                }
                if($(this).parent().find('#exampleInputEmail2').val() == ''){
                    e.preventDefault();
                    alert('Value empty');
                }
                if($(this).parent().find('.ql-editor p').text() == ''){
                    e.preventDefault();
                    alert('Write a message');
                }
            })
            $('#send5').on('click', function(e){
                if($(this).parent().find('#exampleInputEmail1').children('option:selected').val() == ''){
                    e.preventDefault();
                    alert('Criteria empty');
                }
                if($(this).parent().find('#exampleInputEmail2').val() == ''){
                    e.preventDefault();
                    alert('Amount empty');
                }
                if($(this).parent().find('.ql-editor p').text() == ''){
                    e.preventDefault();
                    alert('Write a message');
                }
            })

            $('#all').on('click', function(){
              $('.all').show();
              $('.with, .without, .specific-t, .specific-amount').hide();
            })
            $('#with').on('click', function(){
              $('.with').show();
              $('.all, .without, .specific-t, .specific-amount').hide();
            })
            $('#without').on('click', function(){
              $('.without').show();
              $('.all, .with, .specific-t, .specific-amount').hide();
            })
            $('#specific-t').on('click', function(){
              $('.specific-t').show();
              $('.all, .with, .without, .specific-amount').hide();
            })
            $('#specific-amount').on('click', function(){
              $('.specific-amount').show();
              $('.all, .with, .without, .specific-t').hide();
            })
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
  <script src="vendors/tinymce/tinymce.min.js"></script>
  <script src="vendors/tinymce/themes/modern/theme.js"></script>
  <script src="vendors/summernote/dist/summernote-bs4.min.js"></script>
  </body>
</html>