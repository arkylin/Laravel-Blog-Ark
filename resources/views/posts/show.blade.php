@extends('layouts.default')

@section('title')
<?php
    $MD_title = $post['title'];
    if ( $MD_title !="" ) {
        echo $MD_title . " | " . config('blog.Name');
    } else {
        echo config('blog.Name');
    }
?>
@stop

@section('content')
<article>
<h2><?php echo $MD_title ?></h2>
<div id="preview"><?php echo GetSummary($post['content']); ?></div>
</article>
@stop

@section('footer')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vditor/dist/index.css" />
<script src="https://cdn.jsdelivr.net/npm/vditor/dist/index.min.js"></script>
<script>
    //Vditor
    const initOutline = () => {
        const headingElements = []
        Array.from(document.getElementById('preview').children).forEach((item) => {
        if (item.tagName.length === 2 && item.tagName !== 'HR' && item.tagName.indexOf('H') === 0) {
            headingElements.push(item)
        }
        })

        let toc = []
        window.addEventListener('scroll', () => {
        const scrollTop = window.scrollY
        toc = []
        headingElements.forEach((item) => {
            toc.push({
            id: item.id,
            offsetTop: item.offsetTop,
            })
        })
        })
    }
    fetch('<?php echo url('posts/api/id') ?>/<?php echo $post['id'] ?>').
    then(response => response.json()).
    then(content => content['content']).
    then(markdown => {
        Vditor.preview(document.getElementById('preview'),
        markdown, {
            after () {
                initOutline()
            },
        })
    })
</script>
<link rel="stylesheet" href="//cdn.jsdelivr.net/gh/highlightjs/cdn-release/build/styles/nord.min.css">
<script src="//cdn.jsdelivr.net/gh/highlightjs/cdn-release/build/highlight.min.js"></script>
<script>hljs.highlightAll();</script>
@stop