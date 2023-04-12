<?php
session_start();
include "connect.php";
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $gebruiker_id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM gebruikers WHERE id = ?");

    $stmt->bind_param("i", $gebruiker_id);

    if ($stmt->execute()) {
        echo "Gebruiker succesvol verwijderd";
    } else {
        echo "Fout bij verwijderen van de gebruiker, probeer opnieuw.";
    }
}
?>