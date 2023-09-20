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

class ForumController extends AbstractController implements ControllerInterface
{

    public function index()
    {
        $manager = new CategoryManager;

        $categories = $manager->findAllPlusNbTopic(["label", "ASC"]);

        return [
            "view" => VIEW_DIR . "forum/listCategories.php",
            "data" => [
                "categories" => $categories,
                "title" => "Liste des catégories",
                "description" => "Liste de toutes les catégories du forum"
            ]
        ];
    }


    public function home()
    {
        return [
            "view" => VIEW_DIR . "forum/home.php",
            "data" => [
                "title" => "Accueil",
                "description" => "Page d'accueil du forum"
            ]
        ];
    }

    /************************************* Recherche ************************************** */

    public function search() {

        $categoryManager = new CategoryManager;
        $topicManager = new TopicManager;

       
        if (isset($_POST['submit'])) {
            // on recupère la requête de recherche à partir de la variable $_POST['query'].
            $query = filter_input(INPUT_POST, "query", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $categories = $categoryManager->searchCategory($query);

            $topics = $topicManager->searchTopic($query);

         


            return [
                "view" => VIEW_DIR . "forum/search.php",
                "data" => [
                    "categories" => $categories,
                    "topics" => $topics,
                    "title" => "Recherche", 
                    "description" => "Résultat de la recherche" 
                ]
            ];

        }
    }


    /************************************* Catégorie ************************************** */

    // fonction pour lister toutes les catégories du forum
    public function listCategories()
    {

        $manager = new CategoryManager;
        // on récupère toutes les catégories avec le nombre de sujets associés trié par leur nom
        $categories = $manager->findAllPlusNbTopic(["label", "ASC"]);

        // retourne un tableau avec les informations pour le contenu de la vue
        return [
            "view" => VIEW_DIR . "forum/listCategories.php",
            "data" => [
                "categories" => $categories, // liste des catégorie
                "title" => "Liste des catégories", // titre de la page
                "description" => "Liste de toutes les catégories du forum" // description
            ]
        ];
    }


    // fonction pour ajouter une catégorie
    public function addCategory()
    {

        $manager = new CategoryManager;

        // on vérifie ce qui arrive en POST
        if (isset($_POST['submit'])) {
            $label = filter_input(INPUT_POST, "label", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (isset($_FILES['picture'])) {
                // on vérifie si la taille du fichier est inférieure à 200 Ko (200 * 1024 octets)
                if ($_FILES["picture"]["size"] <= 200 * 1024) {
                    $target_dir = "public/upload/"; // chemin vers le dossier upload
                    $file_name = $_FILES["picture"]["name"]; // extrait le nom original du fichier
                    $file_extension = pathinfo($file_name, PATHINFO_EXTENSION); // recupère l'extension du fichier

                    // Tableau des extensions autorisées
                    $extensions = array("jpg", "jpeg", "png", "gif");
                    
                    // on vérifie si l'extension du fichier est autorisée
                    if (in_array(strtolower($file_extension), $extensions)) {

                        $unique_id = uniqid(); // genère un ID unique
                    
                        // nouveau nom de fichier en ajoutant l'ID unique et l'extension
                        $pictureName = $unique_id . '.' . $file_extension;
                    
                        // chemin complet pour le nouveau fichier
                        $picture = $target_dir . $pictureName;

                        // on déplace le fichier téléchargé vers le dossier d'upload avec le nouveau nom de fichier
                        move_uploaded_file($_FILES['picture']['tmp_name'], $picture);
                        
                        // Maintenant, $picture contient le chemin complet vers le fichier téléchargé avec l'ID unique dans le dossier d'upload.

                    } else {
                        // l'extension du fichier n'est pas autorisée
                        Session::addFlash('error', "Seuls les fichiers JPEG, PNG et GIF sont autorisés");
                        $this->redirectTo("forum", "listCategories");
                    }
                } else {
                    // le fichier dépasse la limite de 2 Ko
                    Session::addFlash('error', "Le fichier est trop volumineux. La taille maximale autorisée est de 200 Ko.");
                    $this->redirectTo("forum", "listCategories");
                }

            }

            // si on récupère bien le nom et l'image de la cétégorie
            if ($label && $picture) {

                // on ajoute un tableau avec les nouvelles données
                $categories = $manager->add(["label" => $label, "picture" => $pictureName]);
                if ($categories) {
                    Session::addFlash('success', "<i class='fa-solid fa-square-check'></i> Catégorie ajoutée !");
                } else {
                    Session::addFlash('error', "Erreur lors de l'ajout de la catégorie !");
                }

                // puis on redirige vers la vue listCategories
                $this->redirectTo("forum", "listCategories");
            }
        }
    }


    // fonction pour supprimer une catégorie
    public function deleteCategory($id) {

        $manager = new CategoryManager;

        // on recupère la catégorie qu'on veut supprimer
        $category = $manager->findOneById($id);
        // on construit le chemin complet jusqu'à l'image dans le dossier upload
        $picture = "public/upload/" . $category->getPicture($id);

        // si le fichier existe, alors on le supprime
        if (file_exists($picture)) {
            unlink($picture);
        }

        // puis on supprime la catégorie de la BDD
        $category = $manager->delete($id);

        // si la catégorie a bein été supprimée
            if ($category) {
                Session::addFlash('success', "<i class='fa-solid fa-square-check'></i> La catégorie a été supprimée !");
            } else {
                Session::addFlash('error', "<i class='fa-solid fa-circle-exclamation'></i>Echec lors de la suppression de la catégorie ");
            }

        $this->redirectTo("forum", "listCategories");
    }


    // fonction pour rediriger vers le formulaire de modification
    public function updateCategoryForm($id)
    {
        // création d'une instance de classe 
        $manager = new CategoryManager;
        // récupération de l'id de la catégorie
        $category = $manager->findOneById($id);
        // préparation des données à retourner sous forme d'un tableau assosiatif
        return [
            "view" => VIEW_DIR . "forum/updateCategory.php", // vue pour afficher le formulaire
            "data" => [  // La clé "data" contient un tableau associatif contenant les données à transmettre à la vue
                "category" => $category, // La clé "category" contient l'objet de catégorie récupéré précédemment, qui sera accessible dans la vue
                "title" => "Modification catégorie",
                "description" => "Formulaire de modification d'une catégorie"
            ]
        ];
    }

    // fonction pour modifier une catégorie
    public function updateCategory($id) {

        $manager = new CategoryManager;

        // on vérifie ce qui arrive en POST
        if (isset($_POST['submit'])) {
            $label = filter_input(INPUT_POST, "label", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (isset($_FILES['picture'])) {
                // on vérifie si la taille du fichier est inférieure à 200 Ko (200 * 1024 octets)
                if ($_FILES["picture"]["size"] <= 200 * 1024) {
                    $target_dir = "public/upload/"; // chemin vers le dossier upload
                    $file_name = $_FILES["picture"]["name"]; // extrait le nom original du fichier
                    $file_extension = pathinfo($file_name, PATHINFO_EXTENSION); // recupère l'extension du fichier

                    // Tableau des extensions autorisées
                    $extensions = array("jpg", "jpeg", "png", "gif");
                    
                    // on vérifie si l'extension du fichier est autorisée
                    if (in_array(strtolower($file_extension), $extensions)) {

                        $unique_id = uniqid(); // genère un ID unique
                    
                        // nouveau nom de fichier en ajoutant l'ID unique et l'extension
                        $pictureName = $unique_id . '.' . $file_extension;
                    
                        // chemin complet pour le nouveau fichier
                        $picture = $target_dir . $pictureName;

                        // on déplace le fichier téléchargé vers le dossier d'upload avec le nouveau nom de fichier
                        move_uploaded_file($_FILES['picture']['tmp_name'], $picture);
                        // Maintenant, $picture contient le chemin complet vers le fichier téléchargé avec l'ID unique dans le dossier d'upload.

                    } else {
                        // l'extension du fichier n'est pas autorisée
                        Session::addFlash('error', "Seuls les fichiers JPEG, PNG et GIF sont autorisés");
                        $this->redirectTo("forum", "listCategories");
                    }
                } else {
                    // le fichier dépasse la limite de 2 Ko
                    Session::addFlash('error', "Le fichier est trop volumineux. La taille maximale autorisée est de 200 Ko.");
                    $this->redirectTo("forum", "listCategories");
                }
            }

            // si les variables ont bien été filtrées
            if ($label && $picture) {

                // on remplace avec les nouvelles données
                $categories = $manager->update(["id" => $id, "label" => $label, "picture" => $pictureName]);

                if ($categories) {
                    Session::addFlash('success', "<i class='fa-solid fa-square-check'></i> La catégorie a été modifiée !");
                } else {
                    Session::addFlash('error', "<i class='fa-solid fa-circle-exclamation'></i>  Echec lors de la modification de la catégorie");
                }
                // puis on redirige vers la vue listCategories
                $this->redirectTo("forum", "listCategories");
            }
        }
    }



    /************************************* Topic ************************************** */


    // fonction pour lister tous les topics pour une catégorie
    public function listTopicsByIdCategory($id) {

        $topicManager = new TopicManager;
        $categoryManager = new CategoryManager;
        $postManager = new PostManager;

        $topics = $topicManager->listTopicById($id);

        $category = $categoryManager->findOneById($id);

        return [
            "view" => VIEW_DIR . "forum/detailCategory.php",
            "data" => [
                "topics" => $topics,
                "category" => $category,
                "title" => "Liste des sujets",
                "description" => "Liste de tous les sujets du forum par catégorie"
            ]
        ];
    }


    // fonction pour ajouter un sujet à une categorie 
    public function addTopic($id) {

        $manager = new TopicManager;
        $postManager = new PostManager;

        $user = Session::getUser(); // on ajoute l'id user de l'utilisateur connecté

        // on vérifie ce qui arrive en POST
        if (isset($_POST['submit'])) {
            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (!empty($text)) {
                // on ajoute un tableau avec les nouvelles données du topic
                $idTopic = $manager->add(["title" => $title, "category_id" => $id, "user_id" => $user->getId()]);

                // on récupère le nouvel Id créé automatiquement grâce à la fonction InsertInto de la fonction add

                // on ajoute un tableau avec les nouvelles données du 1er post
                $posts = $postManager->add(['text' => $text, "topic_id" => $idTopic, "user_id" => $user->getId()]);

                if ($posts) {
                    Session::addFlash('success', "<i class='fa-solid fa-square-check'></i> Sujet ajouté !");
                    $this->redirectTo("forum", "listTopicsByIdCategory", $id);
                } else {
                    Session::addFlash('error', "Erreur lors de l'ajout du sujet !");
                    $this->redirectTo("forum", "listCategories");
                }
            } else {
                Session::addFlash('error', "<i class='fa-solid fa-square-check'></i> Il faut ajouter le premier commentaire !");
                $this->redirectTo("forum", "listTopicsByIdCategory", $id);
            }
        }
    }


    // fonction pour supprimer un topic
    public function deleteTopic($id)
    {

        $categoryManager = new CategoryManager;
        $topicManager = new TopicManager;

        // on cherche l'id de la catégorie du topic
        $topic = $topicManager->findOneById($id);
        $idCategory = $topic->getCategory()->getId();

        // on supprime le topic
        $topic = $topicManager->delete($id);

        if ($topic) {
            Session::addFlash('success', "<i class='fa-solid fa-square-check'></i> Le sujet a été supprimé !");
            $this->redirectTo("forum", "listTopicsByIdCategory", $idCategory);
        } else {
            Session::addFlash('error', "<i class='fa-solid fa-circle-exclamation'></i>Echec lors de la suppression du sujet");
            $this->redirectTo("forum", "listTopicsByIdCategory", $idCategory);
        }
    }


    // fonction pour rediriger vers le formulaire de modification d'un topic
    public function updateTopicForm($id) {

        $manager = new TopicManager;
        // récupération de l'id du topic
        $topic = $manager->findOneById($id);
        // préparation des données à retourner sous forme d'un tableau assosiatif
        return [
            "view" => VIEW_DIR . "forum/updateTopic.php", // vue pour afficher le formulaire
            "data" => [  // La clé "data" contient un tableau associatif contenant les données à transmettre à la vue
                "topic" => $topic, // La clé "category" contient l'objet de catégorie récupéré précédemment, qui sera accessible dans la vue
                "title" => "Modification d'un sujet",
                "description" => "Formulaire de modification d'un sujet"
            ]
        ];
    }

    // fonction pour modifier un topic
    public function updateTopic($id) {

        $topicManager = new TopicManager;
        $postManager = new PostManager;

        $user = Session::getUser(); // on ajoute l'id user de l'utilisateur connecté

        // on cherche l'id de la catégorie de ce topic (pour la redirection)
        $topic = $topicManager->findOneById($id);
        $idCategory = $topic->getCategory()->getId();

        // on vérifie ce qui arrive en POST
        if (isset($_POST['submit'])) {
            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $id = $_POST['id_topic']; // input type hidden

            // on filtre le premier post
            $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // si les règles de validation du formulaire sont respectées
            if ($title && $id && $text) {

                // on remplace avec les nouvelles données du topic
                $topic = $topicManager->update(["title" => $title, "id" => $id, "user_id" => $user->getId()]);

                $idPost = $postManager->findOneById($id);

                // on remplace avec les nouvelles données le 1er post
                $posts = $postManager->update(['text' => $text, "topic_id" => $id, "id" => $idPost, "user_id" => $user->getId()]);

                if ($posts) {
                    Session::addFlash('success', "<i class='fa-solid fa-square-check'></i> Le sujet a été modifié !");
                    $this->redirectTo("forum", "listTopicsByIdCategory", $idCategory);
                } else {
                    Session::addFlash('error', "<i class='fa-solid fa-circle-exclamation'></i>  Echec lors de la modification du sujet");
                    $this->redirectTo("forum", "listCategories");
                }
            }
        }
    }

    /************************************* Post ************************************** */


    // fonction pour lister les posts pour un topic
    public function listPostsByIdTopic($id) {

        $manager = new PostManager;
        $topicManager = new TopicManager;

        $posts = $manager->listPostById($id);

        $topic = $topicManager->findOneById($id);

        return [
            "view" => VIEW_DIR . "forum/detailTopic.php",
            "data" => [
                "posts" => $posts,
                "topic" => $topic,
                "title" => "Liste des commentaires",
                "description" => "Tous les commentaires postés par sujet"
            ]
        ];
    }

    // fonction pour ajouter un post à un topic
    public function addPost($id) {

        $manager = new PostManager;

        $topicManager = new TopicManager;

        $user = Session::getUser(); // on ajoute l'id user de l'utilisateur connecté

        // on vérifie ce qui arrive en POST
        if (isset($_POST['submit'])) {
            $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $id = $_POST['topic_id']; // input type hidden

            // on ajoute un tableau avec les nouvelles données
            $post = $manager->add(["text" => $text, "topic_id" => $id, "user_id" => $user->getId()]);

            // on redirige vers la vue détailTopic
            if ($post) {
                Session::addFlash('success', "<i class='fa-solid fa-square-check'></i> Le commentaire a été ajouté !");
                $this->redirectTo("forum", "listPostsByIdTopic", $id);
            } else {
                Session::addFlash('error', "<i class='fa-solid fa-circle-exclamation'></i> Echec lors de l'ajout du commentaire");
                $this->redirectTo("forum", "listPostsByIdTopic", $id);
            }
        }
    }


    // fonction de redirection pour modifier un post
    public function updatePostForm($id) {
        $manager = new PostManager;

        $post = $manager->findOneById($id);

        return [
            "view" => VIEW_DIR . "forum/updatePost.php", // vue pour afficher le formulaire
            "data" => [  // La clé "data" contient un tableau associatif contenant les données à transmettre à la vue
                "post" => $post,
                "title" => "Modification d'un commentaire",
                "description" => "Formulaire de modification d'un commentaire"
            ]
        ];
    }

    // fonction pour modifier un post
    public function updatePost($id) {

        $postManager = new PostManager;
        $topicManager = new TopicManager;

        $user = Session::getUser(); // on ajoute l'id user de l'utilisateur connecté

        // on cherche l'id du topic de ce post (pour la redirection)
        $post = $postManager->findOneById($id);
        $idTopic = $post->getTopic()->getId();

        // on vérifie ce qui arrive en POST
        if (isset($_POST['submit'])) {
            $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // on remplace avec les nouvelles données du post
            $post = $postManager->update(["text" => $text, "id" => $id, "user_id" => $user->getId()]);

            if ($post) {
                Session::addFlash('success', "<i class='fa-solid fa-square-check'></i> Le commentaire a été modifié !");
                $this->redirectTo("forum", "listPostsByIdTopic", $idTopic);
            } else {
                Session::addFlash('error', "<i class='fa-solid fa-circle-exclamation'></i> Echec lors de la modification du commentaire");
                $this->redirectTo("forum", "listPostsByIdTopic", $idTopic);
            }
        }
    }

    // fonction pour supprimer un post
    public function deletePost($id) {

        $topicManager = new TopicManager;
        $postManager = new PostManager;

        // on cherche l'id du topic correspondant pour la redirection
        $post = $postManager->findOneById($id);
        $idTopic = $post->getTopic()->getId();

        // on supprime le post
        $post = $postManager->delete($id);

        if ($post) {
            Session::addFlash('success', "<i class='fa-solid fa-square-check'></i> Le commentaire a été supprimé !");
            $this->redirectTo("forum", "listPostsByIdTopic", $idTopic);
        } else {
            Session::addFlash('error', "<i class='fa-solid fa-circle-exclamation'></i>Echec lors de la suppression du commentaire");
            $this->redirectTo("forum", "listPostsByIdTopic", $idTopic);
        }
    }
}
