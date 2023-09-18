<?php

$title = $result["data"]['title'];
$description = $result["data"]['description'];

?>

<div class="container-category">

  <div class="banner">

    <h1>Inscription</h1>

  </div>

  <div class="formulaire-register">
    <div class="register">

      <form action="index.php?ctrl=security&action=register" onsubmit="return validateForm()" method="post">
        <label for="pseudo">Pseudo :</label>
        <input type="text" id="pseudo" name="pseudo" placeholder="Entrez un pseudo" required>

        <label for="email">E-mail :</label>
        <input type="email" name="email" placeholder="Entrez un email valide" required>


        <label for="password">Mot de passe :</label>
        <div class="password-input-container">
          <input type="password" id="password-input" name="password" placeholder="Entrez votre mot de passe" minlength="12" required>
          <p id="password-p"><i class="fa-solid fa-eye" id="show-password"></i> Afficher votre mot de passe</p>
        </div>

        <div class="password-input-container">
          <input type="password" id="password-input" name="password" placeholder="Confirmez votre mot de passe" minlength="12" required>
          <p id="password-p"><i class="fa-solid fa-eye" id="show-password"></i> Afficher votre mot de passe</p>
        </div>


        <input class="submit-topic submit-category" type="submit" name="submit" value="S'inscrire">

        <div class="redirection">
          <p>Déjà inscrit?</p>
          <p><a href="index.php?ctrl=security&action=loginForm">Connectez-vous ici</a></p>
        </div>
      </form>

    </div>
  </div>
</div>