<?php
session_start();
include 'connessione.php';

echo ("Benvenuto " . $_SESSION["username"]);


?>