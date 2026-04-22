<?php

require_once './app/models/perfume.model.php';
require_once './app/models/categoria.model.php';
require_once './app/views/templates/perfume.view.php';

class PerfumeController{
    private $model;
    private $view;
    private $modelCategorias;

    public function __construct($res){
        $this->model = new PerfumeModel();
        //$this->modelCategorias = new CategoriasModel();
        $this->view = new PerfumeView($res->user);
    }

    public function showHome(){
        return $this->view->showHome();
    }

    public function showPerfumes(){
        $perfumes = $this->model->getPerfumes();
        $this->view->showPerfumes($perfumes);
    }
     
 }