<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Cinema-Teatro | Benvenuti</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f4f4; }
        .container { max-width: 900px; margin: 30px auto; padding: 20px; background-color: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1, h2 { color: #333; }
        h2 { border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; margin-top: 30px; }
        ul { list-style: none; padding: 0; }
        li { background-color: #fafafa; padding: 15px; border: 1px solid #eee; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center; }
        .content-title { font-weight: bold; font-size: 1.2em; }
        .content-time { font-size: 1.1em; color: #555; }
        a { text-decoration: none; color: #007bff; }
    </style>
</head>
<body>

<div class="container">
    <h1>Proiezioni</h1>

    <?php
    $currentDate = null;
    ?>

    <?php if (!empty($proiezioni)): ?>
        <?php foreach ($proiezioni as $proiezione): ?>

            <?php
            if ($proiezione->data != $currentDate) {
                if ($currentDate !== null) {
                    echo '</ul>';
                }
                $currentDate = $proiezione->data;
                echo '<h2>' . date('d.m.Y, l', strtotime($currentDate)) . '</h2>';
                echo '<ul>';
            }
            ?>

            <li>
                <div>
                    <?php 
                        $film = $proiezione->getFilm();
                        $spettacolo = $proiezione->spettacolo;
                    ?>
                    <?php if ($film): ?>
                        <a href="/film/<?= $film->id ?>" class="content-title"><?= esc($film->titolo) ?></a>
                        <p>Tip: Film</p>
                    <?php elseif ($spettacolo): ?>
                        <a href="/spettacolo/<?= $spettacolo->id ?>" class="content-title"><?= esc($spettacolo->titolo) ?></a>
                        <p>Tip: Predstava</p>
                    <?php endif; ?>
                </div>
                <div class="content-time">
                    <a href="/rezervacija/<?= $proiezione->id ?>">
                        <?= esc(date('H:i', strtotime($proiezione->orario))) ?>h
                    </a>
                </div>
            </li>

        <?php endforeach; ?>
        </ul> <?php else: ?>
        <p>Nema zakazanih projekcija u narednom periodu.</p>
    <?php endif; ?>

</div>

</body>
</html>