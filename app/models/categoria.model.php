<?php
require_once 'app/models/Model.php'; // Aseguramos herencia del padre

class CategoriaModel extends Model {

    public function __construct() {
        parent::__construct(); 
    }

    //Filtrado por nombre usando LIKE (Coincidencias parciales)
    public function getCategoriasByNombre($nombre) {
        $query = $this->db->prepare('SELECT * FROM categorias WHERE nombre LIKE ?');
        $query->execute(["%$nombre%"]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    //Obtener una sola categoría por ID
    public function getCategoriaById($id) {
        $query = $this->db->prepare('SELECT * FROM categorias WHERE id = ?');
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    //Insertar una categoría
    public function insertCategoria($nombre, $imagen = null) {
        $query = $this->db->prepare('INSERT INTO categorias (nombre, imagen) VALUES (?, ?)');
        $query->execute([$nombre, $imagen]);
        return $this->db->lastInsertId(); // Retorna el ID generado para el Controller
    }

    
    public function updateCategoria($id, $nombre, $imagen = null) {
        $query = $this->db->prepare('UPDATE categorias SET nombre = ?, imagen = ? WHERE id = ?');
        return $query->execute([$nombre, $imagen, $id]);
    }

    public function getCategoriaItems($id) { 
        $query = $this->db->prepare('SELECT p.*, c.nombre AS nombre_categoria 
            FROM categorias c 
            JOIN perfume p ON c.id = p.id_categoria
            WHERE c.id = ?
        ');
        $query->execute([$id]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getCategorias($sortBy = 'id', $order = 'ASC') {
        // Lista blanca de campos permitidos para evitar SQL Injection en ORDER BY
        $allowedColumns = ['id', 'nombre'];
        if (!in_array($sortBy, $allowedColumns)) {
            $sortBy = 'id'; // Valor por defecto si mandan fruta
        }

        // Validamos el sentido del orden
        $order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';

        // Construimos la consulta SQL dinámica de forma segura
        $sql = "SELECT * FROM categorias ORDER BY $sortBy $order";
        
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ); 
    }

    public function deleteCategoria($id) {
        $query = $this->db->prepare('DELETE FROM categorias WHERE id = ?');
        return $query->execute([$id]);
    }
}