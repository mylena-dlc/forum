<?php

    namespace Controller;

    use App\Session;
    use App\AbstractController;
    use App\ControllerInterface;
    use App\Manager;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    use Model\Managers\CategoryManager;
    use Model\Managers\UserManager;
    
    class SecurityController extends AbstractController implements ControllerInterface{

        public function index(){
          
           $topicManager = new TopicManager();

            return [
                "view" => VIEW_DIR."forum/listTopics.php",
                "data" => [
                    "topics" => $topicManager->findAll(["creationdate", "DESC"])
                ]
            ];
        }


        /************************************* Profil ************************************** */

         // fonction pour lister tous les utilisateurs
         public function listUsers(){

            $manager = new UserManager;
            $users = $manager->findAll(['creationDate', 'DESC']);
 
             return [
                 "view" => VIEW_DIR."security/listUsers.php",
                 "data" => [
                     "users" => $users
                 ]
             ];
         }


/************************************* S'inscrire ************************************** */



    // fonction pour rediriger vers le formulaire d'inscription
    public function registerForm() {

        return [
            "view" => VIEW_DIR."security/register.php", // vue pour afficher le formulaire
    
        ];
    }

    // fonction pour s'inscrire
    // public function register() {

    //     // on instancie la classe UserManager
    //     $userManager = new UserManager();

    //     // on récupère les données du formulaire d'inscription, puis on les filtre
    //     if(isset($_POST['submit'])) {
    //         $pseudo = filter_input(INPUT_POST,"pseudo",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //         $email = filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL,FILTER_VALIDATE_EMAIL);
    //         $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //         $confirmPassword = filter_input(INPUT_POST, "confirmPassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS);


    //         // on vérifie si le mot de passe et sa confirmation correspondent et 
    //         // que la longeur de la chaîne de caractère est supérieur ou égale à 12
    //         if (($password == $confirmPassword)and(strlen($password) >= 12)) {
            
    //                 // s'ils correspondent, on hache le mot de passe
    //                 // un password est haché en BDD. Le hashage est un mécanisme unidirectionnel 
    //                 // et irréversible. ON NE DEHASHE JAMAIS UN PASSWORD

    //                 // la fonction pass_word va nous demander l'algorithme de hash choisi. 
    //                 // Les algo a privilégier sont DCRYPT et ARGON2i
    //                 // Ne pas utiliser sha ou md5
    //                 // DCRYPt et ARGON2I fond parti des algo de hash fort
    //                 // sha et md5 fond parti des algos de hash faible
    //                 $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    //                 // password_defaut utilise par défaut l'algo BCRYPT
    //                 // BRYPT est un algo fort comme ARGON2i
    //                 // il va créer une empreinte numérique en BDD composé de l'algo utilisé, d'un cost, d'un salt et du password hashé
    //                 // le salt est une chaîne de caractère aléatoire hashée qui sera concaténé à notre mdp hashé
    //                 // si un pirate récupère notre mdr hashé , il aura + de difficulté à découvrir le mdp d'origine
                
    //         } else { 
    //             Session::addFlash('error', "Mot de passe invalide: il doit contenir au moins 12 caractères. Veuillez les saisir à nouveau.");
    //             $this->redirectTo("security", "register"); 
    //         }

    //             // si on récupère bien un email, un pseudo et le mot de passe haché:
    //                 if($email && $pseudo && $passwordHash ) {

    //                 // si la requête pour vérifier si un email identitque existe en bdd en trouve 0, elle renvoit FALSE, on peut continuer :
    //                     if(!$userManager->findOneByEmail($email)) {

    //                     // si la requête pour vérifier si un pseudo identitque existe en bdd en trouve 0, elle renvoit FALSE, on peut continuer :
    //                         if(!$userManager->findOneByPseudo($pseudo)) {

    //                         // on insére l'utilisateur en bdd
    //                             $user = $userManager->add(["pseudo" => $pseudo, "email" => $email, "password" => $passwordHash, "role" => json_encode("ROLE_USER")]);
                        
    //                         if($user) {
    //                             // Session::setUser($user);
    //                             Session::addFlash('success',"<i class='fa-solid fa-square-check'></i> Inscription validée !" );
    //                             $this->redirectTo("home", "index"); 
    //                         } else {
    //                             Session::addFlash('error',"<i class='fa-solid fa-circle-exclamation'></i>Erreur lors de l'inscription" );
    //                         }

    //                     } else {
    //                         Session::addFlash('error',"<i class='fa-solid fa-circle-exclamation'></i> Pseudo déjà enregistrer, veuillez en choisir un autre" );
    //                     }

    //                 } else {
    //                     Session::addFlash('error',"<i class='fa-solid fa-circle-exclamation'></i> Email déjà enregistrer, veuillez en choisir une autre ou connectez-vous" );
    //                 } 
    //             } else {
    //                 Session::addFlash('error',"<i class='fa-solid fa-circle-exclamation'></i> Email ou pseudo invalide" );
    //             }
    //     }  
    
    //     $this->redirectTo("home", "index");  
    // }
                 
        

    public function register() {
        // On vérifie si le formulaire a été soumis
        if (isset($_POST['submit'])) {
            // On récupère les données du formulaire et on les filtre
            $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $confirmPassword = filter_input(INPUT_POST, "confirmPassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            // Vérifier si le mot de passe et sa confirmation correspondent et ont une longueur d'au moins 12 caractères, une majuscule, une minuscule et un caractère spécial
            // if ($password === $confirmPassword && strlen($password) >= 12 && preg_match('/[a-z]/', $password) && preg_match('/[A-Z]/', $password) && preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $password)) {

            if ($password === $confirmPassword && strlen($password) >= 12) {
                // Hacher le mot de passe
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    
                // Vérifier si l'email et le pseudo sont valides
                if ($email && $pseudo && $passwordHash) {
                    // Instancier la classe UserManager
                    $userManager = new UserManager();
    
                    // Vérifier si un utilisateur avec le même email existe déjà en base de données
                    if (!$userManager->findOneByEmail($email)) {
                        // Vérifier si un utilisateur avec le même pseudo existe déjà en base de données
                        if (!$userManager->findOneByPseudo($pseudo)) {
                            // Insérer l'utilisateur en base de données
                            $user = $userManager->add(["pseudo" => $pseudo, "email" => $email, "password" => $passwordHash, "role" => json_encode("ROLE_USER")]);
    
                            if ($user) {
                                Session::addFlash('success', "<i class='fa-solid fa-square-check'></i> Inscription validée !");
                                header("Location:index.php?ctrl=security&action=loginForm");
                            } else {
                                Session::addFlash('error', "<i class='fa-solid fa-circle-exclamation'></i> Erreur lors de l'inscription");
                                // $this->redirectTo($this->registerForm());
                                header("Location:index.php?ctrl=security&action=registerForm");
                            }
                        } else {
                            // Session::addFlash('error', "<span id='pseudo-error'><i class='fa-solid fa-circle-exclamation'></i> Pseudo déjà enregistré, veuillez en choisir un autre</span>");

                            // Enregistrez également le message d'erreur dans une variable JavaScript
// echo "<script>var pseudoError = 'Pseudo déjà enregistré, veuillez en choisi..';</script>";

                            Session::addFlash('error', "<i class='fa-solid fa-circle-exclamation'></i> Pseudo déjà enregistré, veuillez en choisir un autre");
                            header("Location:index.php?ctrl=security&action=registerForm");
                        }
                    } else {
                        Session::addFlash('error', "<i class='fa-solid fa-circle-exclamation'></i> Email déjà enregistré, veuillez en choisir un autre ou connectez-vous");
                        // $this->redirectTo($this->registerForm());
                        header("Location:index.php?ctrl=security&action=registerForm");
                    }
                } else {
                    Session::addFlash('error', "<i class='fa-solid fa-circle-exclamation'></i> Email, pseudo ou mot de passe invalide");
                    // $this->redirectTo("security", "register");
                    header("Location:index.php?ctrl=security&action=registerForm");
                }
            } else {
                Session::addFlash('error', "Mot de passe invalide : il doit contenir au moins 12 caractères. Veuillez les saisir à nouveau.");
                header("Location:index.php?ctrl=security&action=registerForm");
                // $this->redirectTo($this->registerForm());
            }
        }
    }
    
    


/************************************* Se connecter ************************************** */

    // fonction pour rediriger vers le formulaire de de connexion
    public function loginForm() {
      
        return [
            "view" => VIEW_DIR."security/login.php", // vue pour afficher le formulaire
        ];
    }

    // fonction pour se connecter
    public function login() {

        if(isset($_POST['submit'])) {
            $email = filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL,FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // on va d'abord vérifié si le filtrage s'est bien passé
            if($email && $password) { 

            // on va instancier le UserManager pour vérifier que jai bien un user avec cet email
            $userManager = new UserManager();

            $user = $userManager->findOneByEmail($email);

                // si un user avec cet email existe 
                if ($user) {
                    // si l'utilisateur n'est pas banni, on continue
                    if($user->getIsClosed() == 0) { 
                        $userId = $user->getPassword();
                        // on vérifie si le mot de passe fourni correspond au mot de passe haché enregistré
                        // password_verify va comparer 2 chaînes de caractère hachées

                        if (password_verify($password, $userId)) {

                            // si l'utilisateur n'est pas closed
                            // if($user->getIsCloded() == 0 ) { 

                                // on met le user dans la session pour le maintenir connecté
                                Session::setUser($user);
                                Session::addFlash('success',"<i class='fa-solid fa-square-check'></i> Connexion réussie !");
                                $this->redirectTo("forum", "home");
                            // } else {
                            //     Session::addFlash('error',"<i class='fa-solid fa-circle-exclamation'></i>Utilisateur banni." );
                            //     $this->redirectTo("forum", "listCategories");
                            // }

                        } else {
                            Session::addFlash('error',"<i class='fa-solid fa-circle-exclamation'></i> Mot de passe incorrect. Veuillez réessayer." );
                            return $this->redirectTo("security", "loginForm");
                        }
                    } else {
                        Session::addFlash('error',"<i class='fa-solid fa-circle-exclamation'></i> Vous avez été banni du forum, vous ne pouvez plus vous connecter" );
                        // header("Location:index.php?ctrl=security&action=loginForm"); 
                        return $this->redirectTo("security", "loginForm");
                    }
                } else {
                    Session::addFlash('error',"<i class='fa-solid fa-circle-exclamation'></i> Aucun utilisateur avec cet email n'a été trouvé." );
                    return $this->redirectTo("security", "loginForm");
                }
            }
            // $this->redirectTo("security", "login"); 
        }
    }




        // fonction pour se déconnecter
        public function logout() {

            unset($_SESSION['user']);
            $this->redirectTo("forum", "listCategories");
        }
    


    // fonction pour voir son profil
    public function viewProfile($id) {
        // $categoryManager = new CategoryManager;
        $userManager = new UserManager;

        $user = $userManager->findOneById($id);

        return [
            "view" => VIEW_DIR."security/viewProfile.php",
            "data" => [
                "user" => $user
            ]     
    ];


    }


    /************************************* Lock ************************************** */


    // fonction pour verrouiller ou déverouiller un utilisateur
    public function closedUser($id) {

    // on instancie la classe
    $userManager = new UserManager; 
    // on récupére l'état actuel de l'utilisateur (0 s'il est actif, 1 s'il est verouillé)
    $user = $userManager->findOneById($id)->getIsClosed();

        // si le formulaire a été envoyé
        if(isset($_POST["submit"])) {
            // on vérifie si la case à cocher à été cochée
            if (isset($_POST["isClosed"])) {

                // on change l'état en changeant la valeur de isClosed
                if($user == 0) {
                    $userManager->update(["id" => $id, "isClosed" => 1]);
                } else {
                    $userManager->update(["id" => $id, "isClosed" => 0]);
                }
            }
                // redirection vers la liste des users après la mise à jour
                $this->redirectTo("security", "listUsers");
        }
 }


        // fonction pour verouillé ou déverouiller un topic
        public function closedAndOpenTopic($id) {

            $topicManager = new TopicManager;
            // on récupére l'état actuel du topic (0 s'il est actif, 1 s'il est verouillé)
            $topic = $topicManager->findOneById($id)->getIsClosed();
            
            // on récupère l'id de la catégorie pour la redirection
            $idCategory = $topicManager->findOneById($id)->getCategory()->getId();

                // on change l'état en changeant la valeur de isClosed
                if($topic == 0) {
                    $topicManager->update(["id" => $id, "isClosed" => 1]);
                    Session::addFlash('success',"<i class='fa-solid fa-square-check'></i> Topic verouillé !" );
                } else {
                    $topicManager->update(["id" => $id, "isClosed" => 0]);
                    Session::addFlash('success',"<i class='fa-solid fa-square-check'></i> Topic déverouillé !" );
                }
            
                // redirection vers la liste des topics par catégorie après la mise à jour
                $this->redirectTo("forum", "listTopicsByIdCategory", $idCategory);
        }

}
   





