<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('title') ?>
Proiezioni
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container">
    <h1>Lista delle Proiezioni</h1>
    <a href="/admin/proiezioni/new" >+ Aggiungi Nuova Proiezione</a>

    <?php if (session()->get('success')): ?>
        <div class="alert alert-success"><?= session()->get('success') ?></div>
    <?php endif; ?>

    <table border="1" cellpadding="5" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Contenuto</th>
                <th>Data</th>
                <th>Orario</th>
                <th>Azioni</th>
            </tr>
        </thead>
       <tbody>
    <?php if (!empty($proiezioni)): ?>
        <?php foreach ($proiezioni as $proiezione): ?>
            <tr>
                <td><?= $proiezione->id ?></td>
                <td>
                    <?php 
                        // Pozivamo našu novu, ručnu metodu
                        $film = $proiezione->getFilm(); 
                        $spettacolo = $proiezione->spettacolo; // Ovdje još uvijek koristimo magiju
                    ?>

                    <?php if ($film): ?>
                        Film: <strong><?= esc($film->titolo) ?></strong>
                    <?php elseif ($spettacolo): ?>
                        Spettacolo: <strong><?= esc($spettacolo->titolo) ?></strong>
                    <?php else: ?>
                        N/D
                    <?php endif; ?>
                </td>
                <td><?= date('d.m.Y', strtotime($proiezione->data)) ?></td>
                <td>
                    <strong><?= esc($proiezione->orario) ?></strong> 
                    <?php if ($proiezione->fasciaOraria): ?>
                        (<?= esc($proiezione->fasciaOraria->nome) ?>)
                    <?php endif; ?>
                </td>
                <td>
                    <a href="/admin/proiezioni/edit/<?= $proiezione->id ?>">Modifica</a>
                    <form action="/admin/proiezioni/delete/<?= $proiezione->id ?>" method="post" >
                        <?= csrf_field() ?>
                        <button type="submit" onclick="return confirm('Sei sicuro di voler eliminare questa proiezione?');">
                            Elimina
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5">Nessuna proiezione trovata.</td>
        </tr>
    <?php endif; ?>
</tbody>
    </table>
</div>
<?= $this->endSection() ?>