<?php
namespace App\Controller;

use Base\Controller;
use App\Model\User as UserModel;
use App\Model\Admin as AdminModel;

class Admin extends Controller
{
    protected string $view_name = 'Admin';

    private $AdminModel;
    private $action;

    private function protect()
    {
        if (!UserModel::isAuthorized() || !UserModel::currentUserIsAdmin()) {
            header("HTTP/1.0 404 Not Found");
            die();
        }

        if (!is_object($this->AdminModel)) {
            $this->AdminModel = new AdminModel();
            $this->action = parse_url($_SERVER['REQUEST_URI'])['path'];
        }
    }

    public function Index ()
    {
        $this->protect();

        $data['message'] = $_REQUEST['message'] ?? '';
        $data['users_list'] = $this->AdminModel->getUsersList();

        return $this->render("index", $data);
    }

    public function Add ()
    {
        $this->protect();

        $data['message'] = $_REQUEST['message'] ?? '';
        $data['action'] = $this->action;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->AdminModel->add();
        } else {
            return $this->render("add", $data);
        }

    }

    public function Edit ()
    {
        $this->protect();

        $data['message'] = $_REQUEST['message'] ?? '';
        $data['action'] = $this->action;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->AdminModel->saveChanges();
        } else {
            $data = $this->AdminModel->getFormEdit();
            return $this->render("edit", $data);
        }
    }
}