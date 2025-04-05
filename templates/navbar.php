<header>
        <img id="logo" src="../static/images/favicon.png" alt="logo" onclick="window.location.href='index.php'">
        <form action="/html/search.html" id="searchBarTop">
            <input type="search" placeholder="Images, #tags, @utilisateurs">
        </form>

        <?php if (!isset($_SESSION['user'])): ?>
            <div class="buttons">
                <a id="signup" href="index.php/signup?callback=<?php echo $callback ?>">S'inscrire</a>
                <a id="signin" href="index.php/signin?callback=<?php echo $callback ?>"></a>
            </div>
        <?php else: ?>
            <div class="buttons">
                <a id="profile" href="index.php/profile?name=<?php echo $_SESSION['username'] ?>">Mon profil</a>
                <a id="settings" href="index.php/settings?callback=<?php echo $callback ?>"><img src="../static/images/settings.svg" alt="settings"></a>
            </div>
        <?php endif; ?>    
</header>