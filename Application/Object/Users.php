<?php
    class Users {
        public $phone ;
        public $email ;
        public $password ;
        public $firstName ;
        public $lastName ;
        public $isActive ;
        public $isReported ;
        public $isBlocked ;
        public $preference ;
    
        public function __construct($phone,$email,$password,$firstName,$lastName,$isActive,$isReported,$isBlocked,$preference) {
            $this->phone = $phone;
            $this->email = $email;
            $this->password = $password;
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->isActive = $isActive;
            $this->isReported = $isReported;
            $this->isBlocked = $isBlocked;
            $this->preference = $preference;
        }
    }
?>