<?php
require_once __DIR__ . '/../src/Controllers/CommonController.php';
require_once __DIR__ . '/../src/Controllers/User/UserController.php';
require_once __DIR__ . '/../src/Controllers/Admin/AdminController.php';

use Src\Controllers\CommonController;
use Src\Controllers\User\UserController;
use Src\Controllers\Admin\AdminController;

session_start();

define('ROOT_PATH', dirname(__DIR__));
define('SRC_PATH', ROOT_PATH . '/src');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('RELATIVE_PUBLIC_PATH', '/public');
define('VIEWS_PATH', ROOT_PATH . '/views');
define('CONTROLLERS_PATH', SRC_PATH . '/Controllers');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if ($uri === '/login' || $uri === '/registrar') {
    switch ($uri) {
        case '/login':
            $controller = new CommonController();
            switch ($method) {
                case 'GET':
                    $controller->login();
                    break;
                case 'POST':
                    echo $controller->ajaxAutenticarLogin();
                    break;
            }
            exit;

        case '/registrar':
            switch ($method) {
                case 'GET':
                    (new CommonController())->registrar();
                    break;
                case 'POST':
                    $controller = new CommonController();
                    $response = $controller->ajaxRegistrarUsuari();
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    break;
            }
            exit;
    }
}

if ($uri === '' || $uri === '/' || $uri === '/dashboard') {
    $rol = $_SESSION['user']['rol'];

    (new CommonController())->dashboard();

    exit;
}

if (!empty($_SESSION['user']) && !empty($_SESSION['user']['token'])) {
    $currToken = new DateTime();
    $tokenDateTime = DateTime::createFromFormat('dmY-His', $_SESSION['user']['token']);

    if ($tokenDateTime === false) {
        session_destroy();
        header('Location: /login');
        exit;
    }

    $diferencia = $currToken->getTimestamp() - $tokenDateTime->getTimestamp();

    if ($diferencia < 3600) {
        // Renovar token
        $_SESSION['user']['token'] = date('dmY-His');
    } else {
        // Token expirado
        session_destroy();
        header('Location: /login');
        exit;
    }
} else {
    header('Location: /login');
    exit;
}


$rol = $_SESSION['user']['rol'];
if (!empty($rol)) {
    // switch commun
    switch ($uri) {
        case '/common/usuaris/about_us':
            (new CommonController())->aboutUs();
            exit;

        case '/common/usuaris/cambiar_password':
            (new CommonController())->cambiarPassword();
            exit;

        case '/common/usuaris/carrito':
            (new CommonController())->carrito();
            exit;

        case '/common/usuaris/catalogo':
            (new CommonController())->catalogo();
            exit;

        case '/common/usuaris/dashboard':
            (new CommonController())->dashboard();
            exit;

        case '/common/usuaris/formulari':
            (new CommonController())->formulari();
            exit;

        case '/common/usuaris/login':
            (new CommonController())->login();
            exit;

        case '/common/usuaris/perfil':
            (new CommonController())->perfil();
            exit;

        case '/common/usuaris/registrar':
            (new CommonController())->registrar();
            exit;

        case '/common/usuaris/ticket':
            (new CommonController())->ticket();
            exit;
    }
}

// echo $rol;
switch ($rol) {
    case 'admin':
        switch ($uri) {
            case '/admin/perfil':
                $controller = new AdminController();
                if ($method === 'GET') {
                    $controller->perfil();
                }
                exit;

            case '/admin/gestio-productes':
                $controller = new AdminController();
                if ($method === 'GET') {
                    $controller->gestioProductes();
                }
                exit;

            case '/admin/gestio-usuaris':
                $controller = new AdminController();
                if ($method === 'GET') {
                    $controller->gestioUsuaris();
                }
                exit;

            case '/admin/cambiar-password':
                switch ($method) {
                    case 'GET':
                        $controller = new AdminController();
                        $controller->cambiarPassword();
                        break;
                    case 'POST':
                        $controller = new AdminController();
                        $response = $controller->ajaxCambiarPassword();
                        header('Content-Type: application/json');
                        echo json_encode($response);
                        break;
                }
                exit;

            case '/common/usuaris/gestio-perfil':
                $controller = new AdminController();
                if ($method === 'GET') {
                    $controller->gestioUsuaris();
                }
                exit;

            default:
                http_response_code(404);
                echo "404 - Página no encontrada";
                exit;
        }

    case 'usuario':
        if ($method === 'GET') {
            switch ($uri) {
                case '/perfil':
                    (new UserController())->perfil();
                    exit;

                case '/common/usuaris/gestio-perfil':
                    (new UserController())->perfil();
                    exit;


                default:
                    http_response_code(404);
                    echo "404 - Página no encontrada";
                    exit;
            }
        }
        break;

    default:
        http_response_code(403);
        echo "403 - Acceso denegado";
        exit;
}
