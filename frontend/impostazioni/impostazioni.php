<?php 
require_once 'backend/query/utenti.php';

$ruoli = getRuoli();
$utenti = getAllUsers();

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
        <h2>Aggiungi nuovo ruolo</h2>
        <form class="user-form" method="post" action="backend/controller/newRoleCntrl.php">
            <div class="form-group full-width">
                <label>Nome Ruolo</label>
                <input type="text" name="ruolo" placeholder="Nome Ruolo" required>
            </div>
            <div class="form-group">
                <label>Permessi</label><br>
                <table>
                    <tr>
                        <th>Magazzino</th>
                        <th>Inserimenti</th>
                        <th>Ordini</th>
                        <th>Consegne</th>
                        <th>Assemblaggi</th>
                        <th>Movimenti</th>
                        <th>Andamenti</th>
                        <th>Impostazioni</th>
                    </tr>
                    <tr>
                        <td><input type="checkbox" name="permessi[]" value="magazzino"></td>
                        <td><input type="checkbox" name="permessi[]" value="inserimenti_nuovi"></td>
                        <td><input type="checkbox" name="permessi[]" value="ordini"></td>
                        <td><input type="checkbox" name="permessi[]" value="consegne"></td>
                        <td><input type="checkbox" name="permessi[]" value="assemblaggi"></td>
                        <td><input type="checkbox" name="permessi[]" value="movimenti"></td>
                        <td><input type="checkbox" name="permessi[]" value="andamenti"></td>
                        <td><input type="checkbox" name="permessi[]" value="impostazioni"></td>
                    </tr>
                </table>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    Aggiungi ruolo
                </button>
            </div>
        </form>
        <?php if (isset($_COOKIE['role_error'])): ?>
            <p class="form-message error auto-hide">
                <?= htmlspecialchars($_COOKIE['role_error']) ?>
            </p>
        <?php endif; ?>
        <?php if (isset($_COOKIE['role_success'])): ?>
            <p class="form-message success auto-hide">
                <?= htmlspecialchars($_COOKIE['role_success']) ?>
            </p>
        <?php endif; ?>
    </div>

    <div class="card user-create-card">
        <h2>Gestione Ruoli</h2>
        <table>
            <tr>
                <th>Ruolo</th>
                <th>Magazzino</th>
                <th>Inserimenti</th>
                <th>Ordini</th>
                <th>Consegne</th>
                <th>Assemblaggi</th>
                <th>Movimenti</th>
                <th>Andamenti</th>
                <th>Impostazioni</th>
                <th>Azioni</th>
            </tr>
            <?php foreach ($ruoli as $ruolo): ?>
                <tr>
                    <td><?= htmlspecialchars($ruolo['nome']) ?></td>
                    <td><?= $ruolo['magazzino'] ? '<i class="bi bi-check-lg"></i>' : '' ?></td>
                    <td><?= $ruolo['inserimenti_nuovi'] ? '<i class="bi bi-check-lg"></i>' : '' ?></td>
                    <td><?= $ruolo['ordini'] ? '<i class="bi bi-check-lg"></i>' : '' ?></td>
                    <td><?= $ruolo['consegne'] ? '<i class="bi bi-check-lg"></i>' : '' ?></td>
                    <td><?= $ruolo['assemblaggi'] ? '<i class="bi bi-check-lg"></i>' : '' ?></td>
                    <td><?= $ruolo['movimenti'] ? '<i class="bi bi-check-lg"></i>' : '' ?></td>
                    <td><?= $ruolo['andamenti'] ? '<i class="bi bi-check-lg"></i>' : '' ?></td>
                    <td><?= $ruolo['impostazioni'] ? '<i class="bi bi-check-lg"></i>' : '' ?></td>
                    <td><?= $ruolo['nome']=='ADMIN' ? '' : 'Modifica | Elimina' ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    
    <div class="card user-create-card">
        <h2>Gestione Utenti</h2>
        <table>
            <tr>
                <th>Email</th>
                <th>Ruolo</th>
                <th>Azioni</th>
            </tr>
            <?php foreach ($utenti as $utente): ?>
                <tr>
                    <td><?= htmlspecialchars($utente['email']) ?></td>
                    <td><?= htmlspecialchars($utente['ruolo']) ?></td>
                    <td><?= $utente['ruolo']=='ADMIN' ? '' : 'Modifica Ruolo | Elimina' ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</main>
<?php endif; ?>

<script>

document.addEventListener("DOMContentLoaded", function(){

    const magazzino = document.querySelector('input[value="magazzino"]');
    const inserimenti = document.querySelector('input[value="inserimenti_nuovi"]');
    const ordini = document.querySelector('input[value="ordini"]');
    const consegne = document.querySelector('input[value="consegne"]');
    const assemblaggi = document.querySelector('input[value="assemblaggi"]');

    inserimenti.addEventListener("change", function(){
        if(this.checked){
            magazzino.checked = true;
            consegne.checked = true;
        }
    });

    ordini.addEventListener("change", function(){
        if(this.checked){
            assemblaggi.checked = true;
        }
    });

});

</script>

