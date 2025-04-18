<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <title>Registrazione</title>
</head>
<body>
    <div class="reg-div">
    <h2>Registrazione Utente</h2>
    <form action="scriptregistrazione.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        
        <label for="cognome">Cognome:</label>
        <input type="text" id="cognome" name="cognome" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <button type="submit">Registrati</button>
    </form>
</div>


<!-- <div class="social-table container-fluid">
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
</div> -->


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>