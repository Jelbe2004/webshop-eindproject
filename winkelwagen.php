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
    
        $_SESSION['cart'][$product_id] = array(
            'name' => $product_name,
            'price' => $product_price,
        );
    
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
    echo "<tr><th>Name</th><th>Price</th></tr>";
    $total = 0;
    foreach($_SESSION['cart'] as $product_id => $product){
        $product_name = $product['name'];
        $product_price = $product['price'];
        

        $sql = "INSERT INTO orderhistoriek (gebruiker_id, order_datum, product_naam, product_prijs)
        VALUES ('{$_SESSION['user_id']}', NOW(), '$product_name', '$product_price')";
        if ($conn->query($sql) === TRUE) {
            echo "Order added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        echo "<tr>";
        echo "<td>$product_name</td>";
        echo "<td>€$product_price</td>";
        echo "<td><a href=\"cart.php?remove=$product_id\">Remove</a></td>";
        echo "</tr>";
    }
    echo "<tr><td colspan=\"3\"></td><td><b>€$total</b></td><td></td></tr>";
    echo "</table>";
}

?>
<html>
<head>
	<title>Shopping cart</title>
</head>
<body>
	<h1>Shopping cart</h1>
	<a href="index.php">Continue shopping</a>
	<a href="checkout.php">Checkout</a>
</body>
</html>