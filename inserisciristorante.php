<?php
session_start();
include 'connessione.php';

$nome = $_POST['nome'];
$indirizzo = $_POST['indirizzo'];
$citta = $_POST['citta'];
$latitudine = $_POST['latitudine'];
$longitudine = $_POST['longitudine'];


$sqlInsert = "INSERT INTO ristorante (nome, indirizzo, citta, latidune, longitudine) VALUES ('$nome', '$indirizzo', '$citta', '$latitudine', '$longitudine')";
    if ($conn->query($sqlInsert) === TRUE) {
        $_SESSION['esito_ristorante'] = true; 
    } else {
        $_SESSION['esito_ristorante'] = false; 
    }
header("Location: pannelloadmin.php");
exit();

?>