<nav class="navbar navbar-expand-lg navbar-light">
@if (Auth::check())
    <b><a class="navbar-brand bold" href="{{ route('home') }}">{{ GetConfig('SiteName') }}</a></b>
    <ul class="nav col align-self-end justify-content-end">
        @if (Gate::allows('CheckAdmin'))
            <li><a class="btn" href="{{ route('admin_edit') }}">编辑文章</a></li>
            <li><a class="btn" href="{{ route('admin_config') }}">配置博客</a></li>
        @endif
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('users.show', Auth::user()) }}">个人中心</a></li>
            <li><a class="dropdown-item" href="{{ route('users.edit', Auth::user()) }}">修改信息</a></li>
            @if (Gate::allows('CheckAdmin'))
                <li><a class="dropdown-item" href="/admin">管理后台</a></li>
            @endif
            <li><hr class="dropdown-divider"></li>
            <li>
            <a class="dropdown-item" id="logout" href="#">
            <form action="{{ route('logout') }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button class="btn btn-block btn-danger" type="submit" name="button">登出</button>
            </form>
            </a>
            </li>
            </ul>
        </li>
@else
    <a class="navbar-brand" href="{{ route('home') }}">{{ GetConfig('SiteName') }}</a>
    <ul class="nav col align-self-end justify-content-end">
        <!-- <li class="nav-item" ><a class="nav-link" href="{{ route('login') }}">登录</a></li> -->
@endif
    </ul>
</nav>