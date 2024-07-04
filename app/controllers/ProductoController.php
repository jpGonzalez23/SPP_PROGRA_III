<?php

require_once './models/Producto.php';
require_once './interfaces/IApiUsable.php';

class ProductoController extends Producto implements IApiUsable {

    private static $marcaValida = array('Motorola', 'Samsung', 'Xiaomi', 'LG');
    private static $tipoValido = array('Smartphone', 'Table');

    public static function CargarUno($request, $response, $args) {
        $params = $request->getParsedBody();

        $nombre = $params['nombre'];
        $precio = $params['precio'];
        $tipo = $params['tipo'];
        $marca = $params['marca'];
        $stock = $params['stock'];

        if(in_array($tipo,self::$tipoValido) && in_array($marca,self::$marcaValida)) {

            $producto = new Producto();

            $producto->setNombre($nombre);
            $producto->setPrecio($precio);
            $producto->setTipo($tipo);
            $producto->setMarca($marca);
            $producto->setStock($stock);
        
            Producto::crear($producto);
            
            $payload = json_encode(array("Mensaje" => "Se creo el producto con exito"));
        }
        else {
            $payload = json_encode(array("Mensaje Error" => "No es un tipo valio o marca valida"));
        }

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
    public static function TraerUno($request, $response, $args) {
        $params = $request->getParsedBody();

        $nombre = $params['nombre'];
        $marca = $params['marca'];

        if(in_array($marca,self::$marcaValida) && !empty($nombre)) {
            $producto = new Producto();
            $producto->setNombre($nombre);
            $producto->setMarca($marca);

            $resultado = Producto::obtenerUno($producto);

            if($resultado) {
                $payload = json_encode(array("Producto: " => $resultado));
            }
            else {
                $payload = json_encode(array("Mensaje Error" => "Producto no encontrado"));
            }
            
        }
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
	public static function TraerTodos($request, $response, $args) {
        $listado = Producto::obtenerTodos();

        if($listado) {
            $payload = json_encode(array("Mensaje" => $listado));
        }
        else {
            $payload = json_encode(array("Mensaje error" => "Error al mostrar los productos"));
        }

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');

    }
	
	public static function BorrarUno($request, $response, $args) {

    }
	public static function ModificarUno($request, $response, $args) {

    }
}