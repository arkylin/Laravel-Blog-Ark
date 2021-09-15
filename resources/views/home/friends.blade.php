@extends('layouts.default')

@section('content')
<div class="flash-message">
    <p class="alert alert-success">
    友链如有缺失，请联系添加！
    </p>
</div>
<h5>
举个例子：</br>
</h5>
<p>
名称：Arkylin的小屋</br>
网址：https://www.xyz.blue</br>
头像：https://assets.xyz.blue/logo</br>
描述：I'm a student.</br>
</p>
<?php echo GetFriendsLinks(); ?>
@stop