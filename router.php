<?php
require_once './app/libs/response.php';
require_once './app/middlewares/session.auth.middlewares.php';
require_once './app/middlewares/verify.auth.middlewares.php';
require_once './app/middlewares/verify.admin.middlewares.php';
require_once './app/controllers/perfume.controller.php';
require_once './app/controllers/categoria.controller.php';
require_once './app/controllers/auth.controller.php';

define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

$res = new Response();

sessionAuthMiddleware($res);

$action = 'index';
if (!empty($_GET['action'])) {
    $action = $_GET['action'];
}

$params = explode('/', $action);

switch ($params[0]) {
    case 'index':
        //sessionAuthMiddleware($res);
        $controller = new PerfumeController($res);
        $controller->showHome();
        break;

    case 'listaPerfumes':
        $controller = new PerfumeController($res);
        $controller->showPerfumes();
        break;

    case 'detalle_perfume':
        if (isset($params[1])) {
            $id = $params[1];
            $controller = new PerfumeController($res);
            $controller->showPerfumeDetail($id);
        } else {
            $controller = new PerfumeController($res);
            $controller->showError("No se especificó un ID de perfume.");
        }
        break;
    case 'listaCategorias':
        $controller = new ControllerCategoria($res);
        $controller->showCategorias();
        break;

    case 'detalle_categoria':
        if (isset($params[1])) {
            $id = $params[1];
            $controller = new ControllerCategoria($res);
            $controller->showCategoriaById($id);
        } else {
            $controller = new ControllerCategoria($res);
            $controller->showError("No se especificó un ID de categoria.");
        }
        break;
    
    case 'register':
        $controller = new AuthController($res);
        $controller->showRegister();
        break;

    case 'register-user':
        $controller = new AuthController($res);
        $controller->registerUser();
        break;
    
    case 'login':
        $controller = new AuthController($res);
        $controller->showLogin();
        break;

    case 'verificar-login':
        $controller = new AuthController($res);
        $controller->verifyLogin();
        break;

    case 'error':
        sessionAuthMiddleware($res);
        $controller = new PerfumeController($res);
        $controller->showError("404 Page Not Found");
        break;

    default:
        $controller = new PerfumeController($res);
        $error = "404 Page Not Found";
        $controller->showError($error);
        break;
}
