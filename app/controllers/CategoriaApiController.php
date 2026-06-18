<?php
require_once 'app/models/categoria.model.php';

class CategoriaApiController {
    private $model;

    public function __construct() {
        $this->model = new CategoriaModel();
    }

    
    public function getCategorias($req, $res) {
        // Capturamos el ordenamiento opcional (?sort=nombre&order=desc)
        $sortBy = $req->query->sort ?? 'id';
        $order = $req->query->order ?? 'ASC';

        $buscarPorNombre = $req->query->nombre ?? null;

        if ($buscarPorNombre) {
            $categorias = $this->model->getCategoriasByNombre($buscarPorNombre);
        } else {
            $categorias = $this->model->getCategorias($sortBy, $order);
        }

        return $res->json($categorias, 200);
    }

    public function updateCategoria($req, $res) {
        if (!$req->user) {
            return $res->json(["error" => "No autorizado. Se requiere un token JWT valido."], 401);
        }

        $id = $req->params->id; 

        // Verificamos si el recurso a modificar realmente existe en la DB
        $categoria = $this->model->getCategoriaById($id);
        if (!$categoria) {
            return $res->json(["error" => "La categoría con el id=$id no existe"], 404);
        }

        // Validamos que nos manden los datos necesarios en el JSON del body
        if (!isset($req->body->nombre) || empty($req->body->nombre)) {
            return $res->json(["error" => "El campo 'nombre' es obligatorio para actualizar."], 400);
        }

        $nombre = $req->body->nombre;
        $imagen = $req->body->imagen ?? null;

        $this->model->updateCategoria($id, $nombre, $imagen);

        $categoriaModificada = $this->model->getCategoriaById($id);
        return $res->json($categoriaModificada, 200);
    }

    
    public function getCategoriaById($req, $res) {
        $id = $req->params->id; // El router te da el ID mapeado automáticamente
            
        $categoria = $this->model->getCategoriaById($id);

        if (!$categoria) {
            return $res->json(["error" => "La categoría con el id=$id no existe"], 404);
        }
        $perfumesAsociados = $this->model->getCategoriaItems($id);
        
        $respuesta = [
            "id" => $categoria->id,
            "nombre" => $categoria->nombre,
            "imagen" => $categoria->imagen,
            "perfumes" => $perfumesAsociados
        ];

        return $res->json($respuesta, 200);
    }


    public function insertCategoria($req, $res) {
        // Validación del token JWT provisto por el middleware
        if (!$req->user) {
            return $res->json(["error" => "No autorizado. Se requiere un token JWT válido."], 401);
        }

        // Leemos las propiedades directo del JSON decodificado en $req->body
        if (!isset($req->body->nombre) || empty($req->body->nombre)) {
            return $res->json(["error" => "El campo 'nombre' es obligatorio."], 400);
        }

        $nombre = $req->body->nombre;
        $imagen = $req->body->imagen ?? null; // Si no viene la url de la imagen se guarda null

        // Insertamos en la DB usando tu modelo tal cual estaba
        $id = $this->model->insertCategoria($nombre, $imagen);

        if (!$id) {
            return $res->json(["error" => "No se pudo crear el recurso en el servidor"], 500);
        }

        // Obtenemos el objeto recién creado para retornarlo con las convenciones RESTful
        $nuevaCategoria = $this->model->getCategoriaById($id);
        
        // 201 Created es el código correcto para inserciones exitosas
        return $res->json($nuevaCategoria, 201);
    }
}