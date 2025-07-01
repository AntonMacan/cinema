<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Prenotazione Biglietti</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f4f4; }
        .container { max-width: 700px; margin: 30px auto; padding: 20px; background-color: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1, h2, h3 { color: #333; }
        .proiezione-info { background-color: #eee; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center; }
        label { font-size: 1.1em; }
        input[type="number"] { width: 80px; padding: 5px; }
        button { padding: 10px 20px; font-size: 1.1em; background-color: #28a745; color: white; border: none; cursor: pointer; border-radius: 5px; }
    </style>
</head>
<body>

<div class="container">
    <a href="/">&laquo; Torna al repertorio</a>

    <h1>Prenotazione Biglietti</h1>

    <div class="proiezione-info">
        <?php
            $contenuto = $proiezione->getFilm() ?? $proiezione->spettacolo;
        ?>
        <h3>Stai prenotando per: <?= esc($contenuto->titolo ?? 'N/D') ?></h3>
        <p>
            <strong>Data:</strong> <?= date('d.m.Y, l', strtotime($proiezione->data)) ?>
            <br>
            <strong>Orario:</strong> <?= date('H:i', strtotime($proiezione->orario)) ?>h
        </p>
    </div>

    <form action="/booking/process" method="post">
         <?= csrf_field() ?>
         <input type="hidden" name="proiezione_id" value="<?= $proiezione->id ?>">

         <h2>Seleziona i Biglietti</h2>

         <?php foreach ($tipi_biglietti as $biglietto): ?>
            <div class="form-group">
                <label for="biglietti[<?= strtolower($biglietto['tipo']) ?>]">
                    <?= $biglietto['tipo'] ?> (<?= number_format($biglietto['prezzo'], 2) ?> €)
                </label>
                <input type="number" name="biglietti[<?= strtolower($biglietto['tipo']) ?>]" value="0" min="0" max="10">
            </div>
         <?php endforeach; ?>

         <div class="form-group" style="justify-content: flex-end; margin-top: 30px;">
            <button type="submit">Continua</button>
         </div>
    </form>

</div>

</body>
</html>