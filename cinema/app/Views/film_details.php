<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title><?= esc($film->titolo) ?></title>
    <style>
        body { font-family: sans-serif; background-color: #f4f4f4; }
        .container { max-width: 900px; margin: 30px auto; padding: 20px; background-color: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1, h2, h3 { color: #333; }
        .sinossi { margin-top: 20px; line-height: 1.6; }
        .termini-list { list-style: none; padding: 0; margin-top: 20px; }
        .termini-list li { padding: 10px; border-bottom: 1px solid #eee; }
        .termini-list a { font-weight: bold; }
    </style>
</head>
<body>

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

</body>
</html>