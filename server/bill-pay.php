<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['amount'])) {
    date_default_timezone_set('Africa/Nairobi');

    # access token
    $consumerKey = 'ZGVnhGDC0lYajnxrh6ipm3GIjerBWvCw';
    $consumerSecret = 'BAbwnNYKfHrKGekC';

    # define the variables
    $Amount = 1;
    $BusinessShortCode = '254746182038'; // sandbox
    $Passkey = 'EgO4tntXGzlcOVSmC2Rtk38y3Z2kcLDXNQnIRRTHXXvTjmGLk03xxij2TfqBbm//zhOtclInTJmvs1pCm6cTZA6fk1XhveKgc2wtyzTS3feejzTl9eHg2t/5XAi/fromF9uMWlvLP7ZJpziCHn6rG4B39AhOyIIPW1xWWpodsN6eIpwPxiSWvZwhvVX8o9D05XkvyVdCP44yzOtyu8If8KNH4vGmTVlEe1/Y5iKxmr1Vx4KzEVwZVXlQbrWO551WwJmK4MC0Qc1fFOWgmZU8ZvemIWxzSd57JKwFE8J1Rxh33QAEVt2UibubIA6h/m6a9zx2O7yK6QqIrRKM4Dn49Q==';

    $PartyA = '254799834414'; // This is your phone number,
    $AccountReference = 'R' . time();
    $TransactionDesc = 'RoyalRentals';

    # Get the timestamp, format YYYYmmddhms -> 20181004151020
    $Timestamp = date('YmdHis');

    # Get the base64 encoded string -> $password. The passkey is the M-PESA Public Key
    $Password = base64_encode($BusinessShortCode . $Passkey . $Timestamp);

    # header for access token
    $headers = ['Content-Type:application/json; charset=utf8'];

    # M-PESA endpoint urls
    $access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    $initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

    # callback url
    $CallBackURL = 'https://modeled-line.000webhostapp.com/server/bill-pay.php';

    $curl = curl_init($access_token_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_HEADER, FALSE);
    curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
    $result = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $result = json_decode($result);
    curl_close($curl);

    if (isset($result->error)) {
        echo 'Access Token Error: ' . $result->error_description;
        exit;
    }

    $access_token = $result->access_token;

    # header for stk push
    $stkheader = ['Content-Type:application/json', 'Authorization:Bearer ' . $access_token];

    # initiating the transaction
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $initiate_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader); //setting custom header

    $curl_post_data = array(
        //Fill in the request parameters with valid values
        'BusinessShortCode' => $BusinessShortCode,
        'Password' => $Password,
        'Timestamp' => $Timestamp,
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => $Amount,
        'PartyA' => $PartyA,
        'PartyB' => $BusinessShortCode,
        'PhoneNumber' => $PartyA,
        'CallBackURL' => $CallBackURL,
        'AccountReference' => $AccountReference,
        'TransactionDesc' => $TransactionDesc
    );

    $data_string = json_encode($curl_post_data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    $curl_response = curl_exec($curl);
    echo 'curl_response' . $curl_response;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // This is a callback from M-Pesa
    $callbackJSONData = file_get_contents('php://input');

    $logFile = "stkPush.json";
    $log = fopen($logFile, "a");
    fwrite($log, $callbackJSONData);
    fclose($log);

    $callbackData = json_decode($callbackJSONData);

    $resultCode = $callbackData->Body->stkCallback->ResultCode;
    $resultDesc = $callbackData->Body->stkCallback->ResultDesc;
    $merchantRequestID = $callbackData->Body->stkCallback->MerchantRequestID;
    $checkoutRequestID = $callbackData->Body->stkCallback->CheckoutRequestID;
    $pesa = $callbackData->Body->stkCallback->CallbackMetadata->Item[0]->Name;
    $amount = $callbackData->Body->stkCallback->CallbackMetadata->Item[0]->Value;
    $mpesaReceiptNumber = $callbackData->Body->stkCallback->CallbackMetadata->Item[1]->Value;
    $balance = $callbackData->Body->stkCallback->CallbackMetadata->Item[2]->Value;
    $b2CUtilityAccountAvailableFunds = $callbackData->Body->stkCallback->CallbackMetadata->Item[3]->Value;
    $transactionDate = $callbackData->Body->stkCallback->CallbackMetadata->Item[4]->Value;
    $phoneNumber = $callbackData->Body->stkCallback->CallbackMetadata->Item[5]->Value;

    if ($resultCode == 0) {
        echo 'Payment has been successful!';
    }
}