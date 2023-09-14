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
        foreach($posts as $post){
          
    ?>
       
    <div class="post">
        <p class="pseudo"><?=$post->getUser()->getPseudo()?> <span class="date"><?= $post->getCreationDate()?></span></p>
    <br>

        <p><?=$post->getText()?></p>
    <br>
    <div class="action">
        <!-- suppression d'un post -->
        <button class="btn-delete">
            <a href="index.php?ctrl=forum&action=deletePost&id=<?= $post->getId() ?>"><i class="fa-solid fa-trash"></i></a>
        </button>
        <!-- modification d'un post -->
        <button class="btn-update">
            <a href="index.php?ctrl=forum&action=updatePost&id=<?= $post->getId() ?>"><i class="fa-solid fa-pen-to-square"></i></a>
        </button>
      </div>
    </div>

    <?php
        } 
    ?> 
</div>
<div class="formulaire-post">

      <?php    
      if($topic->getIsClosed() == 0) {              
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
              <p class="message-connection"> Pour publier un commentaire veuillez vous connecter<a href="./view/security/login.php"> <i class="fa-solid fa-share"></i></a></p>
        <?php } 
      } else { ?>
              <p class="message-connection">Le sujet est fermé, vous ne pouvez plus poster de commentaire.</p>
      <?php } ?>

  </div>

</div> 