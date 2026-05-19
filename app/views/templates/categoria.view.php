<?php
class CategoriaView {
    public $user = null;

    public function __construct($user) {
        $this->user = $user;
    }

    public function showCategorias($categorias) {
        require 'app/views/templates/listaCategorias.phtml';
    }

    public function showAdminCategorias($categorias) {
        require 'app/views/templates/adminCategorias.phtml';
    }

    public function showCategoriaById($categoria) {
        require 'app/views/templates/detalle_categoria.phtml';
    }

    public function showAddForm() {
        require 'app/views/templates/form_add_categoria.phtml';
    }

    // NUEVA: Para mostrar el formulario de editar con los datos viejos
    public function showEditForm($categoria) {
        require 'app/views/templates/form_edit_categoria.phtml';
    }

    public function showError($error) {
        require 'app/views/templates/error.phtml';
    }
}