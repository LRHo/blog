<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    //图片上传方法
    public function upload()
    {

      $file = Input::file('Filedata');
        if($file ->isValid()){
            $realPath = $file->getRealPath();  //这个表示的是缓存在tmp文件夹下的文件绝对路径。
            $extension = $file->getClientOriginalExtension();//获取后缀名
            $newName = date('YmdHis').mt_rand(100,999).".".$extension;//时间+三位随机数+后缀组成新的文件名
            $path = $file->move(base_path()."/uploads",$newName);
            $filePath = 'uploads/'.$newName;
            return $filePath;
        }

    }
}
