@extends('layouts.default')

@if (Auth::check())

@section('title')
<?php
    echo EchoTitle($post['title']);
?>
@stop

@section('content')
@include('layouts.edit_posts', [
    'ifnew' => 'n',
    'post' => $post])
@stop
@endif