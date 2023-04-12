<?php
session_start();
?>
<!DOCTYPE html>
<html>
<body>
<?php
session_destroy();
print "<br> je bent uitgelogd.";
print "<br><a href='index.php'> terug naar webshop </a>";
?>
</body>
</html>