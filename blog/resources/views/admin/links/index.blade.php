@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 友情链接
    </div>
    <!--面包屑导航 结束-->
    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_title">
                <h3>链接管理</h3>
            </div>
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/links/create')}}"><i class="fa fa-plus"></i>新增链接</a>
                    <a href="{{url('admin/links')}}"><i class="fa fa-refresh"></i>全部链接</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%">排序</th>
                        <th class="tc" width="5%">ID</th>
                        <th>链接名称</th>
                        <th>链接标题</th>
                        <th>链接地址</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" name="ord[]" onchange="ChangeOrder(this,{{$v->link_id}})" value="{{$v->link_order}}">
                        </td>
                        <td class="tc">{{$v->link_id}}</td>
                        <td>
                            <a href="#">{{$v->link_name}}</a>
                        </td>
                        <td>{{$v->link_title}}</td>
                        <td>{{$v->link_url}}</td>
                        <td>
                            <a href="{{url('admin/links/'.$v->link_id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delLink({{$v -> link_id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->

<!--异步提交 更改排序 -->
<script>
    function ChangeOrder(obj,link_id){
        var link_order = $(obj).val();
        $.post("{{url('admin/link/change')}}",{'_token':'{{csrf_token()}}',
        'link_id':link_id,'link_order':link_order},function (data) {
            if(data.status==0){
                layer.alert(data.msg,{icon:6});
            }else{
                layer.alert(data.msg,{icon:5});
            }
        })
    }
</script>
<!--异步提交 更改排序 结束 -->

<script>
    //删除链接
    function delLink(link_id) {
        layer.confirm('是否删除？',{
            btu:['确定','取消']
        },function(){
            $.post("{{url('admin/links')}}/"+link_id,{'_method':'delete','_token':"{{csrf_token()}}"}, function (data) {
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