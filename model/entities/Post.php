<?php
        // je range la classe dans un espace virtuel namespace
    namespace Model\Entities;
        // va chercher la classe Entity qui se trouve dans le namespace APP
    use App\Entity;
        // classe finale, cette classe ne peut pas avoir d'enfant. La classe Topic hérite de la classe Entity
    final class Post extends Entity{

        // liste des propriétés de la classe Topic selon le principe d'encapsulation (visibilité des éléments au sein d'une classe), mes propriétés sont en privées, elles seront accessibles que au sein de la classe
        private $id;
        private $text;
        private $creationDate;
        private $topic;
        private $user;
        
        

        public function __construct($data){         
            $this->hydrate($data);  // l'hydratation permet de prendre des données de la base de donnée pour créé des objets       
        }


        /* Get the value of id*/
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
         * Get the value of text
         */ 
        public function getText()
        {
                return $this->text;
        }

        /**
         * Set the value of text
         *
         * @return  self
         */ 
        public function setText($text)
        {
                $this->text = $text;

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
         * Get the value of topic
         */ 
        public function getTopic()
        {
                return $this->topic;
        }

        /**
         * Set the value of topic
         *
         * @return  self
         */ 
        public function setTopic($topic)
        {
                $this->topic = $topic;

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


        public function to__String() {
            return $this->text;
        }






    }