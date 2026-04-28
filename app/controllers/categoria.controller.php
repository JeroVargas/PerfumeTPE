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
            $this->view = new CategoriaView ($res->user);
        }

        public function showHome(){
            return $this->view->showHome();
        }

        public function showCategorias(){
            $categorias = $this->model->getCategorias();
            $this->view->showCategorias($categorias);
        }

        public function showCategoriaById ($id){
            $categoria = $this->model->getCategoria($id);

            if ($categoria){
                $this->view->showCategoriaById($categoria);
            }else{
                $this->view->showError("Categoria no encontrada.");
            }

        }

        public function showError($error){
            return $this->view->showError($error);
        }

    }