<?php
    namespace Model\Managers;
    
    use App\Manager;
    use App\DAO;
    

    class UserManager extends Manager{

        protected $className = "Model\Entities\User";
        protected $tableName = "user";


        public function __construct(){
            parent::connect();
        }


        // fonction pour vérifier si l'email de l'user est unique
        public function findOneByEmail($email) {
            $sql = "SELECT *
                    FROM ".$this->tableName."
                    WHERE email = :email";

                return $this->getOneOrNullResult(
                    DAO::select($sql, ['email' => $email], false), 
                    $this->className
                );
         }

        // fonction pour vérifier si le pseudo de l'user est unique
        public function findOneByPseudo($pseudo) {
            $sql = "SELECT *
                    FROM ".$this->tableName."
                    WHERE pseudo = :pseudo";

                return $this->getOneOrNullResult(
                    DAO::select($sql, ['pseudo' => $pseudo], false), 
                    $this->className
                );
        }

        // fonction pour lister les user sans afficher les utilisateurs supprimés
        public function findAllUsers($order = null){

            $orderQuery = ($order) ?                 
                "ORDER BY ".$order[0]. " ".$order[1] :
                "";

            $sql = "SELECT *
                    FROM ".$this->tableName." 
                    WHERE email <> 'utilisateur supprimé'
                    ".$orderQuery;

            return $this->getMultipleResults(
                DAO::select($sql), 
                $this->className
            );
        }


}
        

    


    