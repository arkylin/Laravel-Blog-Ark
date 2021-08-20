@extends('layouts.default')

@section('content')

<div class="flash-message">
    <p class="alert alert-success">
    网站各种功能正在加速编排中，友链别删！
    </p>
</div>

<div id="intro">
    <img src="https://www.xyz.blue/logo" alt="<?php echo env('APP_NAME') ?>" id="logo">
    <h1><?php echo env('ADMIN_NAME') ?></h1>
    <p>I am a student.</p>

    <div id="social-icons">
        <a href="https://github.com/arkylin"><i class="fab fa-github"></i></a>
        <a href="https://www.npmjs.com/~arkylin"><i class="fab fa-npm"></i></a>
    </div>
</div>

<?php echo GetHomeMiniCard('article') ?>
<?php echo GetHomeMiniCard('diary') ?>

@stop