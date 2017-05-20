<?php
    class login {
        var $salt="mtg";
        var $user;
        var $password;
        
        public function getSalt() {
            return $this->salt;
        }

        public function setSalt($salt) {
            $this->salt = $salt;
        }

        public function getUser() {
            return $this->user;
        }

        public function setUser($user) {
            $this->user = $user;
        }

        public function getPassword() {
            return $this->password;
        }

        public function setPassword($password) {
            $this->password = $password;
        }
        
        public function getEncrypt() {
            return md5($this->getPassword());
        }

    }
?>
