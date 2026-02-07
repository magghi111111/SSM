<?php function righeConsegna($id){     ?>

<tr class="assembly-details hidden">
    <td colspan="100%">
        <table class="sub-table">
            <thead>
                <tr>
                    <th>Componente</th>
                    <th>Quantità Ricevuta</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $righe = getDettagliConsegna(   $id);
                foreach ($righe as $r):
                ?>
                    <tr>
                        <td><?= htmlspecialchars($r['nome']); ?></td>
                        <td><?= htmlspecialchars($r['qta_ricevuta']) . ' ' . htmlspecialchars($r['unita_misura']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </td>
</tr>

<?php } ?>