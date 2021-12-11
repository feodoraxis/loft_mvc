<?php
namespace Base;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

abstract class Controller
{
    protected $db;
    protected $view;
    protected $view_name;

    public function __construct()
    {
        $this->view = ROOT_DIR . '/app/View/' . $this->view_name . '/';
    }

    public function Index ()
    {
    }

    public function render(string $file_name, array $data = []): string
    {
        try {
            $loader = new FilesystemLoader($this->view);
            $twig = new Environment($loader);
//            $twig->setEscaper('html');

            return $twig->render($file_name . '.twig', $data);
        } catch (Exception | LoaderError | RuntimeError | SyntaxError $e) {
            return $e->getMessage();
        }
    }
}