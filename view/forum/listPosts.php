<?php
$title = "Liste des commentaires";
$metaDescription = "Liste de tous les commentaires par sujet";

$posts = $result["data"]['posts'];
$topic = $result['data']['topic'];

?>

<div class="container">
  <h1><?= $topic->getTitle() ?> </h1>

  <?php
  foreach ($posts as $post) {
  ?>

    <div class="post">
      <p class="pseudo"><?= $post->getUser()->getPseudo() ?> <span class="date"><?= $post->getCreationDate() ?></span></p><br>
      
      <p><?= $post->getText() ?></p>  <br>
    
      <!-- Si on est admin, ou si on est l'utilisateur qui a posté le post et qu'on est bien connecté, alors on affiche les boutons d'action -->
      <?php
      if (App\Session::isAdmin() || isset($_SESSION['user']) && ($_SESSION['user']->getId() == $post->getUser()->getId())) {
      ?>
        <div class="action">
          <!-- suppression d'une catégorie -->
          <button class="btn-delete">
            <a href="index.php?ctrl=forum&action=deletePost&id=<?= $post->getId() ?>"><i class="fa-solid fa-trash"></i></a>
          </button>
          <!-- modification d'une catégorie -->
          <button class="btn-update">
            <a href="index.php?ctrl=forum&action=updatePost&id=<?= $post->getId() ?>"><i class="fa-solid fa-pen-to-square"></i></a>
          </button>
        </div>
      <?php
      }
      ?>
    </div>

  <?php
  }
  ?>

  <div class="formulaire-post">
    <div class="add-post">
      <?php
      if (App\Session::getUser()) {
      ?>
        <h3>Ajouter un commentaire</h3>
        <form class="form-post" action="index.php?ctrl=forum&action=addPost" method="post">

          <!-- input pour récupérer l'id du topic -->
          <input type="hidden" id="topic_id" name="topic_id" value="<?= $topic->getId() ?>" />

          <label for="text"></label>
          <textarea name="text" id="" cols="30" rows="10" placeholder="Saisir votre commentaire"></textarea>

          <input class="submit-post" type="submit" name="submit" value="Ajouter le commentaire">
        </form>
      <?php } else { ?>
        <p class="message-connection"> Pour modifier un commentaire veuillez vous connecter<a href="index.php?ctrl=security&action=loginForm"> <i class="fa-solid fa-share"></i></a></p>
      <?php } ?>
    </div>
  </div>

</div>