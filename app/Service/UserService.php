<?php


namespace App\Service;

use App\Dao\UserDao;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserService
{
    private $userDao;


    public function __construct(UserDao $userDao)
    {
        $this->userDao=$userDao;
    }

    public function addNewUser($user)//添加新用户
    {
        DB::beginTransaction();
        try {
            if ($this->userDao->checkIsRepeatUser($user)) {
                DB::commit();
                return '你的账号或邮箱已被他人使用';
            } else {
                $result=$this->userDao->addNewUser($user);
                if (!$result) {
                    DB::commit();
                    return '注册失败,请检查信息重试';
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            return '注册失败,请检查信息重试';
        }
        DB::commit();
        return '注册成功';
    }

    public function loginCheck($user)//检验登录
    {
        DB::beginTransaction();
        try {
            $result=$this->userDao->searchOneUser($user);//先检查有没有该用户
            if (count($result)===0) {
                DB::commit();
                return false;
            } else {
                if (!$this->userDao->updateUserLoginMessage($user['id'])) {//更新该用户登录信息，如最近登录时间.登录次数
                    DB::commit();
                    return 'false';
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
        return true;
    }

    public function getUserMessage($user)//获取用户个人信息
    {
        return $this->userDao->getUserMessage($user);
    }
}
