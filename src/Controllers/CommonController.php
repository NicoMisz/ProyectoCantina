<?php
namespace Src\Controllers;
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
}