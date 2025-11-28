<?php

namespace Src\Model\Article;
// Clase Article
class Article
{
    // Variables i constants
    private $correus;
    private const RUTA_ARTICLESINGREDIETS = __DIR__ . '/../../data/database/Articles/articulosIngredientes.json';
    private const RUTA_INGREDIETS = __DIR__ . '/../../data/database/Ingredientes/';
    private const RUTA_ARTICLES = __DIR__ . '/../../data/database/Articles/';
    public function __construct()
    {
    }
    // Funcio per poguer obtenir els articles (per no repetir codi)
    public function obtenirArticles()
    {
        $articles = array();
        if ($handle = opendir(self::RUTA_ARTICLES)) {
            // Iterar per els fitxers
            while (false !== ($file = readdir($handle))) {
                if ('.' === $file)
                    continue;
                if ('..' === $file)
                    continue;
                if ('articulosIngredientes.json' === $file)
                    continue;

                $ingredientes = array();
                $sinExtension = pathinfo($file, PATHINFO_FILENAME);
                $article = json_decode(file_get_contents(self::RUTA_ARTICLES . '/' . $file), true);
                // Afegir el article al array que es retorna
                $articles[$sinExtension] = $article;
                // Afegir els ingrediens (al final no s'ha pogut implementar)
                $ingredientes = array();
                foreach ($articles[$sinExtension]['ingredientes'] as $value) {
                    $ingrediente = json_decode(file_get_contents(self::RUTA_INGREDIETS . $value . '.json'), true);
                    array_push($ingredientes, $ingrediente);
                }
                $articles[$sinExtension]['ingredientes'] = $ingredientes;
            }
            closedir($handle);
        }
        return $articles;
    }

    // Funcio per obtenir objecte segons el identificador
    public function obtenirArticle($nom)
    {
        $article = null;
        if ($handle = opendir(self::RUTA_ARTICLES)) {
            // Iterar per els fitxers
            while (false !== ($file = readdir($handle))) {
                if ($file !== '.' && $file !== '..' && $file !== 'articulosIngredientes.json') {
                    // Si troba el fitxer retorna el contingut com objecte
                    if ($file === $nom . ".json") {
                        $article = json_decode(file_get_contents(self::RUTA_ARTICLES . '/' . $file), true);
                    } else {
                        // DEBUG (no s'elimina en cas de tenir quue fer comprovacions)
                        // echo "<br>";
                        // echo $nom . "json !=";
                        // echo $file;
                    }
                } else {
                    continue;
                }
            }
            closedir($handle);
        }
        return $article;
    }
}
