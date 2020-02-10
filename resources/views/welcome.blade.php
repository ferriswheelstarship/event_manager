<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
  <link href="{{ asset('css/navbar-fixed-left.min.css') }}" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top">
    <a class="navbar-brand" href="{{ route('dashboard') }}">イベント管理</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse mt-3" id="navbarsExampleDefault">
        @auth
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">ダッシュボード</a>
            </li>
            <li class="nav-item">
                <a class="nav-link">イベント管理</a>
            </li>
            <li class="nav-item">
                <a class="nav-link">申込管理</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ユーザ設定</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('account.index') }}">ユーザ情報</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('account.regist') }}">ユーザ登録</a>
                </div>
            </li>
        </ul>
        @endauth
        <ul class="navbar-nav float-right">
            @guest
            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">ユーザ登録</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">ログイン</a></li>
            @else
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ url('account/edit/'.Auth::id()) }}">登録内容変更</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        ログアウト
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                    </a>
                </div>
            </li>
            @endguest
        </ul>
    </div>
</nav>    
<!-- <header class="mb-4">
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark"> 
        <a class="navbar-brand" href="{{ route('dashboard') }}">イベント管理</a>
         
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav navbar-right">
              @guest
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">ユーザ登録</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">ログイン</a></li>
              @else
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->name }}</a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="dropdown-item">
                            <a href="{{ route('logout') }}"
                              onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                              Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                              {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
              @endguest
            </ul>
        </div>
    </nav>
</header> -->
<div class="">
  <div class="" id="content">

  </div>
</div>

<!-- footer -->
<footer class="footer">
  <div class="text-muted text-center">&copy; </div>
</footer>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>

@yield('each-js')

</body>
</html>