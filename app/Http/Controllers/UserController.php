<?php

namespace App\Http\Controllers;

use App\Service\UserService;
use App\Tools\EmailTools;
use App\Tools\PasswordTools;
use App\Tools\RSA;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Monolog\Logger;

class UserController extends Controller
{
    private $userService;
    private $rsa;
    private $emailTools;
    private $passwordTools;

    public function __construct(UserService $userService, RSA $rsa, EmailTools $emailTools, PasswordTools $passwordTools)
    {
        $this->userService=$userService;
        $this->rsa=$rsa;
        $this->emailTools=$emailTools;
        $this->passwordTools=$passwordTools;
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addUser(Request $request)//注册用户
    {
        $user=$request->all();
        if (!$this->emailTools->checkEmail($user['email'])) {
            return \response('邮箱格式不对');
        }
        if ($request->session()->exists('privateKey')) {
            $privateKey=$request->session()->get('privateKey');
        } else {
            return response('注册失败，请刷新页面重试', 200);
        }

        $checkCode=$request->session()->get('checkCode', null);
        $email=$request->session()->get('email', null);
        if ($checkCode===null||$user['email']===null) {
            return \response('验证码失效,请重新获取', 200);
        }
        if ($checkCode!=$user['checkCode']||$email!=$user['email']) {
            return \response('验证码不正确', 200);
        }
        $user['password']=$this->getRealPassword($user['password'], $privateKey);
        $user['password']=$this->passwordTools->hashPassword($user['password']);
        $result=$this->userService->addNewUser($user);
        return response($result, 200);
    }


    public function login(Request $request)//登录逻辑
    {
        $user=array(
            'id'=>$request->input('id', null),
            'password'=>$request->input('password', null)
        );
        if ($request->session()->exists('privateKey')) {
            $privateKey=$request->session()->get('privateKey');
        } else {
            return response('登陆失败', 200);
        }
        $user['password']=$this->getRealPassword($user['password'], $privateKey);
        $user['password']=$this->passwordTools->hashPassword($user['password']);

        $result=$this->userService->loginCheck($user);

        if ($result) {
            $randNumber=rand();//生成登陆token,这里做的简单点,用随机数就好了
            $request->session()->put('userToken', $randNumber);//保存token在session
            $request->session()->put('userId', $user['id']);
            $request->session()->save();//保存session
            return response('登录成功', 200)->header('userToken', $randNumber);
        } else {
            return response('密码或账号错误', 200);
        }
    }

//    public function checkLogin(Request $request)//登陆检查
//    {
//        $token=$request->header('userToken').'';//从请求头获取token
//        if ($request->session()->exists('userToken')) {
//            $userToken = $request->session()->get('userToken').'';//获取token
//            if ($userToken===$token) {
//                return '已经登陆';
//            } else {
//                return '未登陆';
//            }
//        } else {
//            return '未登陆';
//        }
//    }


    public function getPublicKey(Request $request)//获取加密公钥
    {
        $keys=$this->rsa->getKeys();
        $publicKey=$keys['publicKey'];
        $privateKey=$keys['privateKey'];
        $request->session()->put('privateKey', $privateKey);
        $request->session()->save();
        $publicKey=$this->rsa->getPublicKeyForJs($publicKey);
        return $publicKey;
    }

    public function getRealPassword($password, $privateKey)//用私钥解密返回的公钥
    {
        $password=$this->rsa->getDecryptData($password, $privateKey);
        return $password;
    }


    public function getPersonMessage(Request $request)//获取用户个人信息
    {
        $userId=$request->session()->get('userId', null);
        if (is_null($userId)) {
            return \response('未登录');
        } else {
            $result=$this->userService->getUserMessage(array('userId'=>$userId));
            if (count($result)===0) {
                return \response('未登录');
            }
        }
        return \response($result, 200);
    }

    public function loginOut(Request $request)//登出操作
    {
        $request->session()->flush();
        $request->session()->save();
        return '登出';
    }
}
