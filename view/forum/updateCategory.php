
<?php

$category = $result['data']['category'];
  
?>

<div class="container-category">

<div class="banner">

  <h1>Modifier la catégorie </h1>

  <div class="formulaire">
    <div class="add-topic add-category update">

    <?php                  
      if(App\Session::getUser()){
    ?>
      <h3 class="title-add">Modifier une catégorie</h3>
      <form action="index.php?ctrl=forum&action=updateCategory&id=<?= $category->getId() ?>" method="post" enctype="multipart/form-data">

        <label for="label">Nouveau nom de la catégorie :</label>
        <input type="text" name="label" placeholder="<?= $category->getLabel() ?>">

        <label for="picture" class="block">Nouvelle image de la catégorie :</label>
        <input type="file" name="picture">

        <input class="submit-topic submit-category" type="submit" name="submit" value="Modifier">
      </form>

      <?php } else { ?>
           <p class="message-connection"> Pour modifier une catégorie veuillez vous connecter<a href="./view/security/login.php"> <i class="fa-solid fa-share"></i></a></p>
    <?php } ?>
    
</div>
    </div>
  </div>
