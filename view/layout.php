<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="title" content="<?= $title ?>">
    <meta name="description" content="<?= $description ?>">
    <meta name="keywords" content="ski, sport d'hiver, snowboard, station">
    <script src="https://cdn.tiny.cloud/1/zg3mwraazn1b2ezih16je1tc6z7gwp5yd4pod06ae5uai8pa/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./public/css/style.css">
</head>

<body>
<?php

$title = $result["data"]['title'];
$description = $result["data"]['description'];

?>
    <div id="wrapper">
        <div id="mainpage">

            <header>
                <nav class="navbar">        
                    <button class="burger">
                        <span class="bar"></span>
                    </button>
                    
                    <div id="nav-left">
                        <a href="index.php?ctrl=home">Accueil</a>
                        <?php
                        if (App\Session::isAdmin()) {
                        ?>
                            <a href="index.php?ctrl=security&action=listUsers" rel="nofollow">Voir la liste des utilisateurs</a>

                        <?php
                        }
                        ?>
                    </div>
                    <div id="nav-right">
                        <?php

                        if (App\Session::getUser()) {
                        ?>
                            <a href="index.php?ctrl=security&action=viewProfile&id=<?= App\Session::getUser()->getId() ?>" rel="nofollow"><span class="fas fa-user"></span>&nbsp;<?= App\Session::getUser()->getPseudo() ?></a>
                            <a href="index.php?ctrl=security&action=logout" rel="nofollow">Déconnexion</a>
                        <?php
                        } else {
                        ?>
                            <a href="index.php?ctrl=security&action=loginForm" rel="nofollow">Connexion</a>
                            <a href="index.php?ctrl=security&action=registerForm" rel="nofollow">Inscription</a>

                        <?php
                        }

                        ?>
                    </div>
        </div>


        </nav>
        </header>

        <main id="forum">

            <!-- c'est ici que les messages (erreur ou succès) s'affichent-->
            <div class="message-container">
                <?php if ($error_message = App\Session::getFlash("error")) : ?>
                    <p class="flash-message error"><?= $error_message ?></p>
                <?php endif; ?>

                <?php if ($success_message = App\Session::getFlash("success")) : ?>
                    <p class="flash-message success"><?= $success_message ?></p>
                <?php endif; ?>
            </div>
            <?= $page ?>

        </main>

    </div>
    <footer>
        <p>&copy; 2020 - Forum CDA - <a href="/home/forumRules.html">Règlement du forum</a> - <a href="">Mentions légales</a> - <a href="">Sitemap</a></p>
        <!--<button id="ajaxbtn">Surprise en Ajax !</button> -> cliqué <span id="nbajax">0</span> fois-->
    </footer>
    </div>
    <!-- <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous">
    </script> -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

    <script src="public/js/script.js"></script>
</body>

</html>