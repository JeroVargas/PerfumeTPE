<?php

class CategoriaView {

    private $user;

    public function __construct($user = null) {
        $this->user = $user;
    }

    public function showHome() {
        require 'app/views/templates/index.phtml';
    }

    public function showCategorias($categorias) {
        require 'app/views/templates/listaCategorias.phtml';
    }

    public function showCategoriaById($categoria) {
        require 'app/views/templates/detalleCategoria.phtml';
    }

    public function showError($error) {
        require 'app/views/templates/error.phtml';
    }
}