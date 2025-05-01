<?php $title = "Annotimage - Acceuille"?>
<?php $callback = 'index.php' ?>

<?php ob_start() ?>
    
    <?php include 'navbar.php'?>


    <section id="main">
        <h1>Téléversez et Annotez vos images</h1>                                                                                                                                                                                                                                                                                                                                                                                                                                                                   

        <form action="/html/search.html">
            <input type="search" placeholder="Images, #tags, @utilisateurs">
        </form>

        <a href="index.php/upload?callback=index.php">
            Nouveau post
            <img src="../static/images/upload.svg" alt="upload">
        </a>
    </section>
    <section id="image_grid">
        <h2>Les images les plus récentes</h2>

                <?php 
                displayImages($infos);
                ?>
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

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>