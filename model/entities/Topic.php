<?php
        // je range la classe dans un espace virtuel namespace
    namespace Model\Entities;
        // va chercher la classe Entity qui se trouve dans le namespace APP
    use App\Entity;
        // classe finale, cette classe ne peut pas avoir d'enfant. La classe Topic hérite de la classe Entity
    final class Topic extends Entity{

        // liste des propriétés de la classe Topic selon le principe d'encapsulation (visibilité des éléments au sein d'une classe), mes propriétés sont en privées, elles seront accessibles que au sein de la classe
        private $id;
        private $title;
        private $creationDate;
        private $isClosed;
        private $user;
        private $category;
      
        


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
         * Get the value of title
         */ 
        public function getTitle()
        {
                return $this->title;
        }

        /**
         * Set the value of title
         *
         * @return  self
         */ 
        public function setTitle($title)
        {
                $this->title = $title;

                return $this;
        }

        /**
         * Get the value of user
         */ 
        public function getUser()
        {
                return $this->user;
        }

        /**
         * Set the value of user
         *
         * @return  self
         */ 
        public function setUser($user)
        {
                $this->user = $user;

                return $this;
        }

                /**
         * Get the value of category
         */ 
        public function getCategory()
        {
                return $this->category;
        }

        /**
         * Set the value of category
         *
         * @return  self
         */ 
        public function setCategory($category)
        {
                $this->category = $category;

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



        public function to__String() {
                return $this->title;
        }
    }
