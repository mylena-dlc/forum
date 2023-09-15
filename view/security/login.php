
<div class="container-category">

  <div class="banner">
    <h1>Connexion</h1>
  </div>
  

  <div class="formulaire-login">
      <div class="add-topic add-category login">

        <form action="index.php?ctrl=security&action=login" method="post">

            <label for="email">E-mail :</label>
            <input type="email" name="email" placeholder="Entrez votre email" required>
            
  
            <label for="password">Mot de passe :</label>
            <div class="password-input-container">
              <input type="password" id="password-input" name="password" placeholder="Entrez votre mot de passe" required>
              <p id="password-p"><i class="fa-solid fa-eye" id="show-password"></i> Afficher votre mot de passe</p> 
            </div> <br>

            <input class="submit-topic" type="submit" name="submit" value="Se connecter">
          
            <div class="redirection">
              <p>Pas encore de compte?</p>
              <p><a href="index.php?ctrl=security&action=registerForm">Inscivez-vous ici</a></p>
            </div>
        </form>

      </div>
  </div>

</div>



