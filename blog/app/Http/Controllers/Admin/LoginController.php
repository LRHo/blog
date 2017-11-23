<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

require_once 'resources/Org/code/Code.class.php';

class LoginController extends Controller
{

    //登录验证
    public function login(){
        if($input = Input::all()){
            $code = new \code;
            $_code = $code->get();
            //验证码校对，返回提示
            if(strtoupper($input['code'] )!= $_code){
                return back() -> with('msg','验证码错误');
            }
            $user = UserModel::first();
            //验证用户输入用户名和密码，返回提示
            if($user->user_name != $input['user_name'] || Crypt::decrypt($user->user_paw) != $input['user_pass'])
            {
                return back() -> with('msg','用户名或密码错误');
            }
            session(['user'=>$user]);
            return redirect('admin/index');
        }else
        {
            return view('admin.login');
        }


    }
    //生成验证码
    public function code(){
        $code = new \code;
        $code ->make();
    }
    //退出，清空session,回到登录页面
    public function quit(){
        session(['user'=>null]);
        return redirect('admin/login');
    }
}
