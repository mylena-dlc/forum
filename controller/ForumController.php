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

/**
 * ForumController class
 * Manages forum-related actions such as viewing categories, topics, posts, and handling search.
 */

class ForumController extends AbstractController implements ControllerInterface
{

    /**
     * Displays a list of all categories with the number of topics in each.
     *
     * @return array An array containing the view path and the data to be displayed in the view.
     */

    public function index()
    {
        // Instantiate the CategoryManager to interact with the category data
        $manager = new CategoryManager;

        // Retrieve all categories sorted by label in ascending order, along with the number of topics in each
        $categories = $manager->findAllPlusNbTopic(["label", "ASC"]);

        // Return the view and data to be displayed
        return [
            "view" => VIEW_DIR . "forum/listCategories.php",
            "data" => [
                "categories" => $categories,
                "title" => "Liste des catégories",
                "description" => "Liste de toutes les catégories du forum"
            ]
        ];
    }

    /**
     * Displays the home page of the forum.
     *
     * @return array An array containing the view path and the data to be displayed in the view.
     */

    public function home()
    {
        // Return the view and data for the forum home page
        return [
            "view" => VIEW_DIR . "forum/home.php",
            "data" => [
                "title" => "Accueil",
                "description" => "Page d'accueil du forum"
            ]
        ];
    }

    /**
     * Manages the header search function, 
     * Category and topic search 
     *
     * @return array An array containing the view path and the search results if a search query is submitted.
     */

