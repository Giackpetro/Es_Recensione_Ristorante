<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <title>Pannello Admin</title>
</head>

<body>
    <div class="container mt-4">
    <div class="d-flex justify-content-center gap-3">

        <!-- Div per inserire recensione -->
        <div class="login-div p-3">
            <h2>Inserisci un nuovo ristorante</h2>
            <form action="inserisciristorante.php" method="POST">
                <label for="nome">Registrazione Ristorante</label>
                <input type="text" id="nome" name="nome" placeholder="Nome" required>
                <input type="text" id="indirizzo" name="indirizzo" placeholder="Indirizzo" required>
                <input type="text" id="citta" name="citta" placeholder="Città" required>
                <input type="text" id="latitudine" name="latitudine" placeholder="Latitudine" value="43.7800127" required>
                <input type="text" id="longitudine" name="longitudine" placeholder="Longitudine" value="11.1997685" required>
                <button type="submit">Salva</button>
            </form>
            <a href="paginalogin.php" class="benvenuto-link">Logout</a>
        </div>
        <!-- Div per informazioni ristoranti -->
        <div class="login-div flex-grow-1 p-3 text-center">
            <h1>Ristoranti presenti</h1>
            <?php
            session_start();
            include 'connessione.php';

            if (!isset($_SESSION['username'])) {
                header("Location: paginalogin.php");
                exit();
            }

            $sqlRistoranti = "SELECT ri. *, COUNT(re.codiceristorante) AS numRec FROM ristorante ri LEFT JOIN recensione re ON ri.codice = re.codiceristorante GROUP BY ri.codice";
            $resultRistoranti = $conn->query($sqlRistoranti);

            if ($resultRistoranti->num_rows > 0) {
                echo "<div class='overflow-auto'> <!-- Mantiene layout pulito -->
                        <table class='table table-dark table-striped mx-auto'>
                        <tr>
                            <th>Codice Ristorante</th>
                            <th>Nome Ristorante</th>
                            <th>Indirizzo</th>
                            <th>Città</th>
                            <th>Numero recensioni</th>
                        </tr>";
                while ($rowRistorante = $resultRistoranti->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $rowRistorante["codice"] . "</td>
                            <td>" . $rowRistorante["nome"] . "</td>
                            <td>" . $rowRistorante["indirizzo"] . "</td>
                            <td>" . $rowRistorante["citta"] . "</td>
                            <td>" . $rowRistorante["numRec"] . "</td>
                          </tr>";
                }
                echo "</table></div>";
            } else {
                echo "<p class='text-warning'>Nessun ristorante presente.</p>";
            }
            ?>
        </div>

        
    </div>
</div>


    <footer class="social-table container-fluid fixed-bottom">
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
                <p>&copy; 2025 Ristoranti Chardi. Tutti i diritti riservati. È vietata la riproduzione, distribuzione o utilizzo non autorizzato dei contenuti di questa pagina.</p>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>