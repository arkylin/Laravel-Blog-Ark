@extends('layouts.default')

@if (Auth::check())

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
<div id="title">
<h1><input type="text" id="post_title" v-model="post_title" :style="get_width"></h1>
</div>
<script>
Vue.createApp({
    data() {
        return {
            post_title: '<?php echo $MD_title ?>'
        }
    },
    computed: {
        get_width() {
            return "width:" + this.post_title.length * 1.08 + "em"
        }
    }
}).mount('#title')
</script>
<hr class="dropdown-divider">
@include('layouts._vditor', [
    'ifnew' => 'n',
    'post_id' => $post -> id])
</br>

<div class="d-grid gap-2 d-md-flex justify-content-md-end">
<!-- <form action="edit" method="POST"> -->
<!-- <input class="btn btn-primary" type="submit" name="submit" value="1" onclick="myFunction()"> -->
<button class="btn btn-primary" onclick="myFunction()">OK</button>
<!-- </form> -->
</div>
</br>

<script>
function myFunction() {
    let PostValue = this.vditor.getValue();
    let PostData = {
        id: <?php echo $post['id'] ?>,
        title: $("#post_title").val(),
        content: PostValue
    };
    console.log(PostData);
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});
    let a = $.post("<?php echo url()->current() ?>", PostData, function(data){
        alert(data);
    });
    
}


</script>

@stop
@endif