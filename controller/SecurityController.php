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

class SecurityController extends AbstractController implements ControllerInterface
{

    public function index()
    {

        $topicManager = new TopicManager();

        return [
            "view" => VIEW_DIR . "forum/listTopics.php",
            "data" => [
                "topics" => $topicManager->findAll(["creationdate", "DESC"])
            ]
        ];
    }


    /************************************* ADMIN ************************************** */

    // fonction pour lister tous les utilisateurs
    public function listUsers()
    {

        $manager = new UserManager;
        $users = $manager->findAll(['creationDate', 'DESC']);

        return [
            "view" => VIEW_DIR . "security/listUsers.php",
            "data" => [
                "users" => $users,
                "title" => "Liste des utilisateurs",
                "description" => "Liste de tous les utilisateurs du forum"
            ]
        ];
    }


    /************************************* S'INSCRIRE ************************************** */


    // fonction pour rediriger vers le formulaire d'inscription
    public function registerForm()
    {

        return [
            "view" => VIEW_DIR . "security/register.php", // vue pour afficher le formulaire
            "data" => [
                "title" => "Inscription",
                "description" => "Formulaire d'inscription au forum"
            ]
            
        ];
    }


    // fonction d'inscription
    public function register()
    {
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



    /************************************* SE CONNECTER ************************************** */


    // fonction pour rediriger vers le formulaire de de connexion
    public function loginForm()
    {

        return [
            "view" => VIEW_DIR . "security/login.php", // vue pour afficher le formulaire 
            "data" => [
                "title" => "Connexion",
                "description" => "Formulaire de connexion au forum"
            ]
            
        ];
    }


    // fonction pour se connecter
    public function login()
    {

        if (isset($_POST['submit'])) {
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // on va d'abord vérifié si le filtrage s'est bien passé
            if ($email && $password) {

                // on va instancier le UserManager pour vérifier que j'ai bien un user avec cet email
                $userManager = new UserManager();

                $user = $userManager->findOneByEmail($email);

                // si un user avec cet email existe 
                if ($user) {
                    // si l'utilisateur n'est pas banni, on continue
                    if ($user->getIsClosed() == 0) {

                        // on vérifie si le mot de passe fourni correspond au mot de passe haché enregistré
                        $userId = $user->getPassword();

                        // password_verify va comparer 2 chaînes de caractère hachées
                        if (password_verify($password, $userId)) {
                            // on met le user dans la session pour le maintenir connecté
                            Session::setUser($user);
                            Session::addFlash('success', "<i class='fa-solid fa-square-check'></i> Connexion réussie !");
                            $this->redirectTo("forum", "home");
                        } else {
                            Session::addFlash('error', "<i class='fa-solid fa-circle-exclamation'></i> Mot de passe incorrect. Veuillez réessayer.");
                            return $this->redirectTo("security", "loginForm");
                        }
                    } else {
                        Session::addFlash('error', "<i class='fa-solid fa-circle-exclamation'></i> Vous avez été banni du forum, vous ne pouvez plus vous connecter");
                        return $this->redirectTo("security", "loginForm");
                    }
                } else {
                    Session::addFlash('error', "<i class='fa-solid fa-circle-exclamation'></i> Aucun utilisateur avec cet email n'a été trouvé.");
                    return $this->redirectTo("security", "loginForm");
                }
            }
        }
    }


    // fonction pour se déconnecter
    public function logout()
    {

        unset($_SESSION['user']);
        $this->redirectTo("forum", "listCategories");
    }



    /************************************* PROFILE ************************************** */

    // fonction pour voir son profil
    public function viewProfile($id)
    {

        $userManager = new UserManager;

        $user = $userManager->findOneById($id);

        return [
            "view" => VIEW_DIR . "security/viewProfile.php",
            "data" => [
                "user" => $user,
                "title" => "Mon profil",
                "description" => "Information concernant mon profil"
            ]
        ];
    }


    // fonction pour modifier son pseudo
    public function updatePseudo($id)
    {

        $userManager = new UserManager();

        if (isset($_POST['submit'])) {

            $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($pseudo) {
                $userManager->update(["pseudo" => $pseudo, "id" => $id]);
                Session::addFlash('success', "<i class='fa-solid fa-square-check'></i> Pseudo modifié !");
                $this->redirectTo("security", "viewProfile", $id);
            } else {
                Session::addFlash('error', "<i class='fa-solid fa-circle-exclamation'></i> Erreur lors de la modification du pseudo");
                $this->redirectTo("security", "viewProfile", $id);
            }
        }
    }


    // fonction pour modifier son email
    public function updateEmail($id)
    {

        $userManager = new UserManager();

        if (isset($_POST['submit'])) {

            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);

            if ($email) {
                $userManager->update(["email" => $email, "id" => $id]);
                Session::addFlash('success', "<i class='fa-solid fa-square-check'></i> Email modifié !");
                $this->redirectTo("security", "viewProfile", $id);
            } else {
                Session::addFlash('error', "<i class='fa-solid fa-circle-exclamation'></i> Erreur lors de la modification de l'adresse email");
                $this->redirectTo("security", "viewProfile", $id);
            }
        }
    }

