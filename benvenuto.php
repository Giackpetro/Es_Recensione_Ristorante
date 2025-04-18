<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
session_start();
include 'connessione.php';

// controlla se l'utente è loggato
if (!isset($_SESSION['username'])) {
    // reindirizza alla pagina di login
    header("Location: paginalogin.php");
    exit();
}
echo ("Benvenuto " . $_SESSION["username"] . "<br>");


$sql = "SELECT * FROM utente WHERE username = '" . $_SESSION["username"]. "'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row["username"];
    $nome = $row["nome"];
    $cognome = $row["cognome"];
    $email = $row["email"];
    $datareg = $row["dataregistrazione"];
}

?>
    <ul>
        <li><?php echo($_SESSION["username"]); ?></li>
        <li><?php echo($nome); ?></li>
        <li><?php echo($cognome); ?></li>
        <li><?php echo($email); ?></li>
        <li><?php echo($datareg); ?></li>
    </ul> 
<a href="scriptlogout.php">Logout</a>
</body>
</html>