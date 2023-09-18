<?php

$post = $result["data"]['post'];
$title = $result["data"]['title'];
$description = $result["data"]['description'];

?>

<div class="container-category">

  <!-- div bannière -->
  <div class="banner">

    <h1>Modifier le commentaire</h1>

  </div>

  <?php
  if (App\Session::getUser()) {
  ?>

    <div class="formulaire-post">

      <div class="add-topic add-post">
        <h3 class="title-add">Modifier un commentaire</h3>
        <form class="form-post" action="index.php?ctrl=forum&action=updatePost&id=<?= $post->getId() ?>" method="post">

          <!-- input pour récupérer l'id du topic -->

          <label for="text"></label>
          <textarea class="textarea-post" name="text" id="" cols="30" rows="10" placeholder="Saisir votre commentaire"></textarea>

          <input class="submit-topic" type="submit" name="submit" value="Ajouter">
        </form>
      </div>

    <?php } else { ?>
      <p class="message-connection"> Pour modifier un commentaire veuillez vous connecter<a href="index.php?ctrl=security&action=loginForm"> <i class="fa-solid fa-share"></i></a></p>
    <?php } ?>

    </div>

</div>