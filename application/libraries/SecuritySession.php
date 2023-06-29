<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SecuritySession
 *
 * @author oscar.f.medellin
 */
class SecuritySession {
    
    private $user;
    private $password;
    
    public function setUsername($user) {
        return $this->user = $user;
    }
    
    public function setPassword($pass) {
        $salt     = sha1("1" . $pass . "1");
        $password = "$salt$pass$salt";
        
        return $this->password = sha1($password);
    }
    
    public function getUsername(){
        return $this->user;
    }
    
    public function getPassword() {
        return $this->password;
    }
}