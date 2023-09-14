<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tiny.cloud/1/zg3mwraazn1b2ezih16je1tc6z7gwp5yd4pod06ae5uai8pa/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="./public/css/style.css">
    <title>FORUM</title>
</head>
<body>
    <div id="wrapper"> 
        <div id="mainpage">

            <header>
                <nav class="navbar">
                    <div id="nav-left">
                        <a href="index.php?ctrl=home">Accueil</a>
                            <?php
                            if(App\Session::isAdmin()){
                                ?>
                                <a href="index.php?ctrl=security&action=listUsers">Voir la liste des utilisateurs</a>
                            
                        <?php
                        }
                        ?>
                    </div>
                    <div id="nav-right">
                    <?php
                        
                        if(App\Session::getUser()){
                            ?>
                            <a href="index.php?ctrl=security&action=viewProfile&id=<?= App\Session::getUser()->getId()?>"><span class="fas fa-user"></span>&nbsp;<?= App\Session::getUser()->getPseudo()?></a>
                            <a href="index.php?ctrl=security&action=logout">Déconnexion</a>
                            <?php
                        }
                        else{
                            ?>
                            <a href="index.php?ctrl=security&action=loginForm">Connexion</a>
                            
                            <a href="index.php?ctrl=security&action=registerForm">Inscription</a>
                            <!-- <a href="index.php?ctrl=forum&action=listTopics">la liste des topics</a> -->
                            <!-- <a href="index.php?ctrl=home&action=listUsers">la liste des users</a> -->
                            <!-- <a href="index.php?ctrl=forum&action=listCategories">la liste des catégories</a> -->
                        <?php
                        }
                
                    ?>
                    </div>
                    </div>
                </nav>
            </header>

            
            <!-- c'est ici que les messages (erreur ou succès) s'affichent-->
            <div id="flash-message">

           
            <?php if ($error_message = App\Session::getFlash("error")) : ?>
                <h3  class="message error"><?= $error_message ?></h3>
            <?php endif; ?>

            <?php if ($success_message = App\Session::getFlash("success")) : ?>
                <h3  class="message success"><?= $success_message ?></h3>
            <?php endif; ?>
            
            </div>


            <main id="forum">
                <?= $page ?>
            </main>

        </div>
        <footer>
            <p>&copy; 2020 - Forum CDA - <a href="/home/forumRules.html">Règlement du forum</a> - <a href="">Mentions légales</a></p>
            <!--<button id="ajaxbtn">Surprise en Ajax !</button> -> cliqué <span id="nbajax">0</span> fois-->
        </footer>
    </div>
    <!-- <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous">
    </script> -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    
    <script>


        // fonction pour afficher les messages flash pendant 9 secondes
        function displayMessage() {
            const message = document.getElementById('flash-message');
            const duration = 9000;
            message.classList.add('flash-message-show');

            setTimeout(function() {
                message.classList.remove('flash-message-show');

            }, duration);
        }

        displayMessage();

       
   
        
// function validateForm() {
//     var isValid = true; // Initialisez une variable pour suivre si le formulaire est valide
// consol.log("hello");
//     // Réinitialisez les messages d'erreur à chaque soumission
//     document.getElementById('pseudo-error').textContent = '';
//     document.getElementById('email-error').textContent = '';
//     document.getElementById('password-error').textContent = '';

//     // Récupérez les valeurs des champs
//     var pseudo = document.getElementById('pseudo').value;
//     var email = document.getElementById('email').value;
//     var password = document.getElementById('password').value;
//     var confirmPassword = document.getElementById('confirmPassword').value;

//     // Vérifiez si le mot de passe a au moins 12 caractères
//     if (password.length < 12) {
//         document.getElementById('password-error').textContent = "Mot de passe invalide : il doit contenir au moins 12 caractères.";
//         isValid = false;
//     }

//     // Ici, vous pouvez ajouter des vérifications supplémentaires, par exemple, vérifier si le pseudo ou l'email existent déjà en BDD.
//     // Vous devrez peut-être faire une requête AJAX pour effectuer ces vérifications côté serveur.

