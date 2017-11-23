@extends('layouts.admin')
@section('content')
<!--面包屑导航 开始-->
<div class="crumb_warp">
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;分类管理
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>添加分类</h3>
    </div>
    <div class="result_content">
        <div class="short_wrap">
            <a href="{{url('admin/category/create')}}"><i class="fa fa-plus"></i>新增分类</a>
            <a href="{{url('admin/category')}}"><i class="fa fa-refresh"></i>全部分类</a>
        </div>
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    <form action="{{url('admin/category')}}" method="post">
        {{csrf_field()}}

        @if(count($errors)>0)
            @if(is_object($errors))
                @foreach($errors->all() as $error)
                    <p>{{$error}}</p>
                @endforeach
            @else
                <p>{{$errors}}</p>
            @endif
        @endif

        <table class="add_tab">
            <tbody>
            <tr>
                <th width="120"><i class="require">*</i>分类：</th>
                <td>
                    <select name="cate_pid">
                        <option value="0">默认（创建顶级分类）</option>
                        @foreach($data as $d)
                            <option value="{{$d ->cate_id}}">{{$d -> cate_name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>分类名称：</th>
                <td>
                    <input type="text" class="sm" name="cate_name">
                    <p>分类名称不能为空</p>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>分类标题：</th>
                <td>
                    <input type="text" class="lg" name="cate_title">
                    <p>标题不超过25个字</p>
                </td>
            </tr>
            <tr>
                <th>关键词：</th>
                <td>
                    <textarea name="cate_keywords"></textarea>
                </td>
            </tr>
            <tr>
                <th>描述：</th>
                <td>
                    <textarea class="lg" name="cate_description"></textarea>
                    <p>标题可以写30个字</p>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>排序：</th>
                <td>
                    <input type="text" class="sm" name="cate_order">
                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <input type="submit" value="提交">
                    <input type="button" class="back" onclick="history.go(-1)" value="返回">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
@endsection


