<header>
        <img id="logo" src="../static/images/favicon.png" alt="logo" onclick="window.location.href='/index.php'">
        <form action="/index.php/search" id="searchBarTop">
            <input type="search" placeholder="Images, #tags, @utilisateurs" id="q" name="q">
        </form>

        <?php if (!isset($_SESSION['user'])): ?>
            <div class="buttons">
                <a id="signup" href="/index.php/signup?callback=<?=  urlencode($callback) ?>">S'inscrire</a>
                <a id="signin" href="/index.php/signin?callback=<?= urlencode($callback) ?>"></a>
            </div>
        <?php else: ?>
            <div class="buttons">
                <a id="profile" href="/index.php/user?user=<?= urlencode($_SESSION['username']) ?>">Mon profil</a>
                <a id="settings" href="/index.php/settings?callback=<?= urlencode($callback) ?>"><img src="../static/images/settings.svg" alt="settings"></a>
            </div>
        <?php endif; ?>    
</header>