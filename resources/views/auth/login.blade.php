<!DOCTYPE html>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="format-detection" content="telephone=no" />
<link rel="icon" href="/img/favicon.ico" />
<link rel="shortcut icon" href="/img/favicon.ico" type="image/vnd.microsoft.icon" />
<link rel="icon" href="/img/favicon.ico" type="image/vnd.microsoft.icon" />
<link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon" />
@php 
  $hostname = $_SERVER['HTTP_HOST'];
@endphp
@if($hostname != 'hyogo-hoiku-kyokai.jp')
<meta name="robots" content="noindex,nofollow"/>
@endif
<title>公益社団法人 兵庫県保育協会 | ユーザログイン</title>
<!-- <script type="text/javascript" src="//webfont.fontplus.jp/accessor/script/fontplus.js?kZSFUtx-OUM%3D&box=93sB9wS4lok%3D&aa=1&ab=2" charset="utf-8"></script> -->

<link href="{{ asset('css/web/swiper.css') }}" rel="stylesheet">
<link href="{{ asset('css/web/style.css') }}" rel="stylesheet">
<link href="{{ asset('css/web/add.css') }}" rel="stylesheet">
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"> -->

</head>
<body id="home">
<!--[if lte IE 10]>
<div class="browserhappy">
Internet Explorerの安全ではないバージョンをお使いのようです。古いWebブラウザを使い続けるとパソコンに危険性が生じます。今すぐブラウザをアップグレードしましょう。
<a href="http://browsehappy.com/" target="_blank">今すぐアップグレード！</a>
</div>
<![endif]-->
<div class="wbx"></div>
<div class="wrp">
  <!-- btn-to-top -->
  <div id="btnToTopBox" class="btn-to-top-float-box">
    <div class="btn-to-top-box">
      <a href="javascript:;" id="btnToTop" class="btn-to-top"></a>
    </div>
  </div>

  <!-- header -->
  <header id="header" class="header">
    <div id="headerInner" class="header-inner">
      <div class="header-box">
        <div class="header-logo">
          <a href="/" class="header-logo-a">
            <div class="header-logo-txt"><span class="logo-txt-s">公益社団法人 兵庫県保育協会</span><br /><span class="logo-txt-l">研修サイト</span></div>
          </a>
        </div>
        <div class="header-nav">
          <div class="header-nav-1">
            <a href="{{ route('links') }}" class="header-nav-link">リンク</a>
            <a href="{{ route('privacy') }}" class="header-nav-link">個人情報保護方針</a>
          </div>
          <div class="header-nav-2">
            <a href="{{ route('login') }}" class="header-nav-btn header-nav-btn-shisetsu">施設ログイン</a>
            <a href="{{ route('login') }}" class="header-nav-btn header-nav-btn-jimukyoku">事務局ログイン</a>
          </div>
        </div>
        <div class="header-icon">
          <div id="navIcon" class="nav-toggle nav-toggle-open">
            <span class="nav-toggle-bar"></span>
            <span class="nav-toggle-bar"></span>
            <span class="nav-toggle-bar"></span>
            <span class="nav-toggle-text"></span>
          </div>
        </div>
      </div>
    </div>
    <!-- nav -->
    <nav id="navMenu" class="nav">
      <div class="nav-inner">
        <ul class="nav-ul-1">
          <li class="nav-ul-1-li active">
            <a href="{{ route('greeting') }}" class="nav-ul-1-li-a"><span class="nav-ul-1-li-a-span nav-ul-1-li-a-greeting">ごあいさつ</span></a>
          </li>
          <li class="nav-ul-1-li">
            <a href="/user_manual.pdf" target="_blank" class="nav-ul-1-li-a"><span class="nav-ul-1-li-a-span nav-ul-1-li-a-manual">操作マニュアル</span></a>
          </li>
          <li class="nav-ul-1-li">
            <a href="{{ route('register') }}" class="nav-ul-1-li-a"><span class="nav-ul-1-li-a-span nav-ul-1-li-a-registration">ユーザ新規登録</span></a>
          </li>
          <li class="nav-ul-1-li">
            <a href="{{ route('login') }}" class="nav-ul-1-li-a"><span class="nav-ul-1-li-a-span nav-ul-1-li-a-login">ユーザログイン</span></a>
          </li>
          <li class="nav-ul-1-li">
            <a href="{{ route('contact') }}" class="nav-ul-1-li-a"><span class="nav-ul-1-li-a-span nav-ul-1-li-a-contact">お問い合わせ</span></a>
          </li>
          <li class="nav-ul-1-li nav-ul-1-li-sp">
            <a href="{{ route('login') }}" class="nav-ul-1-li-a"><span class="nav-ul-1-li-a-span nav-ul-1-li-a-shisetsu">施設ログイン</span></a>
          </li>
          <li class="nav-ul-1-li nav-ul-1-li-sp">
            <a href="{{ route('login') }}" class="nav-ul-1-li-a"><span class="nav-ul-1-li-a-span nav-ul-1-li-a-jimukyoku">事務局ログイン</span></a>
          </li>
          <li class="nav-ul-1-li nav-ul-1-li-sp">
            <a href="{{ route('links') }}" class="nav-ul-1-li-a"><span class="nav-ul-1-li-a-span nav-ul-1-li-a-links">リンク</span></a>
          </li>
          <li class="nav-ul-1-li nav-ul-1-li-sp">
            <a href="{{ route('privacy') }}" class="nav-ul-1-li-a"><span class="nav-ul-1-li-a-span nav-ul-1-li-a-privacy">個人情報保護方針</span></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

    <div id="main" class="contents">
    <div class="second-mainvis-box greeting-mainvis">
      <h1 class="second-mainvis-pagetitle"><span class="greeting-pagetitle">ユーザログイン</span></h1>
    </div>

    <section class="contents-section">
        <div class="contents-section-inner fadeInUp">
            <div class="contact-form-box">
                <div class="contact-form-body">

                    @if (Session::has('status'))
                    <div class="card-body">
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>                        
                    </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="contact-form-body form-group">
                            <table class="tbl-normal">
                                <tr>
                                    <th class="th-w25prc required">メールアドレス</th>
                                    <td>
                                        <input id="email" type="email" class="form-textbox form-control" name="email" value="{{ old('email') }}" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="th-w25prc required">パスワード</th>
                                    <td>
                                        <input id="password" type="password" class="form-textbox form-control" name="password" value="{{ old('password') }}" required>
                                    </td>
                                </tr>
                            </table>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback caution">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                            <div style="text-align:center">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> ログインを記憶する
                                </label>
                            </div>

                            <div class="form-submit-btn-box">
                                <button type="submit" class="form-submit-btn">ログイン</button>
                            </div>
                            <div style="text-align:center">
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                パスワードを忘れましたか?
                                </a>
                            </div>
                            
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>

  </div><!-- main -->

  <!-- footer -->
  <footer class="footer">
    <div class="footer-box-1">
      <div class="contents-section-inner">
        <div class="footer-logo">
          <div class="footer-logo-txt">公益社団法人 兵庫県保育協会</div>
          <address class="footer-logo-address">〒651-0062<br />兵庫県神戸市中央区坂口通2丁目1番1号 <span class="ilb">兵庫県福祉センター内</span></address>
          <div class="footer-logo-tel">TEL：078-242-4623<br class="footer-logo-tel-br" /><span class="footer-logo-tel-separator">&nbsp;/&nbsp;</span>FAX：078-242-1399</div>
        </div>
      </div>
    </div>
    <div class="footer-box-2">
      <div class="contents-section-inner">
        <div class="footer-copyright">
          &copy;2020 公益社団法人 兵庫県保育協会
        </div>
      </div>
    </div>
  </footer>

</div><!--#wrp-->
<script src="{{ asset('js/web/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/web/swiper.js') }}"></script>
<script src="{{ asset('js/web/common.js') }}"></script>
<script>
$(function(){
  indexInitialSetting();
});
</script>
</body>
</html>