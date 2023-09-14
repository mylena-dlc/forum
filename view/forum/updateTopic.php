
<?php

$topic = $result['data']['topic'];
  
?>

<div class="container-category">

<div class="banner">

  <h1>Modifier le sujet </h1>

<?php                  
    if(App\Session::getUser()){
  ?>

  <div class="formulaire">
      <div class="add-topic  add-category update">
        <h3 class="title-add">Modifier un sujet</h3>

          <form class="form-topic" action="index.php?ctrl=forum&action=updateTopic&id=<?= $topic->getId() ?>" method="post">

          <label for="title">Nouveau titre du sujet :</label>
          <input type="text" name="title" placeholder="<?= $topic->getTitle() ?>">

          <!-- input pour récupérer l'id du topic -->
          <input type="hidden" id="id_topic" name="id_topic" value="<?= $topic->getId() ?>"/>

          <!-- Premier Post du topic -->
          <label class="block" for="text">Commentaire :</label>
          <textarea name="text" placeholder="Saisir votre nouveau commentaire" class="textarea-update"></textarea>


          <input class="submit-topic submit-category" type="submit" name="submit" value="Modifier">

          </form>
      </div>
</div>

<?php } else { ?>
           <p class="message-connection"> Pour modifier un sujet veuillez vous connecter<a href="./view/security/login.php"> <i class="fa-solid fa-share"></i></a></p>
    <?php } ?>
    </div>
  </div>
