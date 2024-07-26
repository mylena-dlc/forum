<?php
    namespace Model\Entities;

    use App\Entity;

/**
*  Represents a topic in the forum application
*
*/

    final class Topic extends Entity{

        private $id;
        private $title;
        private $creationDate;
        private $isClosed;
        private $user;
        private $category;
      
        /**
         * Constructor to initialize the topic entity.
         *
         * @param array $data Initial data for the topic entity.
         */
        public function __construct(array $data){         
            $this->hydrate($data);        
        }
 
        /**
         * Get the value of id
         * 
         * @return int|null User ID.
         */ 
        public function getId(): self
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *         
         * @param int $id Topic 
         * @return  self
         */ 
        public function setId(int $id): self
        {
                $this->id = $id;
                return $this;
        }

        /**
         * Get the value of title
         * 
         * @return string|null User pseudonym.
         */ 
        public function getTitle(): ?string
        {
                return $this->title;
        }

        /**
         * Set the value of title
         *
         * @param string $title Topic
         * @return  self
         */ 
        public function setTitle(string $title): self
        {
                $this->title = $title;
                return $this;
        }

        /**
         * Get the value of user
         * 
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
         * Get the value of category
         * 
         * @return self
         */ 
        public function getCategory(): ?int
        {
                return $this->category;
        }

        /**
         * Set the value of category
         *
         * @param int $category Category
         * @return  self
         */ 
        public function setCategory(int $category): self
        {
                $this->category = $category;
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
         * Get the value of closed
         * 
         * @return bool|null Account status (true if closed, false otherwise).
         */ 
        public function getIsClosed(): ?bool
        {
                return $this->isClosed;
        }

        /**
         * Set the value of closed
         *
         * @param bool $isClosed Account status (true if closed, false otherwise)
         * @return  self
         */ 
        public function setIsClosed(bool $isClosed): ?bool
        {
                $this->isClosed = $isClosed;
                return $this;
        }

        /**
         * Convert the user object to a string
         * 
         * @return string Topic title
         */
        public function to__String(): string 
        {
                return $this->title;
        }
    }
