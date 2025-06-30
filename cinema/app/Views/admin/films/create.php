<!DOCTYPE html>
<html lang="it">
<head>
    <title>Aggiungi Nuovo Film</title>
    </head>
<body>
<div class="container">
    <h1>Aggiungi Nuovo Film</h1>

    <?php if (session()->get('errors')): ?>
        <div class="alert alert-danger">
            <ul>
            <?php foreach (session()->get('errors') as $error) : ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <form action="/admin/films/create" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="titolo">Titolo</label>
            <input type="text" name="titolo" value="<?= old('titolo') ?>">
        </div>
        <div class="form-group">
            <label for="sinossi">Sinossi</label>
            <textarea name="sinossi"><?= old('sinossi') ?></textarea>
        </div>
        <div class="form-group">
            <label for="cast">Cast</label>
            <input type="text" name="cast" value="<?= old('cast') ?>">
        </div>
        <div class="form-group">
            <label for="fornitore_id">Fornitore</label>
            <select name="fornitore_id">
                <option value="">Seleziona un fornitore</option>
                <?php foreach ($fornitori as $fornitore): ?>
                    <option value="<?= $fornitore->id ?>"><?= esc($fornitore->nome) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <button type="submit">Salva Film</button>
    </form>
    <br>
    <a href="/admin/films">Annulla</a>
</div>
</body>
</html>