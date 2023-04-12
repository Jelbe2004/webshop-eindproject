<?php
session_start();
include "connect.php"
?>
<html>
<head>
    <title>Inloggen</title>
</head>
<body>
<h1>Inloggen</h1>
<?php
 print "<form method='post' action='controleren.php'>
 username <input type='text' name='gebruikersnaam' placeholder='Username'><br>
 password <input type='text' name='wachtwoord' placeholder='Password'><br>
 <input type='submit' value='Log in'></form>";
?>
</body>
</html>