<?php
session_start();
include "connect.php";
if(empty($_SESSION['cart'])){
    echo "<p>Your cart is empty</p>";
}else{
    $total = 0;
    foreach($_SESSION['cart'] as $product){
        $product_price = $product['price'];
        $product_quantity = $product['quantity'];
        $product_total = $product_price * $product_quantity;
        $total += $product_total;
    }

    $paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; 
    $paypal_id = 'your_paypal_id_here'; 
    $return_url = 'https://www.yourwebsite.com/checkout_complete.php'; 
    $cancel_url = 'https://www.yourwebsite.com/checkout_cancelled.php'; 
    $notify_url = 'https://www.yourwebsite.com/checkout_ipn.php'; 
    $currency_code = 'EUR'; 

    $paypal_data = array(
        'cmd' => '_xclick',
        'business' => $paypal_id,
        'amount' => $total,
        'currency_code' => $currency_code,
        'no_shipping' => 1,
        'no_note' => 1,
        'item_name' => 'Purchase from Your Website',
        'return' => $return_url,
        'cancel_return' => $cancel_url,
        'notify_url' => $notify_url,
        'custom' => $_SESSION['user_id']
    );

    $query_string = http_build_query($paypal_data);

    header("Location: $paypal_url?$query_string");
    exit();
}
?>