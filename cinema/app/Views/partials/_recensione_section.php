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