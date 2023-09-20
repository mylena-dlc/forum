<?php

$categories = $result['data']['categories'];
$topics = $result['data']['topics'];
$title = $result['data']['title'];
$description = $result['data']['description'];

?>

<div class="container-category">

    <!-- bouton retour -->
    <div class="div-back">
        <button class="back"><a href="index.php?ctrl=home"><i class="fa-solid fa-circle-chevron-left"></i> Retour à l'accueil</a></button>
    </div>

    <div class="banner">

        <h1>Résultat(s) de votre recherche</h1>

    </div>

    <h2 class="h2-search">Rubrique Catégorie</h2>

    <div class="grid">
        <?php
        foreach ($categories as $category) {
        ?>

            <div class="card-category">

                <a href="index.php?ctrl=forum&action=listTopicsByIdCategory&id=<?= $category->getId() ?>">

                    <figure class="figure-img">
                        <img class="category-img" src="./public/upload/<?= $category->getPicture() ?>" alt="picture of <?= $category->getLabel() ?>">

                        <!-- Nombre de topic au hover -->
                        <figcaption class="nb-topic">
                            <i class="fa-solid fa-magnifying-glass-plus"></i>
                            <?php
                            if ($category->getNbTopic() == 0) {
                                echo "Aucun sujet";
                            } else if ($category->getNbTopic() == 1) {
                                echo "Voir le sujet";
                            } else {
                                echo "Voir les " . $category->getNbTopic() . " sujets";
                            }
                            ?>
                        </figcaption>
                    </figure>

                    <h5 class="card-title"><?= $category->getLabel() ?></h5>
                </a>

                <!-- Si on est admin, ou si on est l'utilisateur qui a posté le post et qu'on est bien connecté, alors on affiche les boutons d'action -->
                <?php
                if (App\Session::isAdmin() || isset($_SESSION['user']) && ($_SESSION['user']->getId() == $post->getUser()->getId())) {
                ?>
                    <div class="action">
                        <!-- suppression d'une catégorie -->
                        <button class="btn-delete">
                            <a href="index.php?ctrl=forum&action=deleteCategory&id=<?= $category->getId() ?>"><i class="fa-solid fa-trash"></i></a>
                        </button>
                        <!-- modification d'une catégorie -->
                        <button class="btn-update">
                            <a href="index.php?ctrl=forum&action=updateCategoryForm&id=<?= $category->getId() ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                        </button>
                    </div>

                <?php
                }
                ?>

            </div>

        <?php
        }
        ?>
    </div>

    <h2 class="h2-search">Rubrique Sujet</h2>

    <div class="card-topic">
        <?php
        if (isset($topics)) {
            foreach ($topics as $topic) {
        ?>


                <div class="card">

                    <p>
                        <?php if ($topic->getIsClosed() == 1) : ?>
                            <i class="fa-solid fa-lock is-closed"></i>
                        <?php else : ?>
                            <i class="fa-solid fa-lock-open is-closed"></i>
                        <?php endif; ?>
                    </p>

                    <a href="index.php?ctrl=forum&action=listPostsByIdTopic&id=<?= $topic->getId() ?>">
                        <h5 class="card-title"><?= $topic->getTitle() ?></h5>
                    </a>

                    <!-- Si on est admin, ou si on est l'utilisateur qui a posté le topic et qu'on est bien connecter, alors on affiche les boutons d'action -->
                    <?php
                    if (App\Session::isAdmin() || isset($_SESSION['user']) && ($_SESSION['user']->getId() == $topic->getUser()->getId())) {
                    ?>

                        <div class="action">
                            <!-- suppression d'un sujet' -->
                            <button class="btn-delete">
                                <a href="index.php?ctrl=forum&action=deleteTopic&id=<?= $topic->getId() ?>"><i class="fa-solid fa-trash"></i></a>
                            </button>
                            <!-- modification d'un sujet -->
                            <button class="btn-update">
                                <a href="index.php?ctrl=forum&action=updateTopicForm&id=<?= $topic->getId() ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                            </button>

                            <!-- lock un sujet -->
                            <!-- Utilisation d'une ternaire pour afficher le cadenas fermé ou ouvert -->
                            <button class="btn-update">
                                <a href="index.php?ctrl=security&action=closedAndOpenTopic&id=<?= $topic->getId() ?>">
                                    <?php if ($topic->getIsClosed() == 1) : ?>
                                        <i class="fa-solid fa-lock"></i>
                                    <?php else : ?>
                                        <i class="fa-solid fa-lock-open"></i>
                                    <?php endif; ?>
                                </a>
                            </button>
                        </div>

                    <?php } ?>


                </div>
            <?php
            }
        } else { ?>
            <h4 class='title-h4-search'> Aucun topic </h4>
        <?php
        }
        ?>

    </div>

</div>