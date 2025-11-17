<?php
namespace Src\Controllers\Admin;
require_once __DIR__ . '/../../Model/Usuari.php';
require_once __DIR__ . '/../../Model/Article.php';

use DateTime;
use Src\Model\Usuari\Usuari;
use Src\Model\Article\Article;

class AdminController
{
    // public function index()
    // {
    // }

    public function cambiarPassword()
    {
        require __DIR__ . '/../../Views/common/usuaris/cambiarPassword.php';
        exit;
    }

    public function ajaxCambiarPassword()
    {
        header('Content-Type: application/json; charset=utf-8');
        $email = $_POST["email"] ?? null;
        $password = $_POST["password"] ?? null;
        $password2 = $_POST["password_comprovacio"] ?? null;
        if ($password == $password2) {
            $usuari = (new Usuari())->obtenirUsuariPerEmail($email);
            $hash = hash('sha512', $password . $usuari['fechaCreacion']);
            $usuari["password"] = $hash;
            $fitxer = $usuari['id'] . '-' . $usuari['fechaCreacion'];
            $path = __DIR__ . '/../../../data/database/Usuaris/' . $fitxer . '.json';
            file_put_contents($path, json_encode($usuari, JSON_PRETTY_PRINT), LOCK_EX);
            $res = ["res" => 1, "msg" => "Usuari login correcte."];
            session_destroy();
            return json_encode($res, JSON_PRETTY_PRINT);
        } else {
            $res = ["res" => 0, "msg" => "Contraseña diferente"];
            return json_encode($res, JSON_PRETTY_PRINT);
        }
    }


    // Se tiene que eliminar / modificar para que este en el gestioUsuaris
    public function perfil($email = null)
    {
        if ($email == null) {
            $email = $_SESSION['user']['email'];
        }
        $vista = 'admin';
        $data = (new Usuari())->obtenirUsuariPerEmail($email);
        require __DIR__ . '/../../Views/common/usuaris/perfil.php';
        exit;
    }

    public function editarProducte()
    {
        $articuloFile = htmlspecialchars(trim($_POST['articulo-file'] ?? ''), ENT_QUOTES, 'UTF-8');
        $articuloId = filter_var($_POST['articulo-id'], FILTER_SANITIZE_NUMBER_INT);
        $articuloNombre = htmlspecialchars(trim($_POST['articulo-nombre']), ENT_QUOTES, 'UTF-8');
        $articuloDescripcion = htmlspecialchars(trim($_POST['articulo-descripcion']), ENT_QUOTES, 'UTF-8');
        $articuloPrecio = filter_var($_POST['articulo-precio'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $articuloHorario = htmlspecialchars(trim($_POST['articulo-horario']), ENT_QUOTES, 'UTF-8');
        $articuloCantidad = filter_var($_POST['articulo-cantidad'], FILTER_SANITIZE_NUMBER_INT);

        $articulo = [
            "id" => intval($articuloId),
            "nombre" => $articuloNombre,
            "descripcion" => $articuloDescripcion,
            "precio" => floatval($articuloPrecio),
            "horario" => $articuloHorario,
            "cantidad" => intval($articuloCantidad),
            "ingredientes" => [],
            "imagen" => ""
        ];
        echo $articuloFile;
        echo "<pre>";
        print_r($articulo);
        // require DIR . '/../../Views/admin/gestioProductes.php';
        exit;
    }
    public function afegirProducte()
    {
        // $data = (new Article())->obtenirArticles();
        // echo '<pre>';
        // var_dump($data);
        // exit;

        // require DIR . '/../../Views/admin/gestioProductes.php';
        exit;
    }

    public function gestioProductes()
    {
        $data = (new Article())->obtenirArticles();
        // echo '<pre>';
        // var_dump($data);
        // exit;

        require __DIR__ . '/../../Views/admin/gestioProductes.php';
        exit;
    }

    public function gestioUsuaris($email = null)
    {
        if ($email == null) {
            $email = $_SESSION['user']['email'];
        }
        $vista = 'admin';
        $data = (new Usuari())->obtenirUsuariPerEmail($email);
        require __DIR__ . '/../../Views/admin/gestioUsuaris.php';
        exit;
    }
}
