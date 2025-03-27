<?php
session_start();
include 'connessione.php';

    $username = $_POST["username"];
    $password = $_POST["password"];

    
    $sql = "SELECT * FROM utente WHERE username = '$username'";

    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Controllo della password
        if ($row["password"] === $password) {
            // Login riuscito
            $_SESSION["username"] = $row["username"];
            header("Location: benvenuto.php");
            exit();
        } else {
            // Password errata
            $_SESSION["errore"] = "Password errata.";
            header("Location: errore_loginreg.php");
            exit();
        }
    } else {
        // Username non esistente
        $_SESSION["errore"] = "Username non esistente.";
        header("Location: errore_loginreg.php");
        exit();
    }
?>