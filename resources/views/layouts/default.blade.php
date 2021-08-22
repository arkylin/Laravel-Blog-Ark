<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>@yield('title', GetConfig('SiteName') . ' | ' . GetConfig('SiteDesc'))</title>
        <!-- 引入js、css -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <!-- <link rel="stylesheet" href="<?php echo env('ASSETS_URL') ?>/css/app.css"> -->
        <script src="{{ mix('js/app.js') }}"></script>
        <!-- <script src="<?php echo env('ASSETS_URL') ?>/js/app.js"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.4.0/dist/lazyload.min.js"></script>
        <meta name="description" content="{{ GetConfig('SiteDesc') }}">
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
        </div>
        <!-- @yield('post_vditor', "") -->
        @yield('footer', "")
        <!-- 页脚扩展 -->
        @includeIf('layouts._footer')
        </br>
    </body>
</html>