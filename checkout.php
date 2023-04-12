<?php
session_start();
include "connect.php";
if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = array();
}

if(isset($_POST['add_to_cart'])){
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_quantity = $_POST['product_quantity'];

    if(isset($_SESSION['cart'][$product_id])){
        $_SESSION['cart'][$product_id]['quantity'] += $product_quantity;
    }else{
        $_SESSION['cart'][$product_id] = array(
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => $product_quantity
        );
    }
}

if(isset($_GET['remove'])){
    $product_id = $_GET['remove'];
    if(isset($_SESSION['cart'][$product_id])){
        unset($_SESSION['cart'][$product_id]);
    }
}

if(empty($_SESSION['cart'])){
    echo "<p>Your cart is empty</p>";
}else{
    echo "<table>";
    echo "<tr><th>Name</th><th>Price</th><th>Quantity</th><th>Total</th><th></th></tr>";
    $total = 0;
    foreach($_SESSION['cart'] as $product_id => $product){
        $product_name = $product['name'];
        $product_price = $product['price'];
        $product_quantity = $product['quantity'];
        $product_total = $product_price * $product_quantity;
        $total += $product_total;

        $sql = "INSERT INTO orderhistoriek (gebruiker_id, order_datum, product_naam, product_prijs, hoeveelheid, totale_prijs)
        VALUES ('{$_SESSION['user_id']}', NOW(), '$product_name', '$product_price', '$product_quantity', '$product_total')";
        if ($conn->query($sql) === TRUE) {
            echo "Order added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        echo "<tr>";
        echo "<td>$product_name</td>";
        echo "<td>€$product_price</td>";
        echo "<td>$product_quantity</td>";
        echo "<td>€$product_total</td>";
        echo "<td><a href=\"cart.php?remove=$product_id\">Remove</a></td>";
        echo "</tr>";
    }
    echo "<tr><td colspan=\"3\"></td><td><b>€$total</b></td><td></td></tr>";
    echo "</table>";

    echo "<h2>Add Payment Method</h2>";
    echo "<form action=\"process_payment.php\" method=\"post\">";
    echo "<label for=\"card_number\">Card Number:</label>";
    echo "<input type=\"text\" id=\"card_number\" name=\"card_number\" required><br>";
    echo "<label for=\"card_expiry\">Card Expiry:</label>";
    echo "<input type=\"text\" id=\"card_expiry\" name=\"card_expiry\" placeholder=\"MM/YY\" required><br>";
    echo "<label for=\"card_cvc\">Card CVC:</label>";
    echo "<input type=\"text\" id=\"card_cvc\" name=\"card_cvc\" required><br>";
    echo "<input type=\"submit\" value=\"Pay\">";
    echo "</form>";
}
?>