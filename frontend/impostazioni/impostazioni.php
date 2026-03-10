<?php 
require_once 'backend/query/utenti.php';

$ruoli = getRuoli();
$utenti = getAllUsers();

if ($_SESSION['role'] === 'ADMIN'): 
?>
<main class="main settings-page">
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
            <select name="ruolo" required>
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
        <?php if (isset($_COOKIE['edit_role_error'])): ?>
            <p class="form-message error auto-hide">
                <?= htmlspecialchars($_COOKIE['edit_role_error']) ?>
            </p>
        <?php endif; ?>
        <?php if (isset($_COOKIE['delete_role_error'])): ?>
            <p class="form-message error auto-hide">
                <?= htmlspecialchars($_COOKIE['delete_role_error']) ?>
            </p>
        <?php endif; ?>
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
                    <td><?= $ruolo['nome']=='ADMIN' ? '' : '<i data-id='.$ruolo['id'].' style="color: blue;" class="bi bi-pencil"></i> | <a style="color: red;" href=backend/controller/deleteRole.php?delete_id='.$ruolo['id'].'><i class="bi bi-trash"></i></a> ' ?></td>
                </tr>
                <?php if($ruolo['nome'] == 'ADMIN') continue; ?>
                <form class="role-edit-form" action="backend/controller/editRole.php" method="post">
                <input type="hidden" name="id_ruolo" value="<?= $ruolo['id'] ?>">
                <tr class="hidden" id="<?= $ruolo['id'] ?>">
                    <td></td>
                    <td><input type="checkbox" name="permessi[]" value="magazzino" <?= $ruolo['magazzino'] ? 'checked' : '' ?>></td>
                    <td><input type="checkbox" name="permessi[]" value="inserimenti_nuovi" <?= $ruolo['inserimenti_nuovi'] ? 'checked' : '' ?>></td>
                    <td><input type="checkbox" name="permessi[]" value="ordini" <?= $ruolo['ordini'] ? 'checked' : '' ?>></td>
                    <td><input type="checkbox" name="permessi[]" value="consegne" <?= $ruolo['consegne'] ? 'checked' : '' ?>></td>
                    <td><input type="checkbox" name="permessi[]" value="assemblaggi" <?= $ruolo['assemblaggi'] ? 'checked' : '' ?>></td>
                    <td><input type="checkbox" name="permessi[]" value="movimenti" <?= $ruolo['movimenti'] ? 'checked' : '' ?>></td>
                    <td><input type="checkbox" name="permessi[]" value="andamenti" <?= $ruolo['andamenti'] ? 'checked' : '' ?>></td>
                    <td><input type="checkbox" name="permessi[]" value="impostazioni" <?= $ruolo['impostazioni'] ? 'checked' : '' ?>></td>
                    <td><button type="submit" class="btn-primary">Modifica</button></td>
                </tr>
                </form>
            <?php endforeach; ?>
        </table>
    </div>
    
    <div class="card user-create-card">
        <h2>Gestione Utenti</h2>
        <?php if (isset($_COOKIE['edit_user_error'])): ?>
            <p class="form-message error auto-hide">
                <?= htmlspecialchars($_COOKIE['edit_user_error']) ?>
            </p>
        <?php endif; ?>
        <?php if (isset($_COOKIE['delete_user_error'])): ?>
            <p class="form-message error auto-hide">
                <?= htmlspecialchars($_COOKIE['delete_user_error']) ?>
            </p>
        <?php endif; ?>
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
                    <td><?= $utente['ruolo']=='ADMIN' ? '' : '<i data-id="'.$utente['id'].'" style="color: blue;" class="bi bi-pencil"></i> | <a style="color: red;" href=backend/controller/deleteUser.php?delete_id='.$utente['id'].'><i class="bi bi-trash"></i></a> '  ?></td>
                </tr>
                <?php if($utente['ruolo'] == 'ADMIN') continue; ?>
                <form class="user-edit-form" action="backend/controller/editUser.php" method="post">
                <input type="hidden" name="id_user" value="<?= $utente['id'] ?>">
                <tr class="hidden" id="<?= $utente['id'] ?>">
                    <td><input type="email" name="email" value="<?= htmlspecialchars($utente['email']) ?>" required></td>
                    <td>
                        <select name="ruolo" required>
                            <?php foreach ($ruoli as $ruolo): if ($ruolo['nome'] !== 'ADMIN'): ?>
                                <option value="<?= htmlspecialchars($ruolo['id']) ?>" <?= $ruolo['nome'] === $utente['ruolo'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($ruolo['nome']) ?>
                                </option>
                            <?php endif; endforeach; ?>
                        </select>
                    </td>
                    <td><button type="submit" class="btn-primary">Modifica</button></td>
                </tr>
                </form>
            <?php endforeach; ?>
        </table>
    </div>

</main>
<?php endif; ?>

<script>

document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener("change", function (e) {
        if (e.target.type !== "checkbox") return;
        const checkbox = e.target;
        const row = checkbox.closest("tr");
        if (!row) return;

        const magazzino = row.querySelector('input[value="magazzino"]');
        const inserimenti = row.querySelector('input[value="inserimenti_nuovi"]');
        const ordini = row.querySelector('input[value="ordini"]');
        const consegne = row.querySelector('input[value="consegne"]');
        const assemblaggi = row.querySelector('input[value="assemblaggi"]');

        if (checkbox.value === "inserimenti_nuovi" && checkbox.checked) {
            if (magazzino) magazzino.checked = true;
            if (consegne) consegne.checked = true;
        }

        if (checkbox.value === "ordini" && checkbox.checked) {
            if (assemblaggi) assemblaggi.checked = true;
        }

    });

});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".bi-pencil").forEach(function(icon){
        icon.addEventListener("click", function(){
            const id = this.dataset.id;
            console.log(id);
            const row = document.getElementById(id);

            if(!row) return;

            row.classList.toggle("hidden");

        });

    });

});

</script>

