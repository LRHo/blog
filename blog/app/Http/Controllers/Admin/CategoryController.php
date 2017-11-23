<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //get.admin/category 全部分类列表
    public function index()
    {
        $category = (new Category)->tree();
        return view('admin.category.index')->with('data', $category);
    }

    //get.admin/category/create 添加分类
    public function create()
    {
        $data = Category::where('cate_pid',0)->get();
        return view('admin/category/add',compact('data'));

    }


    //post.admin/category 添加分类 提交*验证
    public function store()
    {
            $input = Input::except('_token');
            $rules = [
                'cate_name' => 'required',
            ];
            $massage = [
                'cate_name.required'=>'分类名称不能为空',
            ];

            $validator = Validator::make($input, $rules, $massage);
            if ($validator->passes()) {
                    $re = Category::create($input);
                if($re){
                    return redirect('admin/category');
                }else{
                    return back()->with('errors','提交数据错误，请稍后重试！');
                }

            } else {
                return back()->withErrors($validator);
            }

    }

    //get.admin/category/{category} 展示单个分类信息
    public function show()
    {


    }


    //delete.admin/category/{category} 删除单个分类
    public function destroy($cate_id)
    {
        $re = Category::where('cate_id', $cate_id)->delete();
        //Category::where('cate_pid',$cate_id)->updata(['cate_pid'=>0]);
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



    //get.admin/category/{category}/edit 编辑（修改）分类
    public function edit($cate_id)
    {
        $field = Category::find($cate_id);
        $data = Category::where('cate_pid',0)->get();
        return view('admin.category.edit',compact('field','data'));
    }

    //put.admin/category/{category} 更新分类
    public function update($cate_id)
    {
        $input = Input::except('_token','_method');
        $re = Category::where('cate_id',$cate_id)->update($input);
        if($re)
        {
            return redirect('admin/category');
        }else
        {
            return back()->with('errors','编辑失败，请重试！');
        }

    }
//更改排序方法
    public function changeOrder()
    {

        $input = Input::all();
        $cate = Category::find($input['cate_id']);
        $cate ->cate_order = $input['cate_order'];
        $re = $cate->update();
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
}
