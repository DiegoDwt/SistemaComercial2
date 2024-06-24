<?php

namespace App\Models;

class Usuario {
    private $username;
    private $password;

    public function getUsername() {
        return $username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }
}
