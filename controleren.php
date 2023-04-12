<?php
session_start();
include "connect.php";
$sql="SELECT * FROM tblgebruikers WHERE gebruikersnaam = '".$_POST['gebruikersnaam']."' AND wachtwoord = '".$_POST['wachtwoord']."'";
$resultaat=$mysqli->query($sql);
if ($mysqli->query($sql)){
  $row_cnt = mysqli_num_rows($resultaat);
  print $row_cnt;
 if ($row_cnt==1){
  print "2";
  	$row=$resultaat->fetch_assoc();
    if ($row['admin']==1){
      $_SESSION['type']=$row['admin'];
      $_SESSION['id']=$row['ID'];
    }
    else{
  	$_SESSION['type']="gebruiker";
    $_SESSION['id']=$row['ID'];
    }
  	header ('location: index.php');
  }
}
else{
    print "Error record wijzigen:" . $mysqli->error;
}
$mysqli->close();
?>