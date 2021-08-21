@extends('layouts.default')

@section('content')

<div class="flash-message">
    <p class="alert alert-success">
    网站各种功能正在加速编排中，友链别删！
    </p>
</div>

<div id="intro">
    <img src="<?php if (GetConfig('SiteLogo') !='') { echo GetConfig('SiteLogo'); } ?>" alt="{{ GetConfig('SiteName') }}" id="logo">
    <h1>{{ GetConfig('AuthorName') }}</h1>
    <p>{{ GetConfig('AuthorWords') }}</p>

    <div id="social-icons">
        <?php
            if (GetConfig('GithubName') != '') {
                echo '<a href="https://github.com/' . GetConfig('GithubName') . '"><i class="fab fa-github"></i></a>';
            }
            if (GetConfig('NPMName') != '') {
                echo '<a href="https://www.npmjs.com/~' . GetConfig('NPMName') . '"><i class="fab fa-npm"></i></a>';
            }
        ?>
    </div>
</div>

<?php echo GetHomeMiniCard('article') ?>
<?php echo GetHomeMiniCard('diary') ?>

@stop