<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('title') ?>
<?= esc($film->titolo) ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container">
    <a href="/">&laquo; Torna al repertorio</a>
    
    <h1><?= esc($film->titolo) ?></h1>
    
    <h3>Cast: <?= esc($film->cast) ?></h3>
    
    <p class="sinossi">
        <?= esc($film->sinossi) ?>
    </p>

    <h2>Prossime Proiezioni</h2>
    
    <?php if (!empty($proiezioni)): ?>
        <ul class="termini-list">
            <?php foreach ($proiezioni as $proiezione): ?>
                <li>
                    <a href="/reservation/<?= $proiezione->id ?>">
                        <?= date('d.m.Y, l', strtotime($proiezione->data)) ?> 
                        alle ore <?= date('H:i', strtotime($proiezione->orario)) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Non ci sono proiezioni programmate per questo film.</p>
    <?php endif; ?>

</div>
<hr>
<h2>Recensioni degli Utenti (<?= $totaleRecensioni ?>)</h2>
<?php if ($totaleRecensioni > 0): ?>
    <h3>Voto Medio: <?= $votoMedio ?> / 5</h3>
<?php endif; ?>

<div class="recensioni-list">
    <?php if (!empty($recensioni)): ?>
        <?php foreach ($recensioni as $recensione): ?>
            <div class="recensione">
                <strong><?= esc($recensione->getUtente()->nome ?? 'Utente Sconosciuto') ?></strong>
                <span>(Voto: <?= $recensione->voto ?>/5)</span>
                <p><?= esc($recensione->commento) ?></p>
                <small><?= date('d.m.Y', strtotime($recensione->created_at)) ?></small>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Questo film non ha ancora recensioni. Sii il primo a lasciarne una!</p>
    <?php endif; ?>
</div>
<hr>
<h2>Lascia una Recensione</h2>

<?php if (session()->get('isLoggedIn')): ?>
    
    <?php if (session()->get('success')): ?><div class="alert alert-success"><?= session()->get('success') ?></div><?php endif; ?>
    <?php if (session()->get('error')): ?><div class="alert alert-danger"><?= session()->get('error') ?></div><?php endif; ?>
    <?php if (session()->get('errors')): ?>
        <div class="alert alert-danger">
            <ul><?php foreach (session()->get('errors') as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul>
        </div>
    <?php endif; ?>

    <form action="/recensioni/create" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="film_id" value="<?= $film->id ?>">
        <div class="form-group">
            <label for="voto">Voto (da 1 a 5)</label>
            <select name="voto" id="voto">
                <option value="5">5 - Eccellente</option>
                <option value="4">4 - Molto Buono</option>
                <option value="3" selected>3 - Buono</option>
                <option value="2">2 - Discreto</option>
                <option value="1">1 - Scarso</option>
            </select>
        </div>
        <div class="form-group">
            <label for="commento">Commento</label>
            <textarea name="commento" ><?= old('commento') ?></textarea>
        </div>
        <button type="submit">Invia Recensione</button>
    </form>
<?php else: ?>
    <p>Devi <a href="/login">effettuare il login</a> per lasciare una recensione.</p>
<?php endif; ?>
<?= $this->endSection() ?>