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

    public function showPerfumeDetail($perfume){
        require 'app/views/templates/detalle_perfume.phtml';
    }

    public function showPanelDeControl($perfumes){
        require 'app/views/templates/panel_de_control.phtml';
    }

    public function showAddForm($categorias){
        require_once 'app/views/templates/form_add_perfume.phtml';
    }

    public function showEditForm($perfume, $categorias){
        require_once 'app/views/templates/form_edit_perfume.phtml';
    }

     public function showError($error){
        require 'app/views/templates/error.phtml';
    }
}