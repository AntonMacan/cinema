<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>Prenotazione Biglietti<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
    $contenuto = $proiezione->getFilm() ?? $proiezione->getSpettacolo();
?>

<h1>Prenotazione Biglietti</h1>
<p>Stai completando la prenotazione per la seguente proiezione. Seleziona il numero di biglietti desiderato.</p>

<div class="booking-container">
    <div class="booking-summary">
        <?php if ($contenuto && property_exists($contenuto, 'poster') && $contenuto->poster): ?>
            <img src="/uploads/posters/<?= esc($contenuto->poster) ?>" alt="<?= esc($contenuto->titolo) ?>">
        <?php else: ?>
            <img src="/uploads/posters/default.jpg" alt="Poster">
        <?php endif; ?>
        <h2><?= esc($contenuto->titolo ?? 'N/D') ?></h2>
        <p>
            <strong>Data:</strong> <?= \CodeIgniter\I18n\Time::parse($proiezione->data)->toLocalizedString('EEEE, dd MMMM y') ?><br>
            <strong>Orario:</strong> <?= date('H:i', strtotime($proiezione->orario)) ?>h
        </p>
    </div>

    <div class="booking-form">
        <form action="/booking/process" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="proiezione_id" value="<?= $proiezione->id ?>">

            <h3>Seleziona i Biglietti</h3>

            <?php foreach ($tipi_biglietti as $biglietto): ?>
                <div class="form-group ticket-selection">
                    <label for="biglietti[<?= strtolower($biglietto['tipo']) ?>]">
                        <?= $biglietto['tipo'] ?>
                        <span class="ticket-price">(<?= number_format($biglietto['prezzo'], 2) ?> €)</span>
                    </label>
                    <input type="number" name="biglietti[<?= strtolower($biglietto['tipo']) ?>]" value="0" min="0" max="10">
                </div>
            <?php endforeach; ?>

            <div class="form-group" style="justify-content: flex-end; margin-top: 30px;">
                <button type="submit">Continua all'acquisto</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>