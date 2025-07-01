<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('title') ?>
Registrazione
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container">
    <h2>Registrazione</h2>

    <?php if (isset($validation)): ?>
        <div class="error">
            <strong>Error:</strong>
            <ul>
                <?php foreach ($validation->getErrors() as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/register" method="post">
        <?= csrf_field() ?> <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" value="<?= old('nome') ?>">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= old('email') ?>">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>

        <div class="form-group">
            <label for="password_confirm">Conferma Password</label>
            <input type="password" name="password_confirm" id="password_confirm">
        </div>
        
        <div class="form-group">
            <label for="codice_fiscale">Codice Fiscale</label>
            <input type="text" name="codice_fiscale" id="codice_fiscale" value="<?= old('codice_fiscale') ?>">
        </div>

        <div class="form-group">
            <label for="data_nascita">Data di Nascita</label>
            <input type="date" name="data_nascita" id="data_nascita" value="<?= old('data_nascita') ?>">
        </div>

        <div class="form-group">
            <button type="submit">Registrati</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>