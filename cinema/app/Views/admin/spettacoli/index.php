<!DOCTYPE html>
<html lang="it">
<head>
    <title>Amministrazione Spettacoli</title>
</head>
<body>
<div class="container">
    <h1>Lista degli Spettacoli</h1>
    <a href="/admin/spettacoli/new" style="margin-bottom: 20px; display: inline-block;">+ Aggiungi Nuovo Spettacolo</a>

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
            <?php if (!empty($spettacoli)): ?>
                <?php foreach ($spettacoli as $spettacolo): ?>
                    <tr>
                        <td><?= $spettacolo->id ?></td>
                        <td><?= esc($spettacolo->titolo) ?></td>
                        <td>
                            <a href="/admin/spettacoli/edit/<?= $spettacolo->id ?>">Modifica</a> |
                            <form action="/admin/spettacoli/delete/<?= $spettacolo->id ?>" method="post" style="display:inline;">
                                <?= csrf_field() ?>
                                <button type="submit" onclick="return confirm('Sei sicuro di voler eliminare questo spettacolo?');" style="color:red; border:none; background:none; cursor:pointer;">
                                    Elimina
                                </button>
                            </form>
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
    <br>
    <a href="/dashboard">Torna alla Dashboard</a>
</div>
</body>
</html>