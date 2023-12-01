<?php session_start();
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