<!DOCTYPE html>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="description" content="公益社団法人 兵庫県保育協会のホームページです" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="format-detection" content="telephone=no" />
<link rel="icon" href="/img/favicon.ico" />
<link rel="shortcut icon" href="/img/favicon.ico" type="image/vnd.microsoft.icon" />
<link rel="icon" href="/img/favicon.ico" type="image/vnd.microsoft.icon" />
<link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon" />
<meta name="robots" content="noindex,nofollow"/>
<title>公益社団法人 兵庫県保育協会 | top</title>
<!-- <script type="text/javascript" src="//webfont.fontplus.jp/accessor/script/fontplus.js?kZSFUtx-OUM%3D&box=93sB9wS4lok%3D&aa=1&ab=2" charset="utf-8"></script> -->

<link href="{{ asset('css/web/swiper.css') }}" rel="stylesheet">
<link href="{{ asset('css/web/style.css') }}" rel="stylesheet">

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
          <li class="nav-ul-1-li">
            <a href="{{ route('greeting') }}" class="nav-ul-1-li-a"><span class="nav-ul-1-li-a-span nav-ul-1-li-a-greeting">ごあいさつ</span></a>
          </li>
          <li class="nav-ul-1-li">
            <a href="javascript:alert('現在準備中です');" class="nav-ul-1-li-a"><span class="nav-ul-1-li-a-span nav-ul-1-li-a-manual">操作マニュアル</span></a>
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
    <div class="top-mainvis-outer">
      <div id="mainVis" class="swiper-container mainvis-box">
        <div class="top-mainvis">
          <img src="/img/top-mainvis-01.jpg" class="top-mainvis-img" alt="" />
        </div>
        <!-- <ul class="swiper-wrapper">
          <li class="swiper-slide"><img src="img/top-mainvis-01.jpg" class="img-mainvis" alt="" /></li>
          <li class="swiper-slide"><img src="img/top-mainvis-02.jpg" class="img-mainvis" alt="" /></li>
          <li class="swiper-slide"><img src="img/top-mainvis-03.jpg" class="img-mainvis" alt="" /></li>
        </ul> -->
      </div>
      <div class="top-mainvis-txt-box-3steps">
        <div class="top-mainvis-txt-box-3steps-catch"><img src="./img/top-text-catch.png" class="top-mainvis-txt-box-3steps-catch-img" alt="登録はとっても簡単！" /></div>
        <ul class="top-mainvis-txt-box-3steps-ul">
          <li class="top-mainvis-txt-box-3steps-ul-li top-mainvis-txt-box-3steps-ul-li-01">
            <div class="top-mainvis-txt-box-3steps-ul-li-num-outer"><div class="top-mainvis-txt-box-3steps-ul-li-num top-mainvis-txt-box-3steps-ul-li-num-01">1</div></div>
            <div class="top-mainvis-txt-box-3steps-ul-li-txt">空メールを送信</div>
          </li>
          <li class="top-mainvis-txt-box-3steps-ul-li top-mainvis-txt-box-3steps-ul-li-02">
            <div class="top-mainvis-txt-box-3steps-ul-li-num-outer"><div class="top-mainvis-txt-box-3steps-ul-li-num top-mainvis-txt-box-3steps-ul-li-num-02">2</div></div>
            <div class="top-mainvis-txt-box-3steps-ul-li-txt">受信したメールから認証先へアクセス</div>
          </li>
          <li class="top-mainvis-txt-box-3steps-ul-li top-mainvis-txt-box-3steps-ul-li-03">
            <div class="top-mainvis-txt-box-3steps-ul-li-num-outer"><div class="top-mainvis-txt-box-3steps-ul-li-num top-mainvis-txt-box-3steps-ul-li-num-03">3</div></div>
            <div class="top-mainvis-txt-box-3steps-ul-li-txt">パスワード設定・プロフィール登録</div>
          </li>
        </ul>
      </div>
      <!-- <div class="top-mainvis-txt-box"><div class="top-mainvis-txt">登録は簡単<br />3ステップ</div></div> -->
    </div><!-- top-mainvis-outer -->

    <section class="contents-section">
      <div class="contents-section-inner fadeInUp">

        <div class="top-info-box">
          <header class="top-info-header">
            <div class="top-info-header-inner">
              <h2 class="top-header-h2 top-info-header-h2">開催予定の研修</h2>
              <div class="top-header-tolist-box"><a href="/eventinfo" class="top-header-tolist-a">研修一覧へ</a></div>
            </div>
          </header>
          <ul class="top-info-ul">
          @if (count($data) > 0)
            @foreach($data as $event)
            <li class="top-info-ul-li"><a href="/eventinfo/{{ $event['id'] }}" class="top-info-ul-li-a">
            <span class="top-info-ul-li-date">
            @foreach ($event['event_dates'] as $key => $edate)
            @php
            echo date('Y.m.d', strtotime($edate->event_date));
            @endphp
            @if(!$loop->last) , @endif
            @endforeach
            </span>
            <span class="top-info-ul-li-body"><span class="top-info-ul-li-body-inner">{{ $event['title'] }}</span></span></a></li>
            @endforeach
          @else
            <li style="text-align:center">現在準備中です。</li>
          @endif
          </ul>
        </div>

      </div>
    </section>

    <section class="contents-section">
      <div class="contents-section-inner fadeInUp" style="border-top:1px solid #098">
      </div>
    </section>

    <section class="contents-section">
      <div class="contents-section-inner fadeInUp">
        <div class="top-info-box">
          <header class="top-info-header">
            <div class="top-info-header-inner">
              <h2 class="top-header-h2 top-info-header-h2">インフォメーション</h2>
              <div class="top-header-tolist-box"><a href="/info" class="top-header-tolist-a">記事一覧へ</a></div>
            </div>
          </header>
          <ul class="top-info-ul">
          @if (count($infos) > 0)
            @foreach($infos as $info)
            <li class="top-info-ul-li"><a href="/info/{{ $info->id }}" class="top-info-ul-li-a"><span class="top-info-ul-li-date">@php echo date('Y.m.d', strtotime($info['article_date'])); @endphp</span><span class="top-info-ul-li-body"><span class="top-info-ul-li-body-inner">{{ $info->title }}</span></span></a></li>
            @endforeach
          @else
            <li style="text-align:center">現在準備中です。</li>
          @endif
          </ul>
        </div>

      </div>
    </section>

    <section class="contents-section">
      <div class="contents-section-inner fadeInUp">
        <ul class="top-btns-ul">
          <li class="top-btns-ul-li">
            <a href="{{ route('greeting') }}" class="top-btns-ul-li-a top-btns-ul-li-a-01">
              <img src="img/icon-message.png" class="top-btns-img" alt="ごあいさつ" />
              <span class="top-btns-txt-outer">
                <span class="top-btns-txt">ごあいさつ</span>
              </span>
            </a>
          </li>
          <li class="top-btns-ul-li">
            <a href="javascript:alert('現在準備中です');" class="top-btns-ul-li-a top-btns-ul-li-a-02">
              <img src="img/icon-book.png" class="top-btns-img" alt="操作マニュアル" />
              <span class="top-btns-txt-outer">
                <span class="top-btns-txt">操作マニュアル</span>
              </span>
            </a>
          </li>
          <li class="top-btns-ul-li">
            <a href="{{ route('register') }}" class="top-btns-ul-li-a top-btns-ul-li-a-03">
              <img src="img/icon-pen.png" class="top-btns-img" alt="ユーザー新規登録" />
              <span class="top-btns-txt-outer">
                <span class="top-btns-txt">ユーザ新規登録</span>
              </span>
            </a>
          </li>
          <li class="top-btns-ul-li">
            <a href="{{ route('login') }}" class="top-btns-ul-li-a top-btns-ul-li-a-04">
              <img src="img/icon-person.png" class="top-btns-img" alt="ユーザーログイン" />
              <span class="top-btns-txt-outer">
                <span class="top-btns-txt">ユーザログイン</span>
              </span>
            </a>
          </li>
          <li class="top-btns-ul-li">
            <a href="{{ route('login') }}" class="top-btns-ul-li-a top-btns-ul-li-a-05">
              <img src="img/icon-house.png" class="top-btns-img" alt="施設ログイン" />
              <span class="top-btns-txt-outer">
                <span class="top-btns-txt">施設ログイン</span>
              </span>
            </a>
          </li>
          <li class="top-btns-ul-li">
            <a href="{{ route('login') }}" class="top-btns-ul-li-a top-btns-ul-li-a-06">
              <img src="img/icon-persons.png" class="top-btns-img" alt="事務局ログイン" />
              <span class="top-btns-txt-outer">
                <span class="top-btns-txt">事務局ログイン</span>
              </span>
            </a>
          </li>
        </ul>
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