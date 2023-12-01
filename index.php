<?php session_start();?>
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
    .count{
      display: none;
    }
  </style>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <?php include 'pages/layout/heading.php'?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">Dashboard</h3>
            </div>
            <div class="row grid-margin">
              <?php
              $sql= "SELECT * FROM houses WHERE rental_id = ?";
              $rental_id = $_SESSION["rental_id"];
              $statement = $con -> prepare($sql);
              $statement -> execute([$rental_id]);
              $fetch = $statement -> fetchAll();
              $number_of_tenants = 0;
              $initial_number_of_tenants = 0;
              $occupied_houses = 0;
              $vacant_houses = 0;
              $total_paid_rent = 0;
              $total_paid_rent2 = 0;
              $expected_amount = 0;
              $expected_amount_last = 0;
              $expected_amount_current = 0;
              $number_of_houses_current_month = 0;
              $number_of_houses_last_month = 0;
              $number_of_tenants_current_month = 0;
              $vacant_count1 = 0;
              $vacant_count2 = 0;
              $total_houses = 0;
              $total_houses_last_month = 0;
              foreach($fetch as $fetch){
                $house_id = $fetch["id"];
                $select = "SELECT * FROM tenants";
                $st = $con -> prepare($select);
                $st -> execute();
                $fetch2 = $st -> fetchAll();

                $total_houses += 1;

                if($fetch['status'] != 'Faulty'){
                  $vacant_count1 += 1;
                }

                //current number of houses and number of houses in the last month
                $timestamp = $fetch["date"];
                $date = new DateTime($timestamp);
                $month = $date->format("m");
                $current_month = date('m');
                $last_month = $current_month - 1;
                if($month == $last_month && $fetch['status'] == 'Okay' && $date->format("Y") == date("Y")){
                  $number_of_houses_last_month += 1;
                }
                else if($month == $current_month && $fetch['status'] == 'Okay' && $date->format("Y") == date("Y")){
                  $number_of_houses_current_month += 1;
                }

                if($month == $last_month && $date->format("Y") == date("Y")){
                  $total_houses_last_month += 1;
                }

                foreach($fetch2 as $fetch2){
                  $house_id2 = $fetch2["house_id"];
                  if($house_id == $house_id2){
                    $house_size = $fetch2["size"];

                    $timestamp = $fetch2["date"];
                    $date = new DateTime($timestamp);
                    $month = $date->format("m");
                    $current_month = date('m');
                    $last_month = $current_month - 1;
                    $number_of_tenants += 1;
                    $occupied_houses += 1;
                    if($fetch['status'] != 'Faulty'){
                      $vacant_count2 += 1;
                    }

                    if($month == $last_month){
                      $initial_number_of_tenants += 1;
                    }
                    else if($month == $current_month){
                      $number_of_tenants_current_month += 1;
                    }

                    //payment
                    $payment = "SELECT * FROM payment WHERE tenant_id = ? OR house_id = ?";
                    $st3 = $con -> prepare($payment);
                    $st3 -> execute([$fetch2["id"], $house_id2]);
                    $fetch3 = $st3 -> fetchAll();
                    $rows = $st3 -> rowCount();
                    if($rows > 0){
                      foreach($fetch3 as $fetch3){
                        // $timestamp = $fetch3["date"];
                        // $date = new DateTime($timestamp);
                        // $month = $date->format("m");
                        $month = date('m', strtotime($fetch3["for_month"], '1'));
                        $current_month = date('m');
                        $last_month_payment = $current_month - 1;
                        if($month == $current_month && $fetch3["for_year"] == date('Y')){
                          $total_paid_rent += $fetch3["amount"];
                        }
                        if($month == $last_month_payment && $fetch3["for_year"] == date('Y')){
                          $total_paid_rent2 += $fetch3["amount"];
                        }
                      }
                    }

                    //fetching expected rent
                    $rent = "SELECT DISTINCT * FROM rent WHERE rental_id = ? AND house_size = ?";
                    $st4 = $con -> prepare($rent);
                    $st4 -> execute([$rental_id, $house_size]);
                    $fetch4 = $st4 -> fetch();
                    $rows4 = $st4 -> rowCount();
                    if($rows4 == 1){
                      $expected_amount += $fetch4['amount'];
                      $timestamp = $fetch2["date"];
                      $date = new DateTime($timestamp);
                      $month = $date->format("m");
                      $current_month = date('m');
                      $last_month_payment = $current_month - 1;
                      if($month == $current_month && $date->format("Y") == date("Y")){
                        $expected_amount_current += $fetch4['amount'];
                      }
                      if($month == $last_month_payment && $date->format("Y") == date("Y")){
                        $expected_amount_last += $fetch4['amount'];
                      }
                    }

                    $query = "SELECT DISTINCT * FROM rent WHERE rental_id = ? AND house_size = ?";
                    $st2 = $con -> prepare($query);
                    $st2 -> execute([$rental_id, $house_size]);
                    $rent = $st2 -> fetch();
                  }
                  else{
                    if($fetch['status'] == 'Okay'){
                      $vacant_houses += 1;
                    }
                  }

                  

                  // //for tenants
                  // $timestamp = $tenant["date"];
                  // $date = date("Y-m-d",strtotime($timestamp));
                  // $month = date("m", strtotime($date));
                  // $current_month = date('m');
                  // $last_month = $current_month - 1;
                  // if($month == $last_month){
                  //   $initial_number_of_tenants += 1;
                  // }

                }
              }
              ?>
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
                        <h2><?php echo $number_of_tenants?></h2>
                        <?php if($initial_number_of_tenants != 0) {$percentage_increase = ((($number_of_tenants_current_month - $initial_number_of_tenants)/$initial_number_of_tenants) * 100); if($percentage_increase < 0){?><label class="badge badge-outline-danger badge-pill"><?php echo abs($percentage_increase).'% decrease';?></label><?php }else{?><label class="badge badge-outline-success badge-pill"><?php echo $percentage_increase.'% increase';?></label><?php }}else{?><label class="badge badge-outline-success badge-pill">0% increase</label><?php }?>
                      </div>
                      <div class="statistics-item">
                        <p>
                          <i class="fa fa-building mr-2"></i>
                          Totals Houses
                        </p>
                        <h2><?php echo $total_houses?></h2>
                        <?php if($total_houses_last_month != 0) {$percentage_increase = ((($total_houses - $total_houses_last_month)/$total_houses_last_month) * 100); if($percentage_increase < 0){?><label class="badge badge-outline-danger badge-pill"><?php echo abs($percentage_increase).'% decrease';?></label><?php }else{?><label class="badge badge-outline-success badge-pill"><?php echo $percentage_increase.'% increase';?></label><?php }}else{?><label class="badge badge-outline-success badge-pill">0% increase</label><?php }?>
                      </div>
                      <div class="statistics-item">
                        <p>
                          <i class="fa fa-building mr-2"></i>
                          Vacant Houses
                        </p>
                        <h2><?php $vacant_houses = $vacant_count1 - $vacant_count2; echo $vacant_houses;?></h2>
                        <?php
                        if($vacant_count1 > 0){
                        $percentage_vacant = ($vacant_houses/$vacant_count1) * 100; if($percentage_vacant == 0){?><label class="badge badge-outline-success badge-pill"><?php echo abs(round($percentage_vacant)).'% increase'?></label><?php }else{?>
                        <label class="badge badge-outline-danger badge-pill"><?php echo abs(round($percentage_vacant)).'% increase'?></label><?php }}else{?><label class="badge badge-outline-danger badge-pill">0% increase</label><?php }?>
                      </div>
                      <div class="statistics-item">
                        <p>
                          <i class="fas fa-dollar-sign mr-2"></i>
                          Total Rent Collected
                        </p>
                        <h2><?php echo number_format($total_paid_rent, 0, '.', ',')?></h2>
                        <?php if($total_paid_rent2 != 0){ $percentage_increase = ((($total_paid_rent - $total_paid_rent2)/$total_paid_rent2) * 100); if($percentage_increase < 0){?><label class="badge badge-outline-danger badge-pill"><?php echo abs(round($percentage_increase)).'% decrease';?></label><?php }else{?><label class="badge badge-outline-success badge-pill"><?php echo round($percentage_increase).'% increase';?></label><?php }}else if($total_paid_rent2 == 0){?><label class="badge badge-outline-success badge-pill">100% increase</label><?php }?>
                      </div>
                      <div class="statistics-item">
                        <p>
                          <i class="icon-sm fas fa-chart-line mr-2"></i>
                          Total Expected Rent
                        </p>
                        <h2><?php echo number_format(round($expected_amount), 0, '.', ',')?></h2>
                        <?php if($initial_number_of_tenants != 0) {$percentage_increase = ((($number_of_tenants_current_month - $initial_number_of_tenants)/$initial_number_of_tenants) * 100); if($percentage_increase < 0){?><label class="badge badge-outline-danger badge-pill"><?php echo abs($percentage_increase).'% decrease';?></label><?php }else{?><label class="badge badge-outline-success badge-pill"><?php echo $percentage_increase.'% increase';?></label><?php }}else if($initial_number_of_tenants == 0){?><label class="badge badge-outline-success badge-pill">100% increase</label><?php }?>
                      </div>
                      <div class="statistics-item">
                        <p>
                          <i class="icon-sm fas fa-circle-notch mr-2"></i>
                          Total Unpaid Balances
                        </p>
                        <h2><?php echo number_format(round($expected_amount - $total_paid_rent), 0, '.', ',')?></h2>
                        <?php if($expected_amount_last - $total_paid_rent2 != 0){ $percentage_increase = (((($expected_amount_current - $total_paid_rent) - ($expected_amount_last - $total_paid_rent2))/($expected_amount_last - $total_paid_rent2)) * 100); if($percentage_increase < 0){?><label class="badge badge-outline-success badge-pill"><?php echo abs(round($percentage_increase)).'% decrease';?></label><?php }else if($percentage_increase > 0){?><label class="badge badge-outline-danger badge-pill"><?php echo round($percentage_increase).'% increase';?></label><?php }else if($percentage_increase == 0){?><label class="badge badge-outline-success badge-pill"><?php echo round($percentage_increase).'% increase';?></label> <?php }}else{?><label class="badge badge-outline-danger badge-pill">0% increase</label><?php }?>
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
                    <canvas id="orders-chart"></canvas>
                    <div
                      id="orders-chart-legend"
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
                    <h2 class="mb-5" id="annual_totals">
                      <script>
                        $.ajax({
                          type: "get",
                          url: "server/col-exp.php",
                          dataType: "json",
                          success: function (response) {
                            var collected = response.collected;
                            var sum = 0;

                            for (var i = 0; i < collected.length; i++) {
                                sum += collected[i];
                            }

                            var formattedNumber = sum.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 });

                            $('#annual_totals').html("<h2>Ksh. " + formattedNumber + "</h2><span class='text-muted h4 font-weight-normal'>Overall collected rent</span>");

                          }
                        });
                      </script>
                    </h2>
                    <canvas id="sales-chart"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <div class="row" id="tenans_row">
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body d-flex flex-column">
                    <h4 class="card-title">
                      <i class="fas fa-chart-pie"></i>
                      Tenants stats
                    </h4>
                    <div
                      class="flex-grow-1 d-flex flex-column justify-content-between"
                    >
                      <canvas id="sales-status-chart" class="mt-3"></canvas>
                      <div class="pt-4">
                        <div
                          id="sales-status-chart-legend"
                          class="sales-status-chart-legend"
                        ></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 grid-margin stretch-card" id="houses_row">
                <div class="card">
                  <div class="card-body d-flex flex-column">
                    <h4 class="card-title">
                      <i class="far fa-building"></i>
                      Houses Analytics
                    </h4>
                    <p class="card-description">Current houses analytics</p>
                    <div
                      class="flex-grow-1 d-flex flex-column justify-content-between"
                    >
                      <canvas
                        id="daily-sales-chart"
                        class="mt-3 mb-3 mb-md-0"
                      ></canvas>
                      <div
                        id="daily-sales-chart-legend"
                        class="daily-sales-chart-legend pt-4 border-top"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">
                      <i class="fas fa-table"></i>
                      Rent payment summary
                    </h4>
                    <div class="table-responsive" id="table">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Month</th>
                            <th>Tenants</th>
                            <th>Rent collected</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $sql= "SELECT * FROM houses WHERE rental_id = ?";
                          $rental_id = $_SESSION["rental_id"];
                          $statement = $con -> prepare($sql);
                          $statement -> execute([$rental_id]);
                          $fetch = $statement -> fetchAll();
                          $tenants = 0;
                          $month_name = '';
                          $Jan = 0;$Feb = 0;$Mar = 0;$Apr = 0;$May = 0;$Jun = 0;$Jul = 0;$Aug = 0;$Sep = 0;$Oct = 0;$Nov = 0;$Dec = 0;
                          $Jan_exp = 0;$Feb_exp = 0;$Mar_exp = 0;$Apr_exp = 0;$May_exp = 0;$Jun_exp = 0;$Jul_exp = 0;$Aug_exp = 0;$Sep_exp = 0;$Oct_exp = 0;$Nov_exp = 0;$Dec_exp = 0;
                          $Jan_ten = 0;$Feb_ten = 0;$Mar_ten = 0;$Apr_ten = 0;$May_ten = 0;$Jun_ten = 0;$Jul_ten = 0;$Aug_ten = 0;$Sep_ten = 0;$Oct_ten = 0;$Nov_ten = 0;$Dec_ten = 0;

                          foreach($fetch as $fetch){
                          $house_id = $fetch["id"];
                          $select = "SELECT * FROM tenants";
                          $st = $con -> prepare($select);
                          $st -> execute();
                          $fetch2 = $st -> fetchAll();

                          foreach($fetch2 as $fetch2){
                              $house_id2 = $fetch2["house_id"];
                              $house_size = $fetch['size'];
                              if($house_id == $house_id2){

                                  $timestamp = $fetch2["date"];
                                  $date = new DateTime($timestamp);
                                  $month = $date->format("m");
                                  $year = $date->format("Y");
                                  $current_year = date('Y');

                                  //fetching expected rent
                                  $rent = "SELECT DISTINCT * FROM rent WHERE rental_id = ? AND house_size = ?";
                                  $st4 = $con -> prepare($rent);
                                  $st4 -> execute([$rental_id, $house_size]);
                                  $fetch4 = $st4 -> fetch();
                                  $rows4 = $st4 -> rowCount();

                                  if($year != $current_year || $month == 01){
                                      $Jan_exp += $fetch4['amount'];
                                      $tenants += 1;
                                      $Jan_ten += 1;
                                  }
                                  if($month <= 2){
                                      $Feb_exp += $fetch4['amount'];
                                      $tenants += 1;
                                      $Feb_ten += 1;
                                  }
                                  if($month <= 3){
                                      $Mar_exp += $fetch4['amount'];
                                      $tenants += 1;
                                      $Mar_ten += 1;
                                  }
                                  if($month <= 4){
                                      $Apr_exp += $fetch4['amount'];
                                      $tenants += 1;
                                      $Apr_ten += 1;
                                  }
                                  if ($month <= 5) {
                                      $May_exp += $fetch4['amount'];
                                      $tenants += 1;
                                      $May_ten += 1;
                                  }
                                  if ($month <= 6) {
                                      $Jun_exp += $fetch4['amount'];
                                      $tenants += 1;
                                      $Jun_ten += 1;
                                  }
                                  if ($month <= 7) {
                                      $Jul_exp += $fetch4['amount'];
                                      $tenants += 1;
                                      $Jul_ten += 1;
                                  }
                                  if ($month <= 8) {
                                      $Aug_exp += $fetch4['amount'];
                                      $tenants += 1;
                                      $Aug_ten += 1;
                                  }
                                  if ($month <= 9) {
                                      $Sep_exp += $fetch4['amount'];
                                      $tenants += 1;
                                      $Sep_ten += 1;
                                  }
                                  if ($month <= 10) {
                                      $Oct_exp += $fetch4['amount'];
                                      $tenants += 1;
                                      $Oct_ten += 1;
                                  }
                                  if ($month <= 11) {
                                      $Nov_exp += $fetch4['amount'];
                                      $tenants += 1;
                                      $Nov_ten += 1;
                                  }
                                  if ($month <= 12) {
                                      $Dec_exp += $fetch4['amount'];
                                      $tenants += 1;
                                      $Dec_ten += 1;
                                  }

                                  //payment
                                  $payment = "SELECT * FROM payment WHERE tenant_id = ? OR house_id = ?";
                                  $st3 = $con -> prepare($payment);
                                  $st3 -> execute([$fetch2["id"], $house_id2]);
                                  $fetch3 = $st3 -> fetchAll();
                                  $rows = $st3 -> rowCount();
                                  if($rows > 0){
                                      foreach($fetch3 as $fetch3){
                                          // $timestamp = $fetch3["date"];
                                          // $date = new DateTime($timestamp);
                                          // $month = $date->format("m");
                                          $month = date('m', strtotime($fetch3["for_month"], '1'));
                                          $year = $fetch3["for_year"];

                                          if($month == 1 && $year == date('Y')){
                                              $Jan += $fetch3['amount'];
                                          }elseif ($month == 2 && $year == date('Y')) {
                                              $Feb += $fetch3['amount'];
                                          } elseif ($month == 3 && $year == date('Y')) {
                                              $Mar += $fetch3['amount'];
                                          } elseif ($month == 4 && $year == date('Y')) {
                                              $Apr += $fetch3['amount'];
                                          } elseif ($month == 5 && $year == date('Y')) {
                                              $May += $fetch3['amount'];
                                          } elseif ($month == 6 && $year == date('Y')) {
                                              $Jun += $fetch3['amount'];
                                          } elseif ($month == 7 && $year == date('Y')) {
                                              $Jul += $fetch3['amount'];
                                          } elseif ($month == 8 && $year == date('Y')) {
                                              $Aug += $fetch3['amount'];
                                          } elseif ($month == 9 && $year == date('Y')) {
                                              $Sep += $fetch3['amount'];
                                          } elseif ($month == 10 && $year == date('Y')) {
                                              $Oct += $fetch3['amount'];
                                          } elseif ($month == 11 && $year == date('Y')) {
                                              $Nov += $fetch3['amount'];
                                          } elseif ($month == 12 && $year == date('Y')) {
                                              $Dec += $fetch3['amount'];
                                          }
                                      }
                                  }
                              }
                            }
                          }
                          ?>
                          <tr>
                            <td class="font-weight-bold">January</td>
                            <td class="text-muted"><?php echo $Jan_ten?></td>
                            <td><?php echo $Jan?></td>
                            <td>
                              <?php
                              if($Jan_exp <= $Jan){
                              ?>
                                <label class="badge badge-success badge-pill">Fully paid</label>
                              <?php
                              }elseif($Jan_exp >= $Jan && $Jan != 0){?>
                                <label class="badge badge-warning badge-pill">Partialy paid</label>
                              <?php
                              }elseif($Jan_exp >= $Jan && $Jan <= 0){
                              ?>
                                <label class="badge badge-danger badge-pill">Not paid</label>
                              <?php
                              }
                              ?>
                            </td>
                          </tr>
                          <tr>
                            <td class="font-weight-bold">February</td>
                            <td class="text-muted"><?php echo $Feb_ten?></td>
                            <td><?php echo $Feb ?></td>
                            <td>
                              <?php
                              if($Feb_exp <= $Feb){
                              ?>
                                <label class="badge badge-success badge-pill">Fully paid</label>
                              <?php
                              }elseif($Feb_exp >= $Feb && $Feb != 0){?>
                                <label class="badge badge-warning badge-pill">Partialy paid</label>
                              <?php
                              }elseif($Feb_exp >= $Feb && $Feb <= 0){
                              ?>
                                <label class="badge badge-danger badge-pill">Not paid</label>
                              <?php
                              }
                              ?>
                            </td>
                          </tr>
                          <tr>
                            <td class="font-weight-bold">March</td>
                            <td class="text-muted"><?php echo $Mar_ten?></td>
                            <td><?php echo $Mar?></td>
                            <td>
                              <?php
                              if($Mar_exp <= $Mar){
                              ?>
                                <label class="badge badge-success badge-pill">Fully paid</label>
                              <?php
                              }elseif($Mar_exp >= $Mar && $Mar != 0){?>
                                <label class="badge badge-warning badge-pill">Partialy paid</label>
                              <?php
                              }elseif($Mar_exp >= $Mar && $Mar <= 0){
                              ?>
                                <label class="badge badge-danger badge-pill">Not paid</label>
                              <?php
                              }
                              ?>
                            </td>
                          </tr>
                          <tr>
                            <td class="font-weight-bold">April</td>
                            <td class="text-muted"><?php echo $Apr_ten?></td>
                            <td><?php echo $Apr?></td>
                            <td>
                              <?php
                              if($Apr_exp <= $Apr){
                              ?>
                                <label class="badge badge-success badge-pill">Fully paid</label>
                              <?php
                              }elseif($Apr_exp >= $Apr && $Apr != 0){?>
                                <label class="badge badge-warning badge-pill">Partialy paid</label>
                              <?php
                              }elseif($Apr_exp >= $Apr && $Apr <= 0){
                              ?>
                                <label class="badge badge-danger badge-pill">Not paid</label>
                              <?php
                              }
                              ?>
                            </td>
                          </tr>
                          <tr>
                            <td class="font-weight-bold">May</td>
                            <td class="text-muted"><?php echo $May_ten?></td>
                            <td><?php echo $May?></td>
                            <td>
                              <?php
                              if($May_exp <= $May){
                              ?>
                                <label class="badge badge-success badge-pill">Fully paid</label>
                              <?php
                              }elseif($May_exp >= $May && $May != 0){?>
                                <label class="badge badge-warning badge-pill">Partialy paid</label>
                              <?php
                              }elseif($May_exp >= $May && $May <= 0){
                              ?>
                                <label class="badge badge-danger badge-pill">Not paid</label>
                              <?php
                              }
                              ?>
                            </td>
                          </tr>
                          <tr>
                            <td class="font-weight-bold">June</td>
                            <td class="text-muted"><?php echo $Jun_ten?></td>
                            <td><?php echo $Jun?></td>
                            <td>
                              <?php
                              if($Jun_exp <= $Jun){
                              ?>
                                <label class="badge badge-success badge-pill">Fully paid</label>
                              <?php
                              }elseif($Jun_exp >= $Jun && $Jun != 0){?>
                                <label class="badge badge-warning badge-pill">Partialy paid</label>
                              <?php
                              }elseif($Jun_exp >= $Jun && $Jun <= 0){
                              ?>
                                <label class="badge badge-danger badge-pill">Not paid</label>
                              <?php
                              }
                              ?>
                            </td>
                          </tr>
                          <tr>
                            <td class="font-weight-bold">July</td>
                            <td class="text-muted"><?php echo $Jul_ten?></td>
                            <td><?php echo $Jul?></td>
                            <td>
                              <?php
                              if($Jul_exp <= $Jul){
                              ?>
                                <label class="badge badge-success badge-pill">Fully paid</label>
                              <?php
                              }elseif($Jul_exp >= $Jul && $Jul != 0){?>
                                <label class="badge badge-warning badge-pill">Partialy paid</label>
                              <?php
                              }elseif($Jul_exp >= $Jul && $Jul <= 0){
                              ?>
                                <label class="badge badge-danger badge-pill">Not paid</label>
                              <?php
                              }
                              ?>
                            </td>
                          </tr>
                          <tr>
                            <td class="font-weight-bold">August</td>
                            <td class="text-muted"><?php echo $Aug_ten?></td>
                            <td><?php echo $Aug?></td>
                            <td>
                              <?php
                              if($Aug_exp <= $Aug){
                              ?>
                                <label class="badge badge-success badge-pill">Fully paid</label>
                              <?php
                              }elseif($Aug_exp >= $Aug && $Aug != 0){?>
                                <label class="badge badge-warning badge-pill">Partialy paid</label>
                              <?php
                              }elseif($Aug_exp >= $Aug && $Aug <= 0){
                              ?>
                                <label class="badge badge-danger badge-pill">Not paid</label>
                              <?php
                              }
                              ?>
                            </td>
                          </tr>
                          <tr>
                            <td class="font-weight-bold">September</td>
                            <td class="text-muted"><?php echo $Sep_ten?></td>
                            <td><?php echo $Sep?></td>
                            <td>
                              <?php
                              if($Sep_exp <= $Sep){
                              ?>
                                <label class="badge badge-success badge-pill">Fully paid</label>
                              <?php
                              }elseif($Sep_exp >= $Sep && $Sep != 0){?>
                                <label class="badge badge-warning badge-pill">Partialy paid</label>
                              <?php
                              }elseif($Sep_exp >= $Sep && $Sep <= 0){
                              ?>
                                <label class="badge badge-danger badge-pill">Not paid</label>
                              <?php
                              }
                              ?>
                            </td>
                          </tr>
                          <tr>
                            <td class="font-weight-bold">October</td>
                            <td class="text-muted"><?php echo $Oct_ten?></td>
                            <td><?php echo $Oct?></td>
                            <td>
                              <?php
                              if($Oct_exp <= $Oct){
                              ?>
                                <label class="badge badge-success badge-pill">Fully paid</label>
                              <?php
                              }elseif($Oct_exp >= $Oct && $Oct != 0){?>
                                <label class="badge badge-warning badge-pill">Partialy paid</label>
                              <?php
                              }elseif($Oct_exp >= $Oct && $Oct <= 0){
                              ?>
                                <label class="badge badge-danger badge-pill">Not paid</label>
                              <?php
                              }
                              ?>
                            </td>
                          </tr>
                          <tr>
                            <td class="font-weight-bold">November</td>
                            <td class="text-muted"><?php echo $Nov_ten?></td>
                            <td><?php echo $Nov?></td>
                            <td>
                              <?php
                              if($Nov_exp <= $Nov){
                              ?>
                                <label class="badge badge-success badge-pill">Fully paid</label>
                              <?php
                              }elseif($Nov_exp >= $Nov && $Nov != 0){?>
                                <label class="badge badge-warning badge-pill">Partialy paid</label>
                              <?php
                              }elseif($Nov_exp >= $Nov && $Nov <= 0){
                              ?>
                                <label class="badge badge-danger badge-pill">Not paid</label>
                              <?php
                              }
                              ?>
                            </td>
                          </tr>
                          <tr>
                            <td class="font-weight-bold">December</td>
                            <td class="text-muted"><?php echo $Dec_ten?></td>
                            <td><?php echo $Dec?></td>
                            <td>
                              <?php
                              if($Dec_exp <= $Dec){
                              ?>
                                <label class="badge badge-success badge-pill">Fully paid</label>
                              <?php
                              }elseif($Dec_exp >= $Dec && $Dec != 0){?>
                                <label class="badge badge-warning badge-pill">Partialy paid</label>
                              <?php
                              }elseif($Dec_exp >= $Dec && $Dec <= 0){
                              ?>
                                <label class="badge badge-danger badge-pill">Not paid</label>
                              <?php
                              }
                              ?>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">
                      <i class="fas fa-calendar-alt"></i>
                      Calendar
                    </h4>
                    <div
                      id="inline-datepicker-example"
                      class="datepicker"
                    ></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-7 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">
                      <i class="fas fa-thumbtack"></i>
                      Todo
                    </h4>
                    <div class="add-items d-flex">
                      <input
                        type="text"
                        class="form-control todo-list-input"
                        placeholder="What do you need to do today?"
                      />
                      <button
                        class="add btn btn-primary font-weight-bold todo-list-add-btn"
                        id="add-task"
                      >
                        Add
                      </button>
                    </div>
                    <div class="list-wrapper">
                      <ul class="d-flex flex-column-reverse todo-list" id="todoList">
                      <?php
                          $user_id = $_SESSION["user_id"];

                          $SELECT = "SELECT * FROM todo WHERE user_id = ?";
                          $statement = $con -> prepare($SELECT);
                          $statement -> execute([$user_id]);
                          $fetch = $statement -> fetchAll();

                          foreach($fetch as $fetch){
                              if($fetch['completed'] == null){
                          ?>
                              <li>
                                  <div class="form-check">
                                  <label class="form-check-label">
                                      <input class="checkbox" type="checkbox" value="<?php echo $fetch['id']?>" /><?php echo $fetch['text']?><i class='input-helper'></i>
                                  </label>
                                  </div>
                                  <i class="remove fa fa-times-circle delete-todo"><input type="hidden" value="<?php echo $fetch['id']?>"></i>
                              </li>
                              <?php
                              }
                              else{
                              ?>
                              <li class="completed">
                                  <div class="form-check">
                                  <label class="form-check-label">
                                      <input class="checkbox" type="checkbox" checked /><?php echo $fetch['text']?><i class='input-helper'></i>
                                  </label>
                                  </div>
                                  <i class="remove fa fa-times-circle delete-todo"><input type="hidden" value="<?php echo $fetch['id']?>"></i>
                              </li>
                          <?php
                              }
                          }
                          ?>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
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
    <!-- <script src="js/todolist.js"></script> -->
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="js/dashboard.js"></script>
    <!-- End custom js for this page-->
    <script src="js/jquery_3.6.0.min.js"></script>
  </body>
  <script>
    $(document).ready(function(){
      //adding to todo list
      $('.todo-list-add-btn').on('click', function(e){
        e.preventDefault();
        if($(this).prevAll('.todo-list-input').val() != ''){
          var text = $(this).prevAll('.todo-list-input').val();
          $.ajax({
            type: "post",
            url: "server/todo.php",
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
          $.ajax({
            type: "get",
            url: "server/completed-todo.php",
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
            url: "server/completed-todo.php",
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
          url: "server/delete-todo.php",
          data: {todo_id: todo_id},
          success: function (response) {
            if(response == '1'){
            }
          }
        });
        $(this).parent().remove();
      })

      //loading amount of rent collected per month
      $.ajax({
        type: "get",
        url: "server/payment-per-month.php",
        dataType: "html",
        async: false,
        success: function (response) {
          
        }
      });
    })
  </script>
</html>
