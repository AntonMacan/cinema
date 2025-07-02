<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>Acquisto Completato<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="receipt-container">
    <div class="receipt-header">
        <span class="success-icon">&#10004;</span>
        <h1>Acquisto Completato!</h1>
        <p>Grazie, <?= esc(session()->get('nome')) ?>! La tua prenotazione è stata confermata.</p>
        <p>Una copia di questa conferma con il biglietto in PDF è stata inviata al tuo indirizzo email.</p>
    </div>

    <?php if (isset($pagamento) && isset($proiezione)): ?>
        <?php $contenuto = $proiezione->getFilm() ?? $proiezione->getSpettacolo(); ?>

        <div class="receipt-body">
            <h3>Dettagli della Proiezione</h3>
            <div class="receipt-details">
                <div><strong>Contenuto:</strong></div>
                <div><?= esc($contenuto->titolo ?? 'N/D') ?></div>

                <div><strong>Data e Orario:</strong></div>
                <div><?= \CodeIgniter\I18n\Time::parse($proiezione->data . ' ' . $proiezione->orario)->toLocalizedString('EEEE, dd MMMM y, HH:mm') ?>h</div>
            </div>

            <h3>Riepilogo dell'Acquisto</h3>
            <div class="receipt-details">
                <div><strong>ID Transazione:</strong></div>
                <div><?= $pagamento->id ?></div>

                <div><strong>Biglietti:</strong></div>
                <div>
                    <ul>
                        <?php foreach ($biglietti as $biglietto): ?>
                            <li>Biglietto <?= esc($biglietto->tipo) ?> (<?= number_format($biglietto->prezzo, 2) ?> €)</li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="receipt-total"><strong>Totale Pagato:</strong></div>
                <div class="receipt-total"><strong><?= number_format($pagamento->importo, 2) ?> €</strong></div>
            </div>
        </div>

        <div class="receipt-actions">
            <a href="/booking/pdf/<?= $pagamento->id ?>" class="btn btn-info" target="_blank">Scarica i biglietti</a>
        </div>

    <?php else: ?>
        <div class="receipt-body">
            <p>Dettagli della prenotazione non trovati.</p>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>