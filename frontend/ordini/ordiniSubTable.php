<?php function righeOrdini($id){     ?>

<tr class="assembly-details hidden">
    <td colspan="100%">
        <table class="sub-table">
            <thead>
                <tr>
                    <th>Componente</th>
                    <th>Quantità</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $righe = getDettagliOrdine($id);
                foreach ($righe as $r):
                ?>
                    <tr>
                        <td><?= htmlspecialchars($r['nome']); ?></td>
                        <td><?= htmlspecialchars($r['quantita']) . ' ' . htmlspecialchars($r['unita_misura']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </td>
</tr>

<?php } ?>