<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <title>RoyalRentals</title>
    <!-- plugins:css -->
    <link
      rel="stylesheet"
      href="vendors/iconfonts/font-awesome/css/all.min.css"
    />
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
  .new-payment-outer, .update-outer, #new-tenant{
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
    .close{
      float: right;
    }
    .card{
      position: relative;
    }
    .card .new-tenant{
      position: absolute;
      right: 25px;
      top: 15px;
    }
    #configreset{
      display: none;
    }
    @media (max-width: 900px){
        .new-payment-form, #new-tenant > form{
            width: 70%;
        }
    }
    @media (max-width: 500px){
        .new-payment-form, #new-tenant > form{
            width: 95%;
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
              <h3 class="page-title">All tenants</h3>
              <!-- <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Tables</a></li>
                  <li class="breadcrumb-item active" aria-current="page">
                    Data table
                  </li>
                </ol>
              </nav> -->
            </div>
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">All tenants</h4>
                <button class="btn btn-primary new-tenant">New Tenant</button>
                <div class="row">
                  <div class="col-12">
                    <div class="table-responsive">
                      <table id="order-listing" class="table">
                        <thead>
                          <tr>
                            <th>Order #</th>
                            <th>Tenant Name</th>
                            <th>House No.</th>
                            <th>Rent/month</th>
                            <th>Payment status</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $sql= "SELECT * FROM houses WHERE rental_id = ?";
                          $rental_id = $_SESSION["rental_id"];
                          $statement = $con -> prepare($sql);
                          $statement -> execute([$rental_id]);
                          $fetch = $statement -> fetchAll();
                          $order = 0;
                          foreach($fetch as $fetch){
                            $house_id = $fetch["id"];
                            $select = "SELECT * FROM tenants";
                            $st = $con -> prepare($select);
                            $st -> execute();
                            $fetch2 = $st -> fetchAll();
                            foreach($fetch2 as $fetch2){
                              $house_id2 = $fetch2["house_id"];
                              if($house_id == $house_id2){
                                $house_size = $fetch2["size"];
                                $query = "SELECT DISTINCT * FROM rent WHERE rental_id = ? AND house_size = ?";
                                $st2 = $con -> prepare($query);
                                $st2 -> execute([$rental_id, $house_size]);
                                $rent = $st2 -> fetch();
                                $order += 1;
                                ?>
                                <tr>
                                  <td><?php echo $order?></td>
                                  <td><?php echo $fetch2["name"]?></td>
                                  <td><?php echo $fetch["number"]?></td>
                                  <td><?php echo $rent["amount"]?></td>
                                  <td>
                                    <?php
                                    $payment = "SELECT * FROM payment WHERE tenant_id = ? OR house_id = ? AND rent = ?";
                                    $st3 = $con -> prepare($payment);
                                    $st3 -> execute([$fetch2["id"], $house_id2, $rent['amount']]);
                                    $fetch3 = $st3 -> fetchAll();
                                    $rows = $st3 -> rowCount();
                                    $total_paid_rent = 0;
                                    if($rows > 0){
                                      foreach($fetch3 as $fetch3){
                                        // $timestamp = $fetch3["date"];
                                        // $date = new DateTime($timestamp);
                                        // $month = $date->format("m");
                                        $month = date('m', strtotime($fetch3["for_month"], '1'));
                                        $current_month = date('m');
                                        if($month == $current_month && $fetch3["for_year"] == date('Y')){
                                          $total_paid_rent += $fetch3["amount"];
                                        }
                                      }
                                    }
                                    ?>
                                    <?php
                                    if($total_paid_rent == 0){?>
                                      <label class="badge badge-danger badge-pill">Not paid</label>
                                    <?php
                                    }
                                    else if($total_paid_rent > 0 && $total_paid_rent < $rent["amount"]){?>
                                      <label class="badge badge-warning badge-pill">Partialy paid</label>
                                    <?php
                                    }
                                    else if($total_paid_rent >= $rent["amount"]){?>
                                      <label class="badge badge-success badge-pill">Fully paid</label>
                                    <?php }?>
                                  </td>
                                  <td>
                                    <button class="btn btn-outline-primary edit" value="<?php echo $fetch2["id"]?>">
                                      <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button class="btn btn-outline-warning fine" value="<?php echo $fetch2["id"]?>">
                                      fine
                                    </button>
                                    <button class="btn btn-outline-danger delete" value="<?php echo $fetch2["id"]?>">
                                      <i class="fas fa-trash"></i>
                                    </button>
                                  </td>
                                </tr>
                            <?php
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

          <div id="new-tenant">
            <form action="server/add-tenant.php" method="post" enctype="multipart/form-data">
              <h4>New Tenant <button class="btn close"><i class="fas fa-times"></i></button></h4>
              <div class="class-group mt-3">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Name">
              </div>
              <div class="class-group mt-3">
                <label for="name">ID Number</label>
                <input type="number" class="form-control" name="id_number" id="id" placeholder="ID Number">
              </div>
              <div class="class-group mt-3" id="photos">
                <label for="id-photo">ID Photos (optional)</label>
                <input type="file" accept=".jpg, .png, .webp, .jpeg" name="id_photos[]" multiple class="form-control" id="id-photo">
              </div>
              <div class="class-group mt-3">
                <label for="phone">Phone Number</label>
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone">
              </div>
              <div class="class-group mt-3">
                <label for="email">Email (optional)</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
              </div>
              <div class="class-group mt-3">
                <label for="name">House Size</label>
                <select name="size" id="size" class="form-control">
                  <option value="">--house size--</option>
                  <option value="Single">Single</option>
                  <option value="Double">Double</option>
                  <option value="Bed-Sitter">Bed-Sitter</option>
                  <option value="One-Bedroom">One-Bedroom</option>
                  <option value="Two-Bedroom">Two-Bedroom</option>
                  <option value="Three-Bedroom">Three-Bedroom</option>
                  <option value="Four-Bedroom">Four-Bedroom</option>
                </select>
              </div>
              <div class="class-group mt-3">
                <label for="name">House Number</label>
                <select class="form-control" id="house" name="house_id"></select>
              </div>
              <div class="class-group mt-3">
                <input type="submit" class="form-control btn btn-primary" name="register" id="register" value="Register">
              </div>
              <input type="reset" value="" id="configreset">
            </form>
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
    <div class="update-outer">
            <div class="card-body new-payment-form">
                  <h4 class="card-title">Enter Fine Amount</h4>
                  <form class="forms-sample">
                    <div class="form-group">
                      <label for="fine-amount">Fine Amount</label>
                      <input type="number" class="form-control rent-amount" id="fine-amount" placeholder="Amount...">
                    </div>
                    <button type="submit" id="fine-submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light" id="cancel">Cancel</button>
                  </form>
                </div>
        </div>
    <script>
      $('.fine').on('click', function(){
            $('.update-outer').fadeIn(300);
            $('.update-outer #cancel').on('click', function(e){
                e.preventDefault();
                $('.update-outer').fadeOut(300);
            })
            $('.update-outer #fine-submit').on('click', function(e){
                if($('.rent-amount').val() == ''){
                    e.preventDefault();
                    $('.rent-amount').css('border', '1px solid red');
                }
                else{
                    $('.rent-amount').css('border', '1px solid green');
                }
            })
          })

          //limiting the number of photos are selected
          $('#id-photo').on('change', function(){
            var max_photos = 2;
            var photos_selected = $(this)[0].files.length;
            if(photos_selected > max_photos){
              alert('Only maximum of 2 photos are allowed');
              $(this).val('');
            }
          })

          $(document).ready(function(){
            //new tenant form modal
            $('.new-tenant').on('click', function(){
              $('#new-tenant').fadeIn(500);

              $('.close').on('click', function(e){
                e.preventDefault();
                $('#new-tenant').fadeOut(500);
              })
            });

            //fetching rooms according to house size choosen
            $("#size").on("change", function(){
              if($("#size").children("option:selected").val() != ''){
                var size = $("#size").children("option:selected").val();
                $.ajax({
                  type: "GET",
                  url: "server/house-size.php",
                  data: {size: size},
                  success: function (response) {
                    $("#house").html(response);
                  }
                });
              }
            })

            //submitting fine
            $("#fine-submit").on("click", function(e){
              e.preventDefault();
              if($("#fine-amount").val() != ''){
                var tenant_id = $(".fine").val();
                var amount = $("#fine-amount").val();
                $.ajax({
                  type: "POST",
                  url: "server/fine.php",
                  data: {amount: amount, tenant_id: tenant_id},
                  success: function (response) {
                    if(response == '1'){
                      $('.update-outer').fadeOut(100);
                      $("#fine-amount").val('');
                      return showSwal('success-message');
                    }
                    else if(response == '0'){
                      $('.update-outer').fadeOut(100);
                      $("#fine-amount").val('');
                      alert('Tenant already fined!');
                    }
                  },
                  error: function(){
                    return showSwal('server-message-without-cancel');
                  }
                });
              }
            })

            //delete tenant
            $('.delete').on('click', function(){
              var tenant_id = $(this).val();
              swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3f51b5",
                cancelButtonColor: "#ff4081",
                confirmButtonText: "Great ",
                buttons: {
                  cancel: {
                    text: "Cancel",
                    value: null,
                    visible: true,
                    className: "btn btn-danger",
                    closeModal: true,
                  },
                  confirm: {
                    text: "OK",
                    value: true,
                    visible: true,
                    className: "btn btn-primary",
                    closeModal: true,
                  },
                },
              }).then(function(result){
                if(result){
                  $.ajax({
                    type: "POST",
                    url: "server/delete-tenant.php",
                    data: {tenant_id: tenant_id},
                    success: function (response) {
                      if(response == '1'){
                        location.reload();
                      }
                    },
                    error: function(){
                      return showSwal('server-message-without-cancel');
                    }
                  });
                }
              });
            })

            //edit tenant
            $('.edit').on('click', function(){
              var tenant_id = $(this).val();
              $.ajax({
                type: "GET",
                url: "server/edit-tenant.php",
                data: {tenant_id: tenant_id},
                dataType: 'json',
                success: function (response) {
                  $('#name').val(response.name);
                  $('#id').val(response.id);
                  $('#phone').val(response.phone);
                  $('#email').val(response.email);
                  $('#size option[value='+response.house_size+']').prop('selected', true);
                  $('#house').html('<option value = '+response.house_id+'>'+response.house_number+'</option>');
                  $('#register').val('Save');
                  
                  $('#photos').hide();
                  $('#new-tenant').fadeIn(500);

                  //saving changes
                  $('#register').on('click', function(e){
                    e.preventDefault();
                    var name = $('#name').val();
                    var id = $('#id').val();
                    var phone = $('#phone').val();
                    var email = $('#email').val();
                    var house_size = $('#size').children('option:selected').val();
                    var house_id = $('#house').children('option:selected').val();
                    if(house_size != '' && phone != '' || phone != 0 && house_id != '' || house_id != 0 && id != '' && name != ''){
                      $.ajax({
                        type: "POST",
                        url: "server/edit-tenant2.php",
                        data: {name:name, id:id, phone:phone, email:email, house_size:house_size, house_id:house_id, tenant_id: tenant_id},
                        success: function (response) {
                          if(response == '1'){
                            $('#new-tenant').fadeOut(500);
                            $('#photos').show();
                            $('#house').html('');
                            $('#configreset').click();
                            return showSwal('success-message');
                          }
                        }
                      });
                    }
                    else{
                      alert('Some compulsory fields are required!');
                    }
                  });
                  $('.close').on('click', function(e){
                    e.preventDefault();
                    $('#new-tenant').fadeOut(500);
                    $('#photos').show();
                    $('#house').html('');
                    $('#configreset').click();
                  })
                }
              });
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
  </body>
</html>
