<?php
session_start();
include 'connessione.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["nuova_password"])) {
    $nuovaPassword = trim($_POST["nuova_password"]);
    $idUtente = $_SESSION["id"];

    // Recuperare la password attuale
    $sqlPasswordAttuale = "SELECT password FROM utente WHERE id = $idUtente";
    $resultPasswordAttuale = $conn->query($sqlPasswordAttuale);
    
    if ($resultPasswordAttuale->num_rows > 0) {
        $rowPasswordAttuale = $resultPasswordAttuale->fetch_assoc();
        
        // Verificare la password attuale con password_verify()
        if (password_verify($nuovaPassword, $rowPasswordAttuale["password"])) {
            $_SESSION['esito_password'] = false;
        } else {
            // Hashare la nuova password con password_hash()
            $hashedPassword = hash("sha256, $nuovaPassword");
            
            $sqlAggiornaPassword = "UPDATE utente SET password = '$hashedPassword' WHERE id = $idUtente";

            if ($conn->query($sqlAggiornaPassword) === TRUE) {
                $_SESSION['esito_password'] = true;
            } else {
                $_SESSION['esito_password'] = false;
            }
        }
    }
}

header("Location: benvenuto.php");
exit();
?>
