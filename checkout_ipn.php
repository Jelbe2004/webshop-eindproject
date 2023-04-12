<?php
// Step 1: Get the transaction data
$req = 'cmd=_notify-validate';
foreach ($_POST as $key => $value) {
  $value = urlencode(stripslashes($value));
  $req .= "&$key=$value";
}

// Step 2: Post the transaction data back to PayPal for validation
$ch = curl_init('https://www.paypal.com/cgi-bin/webscr');
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

if( !($res = curl_exec($ch)) ) {
  curl_close($ch);
  exit;
}
curl_close($ch);

// Step 3: Interpret the PayPal response
if (strcmp($res, "VERIFIED") == 0) {
  // Check if the payment status is Completed
  if ($_POST['payment_status'] == 'Completed') {
    // Get the transaction details from PayPal
    $txn_id = $_POST['txn_id'];
    $receiver_email = $_POST['receiver_email'];
    $payer_email = $_POST['payer_email'];
    $item_name = $_POST['item_name'];
    $item_number = $_POST['item_number'];
    $mc_gross = $_POST['mc_gross'];
    $mc_currency = $_POST['mc_currency'];

    // Process the order and update your database
    // ...

    // Send an email notification to the customer and the merchant
    // ...
  }
  else if ($_POST['payment_status'] == 'Pending') {
    // Payment is pending, do not process it until it is complete
  }
  else {
    // Payment is not completed, log the error
  }
}
else if (strcmp($res, "INVALID") == 0) {
  // IPN invalid, log the error
}
?>