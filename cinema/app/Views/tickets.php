<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>I Miei Biglietti<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="profile-header">
    <h1>I Miei Biglietti</h1>
</div>

<h2>Cronologia Acquisti</h2>

<?php
try {
    $now = \CodeIgniter\I18n\Time::now('Europe/Rome');
} catch (\Exception $e) {
    $now = \CodeIgniter\I18n\Time::now();
}

if (!empty($pagamenti)):
    foreach ($pagamenti as $pagamento):

        $firstBiglietto = $pagamento->getBiglietti()[0] ?? null;
        $proiezione = $firstBiglietto ? $firstBiglietto->getProiezione() : null;
        $isExpired = true;
        $ticketClass = 'ticket-expired';

        if ($proiezione) {
            $showtime = \CodeIgniter\I18n\Time::parse($proiezione->data . ' ' . $proiezione->orario, 'Europe/Rome');
            
            if (!$showtime->isBefore($now)) {
                $isExpired = false;
                $ticketClass = '';
            }
        }
        
        $contenuto = $proiezione ? ($proiezione->getFilm() ?? $proiezione->getSpettacolo()) : null;
?>
        <div class="purchase-group <?= $ticketClass ?>">
            <div class="purchase-header">
                <div>
                    <h4>Acquisto del: <?= \CodeIgniter\I18n\Time::parse($pagamento->data)->toLocalizedString('dd MMMM y, HH:mm') ?>h</h4>
                    <span>ID Transazione: <?= $pagamento->id ?></span>
                </div>
                <div class="purchase-total">
                    <strong>Totale: <?= number_format($pagamento->importo, 2) ?> €</strong>
                    
                    <?php if ($isExpired): ?>
                        <button class="btn btn-sm" disabled>Biglietti</button>
                    <?php else: ?>
                        <a href="/booking/pdf/<?= $pagamento->id ?>" class="btn btn-sm btn-info" target="_blank">Biglietti</a>
                    <?php endif; ?>

                </div>
            </div>
            <div class="purchase-body">
                <h5>Dettagli Proiezione:</h5>
                <p>
                    <strong><?= esc($contenuto->titolo ?? 'Contenuto Sconosciuto') ?></strong><br>
                    <?= $proiezione ? \CodeIgniter\I18n\Time::parse($proiezione->data)->toLocalizedString('EEEE, dd MMMM y') : '' ?> 
                    alle <?= $proiezione ? date('H:i', strtotime($proiezione->orario)) : '' ?>h
                </p>
                <h5>Biglietti in questo acquisto:</h5>
                <ul>
                   <?php foreach ($pagamento->getBiglietti() as $biglietto): ?>
                        <li>Biglietto <?= esc($biglietto->tipo) ?> (<?= number_format($biglietto->prezzo, 2) ?> €)</li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Non hai ancora effettuato nessun acquisto.</p>
<?php endif; ?>

<?= $this->endSection() ?>