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
              <h3 class="page-title">Email Services</h3>
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
                  <h4 class="card-title">Email all tenants</h4>
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
                  <h4 class="card-title">Email tenants with balances</h4>
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
                  <h4 class="card-title">Email tenants without balances</h4>
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
                  <h4 class="card-title">Email specific tenant</h4>
                  <form class="forms-sample">
                    <div class="form-group" id="tenant">
                      <label for="exampleInputEmail3">Select Tenant</label>
                      <select class="form-control tenant-name" id="exampleInputEmail23">
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
                  <h4 class="card-title">Email tenants with specific balance range</h4>
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

            $('#exampleInputEmail1').on('change', function(){
              var identity = $(this).children("option:selected").val();
              if(identity != ''){
                if(identity == 'name'){
                  $('#tenant').show();
                  $('#house').hide();
                }
                else{
                  $('#tenant').hide();
                  $('#house').show();
                }
              }
            })
        })
    </script>

    <!-- container-scroller -->

    <script>
      $(document).ready(function(){
        $('#send1').on('click', function(e){
          e.preventDefault();
          var all_tenants = $('.ql-editor').html();
          if($('#quillExample1').text() != ''){
            showSwal('auto-close');
            $.ajax({
              type: "POST",
              url: "server/email-service.php",
              data: {all_tenants: all_tenants},
              success: function (response){
                if(response == '1'){
                  return showSwal('success-message');
                  $('#quillExample1').text('');
                }
              },
              error: function(){
                return showSwal('server-message-without-cancel');
              }
            });
          }
          else{
            alert('Content required');
          }
        })
        $('#send2').on('click', function(e){
          e.preventDefault();
          var with_balance = $('.ql-editor').html();
          if($('#quillExample2').text() != ''){
            showSwal('auto-close');
            $.ajax({
              type: "POST",
              url: "server/email-service.php",
              data: {with_balance: with_balance},
              success: function (response){
                if(response == '1'){
                  return showSwal('success-message');
                  $('#quillExample2').text('');
                }
              },
              error: function(){
                return showSwal('server-message-without-cancel');
              }
            });
          }
          else{
            alert('Content required');
          }
        })
        $('#send3').on('click', function(e){
          e.preventDefault();
          var without_balance = $('.ql-editor').html();
          if($('#quillExample3').text() != ''){
            showSwal('auto-close');
            $.ajax({
              type: "POST",
              url: "server/email-service.php",
              data: {without_balance: without_balance},
              success: function (response){
                if(response == '1'){
                  return showSwal('success-message');
                  $('#quillExample3').text('');
                }
              },
              error: function(){
                return showSwal('server-message-without-cancel');
              }
            });
          }
          else{
            alert('Content required');
          }
        })
        $('#send4').on('click', function(e){
          e.preventDefault();
          var specific = $('.ql-editor').html();
          var tenant_id = $('#tenant select').children('option:selected').val();
          if(tenant_id != ''){
            if($('#quillExample4').text() != ''){
              showSwal('auto-close');
              $.ajax({
                type: "POST",
                url: "server/email-service.php",
                data: {specific: specific, tenant_id: tenant_id},
                success: function (response){
                  if(response == '1'){
                    return showSwal('success-message');
                    $('#quillExample4').text('');
                  }
                },
                error: function(){
                  return showSwal('server-message-without-cancel');
                }
              });
            }
            else{
              alert('Content required');
            }
          }
        })
        $('#send5').on('click', function(e){
          e.preventDefault();
          var specific = $('.ql-editor').html();
          var criteria = $('.specific-amount #exampleInputEmail1').children('option:selected').val();
          var amount = $('.specific-amount #exampleInputEmail2').val();
          if(amount != ''){
            if($('#quillExample5').text() != ''){
              showSwal('auto-close');
              $.ajax({
                type: "POST",
                url: "server/email-service.php",
                data: {specific: specific, criteria: criteria, amount:amount},
                success: function (response){
                  alert(response);
                  if(response == '1'){
                    return showSwal('success-message');
                    $('#quillExample5').text('');
                  }
                  if(response == '0'){
                    alert('No Tenant passes that criteria');
                  }
                },
                error: function(){
                  return showSwal('server-message-without-cancel');
                }
              });
            }
            else{
              alert('Content required');
            }
          }
        })
      })
    </script>

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
