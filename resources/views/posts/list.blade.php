@extends('layouts.default')

@section('title')
<?php echo env('APP_NAME') ?>
@stop

@section('content')
<?php
// echo "<pre>";print_r($posts);echo "</pre>";
?>
<?php
echo GetPostsLists($posts, $page, $type);
?>
@stop
@section('footer')
<!-- Vditor -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vditor/dist/index.css" />
<script src="https://cdn.jsdelivr.net/npm/vditor/dist/index.min.js"></script> -->
@stop