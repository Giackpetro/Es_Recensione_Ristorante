<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <title>Benvenuto</title>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <!-- Div per informazioni utente -->
        <div class="col-md-5 benvenuto-div me-3">
            <?php
                session_start();
                include 'connessione.php';

                if (!isset($_SESSION['username'])) {
                    header("Location: paginalogin.php");
                    exit();
                }

                $sqlUtente = "SELECT * FROM utente WHERE username = '" . $_SESSION["username"] . "'";
                $resultUtente = $conn->query($sqlUtente);

                if ($resultUtente->num_rows > 0) {
                    $rowUtente = $resultUtente->fetch_assoc();
                    $nomeUtente = $rowUtente["nome"];
                    $idUtente = $rowUtente["id"];
                    echo "<h1 class='mb-4'>Benvenuto " . $nomeUtente . "</h1>";
                } else {
                    echo "<p class='text-danger'>Utente non trovato.</p>";
                    exit();
                }

                $sqlRecensioni = "SELECT ristorante.nome AS nomeRistorante, ristorante.indirizzo, recensione.voto, DATE_FORMAT(recensione.data, '%d/%m/%Y') AS dataRecensione 
                                FROM recensione
                                JOIN ristorante ON recensione.codiceristorante = ristorante.codice
                                WHERE recensione.idutente = $idUtente";
                $resultRecensioni = $conn->query($sqlRecensioni);

                $numRecensioni = $resultRecensioni->num_rows;
                echo "<p>Numero recensioni effettuate: <span class='badge bg-primary'>$numRecensioni</span></p>";

                if ($numRecensioni > 0) {
                    echo "<table class='table table-dark table-striped'>
                            <thead>
                                <tr>
                                    <th>Nome Ristorante</th>
                                    <th>Indirizzo</th>
                                    <th>Voto</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>";
                    while ($rowRecensione = $resultRecensioni->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $rowRecensione["nomeRistorante"] . "</td>
                                <td>" . $rowRecensione["indirizzo"] . "</td>
                                <td>" . $rowRecensione["voto"] . "</td>
                                <td>" . $rowRecensione["dataRecensione"] . "</td>
                              </tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<p class='text-warning'>Nessuna recensione effettuata.</p>";
                }

                if (isset($_SESSION['esito_recensione'])) {
                    if ($_SESSION['esito_recensione'] === true) {
                        echo "<p class='alert alert-success'>Recensione inserita con successo</p>";
                    } else {
                        echo "<p class='alert alert-danger'>Impossibile aggiungere la recensione</p>";
                    }
                    unset($_SESSION['esito_recensione']);
                }
            ?>
        </div>
        <!-- Div per inserire recensione -->
        <div class="col-md-5 benvenuto-form-div">
            <h2>Inserisci una nuova recensione</h2>
            <form action="inseriscirecensione.php" method="POST" class="form-recensione">
                <label for="ristorante" class="form-label">Seleziona un ristorante:</label>
                <select id="ristorante" name="ristorante" class="form-select" required>
                    <?php
                    $sqlRistoranti = "SELECT codice, nome FROM ristorante";
                    $resultRistoranti = $conn->query($sqlRistoranti);

                    if ($resultRistoranti->num_rows > 0) {
                        while ($rowRistorante = $resultRistoranti->fetch_assoc()) {
                            echo "<option value='" .$rowRistorante['codice'] . "'>" . $rowRistorante['nome'] . "</option>";
                        }
                    } else {
                        echo "<option disabled>Nessun ristorante disponibile</option>";
                    }
                    ?>
                </select>

                <label class="form-label">Seleziona il voto:</label>
                <div class="rating-container">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <input type="radio" id="voto<?= $i ?>" name="voto" class="rating-input" value="<?= $i ?>" required>
                        <label for="voto<?= $i ?>" class="rating-label"><?= $i ?><i class="bi bi-star"></i></label>
                    <?php endfor; ?>
                </div>
                <button type="submit" class="btn benvenuto-btn">Invia Recensione</button>
            </form>
            <a href="scriptlogout.php" class="benvenuto-link">Logout</a>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
