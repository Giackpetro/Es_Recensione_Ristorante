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
    if ($rowUtente["isAdmin"] == 1) {
        header("Location: pannelloadmin.php");
        exit();
    }
    $nomeUtente = $rowUtente["nome"];
    $idUtente = $rowUtente["id"];
    $_SESSION['id'] = $idUtente;
} else {
    echo "<p class='text-danger'>Utente non trovato.</p>";
    exit();
}
?>

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
            <h1 class='mb-4'>Benvenuto <?php echo $nomeUtente; ?></h1>

            <?php
            $sqlRecensioni = "SELECT ristorante.nome AS nomeRistorante, ristorante.indirizzo, recensione.codiceristorante, recensione.voto, 
                              DATE_FORMAT(recensione.data, '%d/%m/%Y') AS dataRecensione 
                              FROM recensione
                              JOIN ristorante ON recensione.codiceristorante = ristorante.codice
                              WHERE recensione.idutente = $idUtente";
            $resultRecensioni = $conn->query($sqlRecensioni);
            $numRecensioni = $resultRecensioni->num_rows;
            echo "<p>Numero recensioni effettuate: <span class='badge bg-primary'>$numRecensioni</span></p>";
            ?>

            <form action="elimina_recensioni.php" method="POST" id="formElimina">
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>Seleziona</th>
                            <th>Nome Ristorante</th>
                            <th>Indirizzo</th>
                            <th>Voto</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($rowRecensione = $resultRecensioni->fetch_assoc()) {
                            echo "<tr>
                                    <td><input type='checkbox' name='recensioni[]' value='" . $rowRecensione["codiceristorante"] . "' class='recensione-checkbox'></td>
                                    <td>" . $rowRecensione["nomeRistorante"] . "</td>
                                    <td>" . $rowRecensione["indirizzo"] . "</td>
                                    <td>" . $rowRecensione["voto"] . "</td>
                                    <td>" . $rowRecensione["dataRecensione"] . "</td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <button type="submit" id="btnElimina" class="btn btn-danger" disabled>Elimina</button>
            </form>

            <?php
            if (isset($_SESSION['recensioni_eliminate'])) {
                echo "<p class='alert alert-success'>" . $_SESSION['recensioni_eliminate'] . " recensioni eliminate con successo.</p>";
                unset($_SESSION['recensioni_eliminate']);
            }
            ?>

            <!-- Sezione per ottenere info del ristorante -->
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
                <button type="submit" class="btn btn-info mt-2">Info Ristorante</button>
            </form>

        </div>

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
                        <label for="voto<?= $i ?>"> <?= $i ?> <i class="bi bi-star"></i></label>
                    <?php endfor; ?>
                </div>
                <button type="submit">Invia Recensione</button>
            </form>
            <a href="paginalogin.php" class="benvenuto-link">Logout</a>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let checkboxes = document.querySelectorAll(".recensione-checkbox");
    let btnElimina = document.getElementById("btnElimina");

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", function() {
            btnElimina.disabled = !document.querySelector(".recensione-checkbox:checked");
        });
    });
});
</script>

</body>
</html>
