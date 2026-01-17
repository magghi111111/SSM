<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - PWA</title>
    <link rel="stylesheet" href="frontend/login/login.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="frontend/login/login.js"></script>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form method="post" action="" id="loginForm">
            
            <input type="text" id="username" name="username" placeholder="Username" required />
            <input type="password" id="password" name="password" placeholder="Password" required />

            <button type="submit">Accedi</button>
        </form>
        <p id="errorMsg" class="error" style="display:none;">Credenziali errate</p>
    </div>
    
</body>
</html>

<?php

if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];    
    $password = $_POST['password'];
    $_SESSION['user'] = $username;
    header('Location: index.php?page=dashboard');
}

?>