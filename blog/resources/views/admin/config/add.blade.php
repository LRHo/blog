@extends('layouts.admin')
@section('content')
<!--面包屑导航 开始-->
<div class="crumb_warp">
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;添加配置项
</div>
<!--面包屑导航 结束-->

<!--结果集标题与配置项组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>配置项管理</h3>
    </div>
    <div class="result_content">
        <div class="short_wrap">
            <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>新增配置项</a>
            <a href="{{url('admin/config')}}"><i class="fa fa-refresh"></i>全部配置项</a>
        </div>
    </div>
</div>
<!--结果集标题与配置项组件 结束-->

<div class="result_wrap">
    <form action="{{url('admin/config')}}" method="post">
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
                <th><i class="require">*</i>配置项标题：</th>
                <td>
                    <input type="text" class="sm" name="conf_title">
                    <p>配置项标题不能为空</p>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>配置项名称：</th>
                <td>
                    <input type="text" class="sm" name="conf_name">
                    <p>配置项名称不能为空</p>
                </td>
            </tr>
            <tr>
                <th>类型：</th>
                <td>
                    <input type="radio" name="field_type" value="input" onclick="showTr()" checked >input　
                    <input type="radio" name="field_type" value="textarea" onclick="showTr()">textarea　
                    <input type="radio" name="field_type" value="radio" onclick="showTr()">redio　
                </td>
            </tr>
            <tr class="field_value">
                <th>类型值：</th>
                <td>
                    <input type="text" class="sm" name="field_value">
                    <p>只有在类型为redio时才需要配置 1|开启，0|关闭</p>
                </td>
            </tr>
            <tr>
                <th>排序：</th>
                <td>
                    <input type="text" class="sm" name="conf_order" value="0">
                </td>
            </tr>
            <tr>
                <th>说明：</th>
                <td>
                    <textarea name="conf_tips" id="" cols="30" rows="10"></textarea>
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

<script>
    showTr();
    function showTr(){
        var type = $('input[name = field_type]:checked').val();
        if(type == 'radio'){
            $('.field_value').show();
        }else{
            $('.field_value').hide();
        }
    }
</script>
@endsection


