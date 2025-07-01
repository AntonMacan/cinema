<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?><?= esc($spettacolo->titolo) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="details-grid">
    <div class="details-left">
        <img src="/uploads/posters/default.jpg" alt="<?= esc($spettacolo->titolo) ?>" class="details-poster">
    </div>

    <div class="details-right">
        <h1><?= esc($spettacolo->titolo) ?></h1>
        <h3>Cast: <?= esc($spettacolo->cast) ?></h3>

        <p class="sinossi">
            <?= esc($spettacolo->descrizione) ?>
        </p>
    </div>
</div>

<div class="proiezioni-section">
    <h2>Prossime Proiezioni</h2>
    <?php if (!empty($proiezioni)): ?>
        <?php
        $currentDate = null;
        foreach ($proiezioni as $proiezione):
            if ($proiezione->data != $currentDate) {
                if ($currentDate !== null) {
                    echo '</div>'; // Zatvori prethodni .termini-day-group
                }
                $currentDate = $proiezione->data;
                echo '<h3>' . \CodeIgniter\I18n\Time::parse($currentDate)->toLocalizedString('EEEE, dd MMMM y') . '</h3>';
                echo '<div class="termini-day-group">';
            }
        ?>
            <a href="/reservation/<?= $proiezione->id ?>" class="termin-link">
                <?= date('H:i', strtotime($proiezione->orario)) ?>h
            </a>
        <?php endforeach; ?>
        </div> <?php else: ?>
        <p>Non ci sono proiezioni programmate per questo spettacolo.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>