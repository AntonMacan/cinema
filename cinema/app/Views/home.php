<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('title') ?>
Proiezioni
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container">
    <h1>Proiezioni</h1>

    <?php
    $currentDate = null;
    ?>

    <?php if (!empty($proiezioni)): ?>
        <?php foreach ($proiezioni as $proiezione): ?>

            <?php
            if ($proiezione->data != $currentDate) {
                if ($currentDate !== null) {
                    echo '</ul>';
                }
                $currentDate = $proiezione->data;
                echo '<h2>' . \CodeIgniter\I18n\Time::parse($currentDate)->toLocalizedString('dd.MM.y, EEEE') . '</h2>';
                echo '<ul>';
            }
            ?>

            <li>
                <div>
                    <?php 
                        $film = $proiezione->getFilm();
                        $spettacolo = $proiezione->spettacolo;
                    ?>
                    <?php if ($film): ?>
                        <?php if ($film->poster): ?>
                            <img src="/uploads/posters/<?= esc($film->poster) ?>" alt="<?= esc($film->titolo) ?>" width="100" style="float:left; margin-right: 15px;">
                        <?php endif; ?>
                        <a href="/film/<?= $film->id ?>" class="content-title"><?= esc($film->titolo) ?></a>
                    <?php elseif ($spettacolo): ?>
                        <a href="/spettacolo/<?= $spettacolo->id ?>" class="content-title"><?= esc($spettacolo->titolo) ?></a>
                    <?php endif; ?>
                </div>
                <div class="content-time">
                    <a href="/rezervacija/<?= $proiezione->id ?>">
                        <?= esc(date('H:i', strtotime($proiezione->orario))) ?>h
                    </a>
                </div>
            </li>

        <?php endforeach; ?>
        </ul> <?php else: ?>
        <p>Non ci sono proiezioni nel dato periodo.</p>
    <?php endif; ?>

</div>
<?= $this->endSection() ?>