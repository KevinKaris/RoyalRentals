<?php
session_start();
include "../server/connection.php";

if(isset($_SESSION['username']) && !isset($_SESSION['lock']) && isset($_SESSION['user-group']) && $_SESSION['user-group'] == 1 && (time() - $_SESSION['login-time']) <= 28800){
  $user_id = $_SESSION["user_id"];

  $_SESSION['url'] = $_SERVER['REQUEST_URI'];

  $query = "SELECT * FROM users WHERE id = ? AND user_group = ?";
  $st = $con -> prepare($query);
  $st -> execute([$user_id, $_SESSION['user-group']]);
  $fetch = $st ->fetch();
?>
<!doctype html>
<html>
<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<title>RoyalRentals</title>
<link href='https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css' rel='stylesheet'>
<link rel="stylesheet" href="../vendors/iconfonts/font-awesome/css/all.min.css">
<link href='' rel='stylesheet'>
<link rel="shortcut icon" href="../images/logo_mini.png" />
<style>
.demo {
    background: #310441;
    padding: 30px 0;
    min-height: 100vh;
}
.demo .row{
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
}

a {
    text-decoration: none;
}

.pricingTable {
    padding: 25px 10px 70px;
    margin: 0 15px;
    text-align: center;
    z-index: 1;
    position: relative;
}

.pricingTable:after,
.pricingTable:before {
    content: "";
    position: absolute;
    left: 0
}

.pricingTable .price-value .amount {
    display: inline-block;
    font-size: 50px;
    font-weight: 700
}

.pricingTable .price-value .month {
    display: block;
    font-size: 20px;
    font-weight: 500;
    line-height: 10px;
    text-transform: uppercase
}

.pricingTable:before {
    width: 100%;
    height: 100%;
    background: #fff;
    top: 0;
    z-index: -1;
    -webkit-clip-path: polygon(100% 0, 100% 85%, 50% 100%, 0 85%, 0 0);
    clip-path: polygon(100% 0, 100% 85%, 50% 100%, 0 85%, 0 0)
}

.pricingTable:after {
    width: 70px;
    height: 30px;
    background: #1daa72;
    margin: 0 auto;
    top: 70px;
    right: 0;
    -webkit-clip-path: polygon(50% 100%, 0 0, 100% 0);
    clip-path: polygon(50% 100%, 0 0, 100% 0)
}

.pricingTable .title {
    padding: 15px 0;
    margin: 0 -25px 30px;
    background: #1daa72;
    font-size: 25px;
    font-weight: 600;
    color: #fff;
    text-transform: uppercase;
    position: relative
}

.pricingTable .title:after,
.pricingTable .title:before {
    border-top: 15px solid #51836d;
    border-bottom: 15px solid transparent;
    position: absolute;
    bottom: -30px;
    content: ""
}

.pricingTable .title:before {
    border-left: 15px solid transparent;
    left: 0
}

.pricingTable .title:after {
    border-right: 15px solid transparent;
    right: 0
}

.pricingTable .price-value {
    margin-bottom: 25px;
    color: #1daa72
}

.pricingTable .currency {
    display: inline-block;
    font-size: 30px;
    vertical-align: top;
    margin-top: 8px
}

.price-value .amount {
    display: inline-block;
    font-size: 50px;
    font-weight: 700
}

.price-value .month {
    display: block;
    font-size: 20px;
    font-weight: 500;
    line-height: 10px;
    text-transform: uppercase
}

.pricingTable .pricing-content {
    padding: 0;
    margin: 0 0 25px;
    list-style: none;
    border-top: 1px solid #8f8f8f;
    border-bottom: 1px solid #8f8f8f
}

.pricingTable .pricing-content li {
    font-size: 17px;
    color: #8f8f8f;
    line-height: 55px
}

.pricingTable .pricingTable-signup {
    display: inline-block;
    padding: 10px 30px;
    background: #1daa72;
    font-size: 18px;
    font-weight: 600;
    color: #fff;
    overflow: hidden;
    position: relative;
    transition: all .7s ease 0s
}

.pricingTable .pricingTable-signup:before {
    content: "";
    display: inline-block;
    width: 100%;
    height: 100%;
    background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0, rgba(255, 255, 255, 1) 50%, rgba(255, 255, 255, 0) 100%);
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
    transform: translate(0, 100%);
    transition: all .6s ease-in-out 0s
}

.pricingTable .pricingTable-signup:hover:before {
    opacity: 1;
    transform: translate(0, -100%)
}

.pricingTable.blue .pricingTable-signup,
.pricingTable.blue .title,
.pricingTable.blue:after {
    background: #49b0ca
}

.pricingTable.blue .title:after,
.pricingTable.blue .title:before {
    border-top: 15px solid #407a88
}

.pricingTable.blue .price-value {
    color: #49b0ca
}

.pricingTable.pink .pricingTable-signup,
.pricingTable.pink .title,
.pricingTable.pink:after {
    background: #f06ace
}

.pricingTable.pink .price-value {
    color: #f06ace
}

.pricingTable.pink .title:after,
.pricingTable.pink .title:before {
    border-top: 15px solid #773667
}
.payment-modal{
    position: fixed;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .7) !important;
    left: 0;
    top: 0;
    z-index: 10;
    display: none;
}
.payment-modal .main{
    position: absolute;
    display: block;
    top: -100%;
    left: 50%;
    transform: translateX(-50%);
    width: 400px;
    height: 400px;
    padding: 15px;
    background: #fff;
    transition-duration: 4s;
}

