<?php

    namespace Model\Entities;

    use App\Entity;

/**
*  Represents a category in the forum application
*
*/

    final class Category extends Entity{

        private $id;
        private $label;
        private $picture;
        private $nbTopic;

        /**
         * Constructor to initialize the category entity.
         *
         * @param array $data Initial data for the category entity.
         */
        public function __construct($data){         
            $this->hydrate($data);  
        }
 
        /**
         * Get the value of id
         * 
         * @return int|null Category ID.
         */ 
        public function getId(): self
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @param int $id Category
         * @return  self
         */ 
        public function setId(int $id): self
        {
                $this->id = $id;
                return $this;
        }

        /**
         * Get the value of label
         * 
         * @return string|null Category label.
         */ 
        public function getLabel(): ?string
        {
                return $this->label;
        }

        /**
         * Set the value of label
         *
         * @param string $label Category
         * @return  self
         */ 
        public function setLabel(string $label): self
        {
                $this->label = $label;
                return $this;
        }

         /**
         * Get the value of picture
         * 
         * @return string|null Category picture
         */ 
        public function getPicture(): ?string
        {
                return $this->picture;
        }

        /**
         * Set the value of picture
         *
         * @param string $picture Category
         * @return  self
         */ 
        
        public function setPicture(string $picture): self
        {
                $this->picture = $picture;
                return $this;
        }

        /**
         * Get the value of topic
         * 
         * @return int Topic id
         */ 
        public function getNbTopic(): self
        {
                return $this->nbTopic;
        }

        /**
         * Set the value of topic
         *
         * @param int $nbTopic in Category
         * @return  self
         */ 
        public function setNbTopic(int $nbTopic)
        {
                $this->nbTopic = $nbTopic;
                return $this;
        }

        /**
         * Convert the user object to a string
         * 
         * @return string Category label
         */
        public function to__String(): string
         {
            return $this->label;
        }

}