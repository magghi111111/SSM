<div class="card full">
    <table class="orders-table">
        <thead>
            <tr>
                <th>Codice</th>
                <th>Descrizione</th>
                <th>QR-Code (click per scaricare)</th>
                <th>Quantità</th>
                <th>Ultima Modifica</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($componenti as $componente): ?>
                <tr <?= $componente['tipo'] == 'ASSEMBLY' ? 'class="assembly_component"' : '' ?>>
                    <td><?= htmlspecialchars($componente['sku']); ?></td>
                    <td><?= htmlspecialchars($componente['nome']); ?></td>
                    <td><a  class="qr-download" download href="qr/<?= htmlspecialchars($componente['qrcode']); ?>.png"><?= htmlspecialchars($componente['qrcode']); ?></a></td>
                    <td><?= htmlspecialchars($componente['quantita']); ?> <?= htmlspecialchars($componente['unita_misura']); ?></td>
                    <td><?= htmlspecialchars($componente['ultima_modifica']); ?></td>
                </tr>

                <?php if ($componente['tipo'] == 'ASSEMBLY'): ?>
                    <tr class="assembly-details hidden">
                        <td colspan="4">
                            <table class="sub-table">
                                <thead>
                                    <tr>
                                        <th>SKU</th>
                                        <th>Componente</th>
                                        <th>Quantità Necessaria</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $parts = getPartiComponente($componente['id']);
                                    foreach ($parts as $p):
                                    ?>
                                        <tr>
                                            <td><?= htmlspecialchars($p['sku']); ?></td>
                                            <td><?= htmlspecialchars($p['nome']); ?></td>
                                            <td><?= htmlspecialchars($p['quantita']).' '.htmlspecialchars($p['unita_misura']); ?></td>     
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>