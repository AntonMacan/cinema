<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('title') ?>
Spettacoli
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container">
    <h1>Lista degli Spettacoli</h1>

    <a href="/admin/spettacoli/new" class="btn btn-primary mb-20">+ Aggiungi Nuovo Spettacolo</a>

    <?php if (session()->get('success')): ?>
        <div class="alert alert-success"><?= session()->get('success') ?></div>
    <?php endif; ?>

    <table class="table-admin">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titolo</th>
                <th width="200px">Azioni</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($spettacoli)): ?>
                <?php foreach ($spettacoli as $spettacolo): ?>
                    <tr>
                        <td><?= $spettacolo->id ?></td>
                        <td><?= esc($spettacolo->titolo) ?></td>
                        <td>
                            <div class="actions-group">
                                <a href="/admin/spettacoli/edit/<?= $spettacolo->id ?>" class="btn btn-sm btn-info">Modifica</a>
                                <form action="/admin/spettacoli/delete/<?= $spettacolo->id ?>" method="post">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Sei sicuro di voler eliminare questo spettacolo?');">
                                        Elimina
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">Nessun spettacolo trovato.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="pager-container">
        <?= $pager->links() ?>
    </div>

</div>
<?= $this->endSection() ?>