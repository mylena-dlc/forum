<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    

    class CategoryManager extends Manager{

        protected $className = "Model\Entities\Category";
        protected $tableName = "category";


        public function __construct(){
            parent::connect();
        }

        // fonction pour lister les catégorie + le nombre de topic pour chaque catégorie
        public function findAllPlusNbTopic($order = null) {
            
            $orderQuery = ($order) ?                 
                "ORDER BY ".$order[0]. " ".$order[1] :
                "";

            $sql = "SELECT c.id_category, c.label, c.picture, count(t.category_id) AS nbTopic
                    FROM ".$this->tableName." c
                    LEFT JOIN topic t on t.".$this->tableName."_id = c.id_".$this->tableName."
                    group by c.id_".$this->tableName."
                    
                    ".$orderQuery;

            return $this->getMultipleResults(
                DAO::select($sql), 
                $this->className
            );
        }



    }