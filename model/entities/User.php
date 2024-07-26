<?php

    namespace Model\Entities;

    use App\Entity;

/**
*  Represents a user entity in the forum application.
*
*/

    final class User extends Entity{

        private $id;
        private $pseudo;
        private $creationDate;
        private $role;
        private $isClosed;
        private $email;
        private $password;
        
        /**
         * Constructor to initialize the user entity.
         *
         * @param array $data Initial data for the user entity.
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
         * @param int $id User 
         * @return  self
         */ 
        public function setId(int $id): self
        {
                $this->id = $id;
                return $this;
        }

         /**
         * Get the value of pseudo
         * 
         * @return string|null User pseudonym.
         */ 
        public function getPseudo(): ?string
        {
                return $this->pseudo;
        }

        /**
         * Set the value of pseudo
         *
         * @param string $pseudo User pseudonym
         * @return  self
         */ 
        public function setPseudo(string $pseudo): self
        {
                $this->pseudo = $pseudo;
                return $this;
        }

         /**
         * Get the formatted creation date
         * 
         * @return string|null Formatted creation date (d/m/Y, H:i:s)
         */ 
        public function getCreationDate(): ?string 
        {
                if ($this->creationDate instanceof \DateTime) {
                        return $this->creationDate->format("d/m/Y, H:i:s");
                }
                return null;
        }

         /**
         * Set the value of creation date
         *      
         * @param string $date Date in a valid datetime format.
        * @return self
         */ 
        public function setCreationDate(string $date): self
        {
            $this->creationDate = new \DateTime($date);
            return $this;
        }

        /**
	 * Get the value of role
         * 
         * @return array|null User roles as an array.
	 */
	public function getRole(): ?array
	{
	        return json_decode($this->role);
	}

	/**
	 * Set the value of role
         * 
         * @param string $role User roles
	 * @return  self
	 */
	public function setRole(array $role): self
	{
                $this->role = json_encode($role);
                return $this;
	}

        /**
         * Check if the user has a specific role
         * 
         * @param string $role Role to check
         * @return bool True if user has the role, false otherwise
         */
	public function hasRole(string $role): bool
	{  
		$roles = $this->getRole();
                return in_array($role, $roles, true);
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
         * Set the value of isClosed
         *     
         * @param bool $isClosed Account status (true if closed, false otherwise)
         * @return self
         */
        public function setIsClosed(bool $isClosed): self
        {
                $this->isClosed = $isClosed;
                return $this;
        }

        /**
         * Get the value of email
         * 
         * @return string|null User email.
         */ 
        public function getEmail(): ?string
        {
                return $this->email;
        }

        /**
         * Set the value of email
         *
         * @param string $email User email
         * @return  self
         */ 
        public function setEmail(string $email): self
        {
                $this->email = $email;
                return $this;
        }

        /**
         * Get the value of password
         *     
         * @return string|null User password.
         */ 
        public function getPassword(): ?string
        {
                return $this->password;
        }

        /**
         * Set the value of password
         *
         * @param string $password User password
         * @return  self
         */ 
        public function setPassword(string $password): self
        {
                $this->password = $password;
                return $this;
        }

        /**
         * Convert the user object to a string
         * 
         * @return string User pseudonym
         */
        public function to__String(): string 
        {
            return $this->pseudo;
        }

    }