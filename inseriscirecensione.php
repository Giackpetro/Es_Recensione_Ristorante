<?php
session_start();
include 'connessione.php';

$idUtente = $_SESSION['id'];
$codiceRistorante = $_POST['ristorante'];
$voto = $_POST['voto'];


$sql = "SELECT * FROM recensione WHERE idutente = $idUtente AND codiceristorante = '$codiceRistorante'";

$result = $conn->query($sql);
if (!$result) {
    die('Invalid query: ' . mysqli_error($conn));
}

if ($result->num_rows > 0) {
    $_SESSION['esito_recensione'] = false;
} else {
    $sqlInsert = "INSERT INTO recensione (voto, data, idutente, codiceristorante) VALUES ($voto, NOW(), $idUtente, '$codiceRistorante')";
    if ($conn->query($sqlInsert) === TRUE) {
        $_SESSION['esito_recensione'] = true; 
    } else {
        $_SESSION['esito_recensione'] = false; 
    }
}
header("Location: benvenuto.php");
exit();

?>