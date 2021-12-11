<?php
namespace App\Controller;
use Base\Controller;
use App\Model\Blog as BlogModel;
use App\Model\User as UserModel;

class Blog extends Controller
{
    protected $db;
    protected $view_name = 'Blog';

    public function Index()
    {
        $data['action'] = $_SERVER['REQUEST_URI'];
        $data['message'] = '';

        if (!UserModel::isAuthorized()) {
            return 'you must to be authorized';
        }

        $blogModel = new BlogModel();

        if (isset($_POST['action'])) {
            if ($_POST['action'] == 'add') {
                $data['message'] = $blogModel->add();
            }

            if ($_POST['action'] == 'remove') {
                $data['message'] = $blogModel->remove();
            }
        }

        $data['list'] = $blogModel->getPosts();


        return $this->render("index", $data);

    }

    public function addPost ()
    {

    }

    public function removePost()
    {

    }
}