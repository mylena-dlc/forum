<?php

namespace Model\Entities;

use App\Entity;

/**
*  Represents a post in the forum application
*
*/

final class Post extends Entity{

        private $id;
        private $text;
        private $creationDate;
        private $topic;
        private $user;
        
        /**
         * Constructor to initialize the post entity.
         *
         * @param array $data Initial data for the post entity.
         */
        public function __construct($data){         
            $this->hydrate($data); 
        }

        /**
         * Get the value of id
         * 
         * @return int|null Post ID.
         */ 
        public function getId(): self
        {
                return $this->id;
        }

        
        /**
         * Set the value of id
         *
         * @param int $id Post
         * @return  self
         */ 
        public function setId(int $id): self
        {
                $this->id = $id;
                return $this;
        }

        /**
         * Get the value of text
         * 
         * @return string|null Post text
         */ 
        public function getText(): ?string
        {
                return $this->text;
        }

        /**
         * Set the value of text
         *
         * @param string $text Post
         * @return  self
         */ 
        public function setText(string $text): self
        {
                $this->text = $text;
                return $this;
        }

        /**
         * Get the formatted creation date
         * 
         * @return string|null Formatted creation date (d/m/Y, H:i:s)
         */ 
        public function getCreationDate(): ?string 
        {
            $formattedDate = $this->creationDate->format("d/m/Y, H:i:s");
            return $formattedDate;
        }

        /**
         * Set the value of creation date
         *      
         * @param string $date Date in a valid datetime format.
         */ 
        public function setCreationDate(string $date): self
        {
            $this->creationDate = new \DateTime($date);
            return $this;
        }

        /**
         * Get the value of topic
         * 
         * @return int
         */ 
        public function getTopic(): self
        {
                return $this->topic;
        }

        /**
         * Set the value of topic
         *
         * @param int $topic Topic
         * @return  self
         */ 
        public function setTopic(int $topic): self
        {
                $this->topic = $topic;

                return $this;
        }

        /**
         * Get the value of user
         * 
         *  @param int $id User 
         * @return self
         */ 
        public function getUser(): self
        {
                return $this->user;
        }

        /**
         * Set the value of user
         *
         * @param int $user User
         * @return  self
         */ 
        public function setUser(int $user): self
        {
                $this->user = $user;

                return $this;
        }

        /**
         * Convert the user object to a string
         * 
         * @return string Post text
         */
        public function to__String(): ?string 
        {
            return $this->text;
        }

    }