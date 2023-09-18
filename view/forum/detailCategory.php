<?php

$topics = $result["data"]['topics'];
$category = $result['data']['category'];
$title = $result['data']['title'];
$description = $result['data']['description'];

?>

<div class="container-category">

  <!-- bouton retour -->
  <div class="div-back">
    <button class="back"><a href="index.php?ctrl=forum&action=listCategories"><i class="fa-solid fa-circle-chevron-left"></i> Retour aux catégories</a></button>
  </div>

  <!-- div bannière -->
  <div class="banner">

    <h1> <?= $category->getLabel(); ?></h1>

    <div class="formulaire">
      <div class="add-topic">

        <?php
        if (App\Session::getUser()) {
        ?>

          <h3 class="title-add">Ajouter un sujet</h3>

          <form class="form-topic" action="index.php?ctrl=forum&action=addTopic&id=<?= $category->getId() ?>" method="post">

            <label for="title">Titre du sujet :</label>
            <input type="text" name="title" placeholder="Saisir le nom du sujet" required>

            <!-- input pour récupérer l'id de la catégorie -->
            <input type="hidden" id="category_id" name="category_id" value="<?= $category->getId() ?>" />

            <!-- Premier Post du topic -->
            <label class="block" for="text">Commentaire :</label>
            <textarea name="text" placeholder="Saisir votre commentaire"> </textarea>

            <input class="submit-topic" type="submit" name="submit" value="Ajouter">

          </form>

        <?php } else { ?>
          <p class="message-connection"> Pour créer un topic veuillez vous connecter<a href="index.php?ctrl=security&action=loginForm"> <i class="fa-solid fa-share"></i></a></p>
        <?php } ?>

      </div>
    </div>
  </div>

  <div class="grid">

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
      <h4 class='title-h4'> Aucun topic </h4>
    <?php
    }
    ?>

  </div>
</div>