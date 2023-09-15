<?php

$posts = $result["data"]['posts'];
$topic = $result['data']['topic'];

?>

<div class="container-category">

  <!-- bouton retour -->
  <div class="div-back">
    <button class="back"><a href="index.php?ctrl=forum&action=listTopicsByIdCategory&id=<?= $topic->getCategory()->getId() ?>"><i class="fa-solid fa-circle-chevron-left"></i> Retour aux sujets</a></button>
  </div>

  <!-- div bannière -->
  <div class="banner">

    <h1><?=$topic->getTitle()?> </h1>   

  </div>


  <div class="posts"> 
    <?php 

        foreach($posts as $key => $post){

    ?>
       
    <div class="post">
        <p class="pseudo"><?=$post->getUser()->getPseudo()?> <span class="date"><?= $post->getCreationDate()?></span></p>
    <br>

        <p><?=$post->getText()?></p>
    <br>

    <!-- Si on est admin, ou si on est l'utilisateur qui a posté le post et qu'on est bien connecté, alors on affiche les boutons d'action -->
    <?php                  
    if (App\Session::isAdmin() || isset($_SESSION['user']) && ($_SESSION['user']->getId() == $post->getUser()->getId())){
    ?>

    <div class="action">
        <!-- suppression d'un post -->
        <!-- <?php if($key > 0) { ?> Si l'index du tableau de post est plus grand que 0, alors je peux supprimer le post -->
        <button class="btn-delete">
            <a href="index.php?ctrl=forum&action=deletePost&id=<?= $post->getId() ?>"><i class="fa-solid fa-trash"></i></a>
        </button>
        <?php }?>
        <!-- modification d'un post -->
        <button class="btn-update">
            <a href="index.php?ctrl=forum&action=updatePostForm&id=<?= $post->getId() ?>"><i class="fa-solid fa-pen-to-square"></i></a>
        </button>
      </div>
      <?php } ?>
    </div>

    <?php
        } 
    ?> 
</div>
<div class="formulaire-post">

      <?php    
      // Si le topic est actif, alors on peux ajouter un post
      if($topic->getIsClosed() == 0) {   
        // et si on est connecté  
        if(App\Session::getUser()){
      ?>

        <div class="add-topic add-post">
          <h3 class="title-add">Ajouter un commentaire</h3>
          <form class="form-post" action="index.php?ctrl=forum&action=addPost" method="post">
              
            <!-- input pour récupérer l'id du topic -->
            <input type="hidden" id="topic_id" name="topic_id" value="<?= $topic->getId() ?>"/>
            
            <label for="text"></label>
            <textarea class="textarea-post" name="text" id="" cols="30" rows="10" placeholder="Saisir votre commentaire"></textarea>

            <input class="submit-topic" type="submit" name="submit" value="Ajouter">
          </form>
        </div>

        <?php } else { ?>
              <p class="message-connection"> Pour publier un commentaire veuillez vous connecter<a href="index.php?ctrl=security&action=loginForm"> <i class="fa-solid fa-share"></i></a></p>
        <?php } 
      } else { ?>
              <p class="message-connection">Le sujet est fermé, vous ne pouvez plus poster de commentaire.</p>
      <?php } ?>

  </div>

</div> 