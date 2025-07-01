<!DOCTYPE html>
<html lang="it">
<head>
    <title>Modifica Spettacolo</title>
</head>
<body>
<div class="container">
    <h1>Modifica Spettacolo: <?= esc($spettacolo->titolo) ?></h1>

    <form action="/admin/spettacoli/update/<?= $spettacolo->id ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="titolo">Titolo</label>
            <input type="text" name="titolo" value="<?= old('titolo', $spettacolo->titolo) ?>">
        </div>
        <div class="form-group">
            <label for="descrizione">Descrizione</label>
            <textarea name="descrizione"><?= old('descrizione', $spettacolo->descrizione) ?></textarea>
        </div>
        <div class="form-group">
            <label for="cast">Cast</label>
            <input type="text" name="cast" value="<?= old('cast', $spettacolo->cast) ?>">
        </div>
        <div class="form-group">
            <label for="compagnia_id">Compagnia Teatrale</label>
            <select name="compagnia_id">
                <option value="">Seleziona una compagnia</option>
                <?php foreach ($compagnie as $compagnia): ?>
                    <option value="<?= $compagnia->id ?>" <?= ($compagnia->id == $spettacolo->compagnia_id) ? 'selected' : '' ?>>
                        <?= esc($compagnia->nome) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <button type="submit">Aggiorna Spettacolo</button>
    </form>
    <br>
    <a href="/admin/spettacoli">Annulla</a>
</div>
</body>
</html>