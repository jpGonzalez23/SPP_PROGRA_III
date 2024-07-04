<?php

require_once './interfaces/ICrud.php';

class Producto implements ICrud {
    private $id;
    private $nombre;
    private $precio;
    private $tipo;
    private $marca;
    private $stock;

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getNombre() {
        return $this->nombre;
    }
    public function setNombre($nombre) {
        if(isset($nombre) && !empty($nombre)) {
            $this->nombre = $nombre;
        }
    }

    public function getPrecio() {
        return $this->precio;
    }
    public function setPrecio($precio) {
        if(isset($precio)) {
            $this->precio = $precio;
        }
    }

    public function getTipo() {
        return $this->tipo;
    }
    public function setTipo($tipo) {
        if(isset($tipo) && !empty($tipo)) {
            $this->tipo = $tipo;
        }
    }

    public function getMarca() {
        return $this->marca;
    }
    public function setMarca($marca) {
        if(isset($marca) && !empty($marca)) {
            $this->marca = $marca;
        }
    }

    public function getStock() {
        return $this->stock;
    }
    public function setStock($stock) {
        if(isset($stock)) {
            $this->stock = $stock;
        }
    }

    public static function crear($obj) {
        $db = AccesoDatos::obtenerInstancia();
        $consulta = $db->prepararConsulta("INSERT INTO producto (nombre, precio, tipo, marca, stock) VALUES (:nombre, :precio, :tipo, :marca, :stock)");

        $consulta->bindValue(':nombre', $obj->getNombre(), PDO::PARAM_STR);
        $consulta->bindValue(':precio', $obj->getPrecio());
        $consulta->bindValue(':tipo', $obj->getTipo(), PDO::PARAM_STR);
        $consulta->bindValue(':marca', $obj->getMarca(), PDO::PARAM_STR);
        $consulta->bindValue(':stock', $obj->getStock(), PDO::PARAM_INT);

        $consulta->execute();

        return $db->obtenerUltimoId();
    }
    public static function obtenerTodos() {
        $db = AccesoDatos::obtenerInstancia();
        $consulta = $db->prepararConsulta("SELECT * FROM producto");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Producto');
    }
    public static function obtenerUno($obj) {
        $db = AccesoDatos::obtenerInstancia();
        $consulta = $db->prepararConsulta("SELECT * FROM producto WHERE nombre = :nombre AND marca = :marca");
        $consulta->bindValue(':nombre', $obj->getNombre(), PDO::PARAM_STR);
        $consulta->bindValue(':marca', $obj->getMarca(), PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Producto');
    }
    public static function modificar($obj) {
        $db = AccesoDatos::obtenerInstancia();

        $consulta = $db->prepararConsulta("UPDATE producto SET nombre = :nombre, precio = :precio, tipo = :tipo, marca = :marca, stock = :stock WHERE id = :valor");
        $consulta->bindValue(':valor', $obj->getId(), PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $obj->getNombre(), PDO::PARAM_STR);
        $consulta->bindValue(':precio', $obj->getPrecio());
        $consulta->bindValue(':marca', $obj->getMarca(), PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $obj->getTipo(), PDO::PARAM_STR);
        $consulta->bindValue(':stock', $obj->getStock(), PDO::PARAM_STR);

        $consulta->execute();
    }
    public static function borrar($id) {
        $db = AccesoDatos::obtenerInstancia();
        $consulta = $db->prepararConsulta("DELETE FROM productos WHERE id_producto = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        return $consulta->execute();
    }
    
}