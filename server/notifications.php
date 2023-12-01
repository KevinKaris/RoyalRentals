<?php
session_start();
include 'connection.php';

$user_id = $_SESSION['user_id'];

//todo notifications
$SELECT = "SELECT * FROM todo WHERE user_id = ? AND completed IS NULL";
$statement = $con -> prepare($SELECT);
$statement -> execute([$user_id]);
$fetch = $statement -> fetchAll();
$rows = $statement -> rowCount();

if($rows > 0){
    foreach($fetch as $fetch){
        $current_timestamp = date('Y-m-d H:i:s');
        $todo_timestamp = $fetch['date'];
        $current_timestamp = strtotime($current_timestamp);
        $todo_timestamp = strtotime($todo_timestamp);
        $hours = abs($todo_timestamp - $current_timestamp)/(60*60);

        if($hours >= 20){
            $SELECT2 = "SELECT * FROM notifications WHERE user_id = ? AND type = ?";
            $st2 = $con -> prepare($SELECT2);
            $st2 -> execute([$user_id, 'task']);
            $rows = $st2 -> rowCount();
            $column = $st2 -> fetch();
            if($rows <= 0){
                $INSERT = "INSERT INTO notifications (user_id, type, notification) VALUES (?, ?, ?)";
                $st = $con -> prepare($INSERT);
                $execute = $st -> execute([$user_id, 'task', 'Uncompleted Todo task(s)']);
                if($execute == true){
                    $SELECT2 = "SELECT * FROM notifications WHERE user_id = ? AND type = ?";
                    $st2 = $con -> prepare($SELECT2);
                    $st2 -> execute([$user_id, 'task']);
                    $details = $st2 -> fetch();
                ?>
                    <div class="dropdown-divider"></div>
                    <a href="dashboard#todoList" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                        <div class="preview-icon bg-warning">
                            <i class="fas fa-exclamation-circle mx-0"></i>
                        </div>
                        </div>
                        <div class="preview-item-content">
                        <h6 class="preview-subject font-weight-medium">
                            <?php echo $details['notification']?>
                        </h6>
                        <p class="font-weight-light small-text">Reminder</p>
                        </div>
                        <input type="hidden" value="<?php echo $details['id']?>">
                    </a>
                <?php
                }
           }
           else{
            $SELECT2 = "SELECT DISTINCT * FROM notifications WHERE user_id = ? AND type = ? AND view IS NULL";
            $st2 = $con -> prepare($SELECT2);
            $st2 -> execute([$user_id, 'task']);
            $details = $st2 -> fetch();
            if($details != null){?>
                <div class="dropdown-divider"></div>
                <a href="dashboard#todoList" class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                    <div class="preview-icon bg-warning">
                        <i class="fas fa-exclamation-circle mx-0"></i>
                    </div>
                    </div>
                    <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-medium">
                        <?php echo $details['notification']?>
                    </h6>
                    <p class="font-weight-light small-text">Reminder</p>
                    </div>
                    <input type="hidden" value="<?php echo $details['id']?>">
                </a>
                <?php
            }
           }
        }
    }
}

//end of month notification
$current_timestamp = date('Y-m-d');
$current_last_date = date("Y-m-t", strtotime($current_timestamp));

