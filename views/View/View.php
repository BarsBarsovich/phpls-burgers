<?php
namespace views\View;

use \Twig\Environment;
use \Twig\Loader\FilesystemLoader;
use Twig_Error;

class View
{
    const PATH_TO_TEMPLATES ='./views/templates';
    private $templateEngine;

    public function __construct()
    {
        $this->templateEngine = new Environment(new FilesystemLoader(self::PATH_TO_TEMPLATES), [
            'cache' => false,
        ]);
    }

    public function render($path, $data = [])
    {
        try {
            $path = (stristr($path, '.html')) ? $path : "$path.html";
            $result = $this->templateEngine->render($path, !empty($data) ? $data : []);
        } catch (Twig_Error $exception) {
            $result = $exception->getMessage();
        }
        return $result;
    }
}

