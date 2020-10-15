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
<title>公益社団法人 兵庫県保育協会 | お問い合わせ</title>
<!-- <script type="text/javascript" src="//webfont.fontplus.jp/accessor/script/fontplus.js?kZSFUtx-OUM%3D&box=93sB9wS4lok%3D&aa=1&ab=2" charset="utf-8"></script> -->

<link href="{{ asset('css/web/swiper.css') }}" rel="stylesheet">
<link href="{{ asset('css/web/style.css') }}" rel="stylesheet">
<link href="{{ asset('css/web/add.css') }}" rel="stylesheet">

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
          <li class="nav-ul-1-li active">
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
    <div class="second-mainvis-box contact-mainvis">
      <h1 class="second-mainvis-pagetitle"><span class="contact-pagetitle">お問い合わせ</span></h1>
    </div>

    <section class="contents-section">
      <div class="contents-section-inner fadeInUp">
        <div class="contact-form">
          <article class="contact-form-box">
            <header class="contact-box-header">
              <h2 class="contact-box-header-h2">お問い合わせフォーム 入力内容確認</h2>
            </header>
            <div class="contact-form-body">
              <table class="tbl-normal">
                <tr>
                  <th class="th-w25prc">お問い合わせ種別</th>
                  <td>{{ $types[$contact['type']] }}</td>
                </tr>
                @if($contact['type'] == 'general')
                <tr>
                  <th class="th-w25prc">施設名または会社／組織名</th>
                  <td>{{ $contact['cname'] }}</td>
                </tr>
                <tr>
                  <th class="th-w25prc">氏名</th>
                  <td>{{ $contact['name'] }}</td>
                </tr>
                <tr>
                  <th class="th-w25prc">メールアドレス</th>
                  <td>{{ $contact['email'] }}</td>
                </tr>
                <tr>
                  <th class="th-w25prc">お問い合わせ内容</th>
                  <td>{!! nl2br($contact['comment']) !!}</td>
                </tr>
                @elseif($contact['type'] == 'regisrration')
                <tr>
                  <th class="th-w25prc">発生している問題</th>
                  <td>{{ $contact['registration_type'] }}</td>
                </tr>
                <tr>
                  <th class="th-w25prc">メールアドレス</th>
                  <td>{{ $contact['reg_email'] }}</td>
                </tr>
                <tr>
                  <th class="th-w25prc">パスワード</th>
                  <td>****** <br />
                    ※セキュリティを考慮し表示されません。ログイン用に入力されたパスワードはお控え下さい。
                  </td>
                </tr>
                <tr>
                  <th class="th-w25prc">名前</th>
                  <td>{{ $contact['firstname'].'　'.$contact['lastname'].'（'.$contact['firstruby'].'　'.$contact['lastruby'].'）' }}</td>
                </tr>
                <tr>
                  <th class="th-w25prc">電話番号</th>
                  <td>{{ $contact['phone'] }}</td>
                </tr>
                <tr>
                  <th class="th-w25prc">住所</th>
                  <td>
                    {{ $contact['zip'] }}<br />
                    {{ $contact['address'] }}
                  </td>
                </tr>
                <tr>
                  <th class="th-w25prc">生年月日</th>
                  <td>{{ $contact['birth_year'] }}年{{ $contact['birth_month'] }}月{{ $contact['birth_day'] }}日</td>
                </tr>
                <tr>
                  <th class="th-w25prc">所属施設</th>
                  <td>{{ $facility }}</td>
                </tr>
                @if($contact['company_profile_id'] == "なし")
                <tr>
                  <th class="th-w25prc">所属施設所在地</th>
                  <td>{{ $contact['other_facility_pref'].$contact['other_facility_address'] }}</td>
                </tr>
                @endif
                <tr>
                  <th class="th-w25prc">職種</th>
                  <td>{{ $contact['job'] }}</td>
                </tr>
                @if($contact['job'] == "保育士・保育教諭")
                <tr>
                  <th class="th-w25prc">保育士番号所持状況</th>
                  <td>{{ $contact['childminder_status'] }}</td>
                </tr>
                @if($contact['childminder_status'] == "保育士番号あり")
                <tr>
                  <th class="th-w25prc">保育士番号</th>
                  <td>{{ $contact['childminder_number_pref'] }}{{ $contact['childminder_number_only'] }}</td>
                </tr>
                @endif
                @endif


                @endif
              </table>
            </div>            
            {!! Form::open(['url' => 'contact/complete','class' => 'text-center']) !!}
 
            @foreach($contact as $key => $value)
              @if(isset($value))
                {!! Form::hidden($key, $value) !!}
              @endif
            @endforeach
            {!! Form::hidden('facility', $facility) !!}
            {!! Form::submit('戻る', ['name' => 'action', 'class' => 'form-submit-btn mini']) !!}
            {!! Form::submit('送信', ['name' => 'action', 'class' => 'form-submit-btn mini']) !!}
            {!! Form::close() !!}
          </article>
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