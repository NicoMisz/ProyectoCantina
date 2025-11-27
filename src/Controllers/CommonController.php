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
        if (array_key_exists("carreto", $_COOKIE)) {
            $carreto = json_decode($_COOKIE["carreto"], true);

        }
        require __DIR__ . '/../Views/common/usuaris/carrito.php';
        exit;
    }

    public function catalogo()
    {
        $articulos = (new Article())->obtenirArticles();
        // Obtener la hora actual (0-23)
        $horaActual = (int) date('H');
        // Determinar el horario según la hora
        switch (true) {
            case ($horaActual >= 0 && $horaActual < 8):
                $horarioActual = null;
                break;
            case ($horaActual >= 8 && $horaActual < 13):
                $horarioActual = 'Desayuno';
                break;
            case ($horaActual >= 13 && $horaActual < 15):
                $horarioActual = 'Comida';
                break;
            case ($horaActual >= 15 && $horaActual < 19):
                $horarioActual = 'Merienda';
                break;
            case ($horaActual >= 19 && $horaActual < 24):
                $horarioActual = 'Cena';
                break;
            default:
                $horarioActual = null;
                break;
        }
        // Filtrar artículos según el horario actual
        $data = [];
        $horarioActual = 'Comida';

        if ($horarioActual !== null) {
            foreach ($articulos as $key => $articulo) {
                if (isset($articulo['horario']) && $articulo['horario'] === $horarioActual) {
                    $data[$key] = $articulo;
                }
            }
        }

        // Debug (puedes comentar estas líneas después)
        // echo "<pre>";
        // echo "Hora actual: " . $horaActual . "h\n";
        // echo "Horario: " . ($horarioActual ?? 'Cerrado') . "\n";
        // echo "Artículos disponibles:\n";
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

    public function menu()
    {
        $articleClass = new Article();
        $data = array();
        $data["Entrante"] = array();
        $data["Principal"] = array();
        $data["Postre"] = array();
        $data["Bebida"] = array();
        array_push($data["Entrante"], $articleClass->obtenirArticle("1-30122025-171618"));
        array_push($data["Entrante"], $articleClass->obtenirArticle("2-30122025-171618"));
        array_push($data["Entrante"], $articleClass->obtenirArticle("3-24112025-145923"));

        array_push($data["Principal"], $articleClass->obtenirArticle("1-30122025-171618"));
        array_push($data["Principal"], $articleClass->obtenirArticle("2-30122025-171618"));
        array_push($data["Principal"], $articleClass->obtenirArticle("3-24112025-145923"));

        array_push($data["Postre"], $articleClass->obtenirArticle("3-24112025-145923"));
        array_push($data["Bebida"], $articleClass->obtenirArticle("3-24112025-145923"));
        // echo "<pre>";
        // var_dump($data);
        // exit;
        require __DIR__ . '/../Views/common/usuaris/menu.php';
        exit;
    }

    public function perfil()
    {
        require __DIR__ . '/../Views/common/usuaris/perfil.php';
        exit;
    }

    public function tickets()
    {
        $pathUsuarioTickets = '../data/database/Comandas/usuarioComandas.json';
        $path = '../data/database/Comandas/';
        $json = file_get_contents($pathUsuarioTickets);
        $ticketsData = json_decode($json, true);
        $userId = $_SESSION['user']['id'];
        if (!isset($ticketsData[$userId])) {
            // Usuario sin tickets
            $dato = [];
        } else {
            $ticketsId = $ticketsData[$userId]; // array de tickets
            $dato = [];
            foreach ($ticketsId as $ticket) {
                // aquí sí puedes usar el nombre del ticket como índice
                $dato[$ticket] = json_decode(file_get_contents($path . $ticket . '.json'), true);
            }
        }

        // var_dump($ticketsId);
        // echo "<pre>";
        // var_dump($dato);
        // // $fitxer = $id . '-' . $fechaCreacion;

        // // $tickets = null;
        // exit;

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
                    'id' => $usuari['id'] . "-" . $usuari["fechaCreacion"],
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
        exit;

    }
    public function obtenirIdComanda()
    {
        $path = "../data/database/Id/comandaCurrentId.json";
        $file = file_get_contents($path);
        $currId = json_decode($file, true);
        $id = $currId["id"] + 1;
        file_put_contents($path, json_encode(["id" => $id], JSON_PRETTY_PRINT), LOCK_EX);
        return $id;
        exit;

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
        exit;

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
                'imagen' => $data["imagen"],
                'nombre' => $data["nombre"],
                'descripcion' => $data["descripcion"],
                'cantidad' => $article[1] ?? 1,
                'precio' => $article[2] ?? $data["precio"]
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
                    'imagen' => $data["imagen"],
                    'nombre' => $data["nombre"],
                    'descripcion' => $data["descripcion"],
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

            setcookie("carreto", "", time() - 10000000, "/");

            $res = ["res" => 1, "msg" => "Cargar Carreto.", "json" => $data];
        }
        exit;
    }
    public function eliminarArticles()
    {
        if (array_key_exists("carreto", $_COOKIE)) {
            $data = $_COOKIE["carreto"];
            $json = json_decode($data);

            setcookie("carreto", "", time() - 10000000, "/");

            $res = ["res" => 1, "msg" => "Cargar Carreto.", "json" => $data];
        }
        return $res;
        exit;
    }
    public function xmlCarregarCarreto()
    {
        //Debug
        //echo "Explosionado";
        //exit;
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
    public function xmlCrearTicket()
    {
        header('Content-Type: application/json');

        if (array_key_exists("carreto", $_COOKIE)) {
            $carreto = json_decode($_COOKIE["carreto"], true);

            if (empty($carreto)) {
                echo json_encode([
                    "res" => 0,
                    "msg" => "El carrito está vacío."
                ]);
                exit;
            }

            $total = 0;
            foreach ($carreto as $articulo) {
                $subtotal = $articulo['cantidad'] * $articulo['precio'];
                $total += $subtotal;
            }

            // Ahora sí puedes llamarlo (ya no tiene exit)
            $this->eliminarArticles();

            $fechaCreacion = date('dmY-His');
            $id = $this->obtenirIdComanda();

            $comanda = [
                'id' => $id,
                'fecha' => $fechaCreacion,
                'estado' => true,
                'total' => round($total, 2),
                'usuario' => [
                    'id' => $_SESSION['user']['id'],
                    'nombre' => $_SESSION['user']['email']
                ],
                'articulos' => $carreto
            ];

            $fitxer = $id . '-' . $fechaCreacion;
            $path = '../data/database/Comandas/' . $fitxer . '.json';
            file_put_contents($path, json_encode($comanda, JSON_PRETTY_PRINT), LOCK_EX);

            $pathTickets = '../data/database/Comandas/usuarioComandas.json';
            $json = file_get_contents($pathTickets);
            $ticketsData = json_decode($json, true);

            if (!is_array($ticketsData)) {
                $ticketsData = [];
            }

            $userId = $_SESSION['user']['id'];

            if (!isset($ticketsData[$userId])) {
                $ticketsData[$userId] = [];
            }

            $ticketsData[$userId][] = $fitxer;
            file_put_contents($pathTickets, json_encode($ticketsData, JSON_PRETTY_PRINT), LOCK_EX);

            echo json_encode([
                "res" => 1,
                "redirect" => "/tickets",
            ]);
            exit;
        }

        echo json_encode([
            "res" => 0,
            "msg" => "No tienes productos en el carrito."
        ]);
        exit;
    }



}
