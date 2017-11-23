@extends('layouts.admin')
@section('content')

<!--面包屑导航 开始-->
<div class="crumb_warp">
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;文章管理
</div>
<!--面包屑导航 结束-->

<form action="#" method="post">
    <div class="result_wrap">
        <!--快捷导航 开始-->
        <div class="result_title">
            <h3>全部文章</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>新增文章</a>
                <a href="{{url('admin/article')}}"><i class="fa fa-refresh"></i>全部文章</a>
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>

    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab">
                <tr>
                    <th class="tc">ID</th>
                    <th>标题</th>
                    <th>描述</th>
                    <th>点击</th>
                    <th>发布人</th>
                    <th>发布时间</th>
                    <th>操作</th>
                </tr>
                @foreach($data as $v)
                <tr>
                    <td class="tc">
                        {{$v -> art_id}}
                    </td>
                    <td>
                        <a href="#">{{$v -> art_title}}</a>
                    </td>
                    <td>
                        <a href="#">{{$v -> art_description}}</a>
                    </td>
                    <td>{{$v -> art_view}}</td>
                    <td>{{$v -> art_editor}}</td>
                    <td>{{date('Y-m-d',$v -> art_time)}}</td>
                    <td>
                        <a href="{{url('admin/article/'.$v->art_id.'/edit')}}">修改</a>
                        <a href="javascript:;" onclick="delArt({{$v->art_id}});">删除</a>
                    </td>
                </tr>
                    @endforeach
            </table>
            <div class="page_list">
                    {{$data -> links()}}
            </div>
        </div>

        <!--分页样式微调 开始-->
        <style>
            .result_content ul li span {
                padding: 6px 10px;
            }
        </style>
        <!--分页样式微调 结束-->

        <script>
            //删除文章
            function delArt(art_id) {
                layer.confirm('是否删除？',{
                    btu:['确定','取消']
                },function(){
                    $.post("{{url('admin/article')}}/"+art_id,{'_method':'delete','_token':"{{csrf_token()}}"}, function (data) {
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



