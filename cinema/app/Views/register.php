<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Registrazione Nuovo Utente</title>
    <style>
        body { font-family: sans-serif; }
        .container { max-width: 500px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="email"], input[type="password"], input[type="date"] {
            width: 100%; padding: 8px; box-sizing: border-box;
        }
        .error { color: red; font-size: 0.9em; }
        button { padding: 10px 15px; background-color: #007bff; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>

<div class="container">
    <h2>Registrazione</h2>

    <?php if (isset($validation)): ?>
        <div class="error" style="border: 1px solid red; padding: 10px; margin-bottom: 15px; background-color: #ffecec;">
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

</body>
</html>