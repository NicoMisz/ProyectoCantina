<?php

namespace Src\Model\Comanda;

class Comanda
{
    private $correus;
    private const RUTA_COMANDAS = __DIR__ . '/../../data/database/Comandas/';
    public function __construct()
    {
    }
    public function obtenirComandes()
    {
        $comandes = array();
        if ($handle = opendir(self::RUTA_COMANDAS)) {
            // Iterar per els fitxers
            while (false !== ($file = readdir($handle))) {
                if ('.' === $file)
                    continue;
                if ('..' === $file)
                    continue;
                if ('usuarioComandas.json' === $file)
                    continue;
                // Retornar llistat de totes les comandes
                $sinExtension = pathinfo($file, PATHINFO_FILENAME);
                $comanda = json_decode(file_get_contents(self::RUTA_COMANDAS . '/' . $file), true);
                $comandes[$sinExtension] = $comanda;
            }
            closedir($handle);
        }
        return $comandes;
    }
}
