<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\User as UserModel;

class Admin extends Model
{
    protected $table = 'users';

    public function getUsersList ()
    {
        $query = self::query()->orderBy('id', 'DESC')->get();

        $res = [];
        foreach ($query as $item) {
            $res[] = $item->toArray();
        }

        return $res;
    }

    public function getFormEdit ()
    {
        if (!$_REQUEST['id']) {
            $data['message'] = "you must set users id";
            return $data;
        }

        $user_id = intval($_REQUEST['id']);
        $data['form'] = self::query()->where('id', '=', $user_id)->first()->toArray();

        if ($_REQUEST['id'] == UserModel::getCurrentUserId()) {
            $data['form']['can_remove_admin'] = false;
        } else {
            $data['form']['can_remove_admin'] = true;
        }

        return $data;
    }

    public function saveChanges ()
    {
        $user = UserModel::getById(intval($_POST['id']));

        $user->name = $_POST['username'];

        if (empty(UserModel::getByEmail($_POST['useremail']))) {
            $user->email = $_POST['useremail'];
        }

        if ((isset($_POST['is_admin']) && $_POST['is_admin'] == 'on') || UserModel::currentUserIsAdmin()) {
            $user->is_admin = true;
        } else {
            $user->is_admin = false;
        }

        if (!empty($_POST['password']) && mb_strlen($_POST['password']) > 4) {
            $user->password = UserModel::hash_password($_POST['password']);
        }

        if ($user->update()) {
            $msg = 'User has updated';
        } else {
            $msg = "Some error";
        }

        header("Location: /admin?message={$msg}");
    }

    public function add ()
    {
        $this->name = $_POST['username'];

        if (!empty(UserModel::getByEmail($_POST['useremail']))) {
            $msg = "User with this email already exists";
            header("Location: /admin?message={$msg}");
            die();
        }

        $this->email = $_POST['useremail'];

        if (isset($_POST['is_admin']) && $_POST['is_admin'] == 'on') {
            $this->is_admin = true;
        } else {
            $this->is_admin = false;
        }

        if (!empty($_POST['password']) && mb_strlen($_POST['password']) > 4) {
            $this->password = UserModel::hash_password($_POST['password']);
        }

        if ($this->save()) {
            $msg = 'User has added';
        } else {
            $msg = "Some error";
        }

        header("Location: /admin?message={$msg}");
    }
}