@extends('layouts.admin')
@section('content')
<!--面包屑导航 开始-->
<div class="crumb_warp">
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;修改文章
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>文章管理</h3>
    </div>
    <div class="result_content">
        <div class="short_wrap">
            <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>新增文章</a>
            <a href="{{url('admin/article')}}"><i class="fa fa-refresh"></i>全部文章</a>
        </div>
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    <form action="{{url('admin/article/'.$field->art_id.'')}}" method="post">
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
                <th width="120">分类：</th>
                <td>
                    <select name="cate_id">
                        @foreach($data as $d)
                            <option value="{{$d -> cate_id}}"
                                @if($field ->cate_id == $d->cate_id) selected @endif
                            >{{$d -> _cate_name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <th>文章标题：</th>
                <td>
                    <input type="text" class="sm" name="art_title" value="{{$field -> art_title}}">
                </td>
            </tr>
            <tr>
                <th>发布者：</th>
                <td>
                    <input type="text" class="sm" name="art_editor" value="{{$field -> art_editor}}">
                </td>
            </tr>
            <tr>
                <th>插图:</th>
                <td>
                    <input type="text" class="sm" name="art_thumb">
                    <!--使用uploadfiy扩展上传功能 开始-->
                    <input id="file_upload" name="file_upload" type="file" multiple="true">
                    <script src="{{asset('resources/Org/uploadify/jquery.uploadify.min.js')}}"
                            type="text/javascript"></script>
                    <script type="text/javascript">
                        <?php $timestamp = time();?>
                        $(function() {
                            $('#file_upload').uploadify({
                                'buttonText':'上传',
                                'formData'     : {
                                    'timestamp' : '<?php echo $timestamp;?>',
                                    '_token'     : '{{csrf_token()}}'
                                },
                                'swf'      : '{{asset('resources/Org/uploadify/uploadify.swf')}}',
                                'uploader' : '{{url('admin/upload')}}',
                                'onUploadSuccess':function (file,data,response) {
                                    $("input[name='art_thumb']").val(data);
                                    $("#art_thumb_img").attr('src','/'+data);
                                }
                            });
                        });
                    </script>
                </td>
                <!--使用uploadfiy扩展上传功能 结束-->
            </tr>
            <tr>
                <th></th>
                <td>
                    <img src="/{{$field->art_thumb}}" alt="" id="art_thumb_img" style="width: 150px; max-height: 150px;">
                </td>
            </tr>
            <tr>
                <th>关键词：</th>
                <td>
                    <textarea name="art_tag" >{{$field -> art_tag}}</textarea>
                </td>
            </tr>
            <tr>
                <th>描述：</th>
                <td>
                    <textarea class="lg" name="art_description" >{{$field -> art_description}}</textarea>
                </td>
            </tr>

            <tr>
                <th>文章内容</th>
                <!--使用ueditor编辑器扩展 开始-->
                <td >
                    <script type="text/javascript" charset="utf-8" src="{{asset('resources/Org/ueditor/ueditor.config.js')}}" ></script>
                    <script type="text/javascript" charset="utf-8" src="{{asset('resources/Org/ueditor/ueditor.all.min.js')}}" > </script>
                    <script type="text/javascript" charset="utf-8" src="{{asset('resources/Org/ueditor/lang/zh-cn/zh-cn.js')}}" ></script>
                    <script id="editor" name="art_content" type="text/plain" style="width:800px;height:500px;">
                        {!! $field -> art_content!!}
                    </script>
                    <script type="text/javascript">
                        var ue = UE.getEditor('editor');
                    </script>
                    <style>
                        .edui-default{line-height: 28px}
                        div.edui-combox-body,div.edui-botton-body,div.edui-splitbutton-body
                        {overflow: hidden;height: 22px;}
                        div.edui-box{overflow: hidden;height: 22px;}
                    </style>
                </td>
                <!--使用ueditor编辑器扩展 结束-->
            </tr>
            <tr>
                <th></th>
                <td>
                    <input type="submit" value="修改">
                    <input type="button" class="back" onclick="history.go(-1)" value="返回">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
@endsection


