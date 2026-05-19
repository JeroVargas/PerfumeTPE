<?php

class UserModel extends Model{
    
    public function __construct() {
        parent::__construct(); 
    }

    public function getUserByEmail($email){
        $query = $this->db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $query->execute([$email]);
        $user = $query->fetch(PDO::FETCH_OBJ);
        return $user;
    }

    public function addUser($email, $password){
        $query = $this->db->prepare('INSERT INTO usuarios (email, password) VALUES (?,?)');
        $query->execute([$email, $password]);
        return $this->db->lastInsertId();
    }

    
}
