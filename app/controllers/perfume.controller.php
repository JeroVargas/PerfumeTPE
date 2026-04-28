<?php

require_once './app/models/perfume.model.php';
require_once './app/models/categoria.model.php';
require_once './app/views/templates/perfume.view.php';

class PerfumeController{
    private $model;
    private $view;
    private $modelCategorias;//Nico

    public function __construct($res){
        $this->model = new PerfumeModel();
        // Nico $this->modelCategorias = new CategoriasModel();
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

    public function showError($error){
        return $this->view->showError($error);
    }
 }