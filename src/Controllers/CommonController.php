<?php
namespace Src\Controllers;
require_once __DIR__ . '/../Model/Usuari.php';

use DateTime;
use Src\Model\Usuari\Usuari;
use Src\Model\Article\Article;

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
        $data = (new Article())->obtenirArticles();
        // echo "<pre>";
        // var_dump($data);
        // exit;
        require __DIR__ . '/../Views/common/usuaris/catalago.php';
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

    public function pedidos()
    {
        require __DIR__ . '/../Views/common/usuaris/pedidos.php';
        exit;
    }

    public function logOut()
    {
        session_destroy();
        header('Location:' . '/dashboard');
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
        echo json_encode($res, JSON_PRETTY_PRINT);
        exit;
    }
    public function xmlAfegirArticle()
    {
        $jsonstring = $_POST["data"];
        $article = json_decode($jsonstring);
        $data = (new Article())->obtenirArticle($article[0]);

        // echo "<pre>";
        // var_dump($data);
        // var_dump($article);
        // exit;

        if (!array_key_exists("carreto", $_COOKIE)) {
            // echo "Creació Cookie";
            // $data = json_encode($data);
            $carreto = array();
            $carreto[$article[0]] = [
                'id' => $data["id"],
                'cantidad' => 1,
                'precio' => $data["precio"]
            ];
            $cookie = json_encode($carreto);
            setcookie("carreto", $cookie, time() + 2592000);
            $res = ["res" => 1, "msg" => "Test."];
        } else {
            $carreto = json_decode($_COOKIE["carreto"], true);

            if (array_key_exists($article[0], $carreto)) {
                $carreto[$article[0]]["cantidad"] += $article[1];
            } else {
                $carreto[$article[0]] = [
                    'id' => $data["id"],
                    'cantidad' => $article[1],
                    'precio' => $data["precio"]
                ];
            }

            $res = ["res" => 0, "msg" => "Test."];

            // $carreto[$article[0]] = $data;
            // echo "<pre>";
            // var_dump($carreto);
            // exit;
            $cookie = json_encode($carreto, JSON_PRETTY_PRINT);
            setcookie("carreto", $cookie, time() - 10000000);
            setcookie("carreto", $cookie, time() + 2592000);
        }
        // $msg = $_POST["msg"];
        // echo $msg;
        // exit;
        echo json_encode($res, JSON_PRETTY_PRINT);
        exit;
    }

    public function xmlEliminarArticles()
    {
        if (array_key_exists("carreto", $_COOKIE)) {
            $data = $_COOKIE["carreto"];
            $json = json_decode($data);
            setcookie("carreto", null, time() - 10000000);
            echo "ta te cookie";
            $res = ["res" => 1, "msg" => "Cargar Carreto.", "json" => $data];

        }
    }
    public function xmlCarregarCarreto()
    {
        if (array_key_exists("carreto", $_COOKIE)) {
            $carreto = json_decode($_COOKIE["carreto"], true);
            $res = [
                "res" => 1,
                "msg" => "Cargar Carreto.",
                "carreto" => $carreto
            ];
        } else {
            $res = [
                "res" => 0,
                "msg" => "No tienes Carreto."
            ];
        }
        $res = json_encode($res);
        echo $res;
        exit;
    }


}