<?php
namespace Base;

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
        ob_start();
        require_once $this->view . $file_name;
        ob_end_flush();
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}