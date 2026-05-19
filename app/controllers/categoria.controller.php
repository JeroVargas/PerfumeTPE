<?php

require_once './app/models/perfume.model.php';
require_once './app/models/categoria.model.php';
require_once './app/views/templates/categoria.view.php';

class ControllerCategoria {
    private $model;
    private $view;
    private $modelPerfume;

    public function __construct($res){
        $this->model = new CategoriaModel();
        $this->modelPerfume = new PerfumeModel();
        // Pasamos el usuario a la vista para saber si mostrar botones de admin o no
        $this->view = new CategoriaView($res->user);
    }

    public function showCategorias(){
        $categorias = $this->model->getCategorias();
        $this->view->showCategorias($categorias);
    }

    public function showAdminCategorias(){
        $categorias = $this->model->getCategorias();
        $this->view->showAdminCategorias($categorias);
    }

    public function showCategoriaById($id){
        // Usamos el método que trae los perfumes de esa categoría [cite: 17]
        $perfumes = $this->model->getCategoriaItems($id); 
        $this->view->showCategoriaById($perfumes);
    }

    public function addCategoria() {
    
        if (!isset($_POST['nombre']) || empty($_POST['nombre'])) {
            return $this->view->showError("El nombre es obligatorio.");
        }

        $nombre = $_POST['nombre'];
        $imagen = $_POST['imagen']; // La URL de la foto (Opcional) 

        $this->model->insertCategoria($nombre, $imagen);
        header("Location: " . BASE_URL . "listaCategorias");
    }

    public function deleteCategoria($id) {
        
        $this->model->deleteCategoria($id);
        header("Location: " . BASE_URL . "listaCategorias");
    }

    public function showEditForm($id) {
         
        $categoria = $this->model->getCategoriaById($id);
        if ($categoria) {
            $this->view->showEditForm($categoria);
        } else {
            $this->view->showError("Categoría no encontrada.");
        }
    }

    public function updateCategoria() {
        if (!isset($_POST['id']) || !isset($_POST['nombre'])) {
            return $this->view->showError("Faltan datos obligatorios.");
        }

        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $imagen = $_POST['imagen']; 

        $this->model->updateCategoria($id, $nombre, $imagen);
        header("Location: " . BASE_URL . "listaCategorias");
    }

    public function showAddForm() {
        $this->view->showAddForm(); 
    }

    public function showError($error){
        return $this->view->showError($error);
    }
}