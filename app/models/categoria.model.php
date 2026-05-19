<?php
class CategoriaModel extends Model{

    public function __construct() {
        parent::__construct(); 
    }

    public function getCategorias() {
        $query = $this->db->prepare('SELECT * FROM categorias');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ); 
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

    public function getCategoriaById($id) {
        $query = $this->db->prepare('SELECT * FROM categorias WHERE id = ?');
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function insertCategoria($nombre, $imagen = null) {
        $query = $this->db->prepare('INSERT INTO categorias (nombre, imagen) VALUES (?, ?)');
        $query->execute([$nombre, $imagen]);
        return $this->db->lastInsertId();
    }

    public function updateCategoria($id, $nombre, $imagen = null) {
        $query = $this->db->prepare('UPDATE categorias SET nombre = ?, imagen = ? WHERE id = ?');
        return $query->execute([$nombre, $imagen, $id]);
    }

    public function deleteCategoria($id) {
        $query = $this->db->prepare('DELETE FROM categorias WHERE id = ?');
        return $query->execute([$id]);
    }
}