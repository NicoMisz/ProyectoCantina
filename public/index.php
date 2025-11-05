<?php
require_once __DIR__ . '/../src/Controllers/CommonController.php';
require_once __DIR__ . '/../src/Controllers/User/UserController.php';
require_once __DIR__ . '/../src/Controllers/Admin/AdminController.php';

use Src\Controllers\CommonController;
use Src\Controllers\User\UserController;
use Src\Controllers\Admin\AdminController;

session_start();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if ($uri === '/login') {
    if ($method === 'GET') {
        (new DefaultController())->login();
    } elseif ($method === 'POST') {
        $controller = new UserController();
        $response = $controller->autenticarLogin($_POST);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    exit;
}

if (!isset($_SESSION['user'])) {
    echo "HOLA TEST";
    // header('Location: /login');
    exit;
}

$role = $_SESSION['user']['role'];

if ($role === 'admin') {
    if ($method === 'GET') {
        if ($uri === '/') {
            (new DefaultController())->homeAdmin();
        } elseif ($uri === '/admin/panel') {
            (new AdminController())->dashboard();
        } else {
            http_response_code(404);
            echo "404 - Página no encontrada";
        }
    }
    exit;
} elseif ($role === 'usuario') {
    if ($method === 'GET') {
        if ($uri === '/') {
            (new DefaultController())->homeUsuario();
        } elseif ($uri === '/perfil') {
            (new UserController())->perfil();
        } else {
            http_response_code(404);
            echo "404 - Página no encontrada";
        }
    }
    exit;
} else {
    http_response_code(403);
    echo "403 - Acceso denegado";
    exit;
}
