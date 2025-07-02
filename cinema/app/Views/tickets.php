<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>I Miei Biglietti<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1>I Miei Biglietti</h1>

<?php
try {
    $now = \CodeIgniter\I18n\Time::now('Europe/Rome');
} catch (\Exception $e) {
    $now = \CodeIgniter\I18n\Time::now();
}

if (!empty($biglietti)):
    foreach ($biglietti as $biglietto):

        $proiezione = $biglietto->getProiezione();

        $ticketClass = '';

        if ($proiezione) {
            $showtime = \CodeIgniter\I18n\Time::parse($proiezione->data . ' ' . $proiezione->orario, 'Europe/Zagreb');

            if ($showtime->isBefore($now)) {
                $ticketClass = 'ticket-expired'; 
            }
        } else {
            $ticketClass = 'ticket-expired';
        }

        $contenuto = $proiezione ? ($proiezione->getFilm() ?? $proiezione->spettacolo) : null;
?>
        <div class="ticket <?= $ticketClass ?>">
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
    <?php 
    endforeach; 
else: 
?>
    <p>Non hai ancora acquistato nessun biglietto.</p>
<?php endif; ?>

<?= $this->endSection() ?>