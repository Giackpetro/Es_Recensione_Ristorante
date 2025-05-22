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
        <div class="col-md-5 benvenuto-div">
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
                    if ($rowUtente["isAdmin"] == 1) {   //controllo se l'utente è un amministratore
                        header("Location: pannelloadmin.php");
                        exit();
                    }
                    $nomeUtente = $rowUtente["nome"];
                    $idUtente = $rowUtente["id"];
                    $_SESSION['id'] = $idUtente;
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

                <form action="info_ristorante.php" method="POST" class="form-recensione">
                <label for="codice" class="form-label">Seleziona un ristorante per vedere le sue informazioni:</label>
                <select id="codice" name="codice" class="form-select" required>
                    <?php
                    $sqlRistoranti = "SELECT codice, nome FROM ristorante ORDER BY nome";
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
                <button type="submit">Info Ristorante</button>
            </form>
        </div>
        <!-- Div per inserire recensione -->
        <div class="col-md-5 benvenuto-div benvenuto-div-left">
            <h2>Inserisci una nuova recensione</h2>
            <form action="inseriscirecensione.php" method="POST" class="form-recensione">
                <label for="ristorante" class="form-label">Seleziona un ristorante:</label>
                <select id="ristorante" name="ristorante" class="form-select" required>
                    <?php
                    $sqlRistoranti = "SELECT codice, nome FROM ristorante WHERE codice NOT IN (SELECT codiceristorante FROM recensione WHERE idutente = $idUtente)";
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
                <br>
                <label>Seleziona il voto:</label>
                <div>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <input type="radio" id="voto<?= $i ?>" name="voto" value="<?= $i ?>" required>
                        <label for="voto<?= $i ?>"> <?php echo$i ?> <i class="bi bi-star"></i></label>
                    <?php endfor; ?>
                </div>
                <button type="submit">Invia Recensione</button>
            </form>
            <a href="paginalogin.php" class="benvenuto-link">Logout</a>
        </div>
    </div>
</div>

<div class="social-table container-fluid">
        <div class="row text-center py-3">
            <div class="col">
                <a href="https://www.instagram.com" target="_blank">
                    <i class="bi bi-instagram fs-2"></i>
                    <p>Instagram</p>
                </a>
            </div>
            <div class="col">
                <a href="https://www.facebook.com" target="_blank">
                    <i class="bi bi-facebook fs-2"></i>
                    <p>Facebook</p>
                </a>
            </div>
            <div class="col">
                <a href="https://www.tiktok.com" target="_blank">
                    <i class="bi bi-tiktok fs-2"></i>
                    <p>TikTok</p>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col text-center">
                <p>&copy; 2025 Ristorante Ciardo. Tutti i diritti riservati. È vietata la riproduzione, distribuzione o utilizzo non autorizzato dei contenuti di questa pagina.</p>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>