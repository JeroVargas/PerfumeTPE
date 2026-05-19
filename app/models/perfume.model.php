<?php
class PerfumeModel extends Model{

    public function __construct() {
        parent::__construct(); 
    }

    public function getPerfumes(){
        $query = $this->db->prepare('SELECT p.*, c.nombre AS categoria FROM perfume p JOIN categorias c ON p.id_categoria = c.id');
        $query->execute();
        $perfumes = $query->fetchAll(PDO::FETCH_OBJ);
        return $perfumes; 
    }

    public function getPerfume($id){
        $query = $this->db->prepare('SELECT * FROM perfume WHERE id=?');
        $query->execute([$id]);
        $perfume = $query->fetch(PDO::FETCH_OBJ);
        return $perfume;
    }

    public function insertPerfume($id_caterogia,$nombre,$nota,$precio,$imagen = null){
        $query = $this->db->prepare('INSERT INTO perfume(id_categoria,nombre,nota,precio,imagen) VALUE (?,?,?,?,?)');
        $query->execute([$id_caterogia,$nombre,$nota,$precio,$imagen]);
        return $this->db->lastInsertId();
    }

    public function updatePerfume($id,$id_categoria,$nombre,$nota,$precio,$imagen = null){
        $query = $this->db->prepare('UPDATE perfume SET id_categoria = ? , nombre = ? , nota = ? , precio = ? , imagen = ? WHERE id = ?');
        $query -> execute([$id_categoria,$nombre,$nota,$precio,$imagen,$id]);
    }

    public function deletePerfume($id){
        $query = $this->db->prepare('DELETE FROM perfume WHERE id = ? ');
        $query -> execute([$id]);
    }
}