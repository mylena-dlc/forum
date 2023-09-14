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
    
    class ForumController extends AbstractController implements ControllerInterface{

        public function index(){
          
            $manager = new CategoryManager;
            // $categories = $manager->findAll();
            $categories = $manager->findAllPlusNbTopic(["label", "ASC"]);
 
             return [
                 "view" => VIEW_DIR."forum/listCategories.php",
                 "data" => [
                     "categories" => $categories
                 ]
             ];
        }

        public function home(){
            return [
                "view" => VIEW_DIR."forum/home.php"
            ];
        }


        /************************************* Catégorie ************************************** */

        // fonction pour lister toutes les catégories
        public function listCategories(){
            
            $manager = new CategoryManager;
            // $categories = $manager->findAll();
            $categories = $manager->findAllPlusNbTopic(["label", "ASC"]);
 
        
             return [
                 "view" => VIEW_DIR."forum/listCategories.php",
                 "data" => [
                     "categories" => $categories
                 ]
             ];
         }


        // fonction pour ajouter une catégorie
        public function addCategory(){

            $manager = new CategoryManager;
            
            // on vérifie ce qui arrive en POST
            if(isset($_POST['submit'])) {
                $label = filter_input(INPUT_POST, "label", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                // variables
                $formValues = null;

                // validation des règles du formulaire
                $isFormValid = true;

                // label est obligatoire
                if ($label == "") {
                    $isFormValid = false;
                    // $errorMessages["label"] = "Ce champ est obligatoire";
                }

                // Vérifiez s'il y a un fichier téléchargé            
                if (isset($_FILES['picture'])) {
                    $target_dir = "public/img/";
                    $picture = $target_dir . basename($_FILES["picture"]["name"]);
                    move_uploaded_file($_FILES['picture']['tmp_name'], $picture);
                }

                // si les règles de validation du formulaire sont respectées
                if ($isFormValid) {

                    // on ajoute un tableau avec les nouvelles données
                    $categories = $manager->add(["label" => $label, "picture" => $picture]);
                        if($categories){
                            Session::addFlash('success',"<i class='fa-solid fa-square-check'></i> Catégorie ajoutée !" );

                        } else {
                            Session::addFlash('error',"Erreur lors de l'ajout de la catégorie !" );

                        }

                    // puis on redirige vers la vue listCategories
                    $this->redirectTo("forum", "listCategories");

                }
            }
    }

            // fonction pour supprimer une catégorie
            public function deleteCategory($id) {

                $manager = new CategoryManager;
                $categories = $manager->delete($id);

                if($categories) {
                    Session::addFlash('success',"<i class='fa-solid fa-square-check'></i> La catégorie a été supprimée !" );

                } else {
                    Session::addFlash('error',"<i class='fa-solid fa-circle-exclamation'></i>Echec lors de la suppression de la catégorie " );
                }
    
                $this->redirectTo("forum", "listCategories");
            }
    
    
            // fonction pour rediriger vers le formulaire de modification
            public function updateCategoryForm($id) {
                // création d'une instance de classe 
                $manager = new CategoryManager;
                // récupération de l'id de la catégorie
                $category = $manager->findOneById($id);
                // préparation des données à retourner sous forme d'un tableau assosiatif
                return [
                    "view" => VIEW_DIR."forum/updateCategory.php", // vue pour afficher le formulaire
                    "data" => [  // La clé "data" contient un tableau associatif contenant les données à transmettre à la vue
                        "category" => $category  // La clé "category" contient l'objet de catégorie récupéré précédemment, qui sera accessible dans la vue

                    ]
                ];
            }
            
            // fonction pour modifier une catégorie
            public function updateCategory($id) {
    
                $manager = new CategoryManager;
    
                // on vérifie ce qui arrive en POST
                if(isset($_POST['submit'])) {
                    $label = filter_input(INPUT_POST, "label", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
                // variables
                $formValues = null;
    
                // validation des règles du formulaire
                $isFormValid = true;
    
                // label est obligatoire
                if ($label == "") {
                    $isFormValid = false;
                    // $errorMessages["label"] = "Ce champ est obligatoire";
                }
    
                    // Vérifiez s'il y a un fichier téléchargé            
                if (isset($_FILES['picture'])) {
                    $target_dir = "public/img/";
                    $picture = $target_dir . basename($_FILES["picture"]["name"]);
                    move_uploaded_file($_FILES['picture']['tmp_name'], $picture);
                }
    
                // si les règles de validation du formulaire sont respectées
                if ($isFormValid) {
    
                    // on remplace avec les nouvelles données
                    $categories = $manager->update(["id" => $id, "label" => $label, "picture" => $picture]);
                    
                    if($categories) {
                        Session::addFlash('success',"<i class='fa-solid fa-square-check'></i> La catégorie a été modifiée !" );

                    } else {
                        Session::addFlash('error',"<i class='fa-solid fa-circle-exclamation'></i>  Echec lors de la modification de la catégorie" );

                    }
                    // puis on redirige vers la vue listCategories
                    $this->redirectTo("forum", "listCategories");
                }
            }
    
        }


        
/************************************* Topic ************************************** */


         // fonction pour lister tous les topics
         public function listTopics(){

            $manager = new TopicManager;
            $topics = $manager->findAll();
 
             return [
                 "view" => VIEW_DIR."forum/listTopics.php",
                 "data" => [
                     "topics" => $topics
                 ]
             ];
         }


         // fonction pour lister tous les topics pour une catégorie
         public function listTopicsByIdCategory($id){

            $manager = new TopicManager;
            $categoryManager = new CategoryManager;
            // $postManager = new PostManager;
    
            $topics = $manager->listTopicById($id);
            $category = $categoryManager->findOneById($id);

             return [
                 "view" => VIEW_DIR."forum/detailCategory.php",
                 "data" => [
                     "topics" => $topics,
                     "category" => $category
                    //  "post" => $post
                 ]
             ];
         }           
          // foreach($topics as $topic){
            //     $idTopic = $topic->getId();
            //     $post = $postManager->listOnePostById($idTopic);
            //     return $post;
            // }
                
            //  var_dump($post);die;


                  // fonction pour afficher le premier post pour chaque topic
                //   public function listPostByTopic($id){

                //     $manager = new PostManager;
                //     $post = $manager->listOnePostById($id);
                    

                //      return [
                //          "view" => VIEW_DIR."forum/detailCategory.php",
                //          "data" => [
                //              "post" => $post
                //          ]
                //      ];
                //  }




        // fonction pour ajouter un sujet à une categorie 
        public function addTopic($id){

            $manager = new TopicManager;
            $postManager = new PostManager;
            
            $user = Session::getUser(); // on ajoute l'id user de l'utilisateur connecté

            // on vérifie ce qui arrive en POST
            if(isset($_POST['submit'])) {
                $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $id = $_POST['category_id']; // input type hidden

                // on filtre le premier post
                $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                // on ajoute un tableau avec les nouvelles données du topic
                $idTopic = $manager->add(["title" => $title, "category_id" => $id, "user_id" => $user->getId()]);

                // on récupère le nouvel Id créé automatiquement grâce à la fonction InsertInto de la fonction add

                // on ajoute un tableau avec les nouvelles données du 1er post
                $posts = $postManager->add(['text' => $text, "topic_id" => $idTopic, "user_id" => $user->getId()]);

                    if($posts){
                        Session::addFlash('success',"<i class='fa-solid fa-square-check'></i> Sujet ajouté !" );
                        $this->redirectTo("forum", "listTopicsByIdCategory", $id);
                    } else {
                        Session::addFlash('error',"Erreur lors de l'ajout du sujet !" );
                        $this->redirectTo("forum","listCategories");
                    }   
            }
        }
    

        // fonction pour supprimer un topic
        public function deleteTopic($id) {

            $categoryManager = new CategoryManager;
            $topicManager = new TopicManager;

            $topics = $topicManager->delete($id);

            $category = $categoryManager->findOneById($id);

            if($topics) {
                Session::addFlash('success',"<i class='fa-solid fa-square-check'></i> Le sujet a été supprimé !" );

            } else {
                Session::addFlash('error',"<i class='fa-solid fa-circle-exclamation'></i>Echec lors de la suppression du sujet" );
            }

            // $this->redirectTo("forum","detailCategory", $category);
            // return [
            //     "view" => VIEW_DIR."forum/detailCategory.php",
            //     "data" => [
            //         "topics" => $topics,
            //         "category" => $category
            //     ]
            // ];
            
        }


        // fonction pour rediriger vers le formulaire de modification d'un topic
        public function updateTopicForm($id) {
            
            $manager = new TopicManager;
            // récupération de l'id du topic
            $topic = $manager->findOneById($id);
            // préparation des données à retourner sous forme d'un tableau assosiatif
            return [
                "view" => VIEW_DIR."forum/updateTopic.php", // vue pour afficher le formulaire
                "data" => [  // La clé "data" contient un tableau associatif contenant les données à transmettre à la vue
                    "topic" => $topic  // La clé "category" contient l'objet de catégorie récupéré précédemment, qui sera accessible dans la vue

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
            if(isset($_POST['submit'])) {
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

                        if($posts) {
                        Session::addFlash('success',"<i class='fa-solid fa-square-check'></i> Le sujet a été modifié !" );
                        $this->redirectTo("forum", "listTopicsByIdCategory", $idCategory);

                        } else {
                        Session::addFlash('error',"<i class='fa-solid fa-circle-exclamation'></i>  Echec lors de la modification du sujet" );
                        $this->redirectTo("forum","listCategories");
                        }
            }
        }

    }

    /************************************* Post ************************************** */


         // fonction pour lister les posts pour un topic
         public function listPostsByIdTopic($id){

            $manager = new PostManager;
            $topicManager = new TopicManager;
            $userManager = new UserManager;

            $posts = $manager->listPostById($id);
            
            $topic = $topicManager->findOneById($id);

            // $user = $userManager->listUserByPost($id);
//  var_dump($user);die;
             return [
                 "view" => VIEW_DIR."forum/detailTopic.php",
                 "data" => [
                     "posts" => $posts,
                     "topic" => $topic
                    //  "user" => $user
                 ]
             ];
         }

        // fonction pour lister le premier post pour un topic
        // public function listOnePostTopic($id){

        // $manager = new PostManager;
        // $post = $manager->listOnePost($id);

        //     return [
        //         "view" => VIEW_DIR."forum/detailCategory.php",
        //         "data" => [
        //             "post" => $post
        //         ]
        //     ];
        // }



        // fonction pour ajouter un post à un topic
        public function addPost($id){

            $manager = new PostManager;

            $topicManager = new TopicManager;

            $user = Session::getUser(); // on ajoute l'id user de l'utilisateur connecté

            // on vérifie ce qui arrive en POST
            if(isset($_POST['submit'])) {
                $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $id = $_POST['topic_id']; // input type hidden

                // on ajoute un tableau avec les nouvelles données
                $post = $manager->add(["text" => $text, "topic_id" => $id, "user_id" => $user->getId()]);
            
                // puis on redirige vers la vue détailTopic
                $this->redirectTo("forum", "listPostsByIdTopic", $id);
                
            }   
        }


        // fonction pour supprimer un post
        public function deletePost($id) {

            $topicManager = new TopicManager;
            $postManager = new PostManager;

            // on cherche l'id du topic correspondant pour la redirection
            $post = $postManager->findOneById($id);
            $idTopic = $post->getTopic()->getId();

            // avant de supprimer le post, on vérifie que ce ne soit pas le dernier post en ligne
            // $nbPost = $
            $post = $postManager->delete($id);

            if($post) {
                Session::addFlash('success',"<i class='fa-solid fa-square-check'></i> Le commentaire a été supprimé !" );

            } else {
                Session::addFlash('error',"<i class='fa-solid fa-circle-exclamation'></i>Echec lors de la suppression du commentaire" );
            }

            $this->redirectTo("forum", "listPostsByIdTopic", $idTopic);
        }
        




    
    }