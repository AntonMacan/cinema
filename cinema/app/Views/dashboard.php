<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body { font-family: sans-serif; }
        .container { max-width: 800px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        .logout-link { display: inline-block; margin-top: 20px; color: red; }
    </style>
</head>
<body>

<div class="container">
    <h1>Benvenuto, <?= esc(session()->get('nome')) ?>!</h1>
    <p>Questa è la tua dashboard personale. Sei loggato con successo.</p>

    <hr>
    <a href="/myprofile">Vedi i Miei Biglietti</a>
    <hr>
    <a href="/logout" class="logout-link">Logout (Odjava)</a>
</div>

</body>
</html>