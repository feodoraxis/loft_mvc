<?php
namespace Base;

abstract class Model
{
    protected $session;

    public function authUser(int $user_id)
    {
        $this->session = new Session();
        $this->session->authUser($user_id);
    }

}