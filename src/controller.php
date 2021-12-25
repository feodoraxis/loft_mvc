<?php
namespace Base;

use Exception;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;
use Twig\Error\RuntimeError;
use Twig\Loader\FilesystemLoader;

abstract class Controller
{
    protected $db;
    protected $view;
    protected string $view_name;

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

            return $twig->render($file_name . '.twig', $data);
        } catch (Exception | LoaderError | RuntimeError | SyntaxError $e) {
            return $e->getMessage();
        }
    }
}