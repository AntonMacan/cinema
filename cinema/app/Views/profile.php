<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>Il mio profilo<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1>Il mio profilo</h1>

<?php if (session()->get('success')): ?>
    <div class="alert alert-success" role="alert"><?= session()->get('success') ?></div>
<?php endif; ?>
<?php if (session()->get('error')): ?>
    <div class="alert alert-danger" role="alert"><?= session()->get('error') ?></div>
<?php endif; ?>

<?php if (isset($validation)): ?>
    <div class="alert alert-danger">
        <?= $validation->listErrors() ?>
    </div>
<?php endif; ?>


<div class="profile-section">
    <h3>Cambia i dati personali</h3>
    <form action="/profile" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="update_details">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" value="<?= esc($utente->nome) ?>">
        </div>
        <div class="form-group">
            <label for="email">Email (non modificabile)</label>
            <input type="email" name="email" id="email" value="<?= esc($utente->email) ?>" disabled>
        </div>
        <button type="submit">Aggiorna</button>
    </form>
</div>

<hr>

<div class="profile-section">
    <h3>Cambia la password</h3>
    <form action="/profile" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="update_password">
        <div class="form-group">
            <label for="current_password">Vecchia password</label>
            <input type="password" name="current_password" id="current_password">
        </div>
        <div class="form-group">
            <label for="new_password">Nuova password</label>
            <input type="password" name="new_password" id="new_password">
        </div>
        <div class="form-group">
            <label for="password_confirm">Conferma la nuova password</label>
            <input type="password" name="password_confirm" id="password_confirm">
        </div>
        <button type="submit">Aggiorna</button>
    </form>
</div>

<?= $this->endSection() ?>