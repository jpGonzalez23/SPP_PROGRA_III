<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

require __DIR__ . '/../vendor/autoload.php';

require_once './db/AccesoDatos.php';
// require_once './middlewares/Logger.php';

//require_once './controllers/UsuarioController.php';
require_once './controllers/ProductoController.php';
//require_once './controllers/VendedorController.php';

// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Instantiate App
$app = AppFactory::create();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

/*
// Routes
$app->group('/usuarios', function (RouteCollectorProxy $group) {
    $group->get('[/]', \UsuarioController::class . ':TraerTodos');
    $group->get('/{usuario}', \UsuarioController::class . ':TraerUno');
    $group->post('[/]', \UsuarioController::class . ':CargarUno');
  });

$app->get('[/]', function (Request $request, Response $response) {    
    $payload = json_encode(array("mensaje" => "Slim Framework 4 PHP"));
    
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});
*/

$app->group('/tienda/alta', function (RouteCollectorProxy $group) {
  $group->post('[/]', \ProductoController::class . '::CargarUno');
});

$app->group('/tienda/consulta', function (RouteCollectorProxy $group) { 
  $group->get('[/]', \ProductoController::class . '::TraerTodos');
  $group->get('/{id}', \ProductoController::class . '::TraerUno');
  $group->get('/{marca}&{tipo}', \ProductoController::class . '::TraerPorMarcaYTipo');
});

$app->group('/ventas/alta', function (RouteCollectorProxy $group) {
  $group->post('[/]', \VendedorController::class . '::CargarUno');
});

$app->group('/ventas/Consulta', function (RouteCollectorProxy $group) {
  $group->get('[/]', \VendedorController::class . '::TraerTodos');
});


$app->run();
