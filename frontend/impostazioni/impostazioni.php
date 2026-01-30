<?php  if($_SESSION['role'] == 'ADMIN'): ?>
<main class="main">
    <h1>Aggiungi Nuovo Utente</h1>
    <form method="post" action="backend/controller/signUpCntrl.php">
        <input type="text" name="signup_email" placeholder="Email" required>
        <input type="password" name="signup_pass" placeholder="Password" required>
        <input type="password" name="signup_pass_confirm" placeholder="Conferma Password" required>
        <input type="submit" value="Aggiungi Utente">
    </form>
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo '<p style="color: green;">' . $_SESSION['success'] . '</p>';
        unset($_SESSION['success']);
    }
    ?>
</main>
<?php endif; ?>
