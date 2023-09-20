<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    

    class TopicManager extends Manager{

        protected $className = "Model\Entities\Topic";
        protected $tableName = "topic";


        public function __construct(){
            parent::connect();
        }


        // fonction pour lister les topics d'une catégorie
        public function listTopicById($id){

            $sql = "SELECT *
            FROM ".$this->tableName." 
            WHERE category_id = :id
            ";

            return $this->getMultipleResults(
                DAO::select($sql, ["id" => $id]), 
                $this->className
            );

        }

         //fonction pour effectuer une recherche dans la table topic
         public function searchTopic($query) {
           

            $sql = "SELECT *
            FROM ".$this->tableName." 
            WHERE title LIKE :query";
                    
                    

            return $this->getMultipleResults(
                DAO::select($sql, [':query' => '%' . $query . '%']), 
                $this->className
            );
        }

    }

