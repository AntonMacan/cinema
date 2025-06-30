<!DOCTYPE html>
<html lang="it">
<head>
    <title>Amministrazione Film</title>
    </head>
<body>
<div class="container">
    <h1>Lista dei Film</h1>
    <a href="/admin/films/new" style="margin-bottom: 20px; display: inline-block;">+ Aggiungi Nuovo Film</a>

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
                            <form action="/admin/films/delete/<?= $film->id ?>" method="post" style="display:inline;">
                                <?= csrf_field() ?>
                                <button type="submit" onclick="return confirm('Sei sicuro di voler eliminare questo film?');" style="color:red; border:none; background:none; cursor:pointer;">
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
    <br>
    <a href="/dashboard">Torna alla Dashboard</a>
</div>
</body>
</html>