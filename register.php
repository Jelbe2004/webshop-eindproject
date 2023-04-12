<?php
session_start();
include "connect.php";
?>

<html>
<head>
    <title>registeren</title>
</head>
<body>
<h1>registeren</h1>

<?php
if (isset($_POST['register'])) {
    $gebruiker = strtolower($_POST['gebruikersnaam']);
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];
    
    $sqluser = "SELECT gebruikersnaam FROM tblgebruikers WHERE gebruikersnaam='".$gebruiker."'";
    $resultuser = $mysqli->query($sqluser);
    $sqlemail = "SELECT email FROM tblgebruikers WHERE email='".$email."'";
    $resultemail = $mysqli->query($sqlemail);
    
    if ($resultuser->num_rows == 0 && $resultemail->num_rows == 0) {
        $sql = "INSERT INTO tblgebruikers (gebruikersnaam, wachtwoord, email, geld, admin) Values ('".$gebruiker."','".$wachtwoord."','".$email."', 0, 0)";
        $mysqli->query($sql);
        $_SESSION['id'] = $mysqli->insert_id;
        $_SESSION['type']="gebruiker";
        header("Location: ./index.php");
        exit();
    } else {
        echo "Gebruiker of email is al geregistreerd.";
    }
} else {
    echo "<form method='post' action='register.php'>
            <label for='gebruikersnaam'>Gebruikersnaam:</label><br>
            <input type='text' id='gebruikersnaam' name='gebruikersnaam'><br>
            <label for='email'>E-mail:</label><br>
            <input type='text' id='email' name='email'><br>
            <label for='wachtwoord'>Wachtwoord:</label><br>
            <input type='password' id='wachtwoord' name='wachtwoord'><br><br>
            <input type='submit' value='Registreer' name='register'>
        </form>";
}
?>
</body>
</html>