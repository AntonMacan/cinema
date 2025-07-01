<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('title') ?>
<?= esc($spettacolo->titolo) ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container">
    <a href="/">&laquo; Torna al repertorio</a>

    <h1><?= esc($spettacolo->titolo) ?></h1>

    <h3>Cast: <?= esc($spettacolo->cast) ?></h3>

    <p class="descrizione">
        <?= esc($spettacolo->descrizione) ?>
    </p>

    <h2>Prossime Proiezioni</h2>

    <?php if (!empty($proiezioni)): ?>
        <ul class="termini-list">
            <?php foreach ($proiezioni as $proiezione): ?>
                <li>
                    <a href="/reservation/<?= $proiezione->id ?>">
                        <?= date('d.m.Y, l', strtotime($proiezione->data)) ?>
                        alle ore <?= date('H:i', strtotime($proiezione->orario)) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Non ci sono proiezioni programmate per questo spettacolo.</p>
    <?php endif; ?>

</div>
<?= $this->endSection() ?>