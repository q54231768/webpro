<?php


namespace App\Dao;

use App\Model\User;
use Illuminate\Support\Facades\DB;

class UserDao
{
    public function addNewUser($user)
    {

        $userModel=new User();
        $userModel->id=$user['id'];
        $userModel->userName=$user['userName'];
        $userModel->email=$user['email'];
        $userModel->password=$user['password'];
        $result=$userModel->save();
        return $result;
    }

    public function searchOneUser($user)
    {
        $userModel=new User();
        $userModel->id=$user['id'];
        $userModel->password=$user['password'];
        $result=User::where('id', $user['id'])->where('password', $user['password'])->get();
        return $result;
    }
}