//     // Si les vérifications échouent, définissez isValid sur false et affichez les messages d'erreur appropriés.

//     return isValid; // Retourne true si le formulaire est valide, false sinon
// }



    // Fonction du bouton checkbox

    // Sélectionnez toutes les cases à cocher personnalisées
    const customCheckboxes = document.querySelectorAll('.custom-checkbox');

    // Ajoutez un gestionnaire d'événements de clic à chaque case à cocher
    customCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('click', () => {
        // Vérifiez si la case à cocher a la classe 'verrouille'
        if (checkbox.classList.contains('verrouille')) {
        // Si c'est le cas, supprimez la classe 'verrouille' et ajoutez 'actif'
        checkbox.classList.remove('verrouille');
        checkbox.classList.add('actif');
        
        // Changez le texte de 'verrouillé' à 'actif'
        const label = checkbox.nextElementSibling; // Sélectionnez l'élément de texte suivant (label)
        label.textContent = 'actif';
        } else {
        // Si la case à cocher n'a pas la classe 'verrouille', faites l'inverse
        checkbox.classList.remove('actif');
        checkbox.classList.add('verrouille');
        
        // Changez le texte de 'actif' à 'verrouillé'
        const label = checkbox.nextElementSibling; // Sélectionnez l'élément de texte suivant (label)
        label.textContent = 'verrouillé';
        }
    });
    });


    // Fonction pour afficher le bouton "modifier" uniquement lorsqu'on clique sur le bouton checkbox
    // Sélectionnez toutes les paires de cases à cocher et de boutons submit
    const checkboxFormPairs = document.querySelectorAll('.form-checkbox');

    // Bouclez à travers chaque paire
    checkboxFormPairs.forEach(pair => {
        // Sélectionnez la case à cocher et le bouton submit pour cette paire
        const customCheckbox = pair.querySelector('.custom-checkbox');
        const submitButton = pair.querySelector('.submit-checkbox');

        // Ajoutez un gestionnaire d'événements de changement (change) à la case à cocher
        customCheckbox.addEventListener('change', () => {
            // Vérifiez si la case à cocher est cochée
            if (customCheckbox.checked) {
                // Affichez le bouton submit correspondant
                submitButton.style.display = 'block';
            } else {
                // Masquez le bouton submit correspondant
                submitButton.style.display = 'none';
            }
        });
    });


    const passwordInput = document.getElementById('password-input');
  const showPasswordIcon = document.getElementById('show-password');
  const linkShowPassWordIcon = document.getElementById('password-p');

  linkShowPassWordIcon.addEventListener('click', () => {
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      showPasswordIcon.classList.remove('fa-eye');
      showPasswordIcon.classList.add('fa-eye-slash');
    } else {
      passwordInput.type = 'password';
      showPasswordIcon.classList.remove('fa-eye-slash');
      showPasswordIcon.classList.add('fa-eye');
    }
  });


        // $(document).ready(function(){
        //     $(".message").each(function(){
        //         if($(this).text().length > 0){
        //             $(this).slideDown(500, function(){
        //                 $(this).delay(3000).slideUp(500)
        //             })
        //         }
        //     })
        //     $(".delete-btn").on("click", function(){
        //         return confirm("Etes-vous sûr de vouloir supprimer?")
        //     })
        //     tinymce.init({
        //         selector: '.post',
        //         menubar: false,
        //         plugins: [
        //             'advlist autolink lists link image charmap print preview anchor',
        //             'searchreplace visualblocks code fullscreen',
        //             'insertdatetime media table paste code help wordcount'
        //         ],
        //         toolbar: 'undo redo | formatselect | ' +
        //         'bold italic backcolor | alignleft aligncenter ' +
        //         'alignright alignjustify | bullist numlist outdent indent | ' +
        //         'removeformat | help',
        //         content_css: '//www.tiny.cloud/css/codepen.min.css'
        //     });
        // })

        

        /*
        $("#ajaxbtn").on("click", function(){
            $.get(
                "index.php?action=ajax",
                {
                    nb : $("#nbajax").text()
                },
                function(result){
                    $("#nbajax").html(result)
                }
            )
        })*/
    </script>
</body>
</html>