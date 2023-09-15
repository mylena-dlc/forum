<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    

    class PostManager extends Manager{

        protected $className = "Model\Entities\Post";
        protected $tableName = "post";


        public function __construct(){
            parent::connect();
        }

        // Fonction pour afficher tous les posts d'un seul topic
        public function listPostById($id){

            $sql = "SELECT *
            FROM ".$this->tableName." 
            WHERE topic_id = :id
            ";

            return $this->getMultipleResults(
                DAO::select($sql, ["id" => $id]), 
                $this->className
            );

        }

                // Fonction pour afficher le 1er post d'un seul topic
                // public function listOnePostByIdTopic($id){

                //     $sql = "SELECT *
                //     FROM ".$this->tableName." p
                //       WHERE topic_id = :id
                //       ORDER BY p.creationDate ASC
                //       LIMIT 1";
        
                //     return $this->getOneOrNullResult(
                //         DAO::select($sql, ["id" => $id]), 
                //         $this->className
                //     );
        
                // }

                    // // Fonction pour récupéré les messages d'un utilisateur
                    public function postByUser($id){

                        $sql = "SELECT *
                        FROM ".$this->tableName." 
                        WHERE user_id = :id";
            
                        return $this->getOneOrNullResult(
                            DAO::select($sql, ["id" => $id]), 
                            $this->className
                        );
            
                    }







    }