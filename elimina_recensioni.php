<?php
session_start();
include 'connessione.php';

if (isset($_POST['recensioni']) && !empty($_POST['recensioni'])) {
    $recensioniDaEliminare = implode(",", $_POST['recensioni']);

    $sqlElimina = "DELETE FROM recensione WHERE codiceristorante IN ($recensioniDaEliminare) AND idutente = " . $_SESSION['id'];

    if ($conn->query($sqlElimina) === TRUE) {
        $_SESSION['recensioni_eliminate'] = count($_POST['recensioni']);
    } else {
        $_SESSION['recensioni_eliminate'] = 0;
    }
}

header("Location: benvenuto.php");
exit();
?>
