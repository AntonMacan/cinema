<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('title') ?>
I miei biglietti
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container">
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
<?= $this->endSection() ?>