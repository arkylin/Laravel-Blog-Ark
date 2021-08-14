@extends('layouts.default')

@section('content')

<div id="intro" class="home">
    <img src="https://www.xyz.blue/logo" alt="<?php echo env('APP_NAME') ?>" id="logo">
    <h1><?php echo env('ADMIN_NAME') ?></h1>
    <p>I am a student.</p>
</div>

<div id="social-icons" class="home">
</div>

<div id="blog" class="home">
    <h1>Blog</h1>
    <?php echo GetTheNewestPosts() ?>
    <a href="<?php echo env('APP_URL') ?>/posts"><h1 id="home-add-text">点击查看更多</h1></a>
</div>

<div id="diary" class="home">
</div>

<div id="image" class="home">
</div> 

@stop