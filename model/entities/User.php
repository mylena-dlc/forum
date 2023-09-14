<?php
        // je range la classe dans un espace virtuel namespace
    namespace Model\Entities;
        // va chercher la classe Entity qui se trouve dans le namespace APP
    use App\Entity;
        // classe finale, cette classe ne peut pas avoir d'enfant. La classe User hérite de la classe Entity
    final class User extends Entity{

        // liste des propriétés de la classe Topic selon le principe d'encapsulation (visibilité des éléments au sein d'une classe), mes propriétés sont en privées, elles seront accessibles que au sein de la classe
        private $id;
        private $pseudo;
        private $creationDate;
        private $role;
        private $isClosed;
        private $email;
        private $password;
        


        public function __construct($data){         
            $this->hydrate($data);  // l'hydratation permet de prendre des données de la base de donnée pour créé des objets       
        }
 
        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

         /**
         * Get the value of pseudo
         */ 
        public function getPseudo()
        {
                return $this->pseudo;
        }

        /**
         * Set the value of pseudo
         *
         * @return  self
         */ 
        public function setPseudo($pseudo)
        {
                $this->pseudo = $pseudo;

                return $this;
        }


        public function getCreationDate(){
            $formattedDate = $this->creationDate->format("d/m/Y, H:i:s");
            return $formattedDate;
        }

        public function setCreationDate($date){
            $this->creationDate = new \DateTime($date);
            return $this;
        }

        /**
	 * Get the value of role
	 */
	public function getRole()
	{
                // return $this->role;

		return json_decode($this->role);
	}

 

	/**
	 * Set the value of role
	 *
	 * @return  self
	 */
	public function setRole($role)
	{
                // on récupère du JSON
                $this->role = json_encode($role);
                // s'il n'y a pas de rôles attitrés, on va lui attribuer un rôle
                return $this;
	}

 

	public function hasRole($role)
	{
                // si dans le tableau json on trouve un role qui correspond 
                // au rôle envoyé en paramètre, alors cela nous return true
                // return in_array($role, $this->getRole())
                
		$result = $this->getRole() == json_encode($role);
		return $result;
	}


        
       /**
         * Get the value of closed
         */ 
        public function getIsClosed()
        {
                return $this->isClosed;
        }

        /**
         * Set the value of closed
         *
         * @return  self
         */ 
        public function setIsClosed($isClosed)
        {
                $this->isClosed = $isClosed;

                return $this;
        }

          /**
         * Get the value of email
         */ 
        public function getEmail()
        {
                return $this->email;
        }

        /**
         * Set the value of email
         *
         * @return  self
         */ 
        public function setEmail($email)
        {
                $this->email = $email;

                return $this;
        }

                  /**
         * Get the value of password
         */ 
        public function getPassword()
        {
                return $this->password;
        }

        /**
         * Set the value of password
         *
         * @return  self
         */ 
        public function setPassword($password)
        {
                $this->password = $password;

                return $this;
        }

        public function to__String(){
            return $this->pseudo;
        }

    }