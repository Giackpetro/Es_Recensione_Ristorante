<?php

session_start();
foreach ($_SESSION["errore"] as $key => $value) {
    unset($_SESSION["errore"][$key]);
}
include 'connessione.php';

    $username = $_POST["username"];
    $password = $_POST["password"];

    
    $sql = "SELECT * FROM utente WHERE username = '$username'";

    $result = $conn->query($sql);
    
    //crittografia della password
    $passwordHashata = hash("sha256", $password);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Controllo della password 
        if ($row["password"] === substr($passwordHashata, 0, 60)) {    //MODIFICARE PASSWORD SUL DB PER METTERLE CON 64 CARATTERI
            // Login riuscito
            $_SESSION["username"] = $row["username"];
            header("Location: benvenuto.php");
            exit();
        } else {
            // Password errata
            $_SESSION["errore"]["errorePassword"] = "Password errata.";
            header("Location: paginalogin.php");
            exit();
        }
    } else {$_SESSION["errore"]["erroreUsername"] = "Username non esistente.";
        header("Location: paginalogin.php");
        exit();
    }
?>