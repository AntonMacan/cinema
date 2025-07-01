<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('title') ?>
Modifica Film
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container">
    <h1>Modifica Film: <?= esc($film->titolo) ?></h1>

    <?php if (session()->get('errors')): ?>
        <?php endif ?>

    <form action="/admin/films/update/<?= $film->id ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="titolo">Titolo</label>
            <input type="text" name="titolo" value="<?= old('titolo', $film->titolo) ?>">
        </div>
        <div class="form-group">
            <label for="sinossi">Sinossi</label>
            <textarea name="sinossi"><?= old('sinossi', $film->sinossi) ?></textarea>
        </div>
        <div class="form-group">
            <label for="cast">Cast</label>
            <input type="text" name="cast" value="<?= old('cast', $film->cast) ?>">
        </div>
        <div class="form-group">
        <label for="poster">Nuovo Poster (lasciare vuoto per non modificare)</label>
        <input type="file" name="poster" id="poster">
        </div>

        <?php if ($film->poster): ?>
            <div class="form-group">
                <label>Poster Attuale:</label><br>
                <img src="/uploads/posters/<?= esc($film->poster) ?>" alt="Poster" height="150">
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="fornitore_id">Fornitore</label>
            <select name="fornitore_id">
                <option value="">Seleziona un fornitore</option>
                <?php foreach ($fornitori as $fornitore): ?>
                    <option value="<?= $fornitore->id ?>" <?= ($fornitore->id == $film->fornitore_id) ? 'selected' : '' ?>>
                        <?= esc($fornitore->nome) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <button type="submit">Aggiorna Film</button>
    </form>
    <br>
    <a href="/admin/films">Annulla</a>
</div>
<?= $this->endSection() ?>