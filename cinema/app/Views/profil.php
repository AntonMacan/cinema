<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Il Mio Profilo - I Miei Biglietti</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f4f4; }
        .container { max-width: 900px; margin: 30px auto; padding: 20px; background-color: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1, h2 { color: #333; }
        .ticket { border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; }
        .ticket-header h3 { margin: 0; }
        .ticket-details { margin-top: 10px; }
    </style>
</head>
<body>

<div class="container">
    <a href="/dashboard">&laquo; Torna alla Dashboard</a>
    <h1>Il Mio Profilo</h1>
    <h2>I Miei Biglietti Acquistati</h2>

    <?php if (!empty($biglietti)): ?>
        <?php foreach ($biglietti as $biglietto): ?>

            <div class="ticket">
                <?php 
                    // Dohvaćamo projekciju povezanu s ovom kartom
                    $proiezione = $biglietto->getProiezione(); 

                    // Dohvaćamo sadržaj (film ili predstavu)
                    $contenuto = null;
                    if ($proiezione) {
                        $contenuto = $proiezione->getFilm() ?? $proiezione->spettacolo;
                    }
                ?>
                <div class="ticket-header">
                    <h3><?= esc($contenuto->titolo ?? 'Contenuto Sconosciuto') ?></h3>
                </div>
                <div class="ticket-details">
                    <strong>Data:</strong> <?= $proiezione ? date('d.m.Y', strtotime($proiezione->data)) : 'N/D' ?><br>
                    <strong>Orario:</strong> <?= $proiezione ? date('H:i', strtotime($proiezione->orario)) : 'N/D' ?>h<br>
                    <strong>Tipo Biglietto:</strong> <?= esc($biglietto->tipo) ?><br>
                    <strong>Prezzo:</strong> <?= number_format($biglietto->prezzo, 2) ?> €<br>
                    <strong>Acquistato il:</strong> <?= date('d.m.Y H:i', strtotime($biglietto->created_at)) ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Non hai ancora acquistato nessun biglietto.</p>
    <?php endif; ?>
</div>

</body>
</html>