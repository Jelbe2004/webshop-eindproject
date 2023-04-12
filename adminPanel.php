<?php
session_start();
//if(!isset($_SESSION['type']) || $_SESSION['type'] != "admin"){
    //header("location: index.php");
    //exit();
//}

include "connect.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $product_naam = $_POST['product_naam'];
    $product_omschrijving = $_POST['product_omschrijving'];
    $product_prijs = $_POST['product_prijs'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["product_foto"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["product_foto"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "Dit is geen foto.";
        $uploadOk = 0;
    }

    if (file_exists($target_file)) {
        echo "Sorry, de foto wordt al gebruikt.";
        $uploadOk = 0;
    }

    if ($_FILES["product_foto"]["size"] > 500000) {
        echo "Sorry, de foto is te groot.";
        $uploadOk = 0;
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, je mag alleen JPG, JPEG, PNG & GIF uploaden.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, je foto is niet geüpload.";
    } else {
        if (move_uploaded_file($_FILES["product_foto"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO tblwinkelvooraad (product_naam, product_omschrijving, product_prijs, product_foto)
            VALUES ('$product_naam', '$product_omschrijving', '$product_prijs', '$target_file')";
            if ($mysqli->query($sql) === TRUE) {
                echo "Product succesvol in de winkel gezet";
            } else {
                echo "Error: " . $sql . "<br>" . $mysqli->error;
            }
        } else {
            echo "Sorry, er was een error met je foto online te zetten.";
        }
    }
}
?>
<html>
<head>
	<title>Admin paneel</title>
</head>
<body>
	<h1>Admin paneel</h1>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label for="product_naam">Product naam:</label>
			<input type="text" class="form-control" id="product_naam" name="product_naam" required>
		</div>
		<div class="form-group">
			<label for="product_omschrijving">Product omschrijving:</label>
			<textarea class="form-control" id="product_omschrijving" name="product_omschrijving" rows="3" required></textarea>
		</div>
		<div class="form-group">
			<label for="product_prijs">Product prijs:</label>
			<input type="number" step="0.01" class="form-control" id="product_prijs" name="product_prijs" required>
		</div>
		<div class="form-group">
			<label for="product_foto">Product foto:</label>
			<input type="file" class="form-control" id="product_foto" name="product_foto" required>
		</div>
		<button type="submit" class="btn btn-primary">product toevoegen</button>
	</form>
	<br>
    
    <?php
    $sql = "SELECT * FROM tblgebruikers";
    $result = $mysqli->query($sql);
    
    echo "<table>";
    echo "<tr><th>ID</th><th>Gebruikersnaam</th><th>Email</th><th>Verwijderen</th></tr>";
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["ID"]."</td><td>".$row["gebruikersnaam"]."</td><td>".$row["email"]."</td><td><a href='verwijder_gebruiker.php?id=".$row["ID"]."'>Verwijder</a></td></tr>";
      }
    } else {
      echo "Geen resultaten";
    }
    echo "</table>";
    $sql ="SELECT * FROM tblorderhistoriek";
    $result= $mysqli->query($sql);
    echo "<table>";
echo "<tr><th>ID</th><th>Gebruiker ID</th><th>Order Datum</th><th> product naam</th><th> product prijs</th><th> hoeveelheid</th><th>Order Totaal</th></tr>";
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo "<tr><td>".$row["order_id"]."</td><td>".$row["gebruiker_id"]."</td><td>".$row["order_datum"]."</td><td>".$row["product_naam" ]."</td><td>".$row["product_prijs"]."</td><td>".$row["hoeveelheid"]."</td><td>".$row["totale_prijs"]."</td></tr>";
  }
} else {
  echo "Geen resultaten";
}
echo "</table>"
    ?>
	<a href="index.php">terug naar hoofdpagina</a>
</body>
</html>