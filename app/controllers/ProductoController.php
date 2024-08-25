<?php

require_once './models/Producto.php';
require_once './interfaces/IApiUsable.php';

class ProductoController extends Producto implements IApiUsable
{

    private static $marcaValida = array('Motorola', 'Samsung', 'Xiaomi', 'LG');
    private static $tipoValido = array('Smartphone', 'Table');

    public static function CargarUno($request, $response, $args)
    {
        $params = $request->getParsedBody();

        $nombre = $params['nombre'];
        $precio = $params['precio'];
        $tipo = $params['tipo'];
        $marca = $params['marca'];
        $stock = $params['stock'];

        if (in_array($tipo, self::$tipoValido) && in_array($marca, self::$marcaValida)) {
            $producto = new Producto();
            $producto->setNombre($nombre);
            $producto->setPrecio($precio);
            $producto->setTipo($tipo);
            $producto->setMarca($marca);
            $producto->setStock($stock);

            Producto::crear($producto);

            $payload = json_encode(array("Mensaje" => "Se creo el producto con exito"));
        } else {
            $payload = json_encode(array("Mensaje Error" => "No es un tipo valio o marca valida"));
        }

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
    public static function TraerUno($request, $response, $args)
    {
        $id = $args['id'];
        $producto = Producto::obtenerUno($id);
        $payload = json_encode(array("Producto" => $producto));
        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }
    public static function TraerTodos($request, $response, $args)
    {
        $listado = Producto::obtenerTodos();
        $payload = json_encode(array("Lista de productos" => $listado));
        $response->getBody()->write($payload);
        
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function TraerPorMarcaYTipo($request, $response, $args)
    {
        $params = $request->getParsedBody();

        $marca = $params['marca'];
        $tipo = $params['tipo'];

        $listado = Producto::obtenerPorMarcaYTipo($marca, $tipo);

        if ($listado) {
            $payload = json_encode(array("Producto" => $listado));
        } else {
            $payload = json_encode(array("Mensaje" => "No se encontro el producto"));
        }

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function BorrarUno($request, $response, $args)
    {
    }
    public static function ModificarUno($request, $response, $args)
    {
    }
}
