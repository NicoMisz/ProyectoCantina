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
        // echo "Funciona!!!!!";
        exit;
    }
    public function autenticarLogin()
    {




        // echo "<br>";
        // echo $data["id"];
        // echo "<pre>";
        // echo $hash;
        // var_dump();
        // require __DIR__ . '/../Views/common/login.php';
        // echo "Funciona!!!!!";
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
        // echo hash_equals($hash, hash('sha512', $password . $fechaCreacion));
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