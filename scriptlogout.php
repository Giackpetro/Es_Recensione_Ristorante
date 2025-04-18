<?php
session_start();

// elimina tutte le variabili di sessione
session_unset();
session_destroy();

echo "Logout effettuato.<br>";
echo '<a href="paginalogin.php">Torna alla pagina di login</a>';

?>