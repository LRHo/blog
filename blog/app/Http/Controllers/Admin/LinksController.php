<?php

namespace App\Http\Controllers\admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends Controller
{
    //get.admin/links 全部友情链接列表
    public function index()
    {
        $data=Links::orderBy('link_order','desc')->get();
        return view('admin.links.index',compact('data'));
    }

    //get.admin/links/create 添加链接
    public function create()
    {
        return view('admin/links/add');

    }

    //post.admin/links 添加分类 提交*验证
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'link_name' => 'required',
            'link_url' => 'required',
        ];
        $massage = [
            'link_name.required'=>'链接名称不能为空',
            'link_url.required'=>'链接地址不能为空',
        ];
        $validator = Validator::make($input, $rules, $massage);
        if ($validator->passes()) {
            $re = Links::create($input);
            if($re){
                return redirect('admin/links');
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
        $link = Links::find($input['link_id']);
        $link ->link_order = $input['link_order'];
        $re = $link->update();
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

    //delete.admin/links/{links} 删除单个链接
    public function destroy($link_id)
    {
        $re = Links::where('link_id', $link_id)->delete();
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
    //get.admin/links/{links}/edit 编辑（修改）链接
    public function edit($links_id)
    {
        $field = Links::find($links_id);
        return view('admin.links.edit',compact('field'));
    }

    //put.admin/links/{links} 更新链接
    public function update($link_id)
    {
        $input = Input::except('_token','_method');
        $re = Links::where('link_id',$link_id)->update($input);
        if($re)
        {
            return redirect('admin/links');
        }else
        {
            return back()->with('errors','编辑失败，请重试！');
        }

    }
}
