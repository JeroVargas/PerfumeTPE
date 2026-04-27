<?php

class AuthView {
    private $user = null; 
    public function showLogin($error = '') {
        require 'app/views/templates/form_login.phtml';
    }
    
}