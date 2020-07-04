<?php


namespace App\Tools;

class RSA//rsa加密工具
{
    private $config;

    /**
     * RSA constructor.
     */
    public function __construct()
    {
        $this->config = array(
            "config"=> __DIR__.DIRECTORY_SEPARATOR.'openssl.cnf',
            "digest_alg" => "sha512",
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA
        );
    }

    public function getKeys()//获取公钥和私钥
    {

        $res = openssl_pkey_new($this->config);
        openssl_pkey_export($res, $privateKey, null, $this->config);
        $publicKey=openssl_pkey_get_details($res);
        $publicKey=$publicKey['key'];
        return array("publicKey"=>$publicKey,"privateKey"=>$privateKey);
    }

    public function getTargetStr($str, $previousStr, $nextStr)
    {
        $previousStr=str_replace(' ', '', $previousStr);
        $nextStr=str_replace(' ', '', $nextStr);
        $str=str_replace(' ', '', $str);
        $str=str_replace($previousStr, '', $str);
        $str=str_replace($nextStr, '', $str);
        $targetStr=$str;
        return $targetStr;
    }

    public function getPublicKeyForJs($publicKey)//提取对应格式的公钥给前端
    {
        return $this->getTargetStr($publicKey, '-----BEGIN PUBLIC KEY-----', '-----END PUBLIC KEY-----');
    }

    public function encryptData($data, $publicKey)//加密数据
    {
        openssl_public_encrypt($data, $encrpted, $publicKey);
        return $encrpted;
    }

    public function decryptData($encrpted, $privateKey)//解密数据
    {
        openssl_private_decrypt($encrpted, $decpreted, $privateKey);
        return $decpreted;
    }

    public function getDecryptData($encrpted, $privateKey)
    {
        $decpreted=$this->decryptData(base64_decode($encrpted), $privateKey);
         return $decpreted;
    }



}
