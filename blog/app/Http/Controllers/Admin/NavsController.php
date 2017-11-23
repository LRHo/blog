<?php

namespace App\Http\Controllers\admin;

use App\Http\Model\navs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class navsController extends Controller
{
    //get.admin/navs 全部友情导航列表
    public function index()
    {
        $data=Navs::orderBy('nav_order','desc')->get();
        return view('admin.navs.index',compact('data'));
    }

    //get.admin/navs/create 添加导航
    public function create()
    {
        return view('admin/navs/add');

    }

    //post.admin/navs 添加导航 提交*验证
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'nav_name' => 'required',
            'nav_url' => 'required',
        ];
        $massage = [
            'nav_name.required'=>'导航名称不能为空',
            'nav_url.required'=>'导航地址不能为空',
        ];
        $validator = Validator::make($input, $rules, $massage);
        if ($validator->passes()) {
            $re = Navs::create($input);
            if($re){
                return redirect('admin/navs');
            }else{
                return back()->with('errors','提交数据错误，请稍后重试！');
            }

        } else {
            return back()->withErrors($validator);
        }

    }
    //更改排序
    public function changeOrder()
    {

        $input = Input::all();
        $nav = Navs::find($input['nav_id']);
        $nav ->nav_order = $input['nav_order'];
        $re = $nav->update();
        if($re){
            $data = [
                'status'=>0,
                'msg'=>'更新成功',
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'更新失败',
            ];
        }
        return $data;
    }

    //delete.admin/navs/{navs} 删除单个导航
    public function destroy($nav_id)
    {
        $re = Navs::where('nav_id', $nav_id)->delete();
        if ($re) {
            $data = [
                'status' => 0,
                'msg' => '删除成功！',
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '删除失败,请稍后重试！',
            ];
        }
        return $data;
    }
    //get.admin/navs/{navs}/edit 编辑（修改）分类
    public function edit($nav_id)
    {
        $field = Navs::find($nav_id);
        return view('admin.navs.edit',compact('field'));
    }

    //put.admin/navs/{navs} 更新导航
    public function update($nav_id)
    {
        $input = Input::except('_token','_method');
        $re = Navs::where('nav_id',$nav_id)->update($input);
        if($re)
        {
            return redirect('admin/navs');
        }else
        {
            return back()->with('errors','编辑失败，请重试！');
        }

    }
}
