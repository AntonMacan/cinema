<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('title') ?>
Nuova Proiezione
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container">
    <h1>Aggiungi Nuova Proiezione</h1>

    <?php if (session()->get('errors')): ?>
        <div class="alert alert-danger">
            <ul>
            <?php foreach (session()->get('errors') as $error) : ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <form action="/admin/proiezioni/create" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="film_id">Film (seleziona solo se è un film)</label>
            <select name="film_id" id="film_select">
                <option value="">Nessun film</option>
                <?php foreach ($films as $film): ?>
                    <option value="<?= $film->id ?>"><?= esc($film->titolo) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="spettacolo_id">Spettacolo (seleziona solo se è uno spettacolo)</label>
            <select name="spettacolo_id" id="spettacolo_select">
                <option value="">Nessuno spettacolo</option>
                <?php foreach ($spettacoli as $spettacolo): ?>
                    <option value="<?= $spettacolo->id ?>"><?= esc($spettacolo->titolo) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="data">Data</label>
            <input type="date" name="data" value="<?= old('data') ?>">
        </div>

        <div class="form-group">
            <label for="orario">Orario</label>
            <input type="time" name="orario" value="<?= old('orario') ?>">
        </div>
        
        <button type="submit">Salva Proiezione</button>
    </form>
    <br>
    <a href="/admin/proiezioni">Annulla</a>
</div>

<script>
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
<?= $this->endSection() ?>