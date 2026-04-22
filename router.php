<?php
require_once './app/libs/response.php';
//require_once './app/middlewares/session.auth.middlewares.php';
//require_once './app/middlewares/verify.auth.middlewares.php';
//require_once './app/middlewares/verify.admin.middlewares.php';
require_once './app/controllers/perfume.controller.php';
require_once './app/controllers/categoria.controller.php';
//require_once './app/controllers/auth.controller.php';

define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

$res = new Response();

//sessionAuthMiddleware($res);

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
}
