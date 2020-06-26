<?php

namespace App\Http\Controllers;

use App\Tools\EmailTools;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
class SendMailController extends Controller
{
    private $emailTools;

    /**
     * SendMailController constructor.
     * @param $emailTools
     */
    public function __construct(EmailTools  $emailTools)
    {
        $this->emailTools = $emailTools;
    }

    public function sendCheckCode(Request $request)
    {
        $email=$request->input('email', null);
        if ($email===null) {
            return \response('请输入你的邮箱');
        }
        if (!$this->emailTools->checkEmail($email)) {
            return \response('邮箱格式不正确');
        }
        $message = 'test';
        $to =$email;
        $subject = 'webpro注册验证码';
        $checkCode=rand()%100000;

        Mail::raw('验证码:'.$checkCode, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });
        if(count(Mail::failures())>0)         return \response("验证码发送失败,请检查邮箱");
        $request->session()->put("email",$to);
        $request->session()->put("checkCode",$checkCode);
        $request->session()->save();
        return \response("邮箱验证码已经发送");
    }
}
