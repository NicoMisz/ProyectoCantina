<?php

namespace Src\Model\Article;

class Article
{
    private $correus;
    private const RUTA_ARTICLESINGREDIETS = __DIR__ . '/../../data/database/Articles/articulosIngredientes.json';
    private const RUTA_INGREDIETS = __DIR__ . '/../../data/database/Ingredientes/';
    private const RUTA_ARTICLES = __DIR__ . '/../../data/database/Articles/';
    public function __construct() {}
    public function obtenirArticles()
    {
        $articles = array();
        if ($handle = opendir(self::RUTA_ARTICLES)) {
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
                $articles[$sinExtension] = $article;
                $ingredientes = array();
                foreach ($articles[$sinExtension]['ingredientes'] as $value) {
                    $ingrediente = json_decode(file_get_contents(self::RUTA_INGREDIETS . $value . '.json'), true);
                    array_push($ingredientes, $ingrediente);
                }
                // exit;
                $articles[$sinExtension]['ingredientes'] = $ingredientes;
            }
            closedir($handle);
        }


        return $articles;
    }

    public function obtenirArticle($nom)
    {
        $article = null;
        if ($handle = opendir(self::RUTA_ARTICLES)) {
            echo $nom;
            echo "<br>";
            while (false !== ($file = readdir($handle))) {
                if ($file !== '.' && $file !== '..' && $file !== 'articulosIngredientes.json') {
                    if ($file === $nom . ".json") {
                        $article = json_decode(file_get_contents(self::RUTA_ARTICLES . '/' . $file), true);
                    } else {
                        // DEBUG
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
