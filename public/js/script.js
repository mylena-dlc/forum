
// Menu burger 

function toggleMenu() {
    const navbar = document.querySelector(".navbar")
    const burger = document.querySelector(".burger")
    burger.addEventListener('click', () => {
        navbar.classList.toggle('show-nav')
        behavior: "smooth"
    })
}
toggleMenu();


// fonction pour afficher les messages flash pendant 3 secondes
function displayMessage() {
    const messages = document.querySelectorAll('.flash-message');
    const duration = 3000;

    messages.forEach(function(message) {
        message.classList.add('flash-message-show');
    });

    setTimeout(function() {
        messages.forEach(function(message) {
            message.classList.remove('flash-message-show');
        });
    }, duration);
}

displayMessage();

    
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


    // fonction pour afficher le mdp en clair au click
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