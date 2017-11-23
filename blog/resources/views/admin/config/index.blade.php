@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 配置项管理
    </div>
    <!--面包屑导航 结束-->
    <!--搜索结果页面 列表 开始-->
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_title">
                <h3>配置项管理</h3>
            </div>
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>新增配置</a>
                    <a href="{{url('admin/config')}}"><i class="fa fa-refresh"></i>全部配置</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <form action="{{url('admin/config/changeContent')}}" method="post">
                    {{csrf_field()}}

                    <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%">排序</th>
                        <th class="tc" width="5%">ID</th>
                        <th>配置标题</th>
                        <th>配置名称</th>
                        <th>配置内容</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" name="ord[]" onchange="ChangeOrder(this,{{$v->conf_id}})"
                                   value="{{$v->conf_order}}">
                        </td>
                        <td class="tc">{{$v->conf_id}}</td>
                        <td>
                            {{$v->conf_title}}
                        </td>
                        <td>{{$v->conf_name}}</td>
                        <td>
                            <input type="hidden" name="conf_id[]" value="{{$v -> conf_id}}">
                            {!! $v->_html !!}
                        </td>
                        <td>
                            <a href="{{url('admin/config/'.$v->conf_id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delConf({{$v -> conf_id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                    </table>
                    <div>
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </div>
                </form>
            </div>
        </div>

    <!--搜索结果页面 列表 结束-->

<!--异步提交 更改排序 -->
<script>
    function ChangeOrder(obj,conf_id){
        var conf_order = $(obj).val();
        $.post("{{url('admin/config/change')}}",{'_token':'{{csrf_token()}}',
        'conf_id':conf_id,'conf_order':conf_order},function (data) {
            if(data.status==0){
                layer.alert(data.msg,{icon:6});
            }else{
                layer.alert(data.msg,{icon:5});
            }
        })
    }
<!--异步提交 更改排序 结束 -->

    //删除配置
    function delConf(conf_id) {
        layer.confirm('是否删除？',{
            btu:['确定','取消']
        },function(){
            $.post("{{url('admin/config')}}/"+conf_id,{'_method':'delete','_token':"{{csrf_token()}}"},
                    function (data) {
                if(data.status==0){
                    location.href = location.href;
                    layer.alert(data.msg,{icon:6});
                }else{
                    layer.alert(data.msg,{icon:5});
                }
            });
        })
    }

</script>
@endsection