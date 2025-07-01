<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('title') ?>
Film
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container">
    <h1>Lista dei Film</h1>
    <a href="/admin/films/new" >+ Aggiungi Nuovo Film</a>

    <?php if (session()->get('success')): ?>
        <div class="alert alert-success"><?= session()->get('success') ?></div>
    <?php endif; ?>

    <table border="1" cellpadding="5" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titolo</th>
                <th>Azioni</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($films)): ?>
                <?php foreach ($films as $film): ?>
                    <tr>
                        <td><?= $film->id ?></td>
                        <td><?= esc($film->titolo) ?></td>
                        <td>
                            <a href="/admin/films/edit/<?= $film->id ?>">Modifica</a> |
                            <form action="/admin/films/delete/<?= $film->id ?>" method="post" >
                                <?= csrf_field() ?>
                                <button type="submit" onclick="return confirm('Sei sicuro di voler eliminare questo film?');">
                                    Elimina
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">Nessun film trovato.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>