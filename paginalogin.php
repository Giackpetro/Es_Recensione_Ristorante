<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
    <?php 
    session_start();
    ?>
    <div class="login-div">
        <h1>Login</h1>
        <form action="scriptlogin.php" method="post">
        <input type="text" id="username" name="username" placeholder="Username" required>
            <?php if (isset($_SESSION['errore']["erroreUsername"])) {
                echo "<p class='errore'>" . $_SESSION['errore']["erroreUsername"] . "</p>";
            } ?>
            <input type="text" id="password" name="password" placeholder="Password" required>
            <?php if (isset($_SESSION['errore']["errorePassword"])) {
                echo "<p class='errore'>" . $_SESSION['errore']["errorePassword"] . "</p>";
            } ?>
            <button type="submit">Login</button>
            <a href="./paginaregistrazione.php">Non hai un account? Registrati qui!</a>
        </form>
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