<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckMiddleware
{


    public function handle(Request $request, Closure $next)//检查是否登录
    {
        if (!is_null($request->header('userToken'))) {
            $token=$request->header('userToken');//从请求头获取token
            $userToken = $request->session()->get('userToken', null);//获取token
            if ($userToken==$token&&$token!==null) {
                return $next($request);
            } else {
                return response('未登录');
            }
        } else {
            return response('未登录');
        }
    }
}
