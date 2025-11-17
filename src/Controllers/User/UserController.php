<?php
namespace Src\Controllers\User;
require_once __DIR__ . '/../../Model/Usuari.php';

use DateTime;
use Src\Model\Usuari\Usuari;
class UserController
{
    // public function index()
    // {
    // }
    public function perfil()
    {
        $email = $_SESSION['user']['email'];
        $vista = 'usuario';
        $data = (new Usuari())->obtenirUsuariPerEmail($email);
        require __DIR__ . '/../../Views/common/usuaris/perfil.php';
        exit;
    }

}