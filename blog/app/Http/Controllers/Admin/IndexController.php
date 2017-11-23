<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\UserModel;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    //
    public function index(){
        return view('admin.index');
    }
    public function info(){
        return view('admin.info');
    }
    //更改管理员密码
    public function pass(){
        if($input = Input::all()){
            $rules=[
                'password'=>'required|between:6,20|confirmed',
                'password_o'=>'required',
            ];
            $massage=[
                'password.required'=>'新密码不能为空',
                'password_o.required'=>'原密码不能为空',
                'password.between'=>'新密码必须在6至20位之间',
                'password.confirmed'=>'两次密码不一致！',
            ];
            $validator = Validator::make($input,$rules,$massage);
            if($validator->passes()){
                $user = UserModel::first();
                $_password = Crypt::decrypt($user->user_paw);
                if($input['password_o'] == $_password){
                    $user ->user_paw = Crypt::encrypt($input['password']);
                    $user ->update();
                    return redirect('admin/info');
                }else{
                    return back() -> with('errors','原密码错误！');
                }
            }else{
                    return back() -> withErrors($validator);
            }
        }else{
            return view('admin.pass');
        }

    }
}
