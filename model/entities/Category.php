<?php
        // je range la classe dans un espace virtuel namespace
    namespace Model\Entities;
        // va chercher la classe Entity qui se trouve dans le namespace APP
    use App\Entity;
        // classe finale, cette classe ne peut pas avoir d'enfant. La classe Category hérite de la classe Entity
    final class Category extends Entity{

        // liste des propriétés de la classe Topic selon le principe d'encapsulation (visibilité des éléments au sein d'une classe), mes propriétés sont en privées, elles seront accessibles que au sein de la classe
        private $id;
        private $label;
        private $picture;
        private $nbTopic;

        
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
         * Get the value of label
         */ 
        public function getLabel()
        {
                return $this->label;
        }

        /**
         * Set the value of label
         *
         * @return  self
         */ 
        public function setLabel($label)
        {
                $this->label = $label;

                return $this;
        }

                /**
         * Get the value of picture
         */ 
        public function getPicture()
        {
                return $this->picture;
        }

        /**
         * Set the value of picture
         *
         * @return  self
         */ 
        public function setPicture($picture)
        {
                $this->picture = $picture;

                return $this;
        }

                        /**
         * Get the value of topic
         */ 
        public function getNbTopic()
        {
                return $this->nbTopic;
        }

        /**
         * Set the value of topic
         *
         * @return  self
         */ 
        public function setNbTopic($nbTopic)
        {
                $this->nbTopic = $nbTopic;

                return $this;
        }


        public function to__String() {
            return $this->label;
        }

}