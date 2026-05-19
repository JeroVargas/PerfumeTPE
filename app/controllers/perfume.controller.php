<?php

require_once './app/models/perfume.model.php';
require_once './app/models/categoria.model.php';
require_once './app/views/templates/perfume.view.php';

class PerfumeController{
    private $model;
    private $view;
    private $categorias_model;

    public function __construct($res){
        $this->model = new PerfumeModel();
        $this->categorias_model = new CategoriaModel();
        $this->view = new PerfumeView($res->user);
    }

    public function showHome(){
        return $this->view->showHome();
    }

    public function showPerfumes(){
        $perfumes = $this->model->getPerfumes();
        $this->view->showPerfumes($perfumes);
    }

    public function showPerfumeDetail($id){
        $perfume = $this->model->getPerfume($id);
        if ($perfume){
            $this->view->showPerfumeDetail($perfume);
        } else {
            $this->view->showError("Perfume no encontrado.");
        }
    }

    public function showPanelDeControl(){
        $perfumes = $this->model->getPerfumes();
        $this->view->showPanelDeControl($perfumes); 
    }

     public function showAddForm(){
        $categorias = $this->categorias_model->getCategorias();
        $this->view->showAddForm($categorias);
    }

    public function addPerfume(){

    if (!isset($_POST['id_categoria']) || empty($_POST['id_categoria'])){
        return $this->view->showError("Falta la categoria del Perfume");
    }

    if(!isset($_POST['nombre']) || empty($_POST['nombre'])){
        return $this->view->showError("Falta el nombre del Perfume");
    }

    if(!isset($_POST['nota']) || empty($_POST['nota'])){
        return $this->view->showError("Falta la nota del Perfume");
    }

    if(!isset($_POST['precio']) || empty($_POST['precio'])){
        return $this->view->showError("Falta el precio del perfume");
    }

    $id_categoria = $_POST['id_categoria'];
    $nombre = $_POST['nombre'];
    $nota = $_POST['nota'];
    $precio = $_POST['precio'];

    $rutaImagen = null;

    if (!empty($_FILES['imagen']['name'])) {

        $nombreArchivo = uniqid() . $_FILES['imagen']['name'];

        $rutaImagen = 'img/perfumes/' . $nombreArchivo;

        move_uploaded_file(
            $_FILES['imagen']['tmp_name'],
            $rutaImagen
        );
    }

    $categoria = $this->categorias_model->getCategoriaById($id_categoria);

    if (!$categoria){
        return $this->view->showError("La categoría seleccionada no existe.");
    }

    $this->model->insertPerfume(
        $id_categoria,
        $nombre,
        $nota,
        $precio,
        $rutaImagen
    );

    header('Location: ' . BASE_URL . 'panel_de_control');
}

    public function showEditForm($id){
        $perfume = $this->model->getPerfume($id);
        $categorias = $this->categorias_model->getCategorias();
        if ($perfume) {
            $this->view->showEditForm($perfume, $categorias);
        } else {
            $this->view->showError("Perfume no encontrado.");
        }
    }

    public function updatePerfume(){

    if (!isset($_POST['id']) || empty($_POST['id'])){
        return $this->view->showError("Falta el id perfume del Perfume");
    }

    if (!isset($_POST['id_categoria']) || empty($_POST['id_categoria'])){
        return $this->view->showError("Falta la categoria del Perfume");
    }

    if(!isset($_POST['nombre']) || empty($_POST['nombre'])){
        return $this->view->showError("Falta el nombre del Perfume");
    }

    if(!isset($_POST['nota']) || empty($_POST['nota'])){
        return $this->view->showError("Falta la nota del Perfume");
    }

    if(!isset($_POST['precio']) || empty($_POST['precio'])){
        return $this->view->showError("Falta el precio del perfume");
    }

    $id = $_POST['id'];
    $id_categoria = $_POST['id_categoria'];
    $nombre = $_POST['nombre'];
    $nota = $_POST['nota'];
    $precio = $_POST['precio'];

    $perfume = $this->model->getPerfume($id);

    if (!$perfume) {
        $this->view->showError("El perfume que intenta actualizar no existe.");
        return;
    }

    $rutaImagen = $perfume->imagen;

    if (!empty($_FILES['imagen']['name'])) {

        $nombreArchivo = uniqid() . $_FILES['imagen']['name'];

        $rutaImagen = 'img/perfumes/' . $nombreArchivo;

        move_uploaded_file(
            $_FILES['imagen']['tmp_name'],
            $rutaImagen
        );
    }

    $categoria = $this->categorias_model->getCategoriaById($id_categoria);

    if (!$categoria){
        return $this->view->showError("La categoría seleccionada no existe.");
    }

    $this->model->updatePerfume($id,$id_categoria, $nombre, $nota, $precio, $rutaImagen);

    header('Location: ' . BASE_URL . 'panel_de_control');
}

    public function deletePerfume($id){

        if (empty($id)) {
            $this->view->showError("Error al selecionar el item");
            return;
        }

        $perfume = $this->model->getPerfume($id);
        if (!$perfume){
            return $this->view->showError("El perfume que intenta eliminar no existe.");
        }

        $this->model->deletePerfume($id);
        header('Location: ' . BASE_URL . 'panel_de_control');
    }

    public function showError($error){
        return $this->view->showError($error);
    }

 }