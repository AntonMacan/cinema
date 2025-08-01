<header style="background-color: #333; color: white; padding: 10px 20px; display: flex; justify-content: space-between; align-items: center;">
    <div class="logo">
        <a href="/" style="color: white; font-size: 1.5em; font-weight: bold;">Cinema-Teatro</a>
    </div>
    <nav>
        <ul style="list-style: none; margin: 0; padding: 0; display: flex; gap: 20px;">
            <li><a href="/" style="color: white;">Home</a></li>
            
            <?php if (session()->get('isLoggedIn')): ?>
                <li><a href="/tickets" style="color: white;">I miei biglietti</a></li>
                <li><a href="/profile" style="color: white;">Il mio profilo</a></li>
                <?php if (session()->get('ruolo') === 'gestore'): ?>
                    <li><a href="/admin/films" style="color: white;">Film</a></li>
                    <li><a href="/admin/spettacoli" style="color: white;">Spettacoli</a></li>
                    <li><a href="/admin/proiezioni" style="color: white;">Proiezioni</a></li>
                <?php endif; ?>

                
                <li style="color: #ccc;">
                    |   <span>Benvenuto, <?= esc(session()->get('nome')) ?></span>
                </li>
                <li><a href="/logout" style="color: #dc3545;">Logout</a></li>

            <?php else: ?>

                <li><a href="/login" style="color: white;">Login</a></li>
                <li><a href="/register" style="color: white;">Registrazione</a></li>

            <?php endif; ?>
        </ul>
    </nav>
</header>