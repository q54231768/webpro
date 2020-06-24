<?php


namespace App\Service;

use App\Dao\UserDao;

class UserService
{
    public $userDao;

    public function __construct(UserDao $userDao)
    {
        $this->userDao=$userDao;
    }

    public function addNewUser($user)
    {
        return  $this->userDao->addNewUser($user);
    }

    public function searchOneUser($user)
    {
        return  $this->userDao->searchOneUser($user);
    }
}
