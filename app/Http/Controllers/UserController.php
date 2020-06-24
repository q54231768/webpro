<?php

namespace App\Http\Controllers;

use App\Service\UserService;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Monolog\Logger;

class UserController extends Controller
{
    public $userService;


    public function __construct(UserService $userService)
    {
        $this->userService=$userService;
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

    public function addUser(Request $request)
    {

        $user=array(
            'id'=>$request->input('id', null),
            'userName'=>$request->input('userName', null),
            'email'=>$request->input('email', null),
            'password'=>$request->input('password', null)
            );
        $result=$this->userService->addNewUser($user);
        if ($result) {
            return '注册成功';
        } else {
            return 'fail';
        }
    }


    public function login(Request $request)
    {
        $user=array(
            'id'=>$request->input('id', null),
            'password'=>$request->input('password', null)
        );
        $result=$this->userService->searchOneUser($user);
        if (count($result)>0) {
            $randNumber=rand();
            $request->session()->put('userToken', $randNumber);
            return response('登录成功'.$randNumber, 200)->header('userToken', $randNumber);
        } else {
            return response('登陆失败', 200);
        }
    }

    public function checkLogin(Request $request)
    {
        $token=$request->header('userToken').'';
        if ($request->session()->exists('userToken')) {
            $userToken = $request->session()->get('userToken').'';

            if ($userToken===$token) {
                return '已经登陆';
            } else {
                return '未登陆'.$token;
            }
        } else {
            return '未登陆'.$token;
        }
    }
}
