<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annotimage</title>
    <link rel="stylesheet" href="../static/css/style.css">
</head>

<body>
    <header>
        <img id="logo" src="../static/images/logo.png" alt="logo" onclick="window.location.href='index.html'">
        <form action="/html/search.html" id="searchBarTop">
            <input type="search" placeholder="Images, #tags, @utilisateurs">
        </form>

        <div class="buttons">
            <button id="signup">S'inscrire</button>
            <button id="signin" onclick="window.location.href='connect.html'"></button>
        </div>
    </header>


    <section id="main">
        <h1>Téléversez et Annotez vos images</h1>

        <form action="/html/search.html">
            <input type="search" placeholder="Images, #tags, @utilisateurs">
        </form>

        <button onclick="window.location.href='upload.html'">
            Nouveau post
            <img src="../static/images/upload.svg" alt="upload">
        </button>
    </section>
    <section id="image_grid">
        <h2>Les images les plus récentes</h2>

        <div class="row">
            <div class="column">
                <article>
                    <img src="../images/public/1.webp" alt="image" id="img1">
                    <h2>
                        Une image du film Dune (2021)
                    </h2>
                    <p><a href="user.html">@myUser</a></p>
                    <p><a href="tag.html">#dune, #film, #cinema</a></p>
                </article>

                <article>
                    <img src="../images/public/2.webp" alt="image">
                    <h2>
                        Une image du film Dune (2021)
                    </h2>
                    <p>@myUser</p>
                    <p>#dune, #film, #cinema</p>
                </article>

                <article>
                    <img src="../images/public/3.webp" alt="image">
                    <h2>
                        Une image du film Dune (2021)
                    </h2>
                    <p>@myUser</p>
                    <p>#dune, #film, #cinema</p>
                </article>

                <article>
                    <img src="../images/public/4.webp" alt="image">
                    <h2>
                        Une image du film Dune (2021)
                    </h2>
                    <p>@myUser</p>
                    <p>#dune, #film, #cinema</p>
                </article>
            </div>
            <div class="column">
                <article>
                    <img src="../images/public/5.webp" alt="image">
                    <h2>
                        Une image du film Dune (2021)
                    </h2>
                    <p>@myUser</p>
                    <p>#dune, #film, #cinema</p>
                </article>

                <article>
                    <img src="../images/public/6.webp" alt="image">
                    <h2>
                        Une image du film Dune (2021)
                    </h2>
                    <p>@myUser</p>
                    <p>#dune, #film, #cinema #dune, #film, #cinema #dune, #film, #cinema #dune, #film, #cinema
                        #dune,
                        #film, #cinema</p>
                </article>

                <article>
                    <img src="../images/public/7.webp" alt="image">
                    <h2>
                        Une image du film Dune (2021)
                    </h2>
                    <p>@myUser</p>
                    <p>#dune, #film, #cinema</p>
                </article>

                <article>
                    <img src="../images/public/8.webp" alt="image">
                    <h2>
                        Une image du film Dune (2021)
                    </h2>
                    <p>@myUser</p>
                    <p>#dune, #film, #cinema</p>
                </article>
                <article>
                    <img src="../images/public/13.webp" alt="image">
                    <h2>
                        Cette valeur crée une ombre avec un décalage horizontal de 0 pixels, un décalage vertical de
                        4
                        pixels, un flou de 6 pixels, et une couleur noire avec une opacité de 10%.
                    </h2>
                    <p>@myUser</p>
                    <p>#dune, #film, #cinema</p>
                </article>
            </div>
            <div class="column">
                <article>
                    <img src="../images/public/9.webp" alt="image">
                    <h2>
                        Cette valeur crée une ombre avec un décalage horizontal de 0 pixels, un décalage vertical de
                        4
                        pixels, un flou de 6 pixels, et une couleur noire avec une opacité de 10%.
                    </h2>
                    <p>@myUser</p>
                    <p>#dune, #film, #cinema</p>
                </article>

                <article>
                    <img src="../images/public/10.webp" alt="image">
                    <h2>
                        Une image du film Dune (2021)
                    </h2>
                    <p>@myUser</p>
                    <p>#dune, #film, #cinema</p>
                </article>

                <article>
                    <img src="../images/public/11.webp" alt="image">
                    <h2>
                        Une image du film Dune (2021)
                    </h2>
                    <p>@myUser</p>
                    <p>#dune, #film, #cinema</p>
                </article>

                <article>
                    <img src="../images/public/12.webp" alt="image">
                    <h2>
                        Une image du film Dune (2021)
                    </h2>
                    <p>@myUser</p>
                    <p>#dune, #film, #cinema</p>
                </article>
            </div>
            <div class="column">
                <article>
                    <img src="../images/public/1.webp" alt="image">
                    <h2>
                        Une image du film Dune (2021)
                    </h2>
                    <p>@myUser</p>
                    <p>#dune, #film, #cinema</p>
                </article>

                <article>
                    <img src="../images/public/2.webp" alt="image">
                    <h2>
                        Une image du film Dune (2021)
                    </h2>
                    <p>@myUser</p>
                    <p>#dune, #film, #cinema</p>
                </article>

                <article>
                    <img src="../images/public/3.webp" alt="image">
                    <h2>
                        Une image du film Dune (2021)
                    </h2>
                    <p>@myUser</p>
                    <p>#dune, #film, #cinema</p>
                </article>

                <article>
                    <img src="../images/public/4.webp" alt="image">
                    <h2>
                        Une image du film Dune (2021)
                    </h2>
                    <p>@myUser</p>
                    <p>#dune, #film, #cinema</p>
                </article>
            </div>

        </div>
    </section>

    <dialog id="showImg1">
        <img src="../images/public/9.webp" usemap="#image-map" alt="image">
        <div id="tooltip"></div>
        <map name="image-map">
            <area shape="rect" coords="34,44,270,350" alt="Lieu 1" href="#" id="zone">

            <script>
                zone = document.getElementById("zone")
                document.addEventListener('mousemove', showTooltip)

                // Affichage du tooltip quand on survole une zone
                function showTooltip(event) {
                    const tooltip = document.getElementById('tooltip');
                    tooltip.innerHTML = "je suis une annotation";
                    tooltip.style.display = 'block';
                }

                // Cacher le tooltip lorsqu'on quitte une zone
                function hideTooltip() {
                    const tooltip = document.getElementById('tooltip');
                    tooltip.style.display = 'none';
                    tooltipVisible = false; // Le tooltip n'est plus visible
                }
            </script>
            <style>
                #tooltip {
                    position: fixed;
                    display: none;
                    padding: 5px;
                    background-color: rgba(0, 0, 255, 0.7);
                    /* bleu */
                    color: white;
                    border-radius: 5px;
                    pointer-events: none;
                    transition: 0.2s;
                }

                area {
                    outline: 2px solid blue;
                    /* bleu pour rendre la zone visible */
                    outline-offset: 4px;
                    /* pour espacer le contour de la zone */
                }

                img {
                    display: block;
                }
            </style>
            <div>
                <h2>Une image du film Dune (2021)</h2>
                <p>Utilisateur : @myuser</p>
                <p>Tags : #cinema, #film, #dune</p>
            </div>
    </dialog>



    <dialog id="dialogSignup">
        <h2>S'inscrire</h2>
        <form action="/signup">
            <input type="file">
            <input type="text">
            <input type="password">
            <input type="password">
            <button type="submit">S'inscrire</button>
        </form>
        <button id="closeSignup">Annuler</button>
    </dialog>


    <script>
        window.addEventListener('scroll', function () {
            const searchBar = document.getElementById('searchBarTop');

            if (window.scrollY > 300) {
                searchBar.classList.add('show');
            } else {
                searchBar.classList.remove('show');
            }
        });
    </script>



    <script>
        function addDialogCloseListener(buttonId, dialogId) {
            const button = document.getElementById(buttonId);
            const dialog = document.getElementById(dialogId);



            button.addEventListener('click', function () {
                dialog.showModal();
                console.log("show");

                function handleClickOutside(event) {
                    console.log("check");
                    const rect = dialog.getBoundingClientRect();
                    if (
                        event.clientX < rect.left ||
                        event.clientX > rect.right ||
                        event.clientY < rect.top ||
                        event.clientY > rect.bottom
                    ) {
                        dialog.close();
                        console.log("close");

                        // Force refresh/repaint by adding a small delay after closing the dialog
                        setTimeout(() => {
                            document.removeEventListener('click', handleClickOutside);
                            dialog.style.display = 'none'; // Optionnel, si nécessaire
                            // Parfois un rafraîchissement forcé est nécessaire
                            //document.body.offsetHeight; // Accessing offsetHeight to force reflow
                            dialog.style.display = ''

                        }, 0); // 10ms de délai pour donner le temps au navigateur de mettre à jour
                    }
                }

                console.log("listen");
                // Ajouter un délai pour éviter la fermeture immédiate
                setTimeout(() => {
                    document.addEventListener('click', handleClickOutside);
                }, 0);
            });
        }

        // Ajouter les écouteurs pour chaque bouton et boîte de dialogue
        addDialogCloseListener('signup', 'dialogSignup');
        addDialogCloseListener('img1', 'showImg1');

    </script>


    <style>
        /* Style de base pour la boîte de dialogue */
        dialog {
            border: none;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        dialog::backdrop {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(3px);
        }

        dialog form {
            display: flex;
            flex-direction: column;
        }

        dialog label,
        dialog input,
        dialog button {
            margin-bottom: 10px;
        }
    </style>

</body>

</html>