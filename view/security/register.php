

<div class="container-category">

  <div class="banner">

    <h1> Inscription</h1>

  </div>

  <div class="formulaire-register">
      <div class="register">

        <form action="index.php?ctrl=security&action=register"  onsubmit="return validateForm()" method="post" >
            <label for="pseudo">Pseudo :</label>
            <input type="text" id="pseudo"  name="pseudo" placeholder="Entrez un pseudo" required>
            
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
<script>

function validateForm() {
  
    var isValid = true; // Initialisez une variable pour suivre si le formulaire est valide
consol.log("hello");
// Réinitialisez les messages d'erreur à chaque soumission

  var errorPseudo = document.getElementById('pseudo-error').textContent = '';
    document.getElementById('email-error').textContent = '';
    document.getElementById('password-error').textContent = '';

    // Récupérez les valeurs des champs
    var pseudo = document.getElementById('pseudo').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirmPassword').value;

      if(pseudo !== "a"){
        errorPseudo.textContent = "mauvais pseudo";
      }
    // Vérifiez si le mot de passe a au moins 12 caractères
    // if (password.length < 12) {
    //     document.getElementById('password-error').textContent = "Mot de passe invalide : il doit contenir au moins 12 caractères.";
    //     isValid = false;
    // }

    // Ici, vous pouvez ajouter des vérifications supplémentaires, par exemple, vérifier si le pseudo ou l'email existent déjà en BDD.
    // Vous devrez peut-être faire une requête AJAX pour effectuer ces vérifications côté serveur.

    // Si les vérifications échouent, définissez isValid sur false et affichez les messages d'erreur appropriés.

    return isValid; // Retourne true si le formulaire est valide, false sinon
}

</script>

