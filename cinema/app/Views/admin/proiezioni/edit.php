<!DOCTYPE html>
<html lang="it">
<head>
    <title>Modifica Proiezione</title>
</head>
<body>
<div class="container">
    <h1>Modifica Proiezione</h1>

    <?php if (session()->get('error')): ?>
        <div class="alert alert-danger"><?= session()->get('error') ?></div>
    <?php endif ?>
    <?php if (session()->get('errors')): ?>
        <div class="alert alert-danger">
            <ul><?php foreach (session()->get('errors') as $error) : ?><li><?= esc($error) ?></li><?php endforeach ?></ul>
        </div>
    <?php endif ?>

    <form action="/admin/proiezioni/update/<?= $proiezione->id ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="film_id">Film</label>
            <select name="film_id" id="film_select">
                <option value="">Nessun film</option>
                <?php foreach ($films as $film): ?>
                    <option value="<?= $film->id ?>" <?= old('film_id', $proiezione->film_id) == $film->id ? 'selected' : '' ?>>
                        <?= esc($film->titolo) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="spettacolo_id">Spettacolo</label>
            <select name="spettacolo_id" id="spettacolo_select">
                <option value="">Nessuno spettacolo</option>
                <?php foreach ($spettacoli as $spettacolo): ?>
                    <option value="<?= $spettacolo->id ?>" <?= old('spettacolo_id', $proiezione->spettacolo_id) == $spettacolo->id ? 'selected' : '' ?>>
                        <?= esc($spettacolo->titolo) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="data">Data</label>
            <input type="date" name="data" value="<?= old('data', $proiezione->data) ?>">
        </div>

        <div class="form-group">
            <label for="orario">Orario</label>
            <input type="time" name="orario" value="<?= old('orario', $proiezione->orario) ?>">
        </div>
        
        <button type="submit">Aggiorna Proiezione</button>
    </form>
    <br>
    <a href="/admin/proiezioni">Annulla</a>

    <script>
    // Mali JS za poboljšanje iskustva: kada se odabere film, onemogući odabir predstave i obrnuto.
    const filmSelect = document.getElementById('film_select');
    const spettacoloSelect = document.getElementById('spettacolo_select');

    filmSelect.addEventListener('change', function() {
        if (this.value !== '') {
            spettacoloSelect.value = '';
            spettacoloSelect.disabled = true;
        } else {
            spettacoloSelect.disabled = false;
        }
    });

    spettacoloSelect.addEventListener('change', function() {
        if (this.value !== '') {
            filmSelect.value = '';
            filmSelect.disabled = true;
        } else {
            filmSelect.disabled = false;
        }
    });
</script>
</div>
</body>
</html>