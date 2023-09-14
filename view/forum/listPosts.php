<?php

$posts = $result["data"]['posts'];
$topic = $result['data']['topic'];
    
?>

<div class="container">
    <h1><?=$topic->getTitle()?> </h1>   

    <?php 
        foreach($posts as $post){
    ?>
       
    <div class="post">
        <p class="pseudo"><?=$post->getUser()->getPseudo()?> <span class="date"><?= $post->getCreationDate()?></span></p>
    <br>

        <p><?=$post->getText()?></p>
    <br>
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
    </div>

    <?php
        } 
    ?> 

<div class="formulaire-post">
    <div class="add-post">
      <h3>Ajouter un commentaire</h3>
      <form class="form-post" action="index.php?ctrl=forum&action=addPost" method="post">
          
        <!-- input pour récupérer l'id du topic -->
        <input type="hidden" id="topic_id" name="topic_id" value="<?= $topic->getId() ?>"/>
        
        <label for="text"></label>
        <textarea name="text" id="" cols="30" rows="10" placeholder="Saisir votre commentaire"></textarea>

        <input class="submit-post" type="submit" name="submit" value="Ajouter le commentaire">
      </form>
    </div>
  </div>

</div> 