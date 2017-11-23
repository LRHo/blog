@extends('layouts.admin')
@section('content')
            <!--导航 开始-->
            <div class="crumb_warp">
                <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;系统基本信息
            </div>
            <!--导航 结束-->

            <div class="result_wrap">
                <div class="result_title">
                    <h3>系统基本信息</h3>
                </div>
                <div class="result_content">
                    <ul>
                        <li>
                            <label>操作系统</label><span>{{PHP_OS}}</span>
                        </li>
                        <li>
                            <label>运行环境</label><span>{{$_SERVER['SERVER_SOFTWARE']}}</span>
                        </li>
                        <li>
                            <label>版本</label><span>v-1.0</span>
                        </li>
                        <li>
                            <label>上传附件限制</label><span>64M</span>
                        </li>
                        <li>
                            <label>北京时间</label><span><?php echo date('Y-m-d H:i:s')?></span>
                        </li>
                        <li>
                            <label>服务器域名/IP</label><span>{{$_SERVER['SERVER_ADDR']}}</span>
                        </li>
                        <li>
                            <label>Host</label><span>{{$_SERVER['SERVER_ADDR']}}</span>
                        </li>
                    </ul>
                </div>
            </div>
{{--
            <div class="result_wrap">
                <div class="result_title">
                    <h3>使用帮助</h3>
                </div>
                <div class="result_content">
                    <ul>
                        <li>
                            <label>官方交流网站：</label><span><a href="#"></a></span>
                        </li>
                        <li>
                            <label>官方交流QQ群：</label><span><a href="#"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png"></a></span>
                        </li>
                    </ul>
                </div>
            </div>--}}
@endsection




