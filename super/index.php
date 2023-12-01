<?php session_start(); ?>
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
      <?php include 'heading.php' ?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">Dashboard</h3>
            </div>
            <?php 
            $sql = "SELECT * FROM rentals WHERE user_id = ?";
            $statement = $con -> prepare($sql);
            $statement -> execute([$user_id]);
            $rows = $statement -> rowCount();
            $fetch_rental = $statement -> fetchAll();
            $total_houses = 0;
            $total_tenants = 0;
            $faulty_houses = 0;
            $rent_paid = 0;
            $expected_rent = 0;
            if($rows > 0){
              foreach($fetch_rental as $fetch_rental){
                $statement2 = $con -> prepare("SELECT * FROM houses WHERE rental_id = ?");
                $statement2 -> execute([$fetch_rental['id']]);
                $houses_fetch = $statement2 -> fetchAll();
                if($houses_fetch != null){
                  foreach($houses_fetch as $houses_fetch){
                    $total_houses += 1;

                    if($houses_fetch['status'] == 'Faulty'){
                      $faulty_houses += 1;
                    }

                    $statement3 = $con -> prepare("SELECT * FROM tenants WHERE house_id = ?");
                    $statement3 -> execute([$houses_fetch['id']]);
                    $tenants_fetch = $statement3 -> fetchAll();
                    if($tenants_fetch != null){
                      foreach($tenants_fetch as $tenants_fetch){
                        $total_tenants += 1;
                        $statement4 = $con -> prepare("SELECT * FROM payment WHERE house_id = ? OR tenant_id = ?");
                        $statement4 -> execute([$houses_fetch['id'], $tenants_fetch['id']]);
                        $payment_fetch = $statement4 -> fetchAll();

                        $statement5 = $con -> prepare("SELECT * FROM rent WHERE house_size = ? AND rental_id = ?");
                        $statement5 -> execute([$houses_fetch['size'], $fetch_rental['id']]);
                        $rent_fetch = $statement5 -> fetch();
                        if($rent_fetch != null){
                          $expected_rent += $rent_fetch['amount'];
                        }

                        if($payment_fetch != null){
                          foreach($payment_fetch as $payment_fetch){
                            $month = date('m', strtotime($payment_fetch["for_month"], '1'));
                            $current_month = date('m');
                            if($month = $current_month && $payment_fetch["for_year"] == date('Y')){
                              $rent_paid += $payment_fetch['amount'];
                            }
                          }
                        }
                      }
                    }
                  }
                }
              }
            }
            ?>
            <div class="row grid-margin">
              <div class="col-12">
                <div class="card card-statistics">
                  <div class="card-body">
                    <div
                      class="d-flex flex-column flex-md-row align-items-center justify-content-between"
                    >
                      <div class="statistics-item">
                        <p>
                          <i class="icon-sm fa fa-user mr-2"></i>
                          Total Tenants
                        </p>
                        <h2><?php echo $total_tenants?></h2>
                        <?php
                        $occupance = 0;
                        if($total_houses != 0){ $occupance = ($total_tenants / $total_houses) * 100;}
                        if($occupance >= 80){
                        ?>
                        <label class="badge badge-outline-success badge-pill"
                          ><?php echo $occupance.'% occupied houses';?></label>
                        <?php }else if($occupance < 80 && $occupance >= 40){?>
                          <label class="badge badge-outline-warning badge-pill"
                          ><?php echo $occupance.'% occupied houses';?></label>
                          <?php }else{?>
                            <label class="badge badge-outline-danger badge-pill"
                          ><?php echo $occupance.'% occupied houses';?></label>
                          <?php }?>
                      </div>
                      <div class="statistics-item">
                        <p>
                          <i class="fa fa-building mr-2"></i>
                          Total Houses
                        </p>
                        <h2><?php echo $total_houses?></h2>
                        <?php
                        if($faulty_houses <= 5){?>
                        <label class="badge badge-outline-success badge-pill"
                          ><?php echo $faulty_houses.' faulty houses'?></label>
                        <?php }else if($faulty_houses >5){?>
                          <label class="badge badge-outline-success badge-pill"
                          ><?php echo $faulty_houses.' faulty houses'?></label>
                          <?php }?>
                      </div>
                      <div class="statistics-item">
                        <p>
                          <i class="fa fa-building mr-2"></i>
                          Total Vacant Houses
                        </p>
                        <h2><?php echo $total_houses - ($total_tenants + $faulty_houses)?></h2>
                        <?php
                        $percentage_vacant = 0;
                        if($total_houses != 0){
                        $percentage_vacant = ($total_houses - ($total_tenants + $faulty_houses))/$total_houses * 100;}
                        if($percentage_vacant >= 40){
                        ?>
                        <label class="badge badge-outline-danger badge-pill"
                          ><?php echo abs(round($percentage_vacant)).'% vacant houses';?></label>
                        <?php }else if($percentage_vacant < 40 && $percentage_vacant >= 20){?>
                          <label class="badge badge-outline-warning badge-pill"
                          ><?php echo abs(round($percentage_vacant)).'% vacant houses';?></label>
                          <?php }else{?>
                            <label class="badge badge-outline-success badge-pill"
                          ><?php echo abs(round($percentage_vacant)).'% vacant houses';?></label>
                          <?php }?>
                      </div>
                      <div class="statistics-item">
                        <p>
                          <i class="fas fa-dollar-sign mr-2"></i>
                          Total Rent Collected
                        </p>
                        <h2><?php echo number_format(round($rent_paid), 0, '.', ',')?></h2>
                        <?php
                        $percentage_paid_rent = 0;
                        if($expected_rent != 0){
                        $percentage_paid_rent = ($rent_paid / $expected_rent) * 100;}
                        if($percentage_paid_rent >= 80){
                        ?>
                        <label class="badge badge-outline-success badge-pill"
                          ><?php echo abs(round($percentage_paid_rent)).'% paid rent';?></label>
                        <?php }else if($percentage_paid_rent < 80 && $percentage_paid_rent >= 40){?>
                          <label class="badge badge-outline-warning badge-pill"
                          ><?php echo abs(round($percentage_paid_rent)).'% paid rent';?></label>
                          <?php }else{?>
                            <label class="badge badge-outline-danger badge-pill"
                          ><?php echo abs(round($percentage_paid_rent)).'% paid rent';?></label>
                          <?php }?>
                      </div>
                      <div class="statistics-item">
                        <p>
                          <i class="icon-sm fas fa-chart-line mr-2"></i>
                          Total Expected Rent
                        </p>
                        <h2><?php echo number_format(round($expected_rent), 0, '.', ',')?></h2>
                        <?php
                        $percentage_paid_rent = 0;
                        if($expected_rent != 0){
                        $percentage_paid_rent = ($rent_paid / $expected_rent) * 100;}
                        if($percentage_paid_rent >= 80){
                        ?>
                        <label class="badge badge-outline-success badge-pill"
                          >Near to be met</label>
                        <?php }else if($percentage_paid_rent < 80 && $percentage_paid_rent >= 40){?>
                          <label class="badge badge-outline-warning badge-pill"
                          >Not very bad</label>
                          <?php }else{?>
                            <label class="badge badge-outline-danger badge-pill"
                          >Far to be met</label>
                          <?php }?>
                      </div>
                      <div class="statistics-item">
                        <p>
                          <i class="icon-sm fas fa-circle-notch mr-2"></i>
                          Total Unpaid Balances
                        </p>
                        <h2><?php echo number_format(round($expected_rent - $rent_paid), 0, '.', ',')?></h2>
                        <?php
                        $percentage_unpaid_rent = 0;
                        if($expected_rent != 0){
                        $percentage_unpaid_rent = (($expected_rent - $rent_paid) / $expected_rent) * 100;}
                        if($percentage_unpaid_rent >= 80){
                        ?>
                        <label class="badge badge-outline-danger badge-pill"
                          ><?php echo abs(round($percentage_unpaid_rent)).'% unpaid rent';?></label>
                        <?php }else if($percentage_unpaid_rent < 80 && $percentage_unpaid_rent >= 40){?>
                          <label class="badge badge-outline-warning badge-pill"
                          ><?php echo abs(round($percentage_unpaid_rent)).'% unpaid rent';?></label>
                          <?php }else{?>
                            <label class="badge badge-outline-success badge-pill"
                          ><?php echo abs(round($percentage_unpaid_rent)).'% unpaid rent';?></label>
                          <?php }?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">
                      <i class="fas fa-dollar-sign"></i>
                      Rent Collection
                    </h4>
                    <canvas id="orders-chart2"></canvas>
                    <div
                      id="orders-chart-legend2"
                      class="orders-chart-legend"
                    ></div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">
                      <i class="fas fa-dollar-sign"></i>
                      Monthly Profit
                    </h4>
                    <h2 class="mb-5">
                      <?php echo 'Ksh '.number_format(round($rent_paid), 0, '.', ',')?>
                      <span class="text-muted h4 font-weight-normal"
                        >Overall collected rent</span
                      >
                    </h2>
                    <canvas id="sales-chart2"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Houses vs Tenants per rental</h4>
                  <div id="morris-bar-example"></div>
                </div>
              </div>
            </div>
            </div>
            <?php
            $sql = "SELECT * FROM rentals WHERE user_id = ?";
            $statement = $con -> prepare($sql);
            $statement -> execute([$user_id]);
            $rows = $statement -> rowCount();
            $fetch_rental = $statement -> fetchAll();
            $rentals = array();
            $rental = '';
            if($rows > 0){
                foreach($fetch_rental as $fetch_rental){
                    $total_houses = 0;
                    $total_tenants = 0;
                    $statement2 = $con -> prepare("SELECT * FROM houses WHERE rental_id = ?");
                    $statement2 -> execute([$fetch_rental['id']]);
                    $houses_fetch = $statement2 -> fetchAll();
                    if($houses_fetch != null){
                        foreach($houses_fetch as $houses_fetch){
                          $total_houses += 1;
                          $statement3 = $con -> prepare("SELECT * FROM tenants WHERE house_id = ?");
                          $statement3 -> execute([$houses_fetch['id']]);
                          $tenants_fetch = $statement3 -> fetchAll();
                          if($tenants_fetch != null){
                            foreach($tenants_fetch as $tenants_fetch){
                                $total_tenants += 1;
                            }
                          }
                        }
                    }
                    $rental .= sprintf(
                      "{ y: '%s', a: %s, b: %s },",
                      $fetch_rental['name'],
                      $total_houses,
                      $total_tenants
                    );
                  }
                }
                $rentals = $rental; ?>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          <?php include '../pages/layout/footer.php' ?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>

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
  <!-- <script src="../js/todolist.js"></script> -->
  <!-- endinject -->
  <script src="../js/alerts.js"></script>
  <!-- Custom js for this page-->
  <script src="../js/dashboard.js"></script>
  <!-- End custom js for this page-->
  </body>
  <script>
    $(document).ready(function(){
      //adding to todo list
      $('#add-task-todo').on('click', function(e){
        e.preventDefault();
        if($(this).prevAll('.todo-list-input').val() != ''){
          var text = $(this).prevAll('.todo-list-input').val();
          $.ajax({
            type: "post",
            url: "../server/todo.php",
            data: {text: text},
            success: function (response) {
              $('.list-wrapper > ul').append(response);
            }
          });
        }
      })

      //completed todo
      $('.todo-list').on('change', '.checkbox', function(){
        if($(this).is(':checked')){
          //$(this).removeAttr('checked');
          var id = $(this).val();
          var status = 'complete';
          alert(status);
          $.ajax({
            type: "get",
            url: "../server/completed-todo.php",
            data: {id: id, status: status},
            success: function (response) {
            }
          });
        }
        else{
          //$(this).attr('checked', 'checked');
          var id = $(this).val();
          var status = 'uncomplete';
          $.ajax({
            type: "get",
            url: "../server/completed-todo.php",
            data: {id: id, status: status},
            success: function (response) {
            }
          });
          
        }
        $(this).closest("li").toggleClass('completed');
      })

      //deleting a todo
      $('.todo-list').on('click','.remove', function(){
        var todo_id = $(this).find("input[type='hidden']").val();
        $.ajax({
          type: "POST",
          url: "../server/delete-todo.php",
          data: {todo_id: todo_id},
          success: function (response) {
            if(response == '1'){
            }
          }
        });
        $(this).parent().remove();
      })
    })


    if ($("#morris-bar-example").length) {
        Morris.Bar({
        element: "morris-bar-example",
        barColors: ["#63CF72", "#F36368", "#76C1FA", "#FABA66"],
        data: [<?php echo $rentals; ?>],
        xkey: "y",
        ykeys: ["a", "b"],
        labels: ["Total houses", "Total Tenants"],
      });
    }
  </script>
</html>
