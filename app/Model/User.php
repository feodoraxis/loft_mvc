<?php
namespace App\Model;

use Base\Session as Session;
use Base\Db as DB;
use Base\Model;

class User extends Model
{

    public function auth()
    {
        $user = $_POST['user'];

        if (empty($user['email']) || empty($user['password'])) {
            return "You must set email and password";
        }

        if (strlen($user['password']) < 4) {
            return "your password is small";
        }

        $user_data = User::getUserByEmail($user['email']);

        if (empty($user_data) || $user_data['password'] !== $this->hash_password($user['password'])) {
            return "incorrect user email or password";
        }

        $this->authUser($user_data['id']);

        return "You're succesfully authorized";
    }

    public function add()
    {
        $user = (array) $_POST['user'];

        if (empty($user['name']) || empty($user['email'])) {
            return "You must set name and email";
        }

        if (mb_strlen($user['password']['1']) < 5) {
            return "your password is small";
        }

        if ($user['password']['1'] !== $user['password']['2']) {
            return "Passwords is incorrect";
        }

        $db = DB::getInstance();

        $res = $db->exec(
            "INSERT INTO `users` (`name`, `password`, `email`, `date`) VALUES ( :users_name, :user_password, :user_email, :users_date )",
            [
                ':users_name' => $user['name'],
                ':user_password' => $this->hash_password($user['password']['1']),
                ':user_email' => $user['email'],
                ':users_date' => date("Y-m-d"),
            ]
        );

        if (isset($res) && !empty($res)) {
            return 'Registration success. You can auth';
        }

        return 'Error';
    }

    public static function getUserByEmail($email): array
    {
        $db = DB::getInstance();
        $res = $db->fetchOne(
            "SELECT `password`, `id` FROM `users` WHERE `email` = :users_email",
            [
                ':users_email' => $email,
            ]
        );

        if ($res) {
            return $res;
        } else {
            return [];
        }
    }

    public static function currentUserIsAdmin()
    {
        $db = DB::getInstance();

        $user_id = User::getCurrentUserId();
        $res = $db->fetchOne(
            "SELECT `is_admin` FROM `users` WHERE `id`= :user_id",
            [
                ':user_id' => $user_id,
            ]
        );

        if ($res['is_admin'] == 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function getCurrentUser()
    {
        $db = DB::getInstance();

        $user_id = User::getCurrentUserId();
        $sql = "SELECT * FROM `users` WHERE `id`= :user_id";

        $res = $db->exec(
            $sql,
            [
                ':user_id' => $user_id,
            ]
        );

        return $res;
    }

    public static function getCurrentUserId()
    {
        return Session::getUserId();
    }

    private function hash_password(string $password): string
    {
        return sha1($password . 'yid]9e0wu]8^()97eyw');
    }

    public static function isAuthorized()
    {
        return Session::isAuthorized();
    }

    public static function getUserName()
    {
        return 'Andrey';
    }
}