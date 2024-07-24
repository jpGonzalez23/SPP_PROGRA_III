<?php 

require_once './interfaces/ICrud.php';

class Vendedor implements ICrud {

    private $id;
    private $mail;
    private $nombre;
    private $tipo;
    private $marca;
    private $stock;
    private $fechaVenta;
    private $numPedidio;
    private $precioTotal;
    private $rutaFoto;

    public function getIdVendedor() {
        return $this->id;
    }

    public function setIdVendedor($id) {
        if(isset($id) && $id > 0) {
            $this->id = $id;
        }
        else {
            throw new Exception("El id debe ser un numero positivo");
        }
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        if(isset($nombre) && !empty($nombre)) {
            $this->nombre = $nombre;
        }
        else {
            throw new Exception("El espacio del nombre esta vacio");
        }
    }

    public function getMail() {
        return $this->mail;
    }

    public function setMail($mail) {
        if(isset($mail) && !empty($nombre)) {
            $this->mail = $mail;
        }
        else {
            throw new Exception("El espacio del mail esta vacio");
        }
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        if(isset($tipo) && !empty($tipo)) {
            $this->tipo = $tipo;
        }
        else {
            throw new Exception("El espacio del tipo esta vacio");
        }
    }

    public function getStock() {
        return $this->stock;
    }

    public function setStock($stock) {
        if(isset($stock) && $stock > 0) {
            $this->stock = $stock;
        }
        else {
            throw new Exception("El stock debe ser un numero positivo");
        }
    }

    public function getMarca() {
        return $this->marca;
    }

    public function setMarca($marca) {
        if(isset($marca) && !empty($marca)) {
            $this->marca = $marca;
        }
        else {
            throw new Exception("El espacio de la marca esta vacio");
        }
    }

    public function getFechaVenta() {
        return $this->fechaVenta;
    }

    public function setFechaVenta($fechaVenta) {
        if(isset($fechaVenta)) {
            $this->fechaVenta = $fechaVenta;
        }
        else {
            throw new Exception("El espacio de la fecha esta vacio");
        }
    }

    public function getRutaFoto() {
        return $this->fechaVenta;
    }

    public function setRutaFoto($rutaFoto) {
        if(isset($rutaFoto)) {
            $this->rutaFoto = $rutaFoto;
        }
        else {
            throw new Exception("El espacio de la fecha esta vacio");
        }
    }

    public function getPrecioTotal() {
        return $this->precioTotal;
    }

    public function setPrecioTotal($precioTotal ) {
        if(isset($precioTotal) && $precioTotal > 0) {
            $this->precioTotal = $precioTotal   ;
        }
        else {
            throw new Exception("El precio total debe ser un numero positivo");
        }
    }

    public static function crear($vendedor) {
        $db = AccesoDatos::obtenerInstancia();
        $consulta = $db->prepararConsulta("INSERT TO vendedor (mail, nombre, tipo, marca, stock, precioTotal, fechaVenta, rutaFoto) VALUES (:mail, :nombre, :tipo, :marca, :stock, :precioTotal, :fechaVenta, rutaFoto)");
        $consulta->bindValue(':mail', $vendedor->getMail(), PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $vendedor->getNombre(), PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $vendedor->getTipo(), PDO::PARAM_STR);
        $consulta->bindValue(':marca', $vendedor->getMarca(), PDO::PARAM_STR);
        $consulta->bindValue(':stock', $vendedor->getStock(), PDO::PARAM_INT);
        $consulta->bindValue(':precioTotal', $vendedor->getPrecioTotal());
        $consulta->bindValue(':fechaVenta', $vendedor->getFechaVenta());
        $consulta->bindValue(':rutaFoto', $vendedor->getStock(), PDO::PARAM_INT);

        $consulta->execute();

        return $db->obtenerUltimoId();
    }
    public static function obtenerTodos() {
        $db = AccesoDatos::obtenerInstancia();
        $consulta = $db->prepararConsulta("SELECT * FROM vendedor");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Vendedor');

    }
    public static function obtenerUno($mail) {
        $db = AccesoDatos::obtenerInstancia();
        $consulta = $db->prepararConsulta("SELECT * FROM vendedor WHERE mail = :mail");
        $consulta->bindValue(':mail', $mail, PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->fetchObject('Vendedor');
    }
    public static function modificar($obj) {
        $db = AccesoDatos::obtenerInstancia();
        $consulta = $db->prepararConsulta("UPDATE producto SET nombre = :nombre, precio = :precio, tipo = :tipo, marca = :marca, stock = :stock WHERE id = :valor");
    }
    public static function borrar($id) {
        $db = AccesoDatos::obtenerInstancia();
        $consulta = $db->prepararConsulta("");
    }
}