    // fonction pour modifier son mot de passe
    public function updatePassword($id)
    {

        if (isset($_POST['submit'])) {

            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $newPassword = filter_input(INPUT_POST, "newPassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $confirmNewPassword = filter_input(INPUT_POST, "confirmNewPassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // si les 2 mots de passe correspondent
            if ($newPassword == $confirmNewPassword) {

                $userManager = new UserManager();
                // on cherche les infos de l'utilisateur
                $user = $userManager->findOneById($id);
                // on cherche le mdp
                $passwordHash = $user->getPassword();

                // on vérifie que le mdp saisis et identique au mdp en BDD
                if (password_verify($password, $passwordHash)) {
                    // on hashe le nouveau mdp
                    $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                    // on remplace le mdp par le nouveau
                    $userManager->update(["password" => $newPasswordHash, "id" => $id]);
                    Session::addFlash('success', "<i class='fa-solid fa-square-check'></i> Mot de passe modifié !");
                    $this->redirectTo("security", "viewProfile", $id);
                } else {
                    Session::addFlash('error', "<i class='fa-solid fa-circle-exclamation'></i> Mot de passe inconnu");
                }
            } else {
                Session::addFlash('error', "<i class='fa-solid fa-circle-exclamation'></i> Les mots de passes ne sont pas identiques, veuillez les saisir à nouveau");
            }
        }
    }


    /************************************* LOCK ************************************** */


    // fonction pour verrouiller ou déverouiller un utilisateur
    public function closedUser($id)
    {

        // on instancie la classe
        $userManager = new UserManager;
        // on récupére l'état actuel de l'utilisateur (0 s'il est actif, 1 s'il est verouillé)
        $user = $userManager->findOneById($id)->getIsClosed();

        // si le formulaire a été envoyé
        if (isset($_POST["submit"])) {
            // on vérifie si la case à cocher à été cochée
            if (isset($_POST["isClosed"])) {

                // on change l'état en changeant la valeur de isClosed
                if ($user == 0) {
                    $userManager->update(["id" => $id, "isClosed" => 1]);
                    Session::addFlash('success', "<i class='fa-solid fa-square-check'></i> Modification effectuée !");
                    $this->redirectTo("security", "listUsers");
                } else {
                    $userManager->update(["id" => $id, "isClosed" => 0]);
                    Session::addFlash('success', "<i class='fa-solid fa-square-check'></i> Modification effectuée !");
                    $this->redirectTo("security", "listUsers");
                }
            } else {
                Session::addFlash('error', "<i class='fa-solid fa-circle-exclamation'></i> Echec de la modification");
                $this->redirectTo("security", "listUsers");
            }
        }
    }


    // fonction pour verouillé ou déverouiller un topic
    public function closedAndOpenTopic($id)
    {

        $topicManager = new TopicManager;
        // on récupére l'état actuel du topic (0 s'il est actif, 1 s'il est verouillé)
        $topic = $topicManager->findOneById($id)->getIsClosed();

        // on récupère l'id de la catégorie pour la redirection
        $idCategory = $topicManager->findOneById($id)->getCategory()->getId();

        // on change l'état en changeant la valeur de isClosed
        if ($topic == 0) {
            $topicManager->update(["id" => $id, "isClosed" => 1]);
            Session::addFlash('success', "<i class='fa-solid fa-square-check'></i> Topic verouillé !");
        } else {
            $topicManager->update(["id" => $id, "isClosed" => 0]);
            Session::addFlash('success', "<i class='fa-solid fa-square-check'></i> Topic déverouillé !");
        }

        // redirection vers la liste des topics par catégorie après la mise à jour
        $this->redirectTo("forum", "listTopicsByIdCategory", $idCategory);
    }
}
