<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
    <title>Info Ristorante</title>
</head>
<body class="info_ristorante" onload="myMap()">

<div class="contenitore">
    <div class="info_box">
        <h1>Info Ristorante</h1>
        <?php
            session_start();
            include 'connessione.php';

            $codice = $_POST['codice'];

            $sql = "SELECT * FROM ristorante WHERE codice = '$codice'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<ul class='info_list'>";
                    echo "<li><strong>Nome:</strong> " . $row['nome'] . "</li>";
                    echo "<li><strong>Indirizzo:</strong> " . $row['indirizzo'] . "</li>";
                    echo "<li><strong>Città:</strong> " . $row['citta'] . "</li>";
                    echo "<li><strong>Latitudine:</strong> " . $row['latitudine'] . "</li>";
                    echo "<li><strong>Longitudine:</strong> " . $row['longitudine'] . "</li>";
                echo "</ul>";
            }
        ?>
    </div>

    <div class="recensioni_box">
        <h1>Recensioni del ristorante</h1>
        <?php
            $sqlRecensioni = "SELECT utente.nome AS nomeUtente, recensione.voto, DATE_FORMAT(recensione.data, '%d/%m/%Y') AS dataRecensione
                              FROM recensione
                              JOIN utente ON recensione.idutente = utente.id
                              WHERE recensione.codiceristorante = '$codice'";

            $resultRecensioni = $conn->query($sqlRecensioni);

            if ($resultRecensioni->num_rows > 0) {
                echo "<table class='table table-dark table-striped'>
                        <tr>
                            <th>Nome Utente</th>
                            <th>Voto</th>
                            <th>Data</th>
                        </tr>";
                while ($rowRecensione = $resultRecensioni->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $rowRecensione["nomeUtente"] . "</td>
                            <td>" . $rowRecensione["voto"] . "</td>
                            <td>" . $rowRecensione["dataRecensione"] . "</td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p class='text-warning'>Nessuna recensione effettuata.</p>";
            }
        ?>
    </div>
</div>

<div id="map"></div>

<script>
    function myMap() {
        var map = L.map('map').setView([<?php echo $row['latitudine']; ?>, <?php echo $row['longitudine']; ?>], 20);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = L.marker([<?php echo $row['latitudine']; ?>, <?php echo $row['longitudine']; ?>]).addTo(map);
    }
</script>

<br>
<div class="back_link">
    <a href="benvenuto.php">Torna indietro</a>
</div>

</body>
</html>
