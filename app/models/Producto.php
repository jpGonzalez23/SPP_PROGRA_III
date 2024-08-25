<?php

require_once './interfaces/ICrud.php';

class Producto implements ICrud
{
    private $id;
    private $nombre;
    private $precio;
    private $tipo;
    private $marca;
    private $stock;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        if ($id > 0) {
            $this->id = $id;
        } else {
            throw new Exception("El ID debe ser positivo");
        }
    }

    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($nombre)
    {
        if (!empty($nombre)) {
            $this->nombre = $nombre;
        } else {
            throw new Exception("El nombre no puede estar vacio");
        }
    }

    public function getPrecio()
    {
        return $this->precio;
    }
    public function setPrecio($precio)
    {
        if ($precio > 0) {
            $this->precio = $precio;
        } else {
            throw new Exception("El precio debe ser positivo");
        }
    }

    public function getTipo()
    {
        return $this->tipo;
    }
    public function setTipo($tipo)
    {
        if (in_array($tipo, ['Smartphone', 'Tablet'])) {
            $this->tipo = $tipo;
        } else {
            throw new Exception("El tipo debe ser 'Smartphone' o 'Tablet'.");
        }
    }

    public function getMarca()
    {
        return $this->marca;
    }
    public function setMarca($marca)
    {
        if (!empty($marca)) {
            $this->marca = $marca;
        } else {
            throw new Exception("La marca no puede estar vacia");
        }
    }

    public function getStock()
    {
        return $this->stock;
    }
    public function setStock($stock)
    {
        if ($stock > 0) {
            $this->stock = $stock;
        } else {
            throw new Exception("El stock debe ser positivo");
        }
    }

    public static function crear($producto)
    {
        $db = AccesoDatos::obtenerInstancia();
        $consulta = $db->prepararConsulta("INSERT INTO producto (nombre, precio, tipo, marca, stock) VALUES (:nombre, :precio, :tipo, :marca, :stock)");

        $consulta->bindValue(':nombre', $producto->getNombre(), PDO::PARAM_STR);
        $consulta->bindValue(':precio', $producto->getPrecio(), PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $producto->getTipo(), PDO::PARAM_STR);
        $consulta->bindValue(':marca', $producto->getMarca(), PDO::PARAM_STR);
        $consulta->bindValue(':stock', $producto->getStock(), PDO::PARAM_INT);

        $consulta->execute();

        return $db->obtenerUltimoId();
    }
    public static function obtenerTodos(): array
    {
        $db = AccesoDatos::obtenerInstancia();
        $consulta = $db->prepararConsulta("SELECT * FROM `producto`");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Producto');
    }

    public static function obtenerUno($id): ?Producto
    {
        $db = AccesoDatos::obtenerInstancia();
        $consulta = $db->prepararConsulta("SELECT * FROM producto WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchObject('Producto');
    }

    public static function modificar($obj)
    {
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
    public static function borrar($id)
    {
        $db = AccesoDatos::obtenerInstancia();
        $consulta = $db->prepararConsulta("DELETE FROM productos WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        return $consulta->execute();
    }

    public static function obtenerPorMarcaYTipo($marca, $tipo)
    {
        $db = AccesoDatos::obtenerInstancia();
        $consulta = $db->prepararConsulta("SELECT * FROM producto WHERE marca = :marca AND tipo = :tipo");
        $consulta->bindValue(':marca', $marca, PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $tipo, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Producto');
    }
}
