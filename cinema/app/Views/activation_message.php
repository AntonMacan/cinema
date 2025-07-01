<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('title') ?>
Attivazione
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container">
    <h1>Registrazione quasi completata!</h1>
    <p>Grazie per esserti registrato. Abbiamo inviato un'email di attivazione all'indirizzo che hai fornito.</p>
    <p>Per favore, controlla la tua casella di posta (inclusa la cartella spam) e clicca sul link per completare la registrazione e attivare il tuo account.</p>
    <a href="/">Torna alla homepage</a>
</div>
<?= $this->endSection() ?>