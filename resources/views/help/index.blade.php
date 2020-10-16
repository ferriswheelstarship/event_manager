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
<title>公益社団法人 兵庫県保育協会 | ヘルプ</title>
<!-- <script type="text/javascript" src="//webfont.fontplus.jp/accessor/script/fontplus.js?kZSFUtx-OUM%3D&box=93sB9wS4lok%3D&aa=1&ab=2" charset="utf-8"></script> -->

<link href="{{ asset('css/web/swiper.css') }}" rel="stylesheet">
<link href="{{ asset('css/web/style.css') }}" rel="stylesheet">
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
      <h1 class="second-mainvis-pagetitle"><span class="greeting-pagetitle">ヘルプ</span></h1>
    </div>


    <section class="contents-section">
      <div class="contents-section-inner fadeInUp">
        <article class="">
          <header class="links-header">
            <h2 class="links-header-h2">ユーザ登録ができない</h2>
          </header>
          <div class="links-body">

            <h3 style="font-size:1.1em; color: #40c3d9; border-left: 10px solid #40c3d9; padding: 0 10px">仮登録時の返信メールが届かない</h3>
            <div style=" padding:1em">
            <ul style="list-style:disc outside; margin:1em">
                <li style="list-style:disc outside; margin-left:1em; margin-bottom:1em;">仮登録時に入力したメールアドレスに誤りはないかをご確認ください。</li>
                <li style="list-style:disc outside; margin-left:1em ; margin-bottom:1em;"><a href="help/domain" style="color:#00f">ドメイン指定受信設定</a>を正しく行えているかをご確認ください。<br />
                詳細は<a href="help/domain" style="color:#00f">こちら</a>をご覧下さい。</li>
                <li style="list-style:disc outside; margin-left:1em; margin-bottom:1em;">迷惑メールフォルダに該当するメールがないかをご確認下さい。</li>
                <li style="list-style:disc outside; margin-left:1em; margin-bottom:1em;">ご利用のメールサービスの利用可能容量に達しているかどうかご確認下さい。<br />
                容量がいっぱいの場合は受送信メールの整理（削除）をすることで受信できるようになります。</li>
                <li style="list-style:disc outside; margin-left:1em; margin-bottom:1em;">パソコンからをご利用の場合、セキュリティ対策ソフトが原因となっているケースも想定されます。<br />
                詳細はご利用のセキュリティ対策ソフトのマニュアル、ヘルプ等をご確認下さい。</li>                
                <li style="list-style:disc outside; margin-left:1em ; margin-bottom:1em;">スマートフォンをご利用の場合で解決が難しい場合、<br />
                携帯キャリアショップへ「hyogo-hoiku-kyokai.jp」のドメイン指定受信を行ってメールを受信できるようにしたい旨<br />
                ご相談されることも検討下さい。</li>
            </ul>
            </div>

            <h3 style="font-size:1.1em; color: #40c3d9; border-left: 10px solid #40c3d9; padding: 0 10px">仮登録時の返信メールは届いたが、本文内のURLにアクセスできない</h3>
            <div style=" padding:1em">
            <ul style="list-style:disc outside; margin:1em">
                <li style="list-style:disc outside; margin-left:1em; margin-bottom:1em;">本文内のURLがハイパーリンク（青文字＋下線）になっていない場合、<br />
                URL部分をコピーし、webブラウザへコピーしたURLを貼り付けしアクセスできるかご確認ください。<br />
                ハイパーリンクになっているのにアクセスできない場合はURLが途中で途切れている可能性があります。</li>
            </ul>
            </div>

            <h3 style="font-size:1.1em; color: #40c3d9; border-left: 10px solid #40c3d9; padding: 0 10px">ヘルプを見て対応しても、ユーザ登録が完了しない</h3>
            <div style=" padding:1em">
            <ul style="list-style:disc outside; margin:1em">
                <li style="list-style:disc outside; margin-left:1em; margin-bottom:1em;">お急ぎの場合は<a href="{{ route('contact') }}" style="color:#00f">お問い合わせ</a>より代行登録をご依頼ください。</li>
            </ul>
            </div>

          </div>
        </article>

      </div>

      <div class="contents-section-inner fadeInUp">
        <article class="">
          <header class="links-header">
            <h2 class="links-header-h2">登録済の方</h2>
          </header>
          <div class="links-body">

            <h3 style="font-size:1.1em; color: #40c3d9; border-left: 10px solid #40c3d9; padding: 0 10px">研修申込時等システムからのメール通知が届かない</h3>
            <div style=" padding:1em">
            <ul style="list-style:disc inside; margin:1em">
                <li style="list-style:disc outside; margin-left:1em ; margin-bottom:1em;"><a href="help/domain" style="color:#00f">ドメイン指定受信設定</a>を正しく行えているかをご確認ください。<br />
                メールアドレスを変更された場合は、ドメイン指定受信設定が正しくできていない事が原因と思われます。<br />
                詳細は<a href="help/domain" style="color:#00f">こちら</a>をご覧下さい。</li>
                <li style="list-style:disc outside; margin-left:1em; margin-bottom:1em;">迷惑メールフォルダに該当するメールがないかをご確認下さい。</li>
                <li style="list-style:disc outside; margin-left:1em; margin-bottom:1em;">ご利用のメールサービスの利用可能容量に達しているかどうかご確認下さい。<br />
                容量がいっぱいの場合は受送信メールの整理（削除）をすることで受信できるようになります。</li>
                <li style="list-style:disc outside; margin-left:1em; margin-bottom:1em;">パソコンからをご利用の場合、セキュリティ対策ソフトが原因となっているケースも想定されます。<br />
                詳細はご利用のセキュリティ対策ソフトのマニュアル、ヘルプ等をご確認下さい。</li>                
                <li style="list-style:disc outside; margin-left:1em ; margin-bottom:1em;">スマートフォンをご利用の場合で解決が難しい場合、<br />
                携帯キャリアショップへ「hyogo-hoiku-kyokai.jp」のドメイン指定受信を行ってメールを受信できるようにしたい旨<br />
                ご相談されることも検討下さい。</li>
                <!-- <li style="list-style:disc outside; margin-left:1em ; margin-bottom:1em;">ログイン後、ユーザ情報の設定内にある「テストメール送信」を行って下さい。<br />
                メール受信が確認できれば今後のメール通知は届きます。</li> -->
            </ul>
            </div>

          </div>
        </article>

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