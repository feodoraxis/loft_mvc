<?php
namespace App\Controller;
use Base\Controller;
use App\Model\User as UserModel;

class User extends Controller
{
    protected $db;
    protected $view_name = 'User';

    public function Index()
    {
        return $this->auth();
    }

    private function auth ()
    {
        $data = ['message' => '', 'action' => $_SERVER['REQUEST_URI']];
        $user_model = new UserModel();

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !UserModel::isAuthorized()) {
            $data['message'] = $user_model->auth();
        }
        return $this->render("auth.php", $data);
    }

    public function Registration()
    {
        $data = [ 'message' => '' , 'action' => $_SERVER['REQUEST_URI'] ];
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
            $user_model = new UserModel();
            $data['message'] = $user_model->add();
        }

        return $this->render("registration.php" , $data);
    }
}