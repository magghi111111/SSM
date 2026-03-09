<?php 
require_once 'backend/query/utenti.php';

$ruoli = getRuoli();

if ($_SESSION['role'] === 'ADMIN'): 
?>
<main class="main">
    <div class="card user-create-card">
        <h2>Aggiungi nuovo utente</h2>
        <form class="user-form" method="post" action="backend/controller/signUpCntrl.php">
            <div class="form-group full-width">
                <label>Email</label>
                <input type="email" name="signup_email" placeholder="utente@email.com" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="signup_pass" placeholder="Password" required>
            </div>
            <div class="form-group">
                <label>Conferma password</label>
                <input type="password" name="signup_pass_confirm" placeholder="Conferma password" required>
            </div>
            <div class='form-group'>
            <label>Ruolo</label>
            <select name="ruolo">
                <option value="" disabled selected>Seleziona Ruolo</option>
                <?php foreach ($ruoli as $ruolo): ?>
                    <option value="<?= htmlspecialchars($ruolo['id']) ?>">
                        <?= htmlspecialchars($ruolo['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    Aggiungi utente
                </button>
            </div>
            
        </form>
        <?php if (isset($_COOKIE['signup_error'])): ?>
            <p class="form-message error auto-hide">
                <?= htmlspecialchars($_COOKIE['signup_error']) ?>
            </p>
        <?php endif; ?>
        <?php if (isset($_COOKIE['signup_success'])): ?>
            <p class="form-message success auto-hide">
                <?= htmlspecialchars($_COOKIE['signup_success']) ?>
            </p>
        <?php endif; ?>
    </div>

    <div class="card user-create-card">
        <h2>Gestione utenti</h2>
    <div>

</main>
<?php endif; ?>

