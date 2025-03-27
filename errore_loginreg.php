<?php
session_start();
include 'connessione.php';

echo ("errore: " . $_SESSION["errore"] . "<br>");

echo("<a href='./paginalogin.html'>Torna al login</a>");
?>
