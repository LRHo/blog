@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 全部分类
    </div>
    <!--面包屑导航 结束-->
    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_title">
                <h3>分类管理</h3>
            </div>
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/category/create')}}"><i class="fa fa-plus"></i>新增分类</a>
                    <a href="{{url('admin/category')}}"><i class="fa fa-refresh"></i>全部分类</a>
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
                        <th>分类名称</th>
                        <th>标题</th>
                        <th>查看次数</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" name="ord[]" onchange="ChangeOrder(this,{{$v->cate_id}})" value="{{$v->cate_order}}">
                        </td>
                        <td class="tc">{{$v->cate_id}}</td>
                        <td>
                            <a href="#">{{$v->_cate_name}}</a>
                        </td>
                        <td>{{$v->cate_title}}</td>
                        <td>{{$v->cate_view}}</td>
                        <td>
                            <a href="{{url('admin/category/'.$v->cate_id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delCate({{$v->cate_id}});">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
                <div class="page_list">
                </div>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->


<script>
    //异步修改排序
    function ChangeOrder(obj,cate_id){
        var cate_order = $(obj).val();
        $.post("{{url('admin/cate/change')}}",{'_token':'{{csrf_token()}}',
        'cate_id':cate_id,'cate_order':cate_order},function (data) {
            if(data.status==0){
                layer.alert(data.msg,{icon:6});
            }else{
                layer.alert(data.msg,{icon:5});
            }
        })
    }


    //删除方法
    function delCate(cate_id) {
        layer.confirm('是否删除？',{
            btu:['确定','取消']
        },function(){
            $.post("{{url('admin/category')}}/"+cate_id,{'_method':'delete','_token':"{{csrf_token()}}"}, function (data) {
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