<?php

$categories = $result['data']['categories'];
$title = $result['data']['title'];
$description = $result['data']['description'];

?>

<div class="container-category">

  <!-- bouton retour -->
  <div class="div-back">
    <button class="back"><a href="index.php?ctrl=home"><i class="fa-solid fa-circle-chevron-left"></i> Retour à l'accueil</a></button>
  </div>

  <div class="banner">

    <h1>Liste des catégories</h1>

    <div class="formulaire">
      <div class="add-topic add-category">

        <?php
        if (App\Session::getUser()) {
        ?>
          <h3 class="title-add">Ajouter une catégorie</h3>
          <form action="index.php?ctrl=forum&action=addCategory" method="post" enctype="multipart/form-data">

            <label for="label">Catégorie :</label>
            <input type="text" name="label" placeholder="Saisir le nom de la catégorie">

            <label class="block" for="picture">Image de la catégorie :</label>
            <input class="file" type="file" name="picture">

            <input class="submit-topic submit-category" type="submit" name="submit" value="Ajouter">
          </form>

        <?php } else { ?>
          <p class="message-connection"> Pour créer une catégorie veuillez vous connecter<a href="index.php?ctrl=security&action=loginForm"> <i class="fa-solid fa-share"></i></a></p>
        <?php } ?>

      </div>
    </div>
  </div>
  <div class="grid">
    <?php
    foreach ($categories as $category) {
    ?>

      <div class="card-category">

        <a href="index.php?ctrl=forum&action=listTopicsByIdCategory&id=<?= $category->getId() ?>">

          <figure class="figure-img">
            <img class="category-img" src="<?= $category->getPicture() ?>" alt="picture of <?= $category->getLabel() ?>">

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

</div>