// Convert the last day to a Unix timestamp, subtract one day (86400 seconds), and then format it back to 'Y-m-d' format.
$last_day_timestamp = strtotime($current_last_date);
$previous_day = date("Y-m-d", $last_day_timestamp - 86400);
if($current_timestamp == $previous_day){
    $SELECT2 = "SELECT * FROM notifications WHERE user_id = ? AND type = ?";
    $st2 = $con -> prepare($SELECT2);
    $st2 -> execute([$user_id, 'rent_reminder']);
    $rows = $st2 -> rowCount();
    if($rows <= 0){
        $INSERT = "INSERT INTO notifications (user_id, type, notification) VALUES (?, ?, ?)";
        $st = $con -> prepare($INSERT);
        $execute = $st -> execute([$user_id, 'rent_reminder', 'Remind tenants to pay rent']);

        if($execute == true){
            $SELECT2 = "SELECT * FROM notifications WHERE user_id = ? AND type = ? AND view IS NULL";
            $st2 = $con -> prepare($SELECT2);
            $st2 -> execute([$user_id, 'rent_reminder']);
            $details = $st2 -> fetch();
            ?>
            <div class="dropdown-divider"></div>
            <a href="with-balance" class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                <div class="preview-icon bg-danger">
                    <i class="fas fa-file-invoice-dollar mx-0"></i>
                </div>
                </div>
                <div class="preview-item-content">
                <h6 class="preview-subject font-weight-medium">
                    <?php echo $details['notification']?>
                </h6>
                <p class="font-weight-light small-text">One day to end month</p>
                </div>
                <input type="hidden" value="<?php echo $details['id']?>">
            </a>
    <?php
        }
    }
    else{
            $SELECT2 = "SELECT * FROM notifications WHERE user_id = ? AND type = ? AND view IS NULL";
            $st2 = $con -> prepare($SELECT2);
            $st2 -> execute([$user_id, 'rent_reminder']);
            $details = $st2 -> fetch();
            if($details != null){
            ?>
                <div class="dropdown-divider"></div>
                <a href="with-balance" class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                    <div class="preview-icon bg-danger">
                        <i class="fas fa-file-invoice-dollar mx-0"></i>
                    </div>
                    </div>
                    <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-medium">
                        <?php echo $details['notification']?>
                    </h6>
                    <p class="font-weight-light small-text">One day to end month</p>
                    </div>
                    <input type="hidden" value="<?php echo $details['id']?>">
                </a>
        <?php
            }
    }
}

