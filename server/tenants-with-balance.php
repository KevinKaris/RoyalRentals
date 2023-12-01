<?php
session_start();
include 'connection.php';

if(isset($_GET['month']) && isset($_GET['year'])){
    $month = $_GET['month'];
    $year = $_GET['year'];
    $month2 = null;
    $year2 = null;
    $current_month = date('M');
    $current_year = date('Y');

    $sql= "SELECT * FROM houses WHERE rental_id = ?";
                          $rental_id = $_SESSION["rental_id"];
                          $statement = $con -> prepare($sql);
                          $statement -> execute([$rental_id]);
                          $fetch = $statement -> fetchAll();
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
                                $payment = "SELECT * FROM payment WHERE tenant_id = ? OR house_id = ? AND rent = ?";
                                    $st3 = $con -> prepare($payment);
                                    $st3 -> execute([$fetch2["id"], $house_id2, $rent['amount']]);
                                    $fetch3 = $st3 -> fetchAll();
                                    $rows = $st3 -> rowCount();
                                    $total_paid_rent = 0;
                                    $percentage_paid_rent = 0;
                                    if($rows > 0){
                                      foreach($fetch3 as $fetch3){
                                        //$timestamp = $fetch3["date"];
                                        //$date = new DateTime($timestamp);
                                        $month2 = $fetch3["for_month"];
                                        $year2 = $fetch3["for_year"];
                                        if($month2 == $month && $year2 == $year){
                                          $total_paid_rent += $fetch3["amount"];
                                          $percentage_paid_rent = ($total_paid_rent / $rent["amount"] * 100);
                                        }
                                      }
                                      if($total_paid_rent != 0 && $total_paid_rent < $rent["amount"] && $month2 == $month && $year2 == $year){
                                      ?>
                                      <tr>
                                          <td><?php echo $fetch2["name"]?></td>
                                          <td><?php echo '0'.$fetch2["phone"]?></td>
                                          <?php
                                          
                                          ?>
                                          <td>
                                          <?php
                                          if($percentage_paid_rent <= 30){?>
                                          <div class="progress">
                                              <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $percentage_paid_rent.'%'?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                          </div>
                                          <?php }
                                          else if($percentage_paid_rent > 30 && $percentage_paid_rent <= 80){?>
                                          <div class="progress">
                                              <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $percentage_paid_rent.'%'?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                          </div>
                                          <?php
                                          }
                                          else{?>
                                          <div class="progress">
                                              <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $percentage_paid_rent.'%'?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                          </div>
                                          <?php
                                          }
                                          ?>
                                          </td>
                                          <td><?php echo $rent["amount"]?></td>
                                          <td><?php echo $rent["amount"] - $total_paid_rent?></td>
                                          <td><a href="tel:<?php echo '0'.$fetch2["phone"]?>" class="btn py-1 btn-outline-primary">Call</a></td>
                                      </tr>
                                      <?php
                                      }
                                    }
                                    else{
                                      $total_paid_rent = 0;
                                      $percentage_paid_rent = 0;
                                      if($month == $current_month && $current_year == $year && $total_paid_rent == 0){ ?>
                                      <tr>
                                          <td><?php echo $fetch2["name"]?></td>
                                          <td><?php echo '0'.$fetch2["phone"]?></td>
                                          <?php
                                          
                                          ?>
                                          <td>
                                          <?php
                                          if($percentage_paid_rent <= 30){?>
                                          <div class="progress">
                                              <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $percentage_paid_rent.'%'?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                          </div>
                                          <?php }
                                          else if($percentage_paid_rent > 30 && $percentage_paid_rent <= 80){?>
                                          <div class="progress">
                                              <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $percentage_paid_rent.'%'?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                          </div>
                                          <?php
                                          }
                                          else{?>
                                          <div class="progress">
                                              <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $percentage_paid_rent.'%'?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                          </div>
                                          <?php
                                          }
                                          ?>
                                          </td>
                                          <td><?php echo $rent["amount"]?></td>
                                          <td><?php echo $rent["amount"] - $total_paid_rent?></td>
                                          <td><a href="tel:<?php echo '0'.$fetch2["phone"]?>" class="btn py-1 btn-outline-primary">Call</a></td>
                                      </tr>
                                      <?php
                                      }
                                    }
                              }
                            }
                          }
}
                        
?>