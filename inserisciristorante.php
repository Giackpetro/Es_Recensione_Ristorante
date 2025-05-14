<?php
session_start();
include 'connessione.php';

$nome = $_POST['nome'];
$indirizzo = $_POST['indirizzo'];
$citta = $_POST['citta'];


$sqlInsert = "INSERT INTO ristorante (nome, indirizzo, citta) VALUES ('$nome', '$indirizzo', '$citta')";
    if ($conn->query($sqlInsert) === TRUE) {
        $_SESSION['esito_ristorante'] = true; 
    } else {
        $_SESSION['esito_ristorante'] = false; 
    }
header("Location: pannelloadmin.php");
exit();

?>