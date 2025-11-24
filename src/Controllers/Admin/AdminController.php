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

        // Construir la ruta del archivo JSON
        $rutaJSON = __DIR__ . "/../../../data/database/Articles/" . $articuloFile . ".json";

        // Verificar que el archivo existe para obtener los datos previos
        if (!file_exists($rutaJSON)) {
            die("Error: El archivo del artículo no existe");
        }

        // Leer el artículo existente para mantener datos no modificados
        $articuloExistente = json_decode(file_get_contents($rutaJSON), true);
        
        // Mantener la imagen anterior por defecto
        $rutaImagen = $articuloExistente['imagen'] ?? "";
        
        // Mantener los ingredientes existentes
        $ingredientes = $articuloExistente['ingredientes'] ?? [];

        // Procesar nueva imagen solo si se ha subido una
        if (isset($_FILES['articulo-imagen']) && $_FILES['articulo-imagen']['error'] === UPLOAD_ERR_OK) {
            $archivoTemporal = $_FILES['articulo-imagen']['tmp_name'];
            $nombreOriginal = $_FILES['articulo-imagen']['name'];
            $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
            
            // Validar que sea una imagen
            $tiposPermitidos = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array(strtolower($extension), $tiposPermitidos)) {
                die('Tipo de archivo no permitido');
            }
            
            $nombreArchivo = date('dmY-His') . '.' . $extension;
            $rutaDestino = __DIR__ . "/../../../public/assets/media/Articles/" . $nombreArchivo;
            
            if (move_uploaded_file($archivoTemporal, $rutaDestino)) {
                // Eliminar la imagen anterior si existe y no es placeholder
                if (!empty($articuloExistente['imagen']) && file_exists(__DIR__ . "/../../../public" . $articuloExistente['imagen'])) {
                    @unlink(__DIR__ . "/../../../public" . $articuloExistente['imagen']);
                }
                
                $rutaImagen = "/assets/media/Articles/" . $nombreArchivo;
                echo "Archivo subido correctamente: " . $nombreArchivo . "<br>";
            } else {
                echo "Error al subir el archivo<br>";
            }
        }

        // Crear el array del artículo con todos los datos
        $articulo = [
            "id" => intval($articuloId),
            "nombre" => $articuloNombre,
            "descripcion" => $articuloDescripcion,
            "precio" => floatval($articuloPrecio),
            "horario" => $articuloHorario,
            "cantidad" => intval($articuloCantidad),
            "ingredientes" => $ingredientes, // Mantener los ingredientes existentes
            "imagen" => $rutaImagen // Usar la imagen nueva o mantener la anterior
        ];

        // Guardar el JSON en el archivo
        $resultado = file_put_contents($rutaJSON, json_encode($articulo, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);

        if ($resultado !== false) {
            echo "Artículo guardado correctamente en: " . $articuloFile . ".json<br>";
            header("Location: /admin/gestio-productes");
            exit;
        } else {
            echo "Error al guardar el artículo<br>";
        }

        echo "<pre>";
        print_r($articulo);
        echo "</pre>";
        exit;
    }

    public function afegirProducte()
    {
        $articuloNombre = htmlspecialchars(trim($_POST['articulo-nombre']), ENT_QUOTES, 'UTF-8');
        $articuloDescripcion = htmlspecialchars(trim($_POST['articulo-descripcion']), ENT_QUOTES, 'UTF-8');
        $articuloPrecio = filter_var($_POST['articulo-precio'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $articuloHorario = htmlspecialchars(trim($_POST['articulo-horario']), ENT_QUOTES, 'UTF-8');
        $articuloCantidad = filter_var($_POST['articulo-cantidad'], FILTER_SANITIZE_NUMBER_INT);

        // Obtener el ID más alto de los archivos existentes
        $dirArticulos = __DIR__ . "/../../../data/database/Articles/";
        $archivos = glob($dirArticulos . "*.json");
        
        $maxId = 0;
        foreach ($archivos as $archivo) {
            $nombreArchivo = basename($archivo, '.json');
            // Extraer el ID (primer número antes del guión)
            if (preg_match('/^(\d+)-/', $nombreArchivo, $matches)) {
                $idActual = intval($matches[1]);
                if ($idActual > $maxId) {
                    $maxId = $idActual;
                }
            }
        }
        
        // El nuevo ID será el máximo + 1
        $articuloId = $maxId + 1;
        
        // Generar nombre de archivo: ID-ddmmYYYY-HHiiss
        $articuloFile = $articuloId . '-' . date('dmY-His');

        $rutaImagen = "";

        // Procesar la imagen
        if (isset($_FILES['articulo-imagen']) && $_FILES['articulo-imagen']['error'] === UPLOAD_ERR_OK) {
            $archivoTemporal = $_FILES['articulo-imagen']['tmp_name'];
            $nombreOriginal = $_FILES['articulo-imagen']['name'];
            $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
            
            // Validar que sea una imagen
            $tiposPermitidos = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array(strtolower($extension), $tiposPermitidos)) {
                die('Tipo de archivo no permitido');
            }
            
            $nombreArchivo = date('dmY-His') . '.' . $extension;
            $rutaDestino = __DIR__ . "/../../../public/assets/media/Articles/" . $nombreArchivo;
            
            if (move_uploaded_file($archivoTemporal, $rutaDestino)) {
                $rutaImagen = "/assets/media/Articles/" . $nombreArchivo;
                echo "Archivo subido correctamente: " . $nombreArchivo . "<br>";
            } else {
                die("Error al subir el archivo");
            }
        } else {
            die("Debe seleccionar una imagen para el producto");
        }

        // Crear el array del artículo
        $articulo = [
            "id" => intval($articuloId),
            "nombre" => $articuloNombre,
            "descripcion" => $articuloDescripcion,
            "precio" => floatval($articuloPrecio),
            "horario" => $articuloHorario,
            "cantidad" => intval($articuloCantidad),
            "ingredientes" => [],
            "imagen" => $rutaImagen
        ];

        // Construir la ruta del archivo JSON
        $rutaJSON = $dirArticulos . $articuloFile . ".json";

        // Verificar que no exista el archivo (por si acaso)
        if (file_exists($rutaJSON)) {
            die("Error: Ya existe un artículo con ese identificador");
        }

        // Guardar el JSON en el archivo
        $resultado = file_put_contents($rutaJSON, json_encode($articulo, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);

        if ($resultado !== false) {
            echo "Artículo creado correctamente: " . $articuloFile . ".json<br>";
            header("Location: /admin/gestio-productes");
            exit;
        } else {
            die("Error al guardar el artículo");
        }
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
