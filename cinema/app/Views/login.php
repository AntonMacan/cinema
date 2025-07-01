<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('title') ?>
Login Utente
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container">
    <h2>Login</h2>

    <?php if (session()->get('success')): ?>
        <div class="alert alert-success" role="alert">
            <?= session()->get('success') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->get('error')): ?>
        <div class="alert alert-danger" role="alert">
            <?= session()->get('error') ?>
        </div>
    <?php endif; ?>

    <form action="/login" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= old('email') ?>">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>

        <div class="form-group">
            <button type="submit">Login</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>