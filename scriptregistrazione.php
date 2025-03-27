<?php
session_start();
include 'connessione.php'; // File per la connessione al database

// Recupera i dati inviati dalla form
$username = $_POST["username"];
$password = $_POST["password"];
$nome = $_POST["nome"];
$cognome = $_POST["cognome"];
$email = $_POST["email"];

// Controlla se l'username o l'email esistono già nel database
$sql = "SELECT * FROM utente WHERE username = '$username' OR email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Username o email già esistenti
    $_SESSION["errore"] = "Username o email già in uso.";
    header("Location: errore_loginreg.php");
    exit();
} else {
    // Crittografia della password
    $passwordHash = hash("sha256", $password);

    // Inserisce il nuovo utente nel database
    $sqlInsert = "INSERT INTO utente (username, password, nome, cognome, email) 
                  VALUES ('$username', '$passwordHash', '$nome', '$cognome', '$email')";

    if ($conn->query($sqlInsert) === TRUE) {
        // Registrazione riuscita
        $_SESSION["username"] = $username; // Salva l'username nella sessione
        header("Location: benvenuto.php"); // Reindirizza alla pagina di benvenuto
        exit();
    } else {
        // Errore durante l'inserimento nel database
        $_SESSION["errore"] = "Errore durante la registrazione. Riprova.";
        header("Location: errore_loginreg.php");
        exit();
    }
}
?>