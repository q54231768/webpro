<?php


namespace App\Dao;

use App\Model\User;
use Illuminate\Support\Facades\DB;

class UserDao
{

    public function checkIsRepeatUser($user)
    {
        $result=User::select('user_id')->where('user_id', $user['id'])->orWhere('email', $user['email'])->get();
        if (count($result)>0) {
            return true;
        } else {
            return false;
        }
    }


    public function addNewUser($user)
    {
        date_default_timezone_set('PRC');
        $nowTime=date('Y-m-d H:i:s');
        $userModel=new User();
        $userModel->user_id=$user['id'];
        $userModel->user_name=$user['userName'];
        $userModel->email=$user['email'];
        $userModel->password=$user['password'];
        $userModel->delete_time=0;
        $userModel->create_time=$nowTime;
        $userModel->last_login_time=$nowTime;
        $userModel->landing_times=0;
        $result=$userModel->save();
        return $result;
    }

    public function searchOneUser($user)
    {
        $result=User::select('user_id')->where('user_id', $user['id'])->where('password', $user['password'])->where('delete_time', 0)->get();
        return $result;
    }

    public function updateUserLoginMessage($userId)
    {
              date_default_timezone_set('PRC');
              $nowTime=date('Y-m-d H:i:s');
              $result=DB::update('update user set landing_times=landing_times+1,last_login_time=? where user_id= ?', array($nowTime,$userId));
              return $result;
    }


    public function getUserMessage($user)
    {
        $result=User::select('user_id', 'user_name', 'email', 'landing_times', 'create_time')->where('user_id', $user['userId'])->where('delete_time', 0)->get();
        return $result;
    }
}
