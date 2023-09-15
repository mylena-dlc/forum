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
        // public function listTopicById($id){

        //     $sql = "SELECT *
        //     FROM ".$this->tableName." 
        //     WHERE category_id = :id
        //     ";

        //     return $this->getMultipleResults(
        //         DAO::select($sql, ["id" => $id]), 
        //         $this->className
        //     );

        // }



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

                        // Fonction pour afficher le 1er post d'un seul topic
                        public function listOnePostByIdTopic($id){

                            $sql = "SELECT *
                            FROM ".$this->tableName." t
                            LEFT JOIN post p
                            ON p.topic_id = t.id_topic
                              WHERE t.id_topic = :id
                              ORDER BY p.creationDate ASC
                              LIMIT 1";
                
                            return $this->getOneOrNullResult(
                                DAO::select($sql, ["id" => $id]), 
                                $this->className
                            );
                
                        }

        //SELECT * 
        // FROM topic t
        // LEFT JOIN post p 
        // on p.topic_id = t.id_topic
        // WHERE t.id_topic =5
        // ORDER BY p.creationDate ASC
        // LIMIT 1

    }

