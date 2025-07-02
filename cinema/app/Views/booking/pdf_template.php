<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Conferma di Prenotazione</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; } /* DejaVu Sans podržava UTF-8 znakove */
        .ticket-container { border: 2px dashed #333; padding: 20px; width: 100%; }
        h1 { text-align: center; color: #333; }
        h2 { border-bottom: 1px solid #ccc; padding-bottom: 5px; }
        .info-section p { margin: 5px 0; }
        .info-section strong { display: inline-block; width: 150px; }
    </style>
</head>
<body>

<div class="ticket-container">
    <h1>Conferma di Prenotazione</h1>
    <p style="text-align: center;">ID Pagamento: <?= esc($pagamento->id) ?></p>

    <?php if (isset($proiezione)): ?>
        <?php $contenuto = $proiezione->getFilm() ?? $proiezione->getSpettacolo(); ?>
        <div class="info-section">
            <h2>Dettagli Proiezione</h2>
            <p><strong>Contenuto:</strong> <?= esc($contenuto->titolo ?? 'N/D') ?></p>
            <p><strong>Data:</strong> <?= date('d.m.Y, l', strtotime($proiezione->data)) ?></p>
            <p><strong>Orario:</strong> <?= date('H:i', strtotime($proiezione->orario)) ?>h</p>
        </div>
    <?php endif; ?>

    <div class="info-section">
        <h2>Biglietti Acquistati</h2>
        <p><strong>Totale Pagato:</strong> <?= number_format($pagamento->importo, 2) ?> €</p>
        <ul>
            <?php foreach ($biglietti as $biglietto): ?>
                <li>Biglietto <?= esc($biglietto->tipo) ?> (<?= number_format($biglietto->prezzo, 2) ?> €)</li>
            <?php endforeach; ?>
        </ul>
    </div>

    <p style="text-align: center; margin-top: 30px;">Grazie per il tuo acquisto!</p>
</div>

</body>
</html>