//check how much money was not paid by the end of month
if($current_timestamp == $current_last_date){
    $SELECT2 = "SELECT * FROM notifications WHERE user_id = ? AND type IN(?, ?, ?)";
    $st2 = $con -> prepare($SELECT2);
    $st2 -> execute([$user_id, 'rent_paid', 'tenants', 'houses']);
    $details = $st2 -> fetchAll();
    $rows = $st2 -> rowCount();

    if($rows <= 0){
        $INSERT1 = "INSERT INTO notifications (user_id, type, notification) VALUES (?, ?, ?)";
        $st1 = $con -> prepare($INSERT1);
        $execute1 = $st1 -> execute([$user_id, 'rent_paid', 'Check if all rent was paid this month']);

        $INSERT2 = "INSERT INTO notifications (user_id, type, notification) VALUES (?, ?, ?)";
        $st2 = $con -> prepare($INSERT2);
        $execute2 = $st2 -> execute([$user_id, 'tenants', "Hey, check out how many tenants<br> you're closing with this month"]);

        $INSERT3 = "INSERT INTO notifications (user_id, type, notification) VALUES (?, ?, ?)";
        $st3 = $con -> prepare($INSERT3);
        $execute3 = $st3 -> execute([$user_id, 'houses', 'See houses statistics']);

        if($execute1 == true && $execute2 == true && $execute3 == true){
            $SELECT2 = "SELECT * FROM notifications WHERE user_id = ? AND type IN (?, ?, ?) AND view IS NULL";
            $st2 = $con -> prepare($SELECT2);
            $st2 -> execute([$user_id, 'rent_paid', 'tenants', 'houses']);
            $details = $st2 -> fetchAll();

            foreach($details as $details){
                if($details['type'] == 'rent_paid'){?>
                    <div class="dropdown-divider"></div>
                    <a href="dashboard#table" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                        <div class="preview-icon bg-info">
                            <i class="fas fa-file-invoice-dollar mx-0"></i>
                        </div>
                        </div>
                        <div class="preview-item-content">
                        <h6 class="preview-subject font-weight-medium">
                            <?php echo $details['notification']?>
                        </h6>
                        <p class="font-weight-light small-text">Rent payment summary</p>
                        </div>
                        <input type="hidden" value="<?php echo $details['id']?>">
                    </a>
                    <?php
                }
                elseif($details['type'] == 'tenants'){?>
                    <div class="dropdown-divider"></div>
                    <a href="dashboard#tenans_row" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                        <div class="preview-icon bg-success">
                            <i class="fa fa-users mx-0"></i>
                        </div>
                        </div>
                        <div class="preview-item-content">
                        <h6 class="preview-subject font-weight-medium">
                            <?php echo $details['notification']?>
                        </h6>
                        <p class="font-weight-light small-text">Tenants stats</p>
                        </div>
                        <input type="hidden" value="<?php echo $details['id']?>">
                    </a>
                    <?php
                }
                elseif($details['type'] == 'houses'){?>
                    <div class="dropdown-divider"></div>
                    <a href="dashboard#houses_row" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                        <div class="preview-icon bg-dark">
                            <i class="far fa-building mx-0"></i>
                        </div>
                        </div>
                        <div class="preview-item-content">
                        <h6 class="preview-subject font-weight-medium">
                            <?php echo $details['notification']?>
                        </h6>
                        <p class="font-weight-light small-text">Houses stats</p>
                        </div>
                        <input type="hidden" value="<?php echo $details['id']?>">
                    </a>
                    <?php
                }
            }
        }
    }
    else{
        $SELECT2 = "SELECT * FROM notifications WHERE user_id = ? AND type IN (?, ?, ?) AND view IS NULL";
        $st2 = $con -> prepare($SELECT2);
        $st2 -> execute([$user_id, 'rent_paid', 'tenants', 'houses']);
        $details = $st2 -> fetchAll();
        if($details != null){
            foreach($details as $details){
                if($details['type'] == 'rent_paid'){?>
                    <div class="dropdown-divider"></div>
                    <a href="dashboard#table" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                        <div class="preview-icon bg-info">
                            <i class="fas fa-file-invoice-dollar mx-0"></i>
                        </div>
                        </div>
                        <div class="preview-item-content">
                        <h6 class="preview-subject font-weight-medium">
                            <?php echo $details['notification']?>
                        </h6>
                        <p class="font-weight-light small-text">Rent payment summary</p>
                        </div>
                        <input type="hidden" value="<?php echo $details['id']?>">
                    </a>
                    <?php
                }
                elseif($details['type'] == 'tenants'){?>
                    <div class="dropdown-divider"></div>
                    <a href="dashboard#tenans_row" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                        <div class="preview-icon bg-success">
                            <i class="fa fa-users mx-0"></i>
                        </div>
                        </div>
                        <div class="preview-item-content">
                        <h6 class="preview-subject font-weight-medium">
                            <?php echo $details['notification']?>
                        </h6>
                        <p class="font-weight-light small-text">Tenants stats</p>
                        </div>
                        <input type="hidden" value="<?php echo $details['id']?>">
                    </a>
                    <?php
                }
                elseif($details['type'] == 'houses'){?>
                    <div class="dropdown-divider"></div>
                    <a href="dashboard#houses_row" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                        <div class="preview-icon bg-dark">
                            <i class="far fa-building mx-0"></i>
                        </div>
                        </div>
                        <div class="preview-item-content">
                        <h6 class="preview-subject font-weight-medium">
                            <?php echo $details['notification']?>
                        </h6>
                        <p class="font-weight-light small-text">Houses stats</p>
                        </div>
                        <input type="hidden" value="<?php echo $details['id']?>">
                    </a>
                    <?php
                }
            }
        }
    }
}

//deleting completed notifications after five days
$SELECT = "SELECT * FROM notifications WHERE user_id = ?";
$statement = $con -> prepare($SELECT);
$statement -> execute([$user_id]);
$count = $statement -> rowCount();
if($count > 0){
    $fetch = $statement -> fetchAll();
    foreach($fetch as $fetch){
        $timestamp = $fetch['date'];
        $five_days_later = date('Y-m-d', strtotime($timestamp."+5 days"));
        $current_date = date('Y-m-d');
        if($current_date >= $five_days_later){
            $DELETE = "DELETE FROM notifications WHERE user_id = ? AND id = ?";
            $statement2 = $con -> prepare($DELETE);
            $statement2 -> execute([$user_id, $fetch['id']]);
        }
    }
}