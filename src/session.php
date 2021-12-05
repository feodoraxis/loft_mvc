<?php
namespace Base;

class Session
{
    public function init()
    {
        session_start();
    }

    public function authUser(int $user_id)
    {
        $_SESSION['user_id'] = $user_id;
    }

    public static function getUserId()
    {
        return $_SESSION['user_id'];
    }

    public static function isAuthorized():bool
    {
        if (!empty( $_SESSION['user_id'])) {
            return true;
        }

        return false;
    }
}