<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - PWA</title>
    <link rel="stylesheet" href="frontend/login/login.css">
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <form method="post" action="backend/controller/loginCntrl.php" id="loginForm">

            <input type="text" id="login_user" name="login_user" placeholder="Username" required />
            <input type="password" id="login_pass" name="login_pass" placeholder="Password" required />
            <?php
            if (isset($_GET['message']) && $_GET['message'] === 'invalid_credentials') {
                echo '<p style="color:red;">Credenziali non valide. Riprova.</p>';
            }
            ?>
            <button type="submit">Accedi</button>
        </form>

    </div>

</body>

</html>
