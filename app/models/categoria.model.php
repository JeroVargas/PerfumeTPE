<?php
class CategoriaModel{
    private $db;

    public function __construct(){
        $this->db = new PDO('mysql:host=localhost;dbname=perfumetpe;charset=utf8', 'root', '');
    }

    public function getCategorias (){ // Listado de categorias
        $query = $this->db->prepare('SELECT * FROM categorias');
        $query->execute();
        $categorias = $query->fetchAll(PDO::FETCH_OBJ);
        return $categorias; 
    }

    public function getCategoria ($id){ // Categoria por ID
        $query = $this->db->prepare('SELECT p.*, c.nombre AS nombre_categoria 
            FROM categorias c 
            JOIN perfume p ON c.id = p.id_categoria
            WHERE c.id = ?
        ');
        $query->execute([$id]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function insertCategoria($nombre) {
        $query = $this->db->prepare('INSERT INTO categorias (nombre) VALUES (?)');
        $query->execute([$nombre]);

        return $this->db->lastInsertId();
    }

    public function updateCategoria($id, $nombre) {
        $query = $this->db->prepare('UPDATE categorias SET nombre = ? WHERE id = ?');
        return $query->execute([$nombre, $id]);
    }

    public function deleteCategoria($id) {
        $query = $this->db->prepare('DELETE FROM categorias WHERE id = ?');
        return $query->execute([$id]);
    }
}