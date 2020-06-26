<?php


namespace App\Tools;

class EmailTools
{
    public function checkEmail($email)//发送邮件
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
}
