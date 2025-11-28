<?php

namespace Src\Controllers;

require_once __DIR__ . '/../Model/Usuari.php';

use DateTime;
use Src\Model\Usuari\Usuari;
use Src\Model\Article\Article;

class CommonController
{

    // Carregar pagines (no tenen variables)
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
        //Comprovar si exsisteix la variable carreto 
        if (array_key_exists("carreto", $_COOKIE)) {
            $carreto = json_decode($_COOKIE["carreto"], true);
        }
        require __DIR__ . '/../Views/common/usuaris/carrito.php';
        exit;
    }

    public function catalogo()
    {
        // Obtenir Llistat Articles 
        $articulos = (new Article())->obtenirArticles();
        $horaActual = (int) date('H');
        // Determinar l'horari amb l'hora
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
        $horarioActual = 'Comida';
        $data = [];
        // Filtrar Articles segons l'horari
        if ($horarioActual !== null) {
            foreach ($articulos as $key => $articulo) {
                if (isset($articulo['horario']) && $articulo['horario'] === $horarioActual) {
                    $data[$key] = $articulo;
                }
            }
        }
        require __DIR__ . '/../Views/common/usuaris/catalago.php';
        exit;
    }

    public function formulari()
    {
        // No aplicat encara
        exit;
        require __DIR__ . '/../Views/common/usuaris/formulari.php';
    }

    public function menu()
    {
        // Obtenir tots els articles
        $articleClass = new Article();
        $data = array();
        // Categoria articles
        $data["Entrante"] = array();
        $data["Principal"] = array();
        $data["Postre"] = array();
        $data["Bebida"] = array();
        // Articles menu
        $data["Entrante"]["1-30122025-171618"] = $articleClass->obtenirArticle("1-30122025-171618");
        $data["Entrante"]["2-30122025-171618"] = $articleClass->obtenirArticle("2-30122025-171618");
        $data["Entrante"]["3-24112025-145923"] = $articleClass->obtenirArticle("3-24112025-145923");
        $data["Principal"]["1-30122025-171618"] = $articleClass->obtenirArticle("1-30122025-171618");
        $data["Principal"]["2-30122025-171618"] = $articleClass->obtenirArticle("2-30122025-171618");
        $data["Principal"]["3-24112025-145923"] = $articleClass->obtenirArticle("3-24112025-145923");
        $data["Postre"]["3-24112025-145923"] = $articleClass->obtenirArticle("3-24112025-145923");
        $data["Bebida"]["3-24112025-145923"] = $articleClass->obtenirArticle("3-24112025-145923");
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
        // Ruta llistat de tickets
        $pathUsuarioTickets = '../data/database/Comandas/usuarioComandas.json';
        $path = '../data/database/Comandas/';
        // Obtenir contingut del fitxer
        $json = file_get_contents($pathUsuarioTickets);
        // Transformar string a array
        $ticketsData = json_decode($json, true);
        // Obtenir id amb la variable de sessio del usuari
        $userId = $_SESSION['user']['id'];
        if (!isset($ticketsData[$userId])) {
            // Usuari sense tickets
            $dato = [];
        } else {
            $ticketsId = $ticketsData[$userId];
            $dato = [];
            foreach ($ticketsId as $ticket) {
                // Obtenir article especific
                $dato[$ticket] = json_decode(file_get_contents($path . $ticket . '.json'), true);
            }
        }
        require __DIR__ . '/../Views/common/usuaris/ticket.php';
        exit;
    }

    public function pedidos()
    {
        exit;
        require __DIR__ . '/../Views/common/usuaris/pedidos.php';
    }

    public function logOut()
    {
        // Elimina la sessio
        session_destroy();
        // Redireccio a dashboard
        header('Location:' . '/dashboard');
        exit;
    }

    public function ajaxAutenticarLogin()
    {
        // Formata l'estil del header
        header('Content-Type: application/json; charset=utf-8');
        $email = $_POST["email"] ?? null;
        $password = $_POST["password"] ?? null;
        // Recollir dades
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
        // Ruta id Comanda
        $path = "../data/database/Id/comandaCurrentId.json";
        // Obtenir contingut del fitxer com a objecte
        $file = file_get_contents($path);
        $currId = json_decode($file, true);
        // Augmentar id en 1 i actualitzar id
        $id = $currId["id"] + 1;
        file_put_contents($path, json_encode(["id" => $id], JSON_PRETTY_PRINT), LOCK_EX);
        return $id;
        exit;
    }


    public function ajaxRegistrarUsuari()
    {
        // Obtenir dades
        $id = $this->obtenirId();
        $nombre = $_POST["nombre"] ?? null;
        $apellidos = $_POST["apellidos"] ?? null;
        $email = $_POST["email"] ?? null;
        $fechaCreacion = date('dmY-His');
        $password = $_POST["password"] ?? null;
        $password2 = $_POST["password_comprovacio"] ?? null;
        // Rol per defecte usuari
        $rol = 'usuario';
        $activo = True;
        // Falta sanitititzar
        if ($password === $password2) {
            // Hash de contrasenya amb data de creació
            $hash = hash('sha512', $password . $fechaCreacion);
            $json = file_get_contents('../data/class/User.json');
            // A partir d'un json base afegir les dades del  usuari
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
            // Afegir correu
            $this->afegirCorreu($email, $fitxer);
            // Afegir fitxer d'usuari
            file_put_contents($path, json_encode($jsondecode, JSON_PRETTY_PRINT), LOCK_EX);
        } else {
            $res = ["res" => 0, "msg" => "Contraseña diferente"];
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($res);
        }
        exit;
    }

    public function afegirCorreu($correu, $fitxer)
    {
        // Ruta usuariCorreu
        $path = '../data/database/Usuaris/userEmail.json';
        // Obtenir element en format objecte
        $json = file_get_contents($path);
        $jsondecode = json_decode($json, true);
        // Afegir nou correu i guardar
        $jsondecode[$correu] = $fitxer;
        file_put_contents($path, json_encode($jsondecode, JSON_PRETTY_PRINT), LOCK_EX);
        // Retornar missatge
        header('Content-Type: application/json; charset=utf-8');
        $res = ["res" => 1, "msg" => "Usuari afegit correctament."];
        echo json_encode($res, JSON_PRETTY_PRINT);
        exit;
    }
    public function xmlAfegirArticle()
    {
        // Comprovar si s'ha enviat un article o menu
        if (isset($_POST["data"])) {
            $jsonstring = $_POST["data"];
            $article = json_decode($jsonstring);
            // Obtenir articles
            $data = (new Article())->obtenirArticle($article[0]);
            // Si no existeix afegir la cookie
            if (!array_key_exists("carreto", $_COOKIE)) {
                // Crear i afegir article
                $carreto = array();
                $carreto[$article[0]] = [
                    'id' => $data["id"],
                    'imagen' => $data["imagen"],
                    'nombre' => $data["nombre"],
                    'descripcion' => $data["descripcion"],
                    'cantidad' => $article[1] ?? 1,
                    'precio' => $article[2] ?? $data["precio"]
                ];
                // Crear i afegir article
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
                $cookie = json_encode($carreto, JSON_PRETTY_PRINT);
                setcookie("carreto", $cookie, time() - 10000000);
                setcookie("carreto", $cookie, time() + 2592000);
            }
            echo json_encode($res, JSON_PRETTY_PRINT);
            exit;
        } else if (isset($_POST["menu"])) {
            $jsonstring = $_POST["menu"];
            $menu = json_decode($jsonstring);

            if (!array_key_exists("carreto", $_COOKIE)) {
                // echo "Creació Cookie";
                // $data = json_encode($data);
                $carreto = array();
                $carreto["menu"] = [
                    'id' => "0",
                    'imagen' => null,
                    'nombre' => "Menú",
                    'descripcion' => "Menú del Dia",
                    'cantidad' => 1,
                    'precio' => 12.99
                ];
                $cookie = json_encode($carreto);
                setcookie("carreto", $cookie, time() + 2592000);
                $res = ["res" => 1, "msg" => "Test."];
            } else {
                $carreto = json_decode($_COOKIE["carreto"], true);

                $jsonstring = $_POST["menu"];
                $menu = json_decode($jsonstring);

                $carreto["menu"] = [
                    'id' => "0",
                    'imagen' => null,
                    'nombre' => "Menú",
                    'descripcion' => "Menú del Dia",
                    'cantidad' => 1,
                    'precio' => 12.99
                ];
                $cookie = json_encode($carreto);
                setcookie("carreto", $cookie, time() + 2592000);
                $res = ["res" => 1, "msg" => "Test."];
                $res = ["res" => 0, "msg" => "Test."];
                $cookie = json_encode($carreto, JSON_PRETTY_PRINT);
                setcookie("carreto", $cookie, time() - 10000000);
                setcookie("carreto", $cookie, time() + 2592000);
            }
            exit;
        }
        exit;
    }

    public function xmlEliminarArticles()
    {
        if (array_key_exists("carreto", $_COOKIE)) {
            $data = $_COOKIE["carreto"];
            $json = json_decode($data);

            setcookie("carreto", "", time() - 10000000, "/");
            $res = ["res" => 1, "msg" => "Cargar Carreto.", "json" => $data];
            header('Content-Type: application/json');
            echo json_encode($res, JSON_PRETTY_PRINT);
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
            header('Content-Type: application/json');
            echo json_encode($res, JSON_PRETTY_PRINT);
        }
        exit;
    }
    public function xmlCarregarCarreto()
    {
        // Comprovar si exsisteix cookie carreto y extreurala
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
        header('Content-Type: application/json');
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
            //  Eliminar cookie 
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
