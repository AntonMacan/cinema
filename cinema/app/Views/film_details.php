<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?><?= esc($film->titolo) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="details-grid">
    <div class="details-left">
        <?php if ($film->poster): ?>
            <img src="/uploads/posters/<?= esc($film->poster) ?>" alt="<?= esc($film->titolo) ?>" class="details-poster">
        <?php endif; ?>
    </div>

    <div class="details-right">
        <h1><?= esc($film->titolo) ?></h1>
        <h3>Cast: <?= esc($film->cast) ?></h3>

        <p class="sinossi"><?= esc($film->sinossi) ?></p>

        <hr>
        <div class="recensione-summary">
            <h2>Recensioni (<?= $totaleRecensioni ?>)</h2>
            <?php if ($totaleRecensioni > 0): ?>
                <div class="star-rating" title="Voto Medio: <?= $votoMedio ?> / 5">
                <?php 
                // Logika za ispis zvjezdica
                for ($i = 1; $i <= 5; $i++):
                    // Ako je prosječna ocjena veća ili jednaka trenutnoj zvjezdici, zvijezda je puna
                    if ($votoMedio >= $i) {
                        echo '<span class="star full">&#9733;</span>';
                    } 
                    // Ako je prosječna ocjena između trenutne i prethodne zvjezdice (npr. 3.5 je između 3 i 4), zvijezda je polovična
                    elseif ($votoMedio > ($i - 1) && $votoMedio < $i) {
                        echo '<span class="star half">&#9733;</span>'; // Koristimo punu zvijezdu kao podlogu
                    } 
                    // Inače, zvijezda je prazna
                    else {
                        echo '<span class="star empty">&#9734;</span>';
                    }
                endfor; 
                ?>
                <span class="rating-text"><?= $votoMedio ?> / 5</span>
            </div>
            <?php endif; ?>
        </div>

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
        <p>Non ci sono proiezioni programmate per questo film.</p>
    <?php endif; ?>
</div>
<div class="recensioni-section">
    <?= $this->include('partials/_recensione_section') ?>
</div>


<?= $this->endSection() ?>