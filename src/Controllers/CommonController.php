<?php
namespace Src\Controllers;

use DateTime;
class CommonController
{
    public function index()
    {
        echo "CommonController funcionando";
    }

    public function login()
    {
        require __DIR__ . '/../Views/common/login.php';
        exit;
    }
    public function autenticarLogin()
    {
        $email = $_POST["email"] ?? null;
        $password = $_POST["password"] ?? null;
        $correus = json_decode(file_get_contents('../data/database/Usuaris/userEmail.json'), true);
        // echo $correus["jancoten@gmail.com"];
        if (isset($correus[$email])) {
            // $userId = $correus[$email];
            $usuari = json_decode(file_get_contents('../data/database/Usuaris/' . $correus[$email] . '.json'), true);
            // echo "hola1";
            // var_dump($usuari);

            // echo $usuari['fechaCreacion'];
            echo $usuari['password'];
            echo "<br>";
            echo hash('sha512', $password . $usuari['fechaCreacion']);
            $eq = hash_equals($usuari['password'], hash('sha512', $password . $usuari['fechaCreacion']));
            echo $eq;
            $_SESSION['user'] = [
                'id' => $usuari['id'],
                'email' => $usuari['email'],
                'fechaCreacion' => $usuari['fechaCreacion'],
                'rol' => $usuari['rol']
            ];
            var_dump($_SESSION)['user'];
        } else {
            echo "Email no trobat.";
        }
        return "hola";


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


    public function registrar()
    {
        require __DIR__ . '/../Views/common/registrar.php';
    }
    public function registrarUsuari()
    {
        $id = $this->obtenirId();
        $nombre = $_POST["nombre"] ?? null;
        $apellidos = $_POST["apellidos"] ?? null;
        $email = $_POST["email"] ?? null;
        $fechaCreacion = date('dmY-His');
        $password = $_POST["password"] ?? null;
        $rol = 'usuario';
        $activo = True;
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
        $this->afegirCorreu($email, $fitxer);
        file_put_contents($path, json_encode($jsondecode, JSON_PRETTY_PRINT), LOCK_EX);
        // Desencriptar contraseña
    }

    public function afegirCorreu($correu, $fitxer)
    {
        $path = '../data/database/Usuaris/userEmail.json';
        $json = file_get_contents($path);
        $jsondecode = json_decode($json, true);
        $jsondecode[$correu] = $fitxer;
        file_put_contents($path, json_encode($jsondecode, JSON_PRETTY_PRINT), LOCK_EX);
    }
}