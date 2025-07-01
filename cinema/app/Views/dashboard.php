<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
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