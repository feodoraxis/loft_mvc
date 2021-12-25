<?php
namespace App\Controller;
use Base\Controller;
use App\Model\User as UserModel;

class User extends Controller
{
    protected string $view_name = 'User';


    public function Index():string
    {
        return $this->auth();
    }

    private function auth ():string
    {
        $data = ['message' => '', 'action' => $_SERVER['REQUEST_URI']];

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !UserModel::isAuthorized()) {
            $user_model = new UserModel();
            $data['message'] = $user_model->auth();
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && UserModel::isAuthorized()) {
            $data['message'] = "You're already authorized";
        }

        return $this->render("auth", $data);
    }

    public function Registration():string
    {
        $data = [
            'message' => '',
            'text' => 'text',
            'action' => $_SERVER['REQUEST_URI']
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user'])) {
            $user_model = new UserModel();
            $data['message'] = $user_model->add();
        }

        return $this->render("registration" , $data);
    }
}