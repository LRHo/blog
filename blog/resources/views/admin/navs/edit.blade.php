@extends('layouts.admin')
@section('content')
<!--面包屑导航 开始-->
<div class="crumb_warp">
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;修改导航
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>自定义导航管理</h3>
    </div>
    <div class="result_content">
        <div class="short_wrap">
            <a href="{{url('admin/navs/create')}}"><i class="fa fa-plus"></i>新增导航</a>
            <a href="{{url('admin/navs')}}"><i class="fa fa-refresh"></i>全部导航</a>
        </div>
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    <form action="{{url('admin/navs/'.$field -> nav_id.'')}}" method="post">
        <input type="hidden" name="_method" value="put">
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
                <th><i class="require">*</i>导航名称：</th>
                <td>
                    <input type="text" class="sm" name="nav_name" value="{{$field -> nav_name}}">
                </td>
            </tr>
            <tr>
                <th>导航别名：</th>
                <td>
                    <input type="text"  name="nav_alias" value="{{$field -> nav_alias}}">
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>导航地址：</th>
                <td>
                    <input type="text" class="lg" name="nav_url" value="{{$field -> nav_url}}">
                    <p>导航地址不能为空</p>
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


