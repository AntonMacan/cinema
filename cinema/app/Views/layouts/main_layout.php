<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title><?= $this->renderSection('title') ?? 'Cinema-Teatro' ?></title>

    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">

</head>
<body>
    
    <?= $this->include('partials/_header') ?>

    <main class="content">
        <div class="container">
            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <?= $this->include('partials/_footer') ?>

</body>
</html>