<?php
session_start();
include 'connessione.php';

$username = $_POST["username"];
$password = $_POST["password"];
$nome = $_POST["nome"];
$cognome = $_POST["cognome"];
$email = $_POST["email"];

//controllo se l'username esiste già nel database
$sqlUsername = "SELECT * FROM utente WHERE username = '$username'";
$resultUsername = $conn->query($sqlUsername);

if ($resultUsername->num_rows > 0) {
    //username già esistente
    $_SESSION["errore"] = "Username già in uso.";
    header("Location: paginaregistrazione.php");
    exit();
} 

//controllo se l'email esiste già nel database
$sqlEmail = "SELECT * FROM utente WHERE email = '$email'";
$resultEmail = $conn->query($sqlEmail);

if ($resultEmail->num_rows > 0) {
    //email già esistente
    $_SESSION["errore"] = "Email già in uso.";
    header("Location: paginaregistrazione.php");
    exit();
}

//crittografia della password
$passwordHash = hash("sha256", $password);

//inserisco il nuovo utente nel database

    if (isset($_POST["admin"])) {
        $isadmin = 1;
    } else{
        $isadmin = 0;
    }
    $sqlInsert = "INSERT INTO utente (username, password, nome, cognome, email, isadmin) VALUES ('$username', '$passwordHash', '$nome', '$cognome', '$email', '$isadmin')";
    if ($conn->query($sqlInsert) === TRUE) {
    
    //registrazione effettuata
    $_SESSION["username"] = $username; 
    if($isadmin == 1){
        header("Location: pannelloadmin.php");
    }else{
        header("Location: benvenuto.php");
    }
    exit();
} else {
    //errore durante l'inserimento nel database
    $_SESSION["errore"] = "Errore durante la registrazione. Riprova.";
    header("Location: paginaregistrazione.php");
    exit();
}

?>