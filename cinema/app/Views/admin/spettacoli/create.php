<!DOCTYPE html>
<html lang="it">
<head>
    <title>Aggiungi Nuovo Spettacolo</title>
</head>
<body>
<div class="container">
    <h1>Aggiungi Nuovo Spettacolo</h1>

    <?php if (session()->get('errors')): ?>
        <div class="alert alert-danger">
            <ul>
            <?php foreach (session()->get('errors') as $error) : ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <form action="/admin/spettacoli/create" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="titolo">Titolo</label>
            <input type="text" name="titolo" value="<?= old('titolo') ?>">
        </div>
        <div class="form-group">
            <label for="descrizione">Descrizione</label>
            <textarea name="descrizione"><?= old('descrizione') ?></textarea>
        </div>
        <div class="form-group">
            <label for="cast">Cast</label>
            <input type="text" name="cast" value="<?= old('cast') ?>">
        </div>
        <div class="form-group">
            <label for="compagnia_id">Compagnia Teatrale</label>
            <select name="compagnia_id">
                <option value="">Seleziona una compagnia</option>
                <?php foreach ($compagnie as $compagnia): ?>
                    <option value="<?= $compagnia->id ?>"><?= esc($compagnia->nome) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <button type="submit">Salva Spettacolo</button>
    </form>
    <br>
    <a href="/admin/spettacoli">Annulla</a>
</div>
</body>
</html>