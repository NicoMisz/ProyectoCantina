<?php
namespace Src\Model\Usuari;

class Usuari
{
    private $correus;
    private const RUTA_USEREMAIL = __DIR__ . '/../../data/database/Usuaris/userEmail.json';
    private const RUTA_USUARIS = __DIR__ . '/../../data/database/Usuaris/';
    public function __construct()
    {
        // Definir variable amb les referencies de usuarisCorreus
        $this->correus = json_decode(
            file_get_contents(self::RUTA_USEREMAIL),
            true
        ) ?? [];
    }
    // No acabat
    public function obtenirUsuariPerId($id)
    {
        return 0;
    }

    public function obtenirUsuariPerEmail($email)
    {
        if (!isset($this->correus[$email])) {
            return null;
        }
        // Retornar llistat de tots els usuaris
        $rutaArchivo = self::RUTA_USUARIS . $this->correus[$email] . '.json';
        if (!file_exists($rutaArchivo)) {
            return null;
        }
        $usuari = json_decode(file_get_contents($rutaArchivo), true);
        return $usuari;
    }

}