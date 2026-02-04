<head>
    <meta charset="UTF-8" />
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0" /> -->
    <title>Login - PWA</title>
    <link rel="stylesheet" href="frontend/login/login.css">
</head>
<body>
    <div class="login-wrapper">
        <div class="index-login-login">
            <h4>Login to your account</h4>
            <small id="errore" class="error-msg"></small>
            <form class="login-form" method="post" action="backend/controller/loginCntrl.php">
                <div class="input-group">
                    <input type="text" id="login_user" name="login_user" placeholder="Username" required />
                </div>
                <div class="input-group">
                    <input type="password" id="login_pass" name="login_pass" placeholder="Password" required />
                </div>
                <?php
                if (isset($_GET['message']) && $_GET['message'] === 'invalid_credentials') {
                    echo '<p class="error-msg">Credenziali non valide. Riprova.</p>';
                }
                ?>
                <button type="submit" name="submit">LOGIN</button>
            </form>
        </div>
    </div>
</body>