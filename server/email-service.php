<?php
session_start();

include 'connection.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

$rental_id = $_SESSION['rental_id'];

if(isset($_POST['all_tenants'])){
    $message = $_POST['all_tenants'];

    $select = "SELECT * FROM houses WHERE rental_id = ?";
    $st = $con -> prepare($select);
    $st -> execute([$rental_id]);
    $fetch = $st -> fetchAll();
    $count = 0;
    foreach($fetch as $fetch){
        $select2 = "SELECT * FROM tenants WHERE email IS NOT NULL";
        $statement = $con -> prepare($select2);
        $statement -> execute();
        $tenant = $statement -> fetchAll();
        foreach($tenant as $tenant){
            if($tenant['house_id'] == $fetch['id']){
                $rental = "SELECT * FROM rentals WHERE id = ?";
                $st2 = $con -> prepare($rental);
                $st2 -> execute([$rental_id]);
                $fetch2 = $st2 -> fetch();

                $rental_name = $fetch2['name'];
                $name = $tenant['name'];
                    $total_emails = $st2 -> rowCount();
                    $email = $tenant['email'];

                    //email content
                    $email_body = '<html>
                    <p>Dear '.$name.',</p><br>
                    <p>'.$message.'</p><br>
                    <p><strong>&copy; 2023 '.$rental_name.'</strong></p>
                    </html>';
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'kevinkarish983@gmail.com';
                    $mail->Password = 'trpxcutmptmqxxzv';
                    $mail->Port = 465;
                    $mail->SMTPSecure = 'ssl';
                    $mail->isHTML(true);
                    $mail->setFrom('kevinkarish983@gmail.com', "$rental_name");
                    $mail->addAddress($email);
                    $mail->Subject = ("$rental_name");
                    $mail->Body = $email_body;
                    $mail->send();
                    if($mail->send()){
                        $count += 1;
                        if($count == $total_emails){
                            echo '1';
                        }
                    }
            }
        }
    }
}
else if(isset($_POST['with_balance'])){
    $message = $_POST['with_balance'];

    $select = "SELECT * FROM houses WHERE rental_id = ?";
    $st = $con -> prepare($select);
    $st -> execute([$rental_id]);
    $fetch = $st -> fetchAll();
    $count = 0;
    foreach($fetch as $fetch){
        $select2 = "SELECT * FROM tenants WHERE email IS NOT NULL";
        $statement = $con -> prepare($select2);
        $statement -> execute();
        $tenant = $statement -> fetchAll();
        foreach($tenant as $tenant){
            if($tenant['house_id'] == $fetch['id']){
                $rental = "SELECT * FROM rentals WHERE id = ?";
                $st2 = $con -> prepare($rental);
                $st2 -> execute([$rental_id]);
                $fetch2 = $st2 -> fetch();

                $query = "SELECT DISTINCT * FROM rent WHERE rental_id = ? AND house_size = ?";
                $st4 = $con -> prepare($query);
                $st4 -> execute([$rental_id, $fetch['size']]);
                $rent = $st4 -> fetch();

                $payment = "SELECT * FROM payment WHERE tenant_id = ? OR house_id = ?";
                $st3 = $con -> prepare($payment);
                $st3 -> execute([$tenant["id"], $fetch['id']]);
                $fetch3 = $st3 -> fetchAll();
                $rows = $st3 -> rowCount();
                $total_paid_rent = 0;
                if($rows > 0){
                    foreach($fetch3 as $fetch3){
                        $timestamp = $fetch3["date"];
                            $date = date("Y-m-d",strtotime($timestamp));
                            $month = date("m", strtotime($date));
                            $current_month = date('m');
                            if($month == $current_month){
                                $total_paid_rent += $fetch3["amount"];
                            }
                    }
                }
                if($total_paid_rent >= 0 && $total_paid_rent < $rent["amount"]){
                    $rental_name = $fetch2['name'];
                    $name = $tenant['name'];
                    $total_emails = $st2 -> rowCount();
                    $email = $tenant['email'];

                    //email content
                    $email_body = '<html>
                    <p>Dear '.$name.',</p><br>
                    <p>'.$message.'</p><br>
                    <p><strong>&copy; 2023 '.$rental_name.'</strong></p>
                    </html>';
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'kevinkarish983@gmail.com';
                    $mail->Password = 'trpxcutmptmqxxzv';
                    $mail->Port = 465;
                    $mail->SMTPSecure = 'ssl';
                    $mail->isHTML(true);
                    $mail->setFrom('kevinkarish983@gmail.com', "$rental_name");
                    $mail->addAddress($email);
                    $mail->Subject = ("$rental_name");
                    $mail->Body = $email_body;
                    $mail->send();
                    if($mail->send()){
                        $count += 1;
                        if($count == $total_emails){
                            echo '1';
                        }
                    }
                }
            }
        }
    }
}
else if(isset($_POST['without_balance'])){
    $message = $_POST['without_balance'];

    $select = "SELECT * FROM houses WHERE rental_id = ?";
    $st = $con -> prepare($select);
    $st -> execute([$rental_id]);
    $fetch = $st -> fetchAll();
    $count = 0;
    foreach($fetch as $fetch){
        $select2 = "SELECT * FROM tenants WHERE email IS NOT NULL";
        $statement = $con -> prepare($select2);
        $statement -> execute();
        $tenant = $statement -> fetchAll();
        foreach($tenant as $tenant){
            if($tenant['house_id'] == $fetch['id']){
                $rental = "SELECT * FROM rentals WHERE id = ?";
                $st2 = $con -> prepare($rental);
                $st2 -> execute([$rental_id]);
                $fetch2 = $st2 -> fetch();

                $query = "SELECT DISTINCT * FROM rent WHERE rental_id = ? AND house_size = ?";
                $st4 = $con -> prepare($query);
                $st4 -> execute([$rental_id, $fetch['size']]);
                $rent = $st4 -> fetch();

                $payment = "SELECT * FROM payment WHERE tenant_id = ? OR house_id = ?";
                $st3 = $con -> prepare($payment);
                $st3 -> execute([$tenant["id"], $fetch['id']]);
                $fetch3 = $st3 -> fetchAll();
                $rows = $st3 -> rowCount();
                $total_paid_rent = 0;
                if($rows > 0){
                    foreach($fetch3 as $fetch3){
                            $timestamp = $fetch3["date"];
                            $date = date("Y-m-d",strtotime($timestamp));
                            $month = date("m", strtotime($date));
                            $current_month = date('m');
                            if($month == $current_month){
                                $total_paid_rent += $fetch3["amount"];
                            }
                    }
                }
                if($total_paid_rent >= $rent["amount"]){
                    $rental_name = $fetch2['name'];
                    $name = $tenant['name'];
                    $total_emails = $st2 -> rowCount();
                    $email = $tenant['email'];

                    //email content
                    $email_body = '<html>
                    <p>Dear '.$name.',</p><br>
                    <p>'.$message.'</p><br>
                    <p><strong>&copy; 2023 '.$rental_name.'</strong></p>
                    </html>';
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'kevinkarish983@gmail.com';
                    $mail->Password = 'trpxcutmptmqxxzv';
                    $mail->Port = 465;
                    $mail->SMTPSecure = 'ssl';
                    $mail->isHTML(true);
                    $mail->setFrom('kevinkarish983@gmail.com', "$rental_name");
                    $mail->addAddress($email);
                    $mail->Subject = ("$rental_name");
                    $mail->Body = $email_body;
                    $mail->send();
                    if($mail->send()){
                        $count += 1;
                        if($count == $total_emails){
                            echo '1';
                        }
                    }
                }
            }
        }
    }
}
else if(isset($_POST['specific']) && isset($_POST['tenant_id'])){
    $message = $_POST['specific'];
    $tenant_id = $_POST['tenant_id'];

    $select2 = "SELECT * FROM tenants WHERE id = ?";
    $statement = $con -> prepare($select2);
    $statement -> execute([$tenant_id]);
    $tenant = $statement -> fetch();

    $select = "SELECT * FROM houses WHERE id = ?";
    $st = $con -> prepare($select);
    $st -> execute([$tenant['house_id']]);
    $fetch = $st -> fetch();

    $rental = "SELECT * FROM rentals WHERE id = ?";
    $st2 = $con -> prepare($rental);
    $st2 -> execute([$rental_id]);
    $fetch2 = $st2 -> fetch();

    $rental_name = $fetch2['name'];
    $name = $tenant['name'];
    $email = $tenant['email'];

    //email content
    $email_body = '<html>
    <p>Dear '.$name.',</p><br>
    <p>'.$message.'</p><br>
    <p><strong>&copy; 2023 '.$rental_name.'</strong></p>
    </html>';
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'kevinkarish983@gmail.com';
    $mail->Password = 'trpxcutmptmqxxzv';
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';
    $mail->isHTML(true);
    $mail->setFrom('kevinkarish983@gmail.com', "$rental_name");
    $mail->addAddress($email);
    $mail->Subject = ("$rental_name");
    $mail->Body = $email_body;
    $mail->send();
    if($mail->send()){
        echo '1';
    }
}
else if(isset($_POST['specific']) && isset($_POST['criteria']) && isset($_POST['amount'])){
    $message = $_POST['specific'];
    $criteria = $_POST['criteria'];
    $amount = $_POST['amount'];

    $select = "SELECT * FROM houses WHERE rental_id = ?";
    $st = $con -> prepare($select);
    $st -> execute([$rental_id]);
    $fetch = $st -> fetchAll();
    $count = 0;
    foreach($fetch as $fetch){
        $select2 = "SELECT * FROM tenants WHERE email IS NOT NULL";
        $statement = $con -> prepare($select2);
        $statement -> execute();
        $tenant = $statement -> fetchAll();
        foreach($tenant as $tenant){
            if($tenant['house_id'] == $fetch['id']){
                $rental = "SELECT * FROM rentals WHERE id = ?";
                $st2 = $con -> prepare($rental);
                $st2 -> execute([$rental_id]);
                $fetch2 = $st2 -> fetch();

                $query = "SELECT DISTINCT * FROM rent WHERE rental_id = ? AND house_size = ?";
                $st4 = $con -> prepare($query);
                $st4 -> execute([$rental_id, $fetch['size']]);
                $rent = $st4 -> fetch();

                $payment = "SELECT * FROM payment WHERE tenant_id = ? OR house_id = ?";
                $st3 = $con -> prepare($payment);
                $st3 -> execute([$tenant["id"], $fetch['id']]);
                $fetch3 = $st3 -> fetchAll();
                $rows = $st3 -> rowCount();
                $total_paid_rent = 0;
                if($rows > 0){
                    foreach($fetch3 as $fetch3){
                            $timestamp = $fetch3["date"];
                            $date = date("Y-m-d",strtotime($timestamp));
                            $month = date("m", strtotime($date));
                            $current_month = date('m');
                            if($month == $current_month){
                                $total_paid_rent += $fetch3["amount"];
                            }
                    }
                }
                if($criteria == '>'){
                    if(($rent["amount"] - $total_paid_rent) > $amount){
                        $rental_name = $fetch2['name'];
                        $name = $tenant['name'];
                        $total_emails = $st2 -> rowCount();
                        $email = $tenant['email'];

                        //email content
                        $email_body = '<html>
                        <p>Dear '.$name.',</p><br>
                        <p>'.$message.'</p><br>
                        <p><strong>&copy; 2023 '.$rental_name.'</strong></p>
                        </html>';
                        $mail = new PHPMailer(true);
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'kevinkarish983@gmail.com';
                        $mail->Password = 'trpxcutmptmqxxzv';
                        $mail->Port = 465;
                        $mail->SMTPSecure = 'ssl';
                        $mail->isHTML(true);
                        $mail->setFrom('kevinkarish983@gmail.com', "$rental_name");
                        $mail->addAddress($email);
                        $mail->Subject = ("$rental_name");
                        $mail->Body = $email_body;
                        $mail->send();
                        if($mail->send()){
                            $count += 1;
                            if($count == $total_emails){
                                echo '1';
                            }
                        }
                    }
                }
                else if($criteria == '<'){
                    if(($rent["amount"] - $total_paid_rent) < $amount){
                        $rental_name = $fetch2['name'];
                        $name = $tenant['name'];
                        $total_emails = $st2 -> rowCount();
                        $email = $tenant['email'];

                        //email content
                        $email_body = '<html>
                        <p>Dear '.$name.',</p><br>
                        <p>'.$message.'</p><br>
                        <p><strong>&copy; 2023 '.$rental_name.'</strong></p>
                        </html>';
                        $mail = new PHPMailer(true);
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'kevinkarish983@gmail.com';
                        $mail->Password = 'trpxcutmptmqxxzv';
                        $mail->Port = 465;
                        $mail->SMTPSecure = 'ssl';
                        $mail->isHTML(true);
                        $mail->setFrom('kevinkarish983@gmail.com', "$rental_name");
                        $mail->addAddress($email);
                        $mail->Subject = ("$rental_name");
                        $mail->Body = $email_body;
                        $mail->send();
                        if($mail->send()){
                            $count += 1;
                            if($count == $total_emails){
                                echo '1';
                            }
                        }
                    }
                }
                else if($criteria == '='){
                    if(($rent["amount"] - $total_paid_rent) == $amount){
                        $rental_name = $fetch2['name'];
                        $name = $tenant['name'];
                        $total_emails = $st2 -> rowCount();
                        $email = $tenant['email'];

                        //email content
                        $email_body = '<html>
                        <p>Dear '.$name.',</p><br>
                        <p>'.$message.'</p><br>
                        <p><strong>&copy; 2023 '.$rental_name.'</strong></p>
                        </html>';
                        $mail = new PHPMailer(true);
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'kevinkarish983@gmail.com';
                        $mail->Password = 'trpxcutmptmqxxzv';
                        $mail->Port = 465;
                        $mail->SMTPSecure = 'ssl';
                        $mail->isHTML(true);
                        $mail->setFrom('kevinkarish983@gmail.com', "$rental_name");
                        $mail->addAddress($email);
                        $mail->Subject = ("$rental_name");
                        $mail->Body = $email_body;
                        $mail->send();
                        if($mail->send()){
                            $count += 1;
                            if($count == $total_emails){
                                echo '1';
                            }
                        }
                    }
                }
            }
        }
    }
}
?>