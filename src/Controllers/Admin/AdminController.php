<?php
namespace Src\Controllers\Admin;
require_once __DIR__ . '/../../Model/Usuari.php';

use DateTime;
use Src\Model\Usuari\Usuari;

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
}
