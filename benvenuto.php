<?php
session_start();
include 'connessione.php';

// controlla se l'utente è loggato
if (!isset($_SESSION['username'])) {
    // reindirizza alla pagina di login
    header("Location: paginalogin.html");
    exit();
}
echo ("Benvenuto " . $_SESSION["username"] . "<br>");

echo '<a href="scriptlogout.php">Logout</a>';
?>