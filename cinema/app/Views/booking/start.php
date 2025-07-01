<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('title') ?>
Prenotazione biglietti
<?= $this->endSection() ?>
<?= $this->section('content') ?>
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

         <div class="form-group">
            <button type="submit">Continua</button>
         </div>
    </form>

</div>
<?= $this->endSection() ?>