    public function search() {

        // Instantiate the CategoryManager and TopicManager for searching categories and topics
        $categoryManager = new CategoryManager;
        $topicManager = new TopicManager;

        // Check if the search form has been submitted
        if (isset($_POST['submit'])) {

            // Sanitize the search query to prevent XSS attacks
            $query = filter_input(INPUT_POST, "query", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Search for categories and topics matching the query
            $categories = $categoryManager->searchCategory($query);
            $topics = $topicManager->searchTopic($query);

            // Return the view and search results
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


    /**
     * Displays a list of all categories with the number of topics in each on the category page 
     *
     * @return array An array containing the view path and the data to be displayed in the view.
     */
   
    public function listCategories()
    {
        // Instantiate the CategoryManager to interact with the category data
        $manager = new CategoryManager;
        
        // Retrieve all categories sorted by label in ascending order, along with the number of topics in each
        $categories = $manager->findAllPlusNbTopic(["label", "ASC"]);

        // Return the view and data to be displayed
        return [
            "view" => VIEW_DIR . "forum/listCategories.php",
            "data" => [
                "categories" => $categories,
                "title" => "Liste des catégories", 
                "description" => "Liste de toutes les catégories du forum" 
            ]
        ];
    }


    /**
     * Adds a new category to the forum.
     */

    public function addCategory()
    {
        // Instantiate the CategoryManager to interact with the category data
        $manager = new CategoryManager;

        // Check if the form has been submitted
        if (isset($_POST['submit'])) {

            // Sanitize the label input to prevent XSS attacks
            $label = filter_input(INPUT_POST, "label", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Check if a picture has been uploaded
            if (isset($_FILES['picture'])) {

                // Ensure the picture size is within the allowed limit (200 KB)
                if ($_FILES["picture"]["size"] <= 200 * 1024) {
                    $target_dir = "public/upload/";
                    $file_name = $_FILES["picture"]["name"]; 
                    $file_extension = pathinfo($file_name, PATHINFO_EXTENSION); 

                    // Define allowed file extensions
                    $extensions = array("jpg", "jpeg", "png", "gif");
                    
                    // Check if the file extension is allowed
                    if (in_array(strtolower($file_extension), $extensions)) {

                        $unique_id = uniqid(); 
                        $pictureName = $unique_id . '.' . $file_extension;
                        $picture = $target_dir . $pictureName;

                       // Move the uploaded file to the target directory
                        move_uploaded_file($_FILES['picture']['tmp_name'], $picture);
                    
                    } else {
                        // Add an error flash message if the file extension is not allowed
                        Session::addFlash('error', "Seuls les fichiers JPEG, PNG et GIF sont autorisés");
                        $this->redirectTo("forum", "listCategories");
                    }
                } else {
                    // Add an error flash message if the file is too large
                    Session::addFlash('error', "Le fichier est trop volumineux. La taille maximale autorisée est de 200 Ko.");
                    $this->redirectTo("forum", "listCategories");
                }
            }
            // Add the category to the database if the label and picture are valid
            if ($label && $picture) {

                $categories = $manager->add(["label" => $label, "picture" => $pictureName]);
                if ($categories) {
                    // Add a success flash message if the category is added successfully
                    Session::addFlash('success', "<i class='fa-solid fa-square-check'></i> Catégorie ajoutée !");
                } else {
                    // Add an error flash message if there is an error adding the category
                    Session::addFlash('error', "Erreur lors de l'ajout de la catégorie !");
                }
                // Redirect to the list of categories
                $this->redirectTo("forum", "listCategories");
            }
        }
    }


    /**
     * Deletes a category from the forum
     *
     * @param int $id The ID of the category to delete
     */   

    public function deleteCategory($id) {

        // Instantiate the CategoryManager to interact with the category data
        $manager = new CategoryManager;

        // Find the category to delete by its ID
        $category = $manager->findOneById($id);

        // Construct the path to the category's picture
        $picture = "public/upload/" . $category->getPicture($id);
    
        // Check if the picture file exists and delete it
        if (file_exists($picture)) {
            unlink($picture);
        }

        // Delete the category from the database
        $category = $manager->delete($id);

            // Add a flash message based on the result of the deletion
            if ($category) {
                Session::addFlash('success', "<i class='fa-solid fa-square-check'></i> La catégorie a été supprimée !");
            } else {
                Session::addFlash('error', "<i class='fa-solid fa-circle-exclamation'></i>Echec lors de la suppression de la catégorie ");
            }

            // Redirect to the list of categories
            $this->redirectTo("forum", "listCategories");
    }


    /**
     * Displays the form for updating a category
     *
     * @param int $id The ID of the category to update
     * @return array An associative array containing the view and data for the update form
     */

    public function updateCategoryForm($id)
    {
        // Instantiate the CategoryManager to interact with the category data
        $manager = new CategoryManager;

        // Retrieve the category object by its ID
        $category = $manager->findOneById($id);

        // Return the view and data to be displayed
        return [
            "view" => VIEW_DIR . "forum/updateCategory.php", 
            "data" => [  
                "category" => $category, 
                "title" => "Modification catégorie",
                "description" => "Formulaire de modification d'une catégorie"
            ]
        ];
    }

    /**
     * Updates a category with new data
     *
     * @param int $id The ID of the category to update
     */
    public function updateCategory(int $id) {

        // Instantiate the CategoryManager to interact with the category data
        $manager = new CategoryManager;

        // Check if the form has been submitted
        if (isset($_POST['submit'])) {
            // Sanitize the label input to prevent XSS attacks
            $label = filter_input(INPUT_POST, "label", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Check if a picture has been uploaded
            if (isset($_FILES['picture'])) {

                // Ensure the picture size is within the allowed limit (200 KB)
                if ($_FILES["picture"]["size"] <= 200 * 1024) {
                    $target_dir = "public/upload/"; 
                    $file_name = $_FILES["picture"]["name"]; 
                    $file_extension = pathinfo($file_name, PATHINFO_EXTENSION); 

                    // Define allowed file extensions
                    $extensions = array("jpg", "jpeg", "png", "gif");
                    
                    // Check if the file extension is allowed
                    if (in_array(strtolower($file_extension), $extensions)) {

                        $unique_id = uniqid(); 
                        $pictureName = $unique_id . '.' . $file_extension;
                        $picture = $target_dir . $pictureName;

                       // Move the uploaded file to the target directory
                        move_uploaded_file($_FILES['picture']['tmp_name'], $picture);

                    } else {
                        // Add an error flash message if the file extension is not allowed
                        Session::addFlash('error', "Seuls les fichiers JPEG, PNG et GIF sont autorisés");
                        $this->redirectTo("forum", "listCategories");
                    }
                } else {
                    // Add an error flash message if the file is too large
                    Session::addFlash('error', "Le fichier est trop volumineux. La taille maximale autorisée est de 200 Ko.");
                    $this->redirectTo("forum", "listCategories");
                }
            }

            // Add the category to the database if the label and picture are valid
            if ($label && $picture) {

                $categories = $manager->update(["id" => $id, "label" => $label, "picture" => $pictureName]);

                if ($categories) {
                 // Add a success flash message if the category is added successfully
                    Session::addFlash('success', "<i class='fa-solid fa-square-check'></i> La catégorie a été modifiée !");
                } else {
                    // Add an error flash message if there is an error adding the category
                    Session::addFlash('error', "<i class='fa-solid fa-circle-exclamation'></i>  Echec lors de la modification de la catégorie");
                }
                // Redirect to the list of categories
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
