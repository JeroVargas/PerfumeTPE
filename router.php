<?php
require_once __DIR__ . '/app/libs/router/router.php';
require_once __DIR__ . '/app/libs/jwt/jwt.middleware.php'; 
require_once __DIR__ . '/app/models/Model.php';
require_once __DIR__ . '/app/controllers/CategoriaApiController.php';
require_once __DIR__ . '/app/controllers/UserApiController.php';

$router = new Router();

$router->addMiddleware(new JWTMiddleware());

// 2. RUTA PARA OBTENER EL TOKEN (Autenticarse)
$router->addRoute('api/auth/token', 'POST', 'UserApiController', 'getToken');

// 3. RUTAS DE CATEGORIAS
$router->addRoute('api/categorias', 'GET', 'CategoriaApiController', 'getCategorias');
$router->addRoute('api/categorias/:id', 'GET', 'CategoriaApiController', 'getCategoriaById');
$router->addRoute('api/categorias', 'POST', 'CategoriaApiController', 'insertCategoria');
$router->addRoute('api/categorias/:id', 'PUT', 'CategoriaApiController', 'updateCategoria');

$resource = $_GET["resource"] ?? '';
$router->route($resource, $_SERVER['REQUEST_METHOD']);