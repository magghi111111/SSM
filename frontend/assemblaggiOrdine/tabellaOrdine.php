<?php
function renderComponenteOrdine($componente, $livello = 0)
{ 
    $stockDisponibile = getStock($componente['id_componente']);
    $quantitaDaGenerare = $componente['quantita'];

    for ($i = 1; $i <= $quantitaDaGenerare; $i++) {

        // indice univoco per l'input QR
        $qrIndex = $i;
        ?>
        <tr class="assembly-node" data-component-id="<?= $componente['id_componente'] ?>" data-level="<?= $livello ?>">
            <td style="padding-left: <?= $livello * 20 ?>px;">
                <?= htmlspecialchars($componente['nome']) ?>
            </td>
            <td>1 <?= htmlspecialchars($componente['unita_misura']) ?></td>
            <td>
                <input type="text" name="componenti_finali[<?= $componente['id_componente'] ?>][<?= $qrIndex ?>]" 
                       class="<?= ($stockDisponibile > 0) ? 'component-qr qr-final' : '' ?>" 
                       data-componente-id="<?= $componente['id_componente'] ?>" 
                       value="<?= ($stockDisponibile > 0) ? '' : 'ASSEMBLY' ?>"
                       readonly
                       placeholder="Non scannerizzato">
            </td>
            <td>
                <span class="node-status <?= ($stockDisponibile > 0) ? 'ready' : 'pending' ?>">
                    <?= ($stockDisponibile > 0) ? 'Disponibile' : 'Da assemblare' ?>
                </span>
            </td>
        </tr>
        <?php

        if ($stockDisponibile <= 0) {
            // Renderizza subito i figli se non c'è stock
            $children = getPartiComponente($componente['id_componente']);
            foreach ($children as $child) {
                renderComponenteOrdine([
                    'id_componente' => $child['id'],
                    'nome' => $child['nome'],
                    'quantita' => $child['quantita'],
                    'unita_misura' => $child['unita_misura']
                ], $livello + 1);
            }
        } else {
            $stockDisponibile--; // decrementa lo stock usato
        }
    }
}
?>