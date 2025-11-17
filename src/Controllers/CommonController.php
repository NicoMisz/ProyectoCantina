<?php
namespace Src\Controllers;
require_once __DIR__ . '/../Model/Usuari.php';

use DateTime;
use Src\Model\Usuari\Usuari;
class CommonController
{

    public function dashboard()
    {
        require __DIR__ . '/../Views/common/usuaris/dashboard.php';
        exit;
    }

    public function login()
    {
        require __DIR__ . '/../Views/common/usuaris/login.php';
        exit;
    }

    public function registrar()
    {
        require __DIR__ . '/../Views/common/usuaris/registrar.php';
        exit;
    }

    public function aboutUs()
    {
        require __DIR__ . '/../Views/common/usuaris/aboutUs.php';
        exit;
    }
    
    public function cambiarPassword()
    {
        require __DIR__ . '/../Views/common/usuaris/cambiarPassword.php';
        exit;
    }
    
    public function carrito()
    {
        require __DIR__ . '/../Views/common/usuaris/carrito.php';
        exit;
    }
    
    public function catalogo()
    {
        require __DIR__ . '/../Views/common/usuaris/catalog.php';
        exit;
    }
    
    public function formulari()
    {
        require __DIR__ . '/../Views/common/usuaris/formulari.php';
        exit;
    }
    
    public function perfil()
    {
        require __DIR__ . '/../Views/common/usuaris/perfil.php';
        exit;
    }
    
    public function ticket()
    {
        require __DIR__ . '/../Views/common/usuaris/ticket.php';
        exit;
    }
    
    public function logOut()
    {
        session_destroy();
        header('Location:' .'/dashboard');
        exit;
    }

    public function ajaxAutenticarLogin()
    {
        header('Content-Type: application/json; charset=utf-8');
        $email = $_POST["email"] ?? null;
        $password = $_POST["password"] ?? null;
        $usuari = (new Usuari())->obtenirUsuariPerEmail($email);
        if (!($usuari == null)) {
            $eq = hash_equals($usuari['password'], hash('sha512', $password . $usuari['fechaCreacion']));
            if ($eq) {
                $_SESSION['user'] = [
                    'id' => $usuari['id'],
                    'email' => $usuari['email'],
                    'fechaCreacion' => $usuari['fechaCreacion'],
                    'rol' => $usuari['rol'],
                    'token' => date('dmY-His')
                ];
                $res = ["res" => 1, "msg" => "Usuari login correcte.", "redirect" => "/dashboard"];
                // header('Location: /login');

            } else {
                $res = ["res" => 0, "msg" => "Contrasenya incorrecta."];
            }
        } else {
            $res = ["res" => 0, "msg" => "Usuari incorrecte."];
        }
        return json_encode($res, JSON_PRETTY_PRINT);
    }


    public function obtenirId()
    {
        $path = "../data/database/Id/currentId.json";
        $file = file_get_contents($path);
        $currId = json_decode($file, true);
        $id = $currId["id"] + 1;
        file_put_contents($path, json_encode(["id" => $id], JSON_PRETTY_PRINT), LOCK_EX);
        return $id;
    }


    public function ajaxRegistrarUsuari()
    {
        $id = $this->obtenirId();
        $nombre = $_POST["nombre"] ?? null;
        $apellidos = $_POST["apellidos"] ?? null;
        $email = $_POST["email"] ?? null;
        $fechaCreacion = date('dmY-His');
        $password = $_POST["password"] ?? null;
        $password2 = $_POST["password_comprovacio"] ?? null;
        $rol = 'usuario';
        $activo = True;
        if ($password === $password2) {
            $hash = hash('sha512', $password . $fechaCreacion);
            $json = file_get_contents('../data/class/User.json');
            $jsondecode = json_decode($json, true);
            $jsondecode["id"] = $id;
            $jsondecode["nombre"] = $nombre;
            $jsondecode["apellidos"] = $apellidos;
            $jsondecode["email"] = $email;
            $jsondecode["fechaCreacion"] = $fechaCreacion;
            $jsondecode["password"] = $hash;
            $jsondecode["rol"] = $rol;
            $jsondecode["activo"] = $activo;
            $fitxer = $id . '-' . $fechaCreacion;
            $path = '../data/database/Usuaris/' . $fitxer . '.json';
            $res = $this->afegirCorreu($email, $fitxer);
            file_put_contents($path, json_encode($jsondecode, JSON_PRETTY_PRINT), LOCK_EX);
            return $res;
        } else {
            header('Content-Type: application/json; charset=utf-8');
            $res = ["res" => 0, "msg" => "Contraseña diferente"];
            return $res;
        }
    }

    public function afegirCorreu($correu, $fitxer)
    {
        $path = '../data/database/Usuaris/userEmail.json';
        $json = file_get_contents($path);
        $jsondecode = json_decode($json, true);
        $jsondecode[$correu] = $fitxer;
        file_put_contents($path, json_encode($jsondecode, JSON_PRETTY_PRINT), LOCK_EX);

        header('Content-Type: application/json; charset=utf-8');
        $res = ["res" => 1, "msg" => "Usuari afegit correctament."];
        return json_encode($res, JSON_PRETTY_PRINT);
    }
}