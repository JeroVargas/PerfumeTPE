<?php
require_once './app/libs/response.php';
require_once './app/middlewares/session.auth.middlewares.php';
require_once './app/middlewares/verify.auth.middlewares.php';
require_once './app/middlewares/verify.admin.middlewares.php';
require_once './app/models/Model.php'; 
require_once './app/controllers/perfume.controller.php';
require_once './app/controllers/categoria.controller.php';
require_once './app/controllers/auth.controller.php';

// define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

$res = new Response();

sessionAuthMiddleware($res);

$action = 'index';
if (!empty($_GET['action'])) {
    $action = $_GET['action'];
}

$params = explode('/', $action);

switch ($params[0]) {
    case 'index':
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

    case 'admin-categorias':
        verifyAdminMiddleware($res);
        $controller = new ControllerCategoria($res);
        $controller->showAdminCategorias();
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

    case 'logout':
        $controller = new AuthController($res);
        $controller->logout();
        break;

    case 'verificar-login':
        $controller = new AuthController($res);
        $controller->verifyLogin();
        break;
    
    case 'panel_de_control':
        verifyAdminMiddleware($res);
        $controller = new PerfumeController($res);
        $controller->showPanelDeControl();
        break;

    case 'show-add-perfume-form':
        verifyAdminMiddleware($res);
        $controller = new PerfumeController($res);
        $controller->showAddForm();
        break;

    case 'add-perfume':
        verifyAdminMiddleware($res);
        $controller = new PerfumeController($res);
        $controller->addPerfume();
        break;

    case 'delete-perfume':
        verifyAdminMiddleware($res);
        $controller = new PerfumeController($res);
        if (isset($params[1])) {
            $id = $params[1];
            $controller->deletePerfume($id);
        } else {
            $controller->showError("No se especifico un ID para borrar.");
        }
        break;

    case 'show-edit-form':
        verifyAdminMiddleware($res);
        $controller = new PerfumeController($res);
        $id = $params[1];
        $controller->showEditForm($id);
        break;

    case 'update-perfume':
        verifyAdminMiddleware($res);
        $controller = new PerfumeController($res);
        $controller->updatePerfume();
        break;
    
    case 'form-add-categoria':
        verifyAdminMiddleware($res);
        $controller = new ControllerCategoria($res);
        $controller->showAddForm(); // Esta es la que llama a la vista
        break;

    case 'add-categoria':
        verifyAdminMiddleware($res);
        $controller = new ControllerCategoria($res);
        $controller->addCategoria();
        break;

    case 'delete-categoria':
        verifyAdminMiddleware($res);
        $controller = new ControllerCategoria($res);
        if (isset($params[1])) {
            $controller->deleteCategoria($params[1]);
        }
        break;

    case 'show-edit-categoria':
        verifyAdminMiddleware($res);
        $controller = new ControllerCategoria($res);
        $controller->showEditForm($params[1]);
        break;

    case 'update-categoria':
        verifyAdminMiddleware($res);
        $controller = new ControllerCategoria($res);
        $controller->updateCategoria();
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
