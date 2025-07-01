<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('title') ?>
Grazie!
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container">
    <h1>Grazie per il tuo acquisto!</h1>
    
    <?php if (isset($pagamento) && isset($proiezione)): ?>
        <p>La tua prenotazione è stata confermata.</p>

        <div class="proiezione-info">
            <?php $contenuto = $proiezione->getFilm() ?? $proiezione->spettacolo; ?>
            <h3>Dettagli della Proiezione</h3>
            <p>
                <strong>Contenuto:</strong> <?= esc($contenuto->titolo ?? 'N/D') ?><br>
                <strong>Data:</strong> <?= date('d.m.Y', strtotime($proiezione->data)) ?><br>
                <strong>Orario:</strong> <?= date('H:i', strtotime($proiezione->orario)) ?>h
            </p>
        </div>

        <h3>Biglietti Acquistati (Totale: <?= number_format($pagamento->importo, 2) ?> €)</h3>
        <ul>
            <?php foreach ($biglietti as $biglietto): ?>
                <li>Biglietto <?= esc($biglietto->tipo) ?> - <?= number_format($biglietto->prezzo, 2) ?> €</li>
            <?php endforeach; ?>
        </ul>

    <?php else: ?>
        <p>Dettagli della prenotazione non trovati.</p>
    <?php endif; ?>

    <br>
    <a href="/booking/pdf/<?= $pagamento->id ?>" target="_blank" >
        Scarica i biglietti
    </a>
    <br><br>
    <a href="/">Torna alla homepage</a>
</div>
<?= $this->endSection() ?>