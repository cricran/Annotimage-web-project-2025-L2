<header>
        <img id="logo" src="../static/images/favicon.png" alt="logo" onclick="window.location.href='index.php'">
        <form action="/html/search.html" id="searchBarTop">
            <input type="search" placeholder="Images, #tags, @utilisateurs">
        </form>

        <div class="buttons">
            <a id="signup" href="index.php/signup?callback=<?php echo $callback ?>">S'inscrire</a>
            <a id="signin" href="index.php/signin?callback=<?php echo $callback ?>"></a>
        </div>
</header>