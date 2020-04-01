<nav class="navbar navbar-expand-md navbar-dark bg-info fixed-left">
    <a class="navbar-brand" href="{{ route('dashboard') }}">兵庫県保育協会 <br> 研修管理システム</a>
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
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">研修管理</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('event.index') }}">研修一覧</a>
                    @can('area-higher')
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('event.create') }}">研修登録</a>
                    @endcan
                </div>
            </li>            
            <li class="nav-item">
                <a class="nav-link">申込管理</a>
            </li>
            @can('system-only')
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ユーザ設定</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('account.index') }}">ユーザ情報</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('account.regist') }}">ユーザ登録</a>
                </div>
            </li>
            @elsecan('admin-only')
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ユーザ設定</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('account.index') }}">ユーザ情報</a>
                </div>
            </li>            
            @endcan
        </ul>
        @endauth
        <ul class="navbar-nav">
            @guest
            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">ユーザ登録</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">ログイン</a></li>
            @else
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('account.edit',['user_id' => Auth::id()]) }}">登録内容変更</a>
                    @can('user-only')
                    <a class="dropdown-item" href="{{ route('account.withdrawalconfirm') }}">退会（休止）</a>
                    @endcan
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