@media only screen and (max-width:990px) {
    .pricingTable {
        margin-bottom: 30px
    }
}
@media only screen and (max-width: 500px){
    .payment-modal .main{
        width: 93%;
    }
}
</style>
<script type='text/javascript' src=''></script>
<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
<script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js'></script>
</head>
<body oncontextmenu='return false' class='snippet-body'>
<div class="demo">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-sm-8">
                <div class="pricingTable">
                    <h3 class="title">Monthly Subscription</h3>
                    <div class="price-value">
                        <span class="currency">Ksh</span>
                        <span class="amount">2,000</span>
                        <span class="month">/rental</span>
                    </div>
                    <ul class="pricing-content">
                        <li><b><i class="fa fa-check"></i></b> Customer Support</li>
                        <li><b><i class="fa fa-check"></i></b> Feature Updates</li>
                        <li><b><i class="fa fa-check"></i></b> Personalized Customization</li>
                        <li><b><i class="fa fa-check"></i></b> Maintainance Support</li>
                        <li><b><i class="fa fa-check"></i></b> Data Backup</li>
                    </ul>
                    <a href="#" class="pricingTable-signup" id="pricingTable-signup">Checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$rental = "SELECT * FROM rentals WHERE user_id = ?";
$statement = $con -> prepare($rental);
$statement -> execute([$fetch['id']]);
//$fetch_rental = $statement -> fetchAll();
$count = $statement -> rowCount();
$amount = 2000 * $count;
$_SESSION['amount'] = $amount;
?>

<!-- confirm modal -->
<div class="payment-modal">
    <div class="main">
        <h4 class="col-12 text-center mb-3">Checkout</h4>
        <div class="form-group mb-3">
            <input type="radio" id="mpesa" checked>
            <label for="mpesa">Mpesa</label>
        </div>
        <div class="form-group mb-3">
            <input type="number" class="form-control" value="<?php echo $amount?>" id="amount">
        </div>
        <div class="form-group mb-3">
            <label for="number_of_months">Enter Number of Months</label>
            <input type="number" class="form-control" value="" placeholder="Enter No. of months" id="number_of_months">
        </div>
        <div class="form-group row mb-3">
            <input type="text" class="form-control" style="width: 20%; margin-left: 13px !important" value="254" id="country-code">
            <input type="tel" class="form-control mx-2" style="width: 71.5%" value="<?php echo $fetch['phone'] ?>" id="phone" placeholder="e.g 740000000">
        </div>
        <div class="form-group mb-3">
            <input type="submit" class="btn btn-primary form-control" value="Pay Now" id="pay">
        </div>
        <button class="btn btn-light btn-outline-dark" id="cancel">Cancel</button>
    </div>
</div>

<script src="../js/jquery_3.6.0.min.js"></script>
<script type='text/javascript'></script>
<script>
    $(document).ready(function(){
        //calculating amount to be paid when number of months is entered
        $('#number_of_months').on('keyup', function(){
            var number_of_months = $(this).val();
            number_of_months = number_of_months.replace(/\D/g, '');
            if(number_of_months > 0){
                $('#amount').val(number_of_months * <?php echo $amount?>);
            }
        })

        $('#pricingTable-signup').on('click', function(){
            $('.payment-modal').show();
            $('.payment-modal .main').css('top', '20%');
            $('.payment-modal #cancel').on('click', function(){
                $('.payment-modal .main').css('top', '-100%');
                $('.payment-modal').hide();
            })

            var maxDigits = 9;

            $('#phone').on('input', function() {
                var inputValue = $(this).val();

                // Remove non-numeric characters
                inputValue = inputValue.replace(/\D/g, '');

                // Limit the number of digits
                inputValue = inputValue.slice(0, maxDigits);
            });

            $('#pay').on('click', function(){
                if ($('#mpesa').is(':checked')) {
                    var inputValue = $('#phone').val();
                    inputValue = inputValue.replace(/\D/g, '');
                    var amount = $('#amount').val();
                    var user_id = <?php echo $fetch['id']?>;
                    var number_of_months = $(this).val();
                    number_of_months = number_of_months.replace(/\D/g, '');
                    if(inputValue != ''){
                        if(inputValue.length == 9){
                            $('.payment-modal #cancel').prop('disabled', true);
                            $(this).val('Processing...').prop('disabled', true);
                            $.ajax({
                                type: "post",
                                url: "../server/bill-pay.php",
                                data: {phone: inputValue, amount: amount, user_id: user_id, months: number_of_months},
                                //dataType: "dataType",
                                success: function(response){
                                    console.log(response);
                                }
                            });
                        }
                        else{
                            alert('Invalid phone number or incorrect format!');
                        }
                    }
                    else{
                        alert('Enter phone number!');
                    }
                } else {
                    alert('Payment mode not selected!');
                }
            })
        })

        //disabling amount button
        $('#amount').prop('disabled', true);
        $('#country-code').prop('disabled', true);
    })
</script>
</body>
</html>
<?php
}
elseif(isset($_SESSION['username']) && isset($_SESSION['lock']) && isset($_SESSION['user-group']) && $_SESSION['user-group'] == 1 && (time() - $_SESSION['login-time']) <= 28800){
  echo "<script>window.location.assign('lock')</script>";
}
else{
  echo "<script>window.location.assign('../login')</script>";
}