<?php


namespace App\Tools;

class PasswordTools
{

    private $regions;

    /**
     * PasswordTools constructor.
     */
    public function __construct()
    {
        $this->regions=array(
          array(10,20),
            array(2,25),
              array(3,15),
               array(6,10),
                 array(7,9),
                   array(20,10),
                     array(9,20),
                       array(18,12),
                          array(18,10),
                             array(15,15)
        );
    }

    /**
     * PasswordTools constructor.
     * 做密码放入数据库前的加密,
     * 加密逻辑为根据密码ascii的和取模来截取密码MD5hash一次后的内容，
     * 在此基础上再做一次MD5
     * @param $region
     */

    public function hashPassword($password)
    {
        $len=strlen($password);
        $strAccum=0;
        for ($i=0; $i<$len; ++$i) {
            $strAccum=$strAccum+ord($password[$i]);
        }
        $pos=$strAccum%10;
        $region=$this->regions[$pos];
        $newPassword=md5($password);
        $newPassword=substr($password, $region[0], $region[1]);
        $newPassword=md5($newPassword);
        return $newPassword;
    }
}
