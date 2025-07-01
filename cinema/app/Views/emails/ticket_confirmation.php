<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Conferma di Prenotazione</title>
</head>
<body style="font-family: sans-serif;">
    <h1>Grazie per il tuo acquisto!</h1>
    <p>Ciao <?= esc(session()->get('nome')) ?>, la tua prenotazione è stata confermata con successo.</p>
    <p>In allegato trovi la conferma in formato PDF.</p>

    <?php $contenuto = $proiezione->getFilm() ?? $proiezione->spettacolo; ?>
    <h2>Dettagli della Proiezione:</h2>
    <ul>
        <li><strong>Contenuto:</strong> <?= esc($contenuto->titolo) ?></li>
        <li><strong>Data:</strong> <?= date('d.m.Y', strtotime($proiezione->data)) ?></li>
        <li><strong>Orario:</strong> <?= date('H:i', strtotime($proiezione->orario)) ?>h</li>
    </ul>

    <h2>Biglietti Acquistati (Totale: <?= number_format($pagamento->importo, 2) ?> €):</h2>
    <ul>
        <?php foreach ($biglietti as $biglietto): ?>
            <li>Biglietto <?= esc($biglietto->tipo) ?> (<?= number_format($biglietto->prezzo, 2) ?> €)</li>
        <?php endforeach; ?>
    </ul>
</body>
</html>