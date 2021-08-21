@extends('layouts.default')

@if (Auth::check())

@section('title')
配置文件 | <?php echo GetConfig('SiteName') ?>
@stop

@section('content')

<?php
echo '<form method="POST">';
foreach ($config as $conf) {
    echo '<div class="form-floating">';
    echo '<input type="text" class="form-control" id="' . $conf['name'] . '" name="' . $conf['name'] . '" value="' . $conf['value'] . '">';
    echo '<label for="' . $conf['name'] . '">' . $conf['name'] . '</label>';
    echo '</div>';
    echo '</br>';
}
echo '<button type="submit" class="btn btn-primary">提交</button>';
echo '</form>';
?>


@stop
@endif