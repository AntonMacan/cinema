<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>
Amministrazione Film
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
    <h1>Lista dei Film</h1>

    <a href="/admin/films/new" class="btn btn-primary mb-20">+ Aggiungi Nuovo Film</a>

    <?php if (session()->get('success')): ?>
        <div class="alert alert-success"><?= session()->get('success') ?></div>
    <?php endif; ?>

    <table class="table-admin">
        <thead>
            <tr>
                <th>Poster</th>
                <th>ID</th>
                <th>Titolo</th>
                <th width="200px">Azioni</th> </tr>
        </thead>
        <tbody>
            <?php if (!empty($films)): ?>
                <?php foreach ($films as $film): ?>
                    <tr>
                        <td>
                            <img src="/uploads/posters/<?= esc($film->poster ?? 'default.jpg') ?>" alt="<?= esc($film->titolo) ?>" width="60">
                        </td>
                        <td><?= $film->id ?></td>
                        <td><?= esc($film->titolo) ?></td>
                        <td>
                            <div class="actions-group">
                                <a href="/admin/films/edit/<?= $film->id ?>" class="btn btn-sm btn-info">Modifica</a>
                                <form action="/admin/films/delete/<?= $film->id ?>" method="post">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Sei sicuro di voler eliminare questo film?');">
                                        Elimina
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Nessun film trovato.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="pager-container">
        <?= $pager->links() ?>
    </div>
</div>
<?= $this->endSection() ?>