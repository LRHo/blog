<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
     //get.admin/article 全部文章列表
    public function index()
    {
        $data = Article::orderBy('art_id','desc')->paginate(10);
        return view('admin.article.index',compact('data'));
    }

    //get.admin/article/create 添加文章
    public function create()
    {
        $data = (new Category)->tree();
        return view('admin.article.add',compact('data'));

    }
    //post.admin/article 添加文章 提交*验证
    public function store()
    {
        $input = Input::except('_token');
        $input ['art_time'] = time();
        $rules = [
            'art_title' => 'required',
            'art_content' => 'required',
            'art_editor' => 'required',
        ];
        $massage = [
            'art_title.required'=>'文章标题不能为空',
            'art_content.required'=>'内容不能为空',
            'art_editor.required'=>'发布者不能为空',
        ];
        $validator = Validator::make($input, $rules, $massage);
        if ($validator->passes()) {
            $re = Article::create($input);
            if ($re) {
                return redirect('admin/article');
            } else {
                return back()->with('errors', '提交数据错误，请稍后重试！');
            }
        }else {
        return back()->withErrors($validator);
        }
    }

    //get.admin/article/{article}/edit 编辑（修改）分类
    public function edit($art_id)
    {
        $field = Article::find($art_id);
        $data = Article::where('art_id',0)->get();
        return view('admin.article.edit',compact('field','data'));
    }

    //put.admin/article/{article} 更新文章
    public function update($art_id)
    {
        $input = Input::except('_token','_method');
        $re = Article::where('art_id',$art_id)->update($input);
        if($re)
        {
            return redirect('admin/article');
        }else
        {
            return back()->with('errors','编辑失败，请重试！');
        }

    }
    //delete.admin/article/{article} 删除单个分类
    public function destroy($art_id)
    {
        $re = Article::where('art_id', $art_id)->delete();
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
}
