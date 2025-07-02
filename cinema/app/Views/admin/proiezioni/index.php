<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>
Amministrazione Proiezioni
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
    <h1>Lista delle Proiezioni</h1>

    <a href="/admin/proiezioni/new" class="btn btn-primary mb-20">+ Aggiungi Nuova Proiezione</a>

    <?php if (session()->get('success')): ?>
        <div class="alert alert-success"><?= session()->get('success') ?></div>
    <?php endif; ?>

    <table class="table-admin">
        <thead>
            <tr>
                <th>ID</th>
                <th>Contenuto</th>
                <th>Data</th>
                <th>Orario</th>
                <th width="200px">Azioni</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($proiezioni)): ?>
                <?php foreach ($proiezioni as $proiezione): ?>
                    <tr>
                        <td><?= $proiezione->id ?></td>
                        <td>
                            <?php
                                // Koristimo naše ručne metode koje pouzdano rade
                                $contenuto = $proiezione->getFilm() ?? $proiezione->spettacolo;
                            ?>
                            <?php if ($contenuto): ?>
                                <small><?= $proiezione->film_id ? 'Film:' : 'Spettacolo:' ?></small><br>
                                <strong><?= esc($contenuto->titolo) ?></strong>
                            <?php else: ?>
                                N/D
                            <?php endif; ?>
                        </td>
                        <td><?= \CodeIgniter\I18n\Time::parse($proiezione->data)->toLocalizedString('dd.MM.y') ?></td>
                        <td><?= esc(date('H:i', strtotime($proiezione->orario))) ?>h</td>
                        <td>
                            <div class="actions-group">
                                <a href="/admin/proiezioni/edit/<?= $proiezione->id ?>" class="btn btn-sm btn-info">Modifica</a>
                                <form action="/admin/proiezioni/delete/<?= $proiezione->id ?>" method="post">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Sei sicuro di voler eliminare questa proiezione?');">
                                        Elimina
                                    </button>
                                </form>
                            </div>
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

    <div class="pager-container">
        <?= $pager->links() ?>
    </div>

</div>
<?= $this->endSection() ?>