<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>@yield('title', GetConfig('SiteName') . ' | ' . GetConfig('SiteDesc'))</title>
        <!-- 引入js、css -->
        <!-- VUE -->
        <script src="{{ env('ASSETS_URL') }}/static/Vue/vue.global.js"></script>
        <!-- Bootstrap -->
        <link href="{{ env('ASSETS_URL') }}/static/Bootstrap/bootstrap.min.css" rel="stylesheet">
        <script src="{{ env('ASSETS_URL') }}/static/Bootstrap/bootstrap.bundle.min.js"></script>
        <!-- jQuery -->
        <script src="{{ env('ASSETS_URL') }}/static/jQuery/jquery.min.js"></script>
        <!-- LazyLoad -->
        <script src="{{ env('ASSETS_URL') }}/static/Lazyload/vanilla-lazyload.min.js"></script>
        <!-- FontAwesome -->
        <!-- <link href="{{ env('ASSETS_URL') }}/static/FontAwesome/css/all.min.css" rel="stylesheet"> -->
        <!-- <script src="{{ env('ASSETS_URL') }}/static/FontAwesome/js/all.min.js"></script> -->
        <!-- 自定义 -->
        <link rel="stylesheet" href="{{ url('static/css/main.css') }}">
        <script src="{{ url('static/js/main.js') }}"></script>
        <!-- MIX -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <!-- <script src="mix('js/app.js')"></script> -->
        <!-- 完成引入 -->
        <!-- <meta name="description" content="{{ GetConfig('SiteDesc') }}"> -->
        @yield('descri', '')
        <meta name="keywords" content="{{ GetConfig('SiteKeywords') }}"}
        <!-- CSRF -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @yield('header', "")
        <?php echo IfEnableBaiduTongji('true'); ?>
    </head>
    <body>
    <script type='text/javascript'>
    // 　　window.onload = function(){
    // 　　　　alert("页面加载完成====》onload");
    // 　　}
    　　$(document).ready(function () {
    　　　　var lazyLoadInstance = new LazyLoad({
            // Your custom settings go here
            });
    　　});
    </script>
    <div class="container" id="main">
        @include('layouts._header')
            <div class="offset-md-1 col-md-10">
            @include('shared._messages')
            </div>
        @yield('content')
        <!-- @yield('post_vditor', "") -->
        @yield('footer', "")
        <!-- 页脚扩展 -->
        @includeIf('layouts._footer')
    </div>
        </br>
    </body>
</html>