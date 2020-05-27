<nav class="navbar navbar-expand-md navbar-dark bg-info fixed-left">
    <a class="navbar-brand" href="{{ route('dashboard') }}">兵庫県保育協会 <br> 研修管理システム</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse mt-3" id="navbarsExampleDefault">
        @guest
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">ユーザ登録</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">ログイン</a></li>
        </ul>
        @else
        <div class="w-100 nav-item dropdown my-3 p-2 bg-light">
            <a class="dropdown-toggle w-100 d-inline-block align-middle account " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">                
                <i class="fa fa-2x fa-user text-info mr-1"></i>
                <small class="align-top">{{ Auth::user()->name }}</small>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('account.edit',['user_id' => Auth::id()]) }}">登録内容変更</a>
                @can('user-only')
                <a class="dropdown-item" href="{{ route('account.withdrawalconfirm') }}">退会</a>
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
        </div>
        @endguest
        @auth
        <ul class="navbar-nav mt-3">
            <li class="nav-item">                
                <a class="nav-link" href="{{ route('dashboard') }}">ダッシュボード</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">研修</a>
                <div class="dropdown-menu">
                    <!-- <a class="dropdown-item" href="{{ route('event.index') }}">全ての研修</a>
                    <div class="dropdown-divider"></div> -->
                    <a class="dropdown-item" href="{{ route('event.before') }}">開催前の研修</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('event.finished') }}">終了した研修</a>
                    @can('area-higher')
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('event.create') }}">研修登録</a>
                    @endcan
                </div>
            </li>
            @can('area-higher')
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">申込管理</a>
                <div class="dropdown-menu">
                    <!-- <a class="dropdown-item" href="{{ route('entry.index') }}">全ての研修</a>
                    <div class="dropdown-divider"></div> -->
                    <a class="dropdown-item" href="{{ route('entry.interm') }}">受付中の研修</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('entry.finished') }}">受付終了した研修</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">受付管理</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('reception.index') }}">開催間近の研修</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('reception.finished') }}">終了した研修</a>
                </div>
            </li>
            @endcan

            @can('admin-higher')
            <li class="nav-item dropdown">
                <a class="nav-link" href="{{ route('history.user') }}">受講履歴</a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('history.index') }}">受講履歴</a>
            </li>
            @endcan

            @can('system-only')
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">メール</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('mail.index') }}">メール一覧（下書き・送信済）</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('mail.create') }}">メール作成</a>
                    <!-- <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('mailgroup.index') }}">グループ一覧</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('mailgroup.create') }}">グループ作成</a> -->
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ユーザ管理</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('account.branch_user') }}">支部ユーザ</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('account.company_user') }}">法人ユーザ</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('account.general_user') }}">個人ユーザ</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('account.regist') }}">ユーザ登録</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">サイトコンテンツ</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('information.index') }}">インフォメーション</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('inquiry.index') }}">お問い合わせ</a>
                </div>
            </li>
            @elsecan('admin-only')
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ユーザ管理</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('account.index') }}">ユーザ一覧</a>
                </div>
            </li>            
            @endcan
        </ul>
        @endauth
    </div>
</nav>    
