<?php

class PerfumeView{

    private $user = null;

    public function __construct($user){
        $this->user = $user;
    } 

    public function showHome(){
        require 'app/views/templates/index.phtml';
    }

    public function showPerfumes($perfumes){
        require 'app/views/templates/listaPerfumes.phtml';
    }
}