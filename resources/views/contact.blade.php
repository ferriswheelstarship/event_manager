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
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />

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
            <a href="/user_manual.pdf" target="_blank" class="nav-ul-1-li-a"><span class="nav-ul-1-li-a-span nav-ul-1-li-a-manual">操作マニュアル</span></a>
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
        <article class="contact-box">
          <header class="contact-box-header">
            <h2 class="contact-box-header-h2">電話でのお問い合わせ</h2>
          </header>
          <div class="contact-box-body">
            <div class="contact-box-tel">
              <a href="tel:0782424623" class="contact-box-tel-a">078-242-4623</a>
              受付時間：10:00〜17:00（月〜金）
            </div>
            <div class="contact-box-address">
              <div class="contact-box-address-name">公益社団法人 兵庫県保育協会</div>
              〒651-0062<br />兵庫県神戸市中央区坂口通2丁目1番1号 <span class="ilb">兵庫県福祉センター内</span>
            </div>
          </div>
        </article>
        <form id="form" class="contact-form" method="POST" action="{{ route('comfirm') }}#form" >
          {{ csrf_field() }}
          <article class="contact-form-box">
            <header class="contact-box-header">
              <h2 class="contact-box-header-h2">お問い合わせフォーム</h2>
            </header>
            <div class="contact-form-body">
              <table class="tbl-normal">
                <tr>
                  <th class="th-w25prc required">お問い合わせ種別</th>
                  <td>
                    <select 
                        class="select form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" 
                        name="type"
                        onchange="changeType(this.value)">
                        <option value="0">選択して下さい</option>
                        @foreach ($types as $key => $val)
                            <option value="{{ $key }}" @if(old('type') == $key) selected @endif>{{ $val }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('type'))
                    <br /><span class="invalid-feedback caution">
                      <strong>{{ $errors->first('type') }}</strong>
                    </span>
                    @endif
                  </td>
              </table>
              
              <div id="general" style="display: 
                                @if(old('type') !='general') 
                                    none
                                @endif ">

              <table class="tbl-normal">
                <tr>
                  <th class="th-w25prc required">施設名または会社／組織名</th>
                  <td>
                    <input type="text" class="form-textbox form-control{{ $errors->has('cname') ? ' is-invalid' : '' }}" 
                    name="cname" value="{{ old('cname') }}" />
                    @if ($errors->has('cname'))
                    <span class="invalid-feedback caution">
                      <strong>{{ $errors->first('cname') }}</strong>
                    </span>
                    @endif
                  </td>
                </tr>
                <tr>
                  <th class="th-w25prc required">氏名</th>
                  <td>
                    <input type="text" class="form-textbox form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" 
                    name="name" value="{{ old('name') }}" />
                    @if ($errors->has('name'))
                    <span class="invalid-feedback caution">
                      <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                  </td>
                </tr>
                <tr>
                  <th class="th-w25prc required">メールアドレス</th>
                  <td>
                    <input type="text" class="form-textbox form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" 
                    name="email" value="{{ old('email') }}" />
                    @if ($errors->has('email'))
                    <span class="invalid-feedback caution">
                      <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @else
                    <div class="note">※半角英数字</div>
                    @endif
                  </td>
                </tr>
                <tr>
                  <th class="th-w25prc required">メールアドレス再入力</th>
                  <td>
                    <input type="text" class="form-textbox form-control{{ $errors->has('cmail') ? ' is-invalid' : '' }}" 
                    name="cmail" value="{{ old('cmail') }}" />
                    @if ($errors->has('cmail'))
                    <span class="invalid-feedback caution">
                      <strong>{{ $errors->first('cmail') }}</strong>
                    </span>
                    @else
                    <div class="note">※再入力してください</div>
                    @endif
                  </td>
                </tr>
                <tr>
                  <th class="th-w25prc required">お問い合わせ内容</th>
                  <td>
                    <textarea name="comment" 
                    class="form-textarea form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}" >{{ old('comment') }}</textarea>
                    @if ($errors->has('comment'))
                    <span class="invalid-feedback caution">
                      <strong>{{ $errors->first('comment') }}</strong>
                    </span>
                    @endif
                  </td>
                </tr>
              </table>
              </div>

              <div id="regisrration" style="display: 
                                @if(old('type') !='regisrration') 
                                    none
                                @endif ">
              <table class="tbl-normal">
                <tr>
                  <th class="th-w25prc required">発生している問題</th>
                  <td>
                    <select 
                        class="select form-control{{ $errors->has('registration_type') ? ' is-invalid' : '' }}" 
                        name="registration_type"
                        onchange="changeProblem(this.value)">
                        <option value="0">選択して下さい</option>
                        @foreach ($registration_types as $val)
                        <option value="{{ $val }}" @if(old('registration_type') == $val) selected @endif>{{ $val }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('registration_type'))
                    <br /><span class="invalid-feedback caution">
                      <strong>{{ $errors->first('registration_type') }}</strong>
                    </span>
                    @endif
                  </td>
                </tr>
                <!-- <tr id="solution">
                  <th class="th-w25prc required">依頼内容</th>
                  <td>
                    <select 
                        class="select form-control{{ $errors->has('solution') ? ' is-invalid' : '' }}" 
                        name="solution"
                        onchange="changeSolution(this.value)">
                        <option value="0">選択して下さい</option>
                        @foreach ($solutions as $val)
                        <option value="{{ $val }}" @if(old('solution') == $val) selected @endif>{{ $val }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('solution'))
                    <span class="invalid-feedback caution">
                      <strong>{{ $errors->first('solution') }}</strong>
                    </span>
                    @endif
                  </td>
                </tr>
              </table>

              <div id="self" style="display: 
                                @if(old('solution') != '登録は自分でするので本登録URLを送ってほしい') 
                                    none
                                @endif ">
                <div style=" margin:1em 0">以下の情報をご入力ください。</div>
                <table class="tbl-normal">
                  <tr>
                    <th class="th-w25prc required">仮登録時に入力した<br />メールアドレス</th>
                    <td>
                      <input type="text" class="form-textbox form-control{{ $errors->has('self_email') ? ' is-invalid' : '' }}" 
                      name="self_email" value="{{ old('self_email') }}" placeholder="abcd@hyogo-hoiku-kyokai.jp"  />
                      @if ($errors->has('self_email'))
                      <span class="invalid-feedback caution">
                        <strong>{{ $errors->first('self_email') }}</strong>
                      </span>
                      @else
                      <div class="note">※半角英数字</div>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th class="th-w25prc required">メールアドレス再入力</th>
                    <td>
                      <input type="text" class="form-textbox form-control{{ $errors->has('self_email_confirmation') ? ' is-invalid' : '' }}" 
                      name="self_email_confirmation" value="{{ old('self_email_confirmation') }}"  />
                      @if ($errors->has('self_email_confirmation'))
                      <span class="invalid-feedback caution">
                        <strong>{{ $errors->first('self_email_confirmation') }}</strong>
                      </span>
                      @else
                      <div class="note">※再入力してください</div>
                      @endif
                    </td>
                  </tr> -->

                </table>
              <!-- </div> -->

              <div id="request">
                <div style=" margin:1em 0">登録代行のご依頼には以下の情報のご入力をお願い致します。<br />
                代行での登録はメールアドレスの認証をせず登録を行います。<br />
                登録後システムからのメール通知が届かない可能性がありますので予めご了承の上ご依頼下さい。<br />
                登録が完了次第、下記で入力された電話番号へご連絡させていただきます。
                </div>
                <table class="tbl-normal">
                  <tr>
                    <th class="th-w25prc required">メールアドレス</th>
                    <td>
                      <input type="text" class="form-textbox form-control{{ $errors->has('reg_email') ? ' is-invalid' : '' }}" 
                      name="reg_email" value="{{ old('reg_email') }}"  placeholder="abcd@hyogo-hoiku-kyokai.jp" />
                      @if ($errors->has('reg_email'))
                      <span class="invalid-feedback caution">
                        <strong>{{ $errors->first('reg_email') }}</strong>
                      </span>
                      @else
                      <div class="note">
                        ※半角英数字<br />
                        ※登録完了後のログインにご入力頂いたメールアドレスを利用します。
                      </div>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th class="th-w25prc required">メールアドレス再入力</th>
                    <td>
                      <input type="text" class="form-textbox form-control{{ $errors->has('reg_email_confirmation') ? ' is-invalid' : '' }}" 
                      name="reg_email_confirmation" value=""  />
                      <div class="note">※再入力してください</div>
                    </td>
                  </tr>
                  <tr>
                    <th class="th-w25prc required">パスワード</th>
                    <td>
                      <input 
                          type="password" 
                          class="form-textbox form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" 
                          name="password">

                      @if ($errors->has('password'))
                          <span class="invalid-feedback caution">
                              <strong>{{ $errors->first('password') }}</strong>
                          </span>
                      @else
                      <div class="note">
                        ※半角英数字6文字以上<br />
                        ※登録完了後のログインにご入力頂いたパスワードを利用します。パスワードを予めお控えください。
                      </div>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th class="th-w25prc required">名前</th>
                    <td>
                      <input
                          id="firstname" type="text"
                          class="form-textbox form-control{{ $errors->has('firstname') ? ' is-invalid' : '' }}"
                          name="firstname" value="{{ old('firstname') }}" placeholder="兵庫" style="margin-bottom:5px">
                      <input
                          id="lastname" type="text"
                          class="form-textbox form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}"
                          name="lastname" value="{{ old('lastname') }}" placeholder="太郎">

                      @if ($errors->has('firstname'))
                          <span class="invalid-feedback caution">
                          <strong>{{ $errors->first('firstname') }}</strong>
                          </span>
                      @endif
                      @if ($errors->has('lastname'))
                          <span class="invalid-feedback caution">
                          <strong>{{ $errors->first('lastname') }}</strong>
                          </span>
                      @endif

                    </td>
                  </tr>
                  <tr>
                    <th class="th-w25prc required">フリガナ</th>
                    <td>
                      <input id="firstruby" type="text"
                          class="form-textbox form-control{{ $errors->has('firstruby') ? ' is-invalid' : '' }}"
                          name="firstruby" value="{{ old('firstruby') }}" placeholder="ヒョウゴ"  style="margin-bottom:5px">
                      @if ($errors->has('firstruby'))
                          <span class="invalid-feedback caution">
                          <strong>{{ $errors->first('firstruby') }}</strong>
                          </span>
                      @endif
                      <input id="lastruby" type="text"
                          class="form-textbox form-control{{ $errors->has('lastruby') ? ' is-invalid' : '' }}"
                          name="lastruby" value="{{ old('lastruby') }}" placeholder="タロウ"
                          >
                      @if ($errors->has('lastruby'))
                          <span class="invalid-feedback caution">
                          <strong>{{ $errors->first('lastruby') }}</strong>
                          </span>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th class="th-w25prc required">電話番号</th>
                    <td>
                      <input id="phone" type="text"
                              class="form-textbox form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                              name="phone" value="{{ old('phone') }}"
                              >
                      @if ($errors->has('phone'))
                          <span class="invalid-feedback caution">
                          <strong>{{ $errors->first('phone') }}</strong>
                          </span>
                      @else
                      <div class="note">
                        ※代行登録完了後、ご入力いただた電話番号へ連絡させていただきます。
                      </div>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th class="th-w25prc required">住所</th>
                    <td>
                      <input id="zip" type="text"
                              class="form-textbox form-control{{ $errors->has('zip') ? ' is-invalid' : '' }}"
                              name="zip" value="{{ old('zip') }}"
                              placeholder="651-0062"  style="margin-bottom:5px">
                      @if ($errors->has('zip'))
                          <span class="invalid-feedback caution">
                          <strong>{{ $errors->first('zip') }}</strong>
                          </span>
                      @endif
                      <input id="address" type="text"
                              class="form-textbox form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                              name="address" value="{{ old('address') }}"
                              placeholder="神戸市中央区坂口通2丁目1番1号"
                              >
                      @if ($errors->has('address'))
                          <span class="invalid-feedback caution">
                          <strong>{{ $errors->first('address') }}</strong>
                          </span>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th class="th-w25prc required">生年月日</th>
                    <td>
                      <select id="birth_year" 
                      class="select form-control{{ $errors->has('birth_year') ? ' is-invalid' : '' }}" 
                      name="birth_year">
                          <option value="0">----</option>
                          @for ($i = 1930; $i <= 2005; $i++)
                              <option value="{{ $i }}"
                                      @if(old('birth_year') == $i) selected @endif>{{ $i }}年</option>
                          @endfor
                      </select>
                      <select id="birth_month" 
                      class="select form-control{{ $errors->has('birth_month') ? ' is-invalid' : '' }}"                                                 
                      name="birth_month">
                          <option value="0">--</option>
                          @for ($i = 1; $i <= 12; $i++)
                              <option value="{{ $i }}"
                                  @if(old('birth_month') == $i) selected @endif>{{ $i }}月</option>
                          @endfor
                      </select>
                      <select id="birth_day" 
                      class="select form-control{{ $errors->has('birth_day') ? ' is-invalid' : '' }}" 
                      name="birth_day">
                          <option value="0">--</option>
                          @for ($i = 1; $i <= 31; $i++)
                              <option value="{{ $i }}"
                                  @if(old('birth_day') == $i) selected @endif>{{ $i }}日</option>
                          @endfor
                      </select>

                      @if ($errors->has('birth_year'))
                      <br /><span class="invalid-feedback caution">
                          <strong>{{ $errors->first('birth_year') }}</strong>
                      </span>
                      @endif
                      @if ($errors->has('birth_month'))
                      <br /><span class="invalid-feedback caution">
                          <strong>{{ $errors->first('birth_month') }}</strong>
                      </span>
                      @endif
                      @if ($errors->has('birth_day'))
                      <br /><span class="invalid-feedback caution">
                          <strong>{{ $errors->first('birth_day') }}</strong>
                      </span>
                      @endif

                    </td>
                  </tr>
                  <tr>
                    <th class="th-w25prc required">所属施設</th>
                    <td>
                      <select 
                      id="company_profile_id" 
                      class="select-search-multiple form-control{{ $errors->has('company_profile_id') ? ' is-invalid' : '' }}" 
                      name="company_profile_id"
                      onchange="changeEventFacility(this.value)"
                      style="min-width:300px">
                          <option value="0">所属施設を選択</option>
                          <option value="なし" @if(old('company_profile_id') === "なし") selected @endif>兵庫県保育協会の会員施設以外（所属なし）</option>
                          @foreach ($facilites as $key => $val)
                          <option value="{{ $val['company_profile_id'] }}"
                              @if(old('company_profile_id') == $val['company_profile_id']) selected @endif>【{{ $val['city'] }}】{{ $val['name'] }}</option>
                          @endforeach
                      </select>

                      @if ($errors->has('company_profile_id'))
                          <br /><span class="invalid-feedback caution">
                          <strong>{{ $errors->first('company_profile_id') }}</strong>
                          </span>
                      @endif
                    </td>
                  </tr>
                </table>
                <div 
                    id="only-indivisual-user"
                    style="display: 
                    @if(old('company_profile_id') != 'なし') 
                        none
                    @endif ">
                <table class="tbl-normal">
                  <tr>
                    <th class="th-w25prc required">所属施設名</th>
                    <td>
                      <input
                          id="other_facility_name" type="text"
                          class="form-textbox form-control{{ $errors->has('other_facility_name') ? ' is-invalid' : '' }}"
                          name="other_facility_name" value="{{ old('other_facility_name') }}">

                      @if ($errors->has('other_facility_name'))
                          <span class="invalid-feedback caution">
                          <strong>{{ $errors->first('other_facility_name') }}</strong>
                          </span>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th class="th-w25prc required">所属施設所在地</th>
                    <td>
                      <select 
                      id="other_facility_pref" 
                      class="select form-control{{ $errors->has('other_facility_pref') ? ' is-invalid' : '' }}" 
                      name="other_facility_pref"  style="margin-bottom:5px">
                          <option value="0">都道府県を選択</option>
                          @foreach ($pref_all as $key => $val)
                          <option value="{{ $val }}"
                              @if(old('other_facility_pref') == $val) selected @endif>{{ $val }}</option>
                          @endforeach
                      </select>

                      @if ($errors->has('other_facility_pref'))
                          <br /><span class="invalid-feedback caution">
                          <strong>{{ $errors->first('other_facility_pref') }}</strong>
                          </span>
                      @endif
                      <input
                          id="other_facility_address" type="text"
                          class="form-textbox form-control{{ $errors->has('other_facility_address') ? ' is-invalid' : '' }}"
                          name="other_facility_address" value="{{ old('other_facility_address') }}" 
                          placeholder="市町村を入力してください">

                      @if ($errors->has('other_facility_address'))
                          <span class="invalid-feedback caution">
                          <strong>{{ $errors->first('other_facility_address') }}</strong>
                          </span>
                      @endif
                    </td>
                  </tr>
                </table>
                </div>
                <table class="tbl-normal">
                  <tr>
                    <th class="th-w25prc required">職種</th>
                    <td>
                      <select 
                      id="job" 
                      class="select form-control{{ $errors->has('job') ? ' is-invalid' : '' }}" 
                      name="job"
                      onchange="changeEventJob(this.value)">
                          <option value="0">----</option>
                          @foreach ($job as $key => $val)
                          <option value="{{ $val }}"
                              @if(old('job') == $val) selected @endif>{{ $val }}</option>
                          @endforeach
                      </select>

                      @if ($errors->has('job'))
                      <br /><span class="invalid-feedback caution">
                        <strong>{{ $errors->first('job') }}</strong>
                      </span>
                      @endif
                    </td>
                  </tr>
                </table>
                <div id="only-nursery" 
                    style="display: 
                    @if(old('job') != '保育士・保育教諭') none 
                    @endif">
                <table class="tbl-normal">
                  <tr>
                    <th class="th-w25prc required">保育士番号所持状況</th>
                    <td>
                      <select id="childminder_status" 
                          class="select form-control{{ $errors->has('childminder_status') ? ' is-invalid' : '' }}" 
                          name="childminder_status"
                          onchange="changeEventChildminder(this.value)">
                          <option value="0">----</option>
                          @foreach ($childminder_status as $key => $val)
                          <option value="{{ $val }}"
                              @if(old('childminder_status') == $val) selected @endif>{{ $val }}</option>
                          @endforeach
                      </select>

                      @if ($errors->has('childminder_status'))
                          <br /><span class="invalid-feedback caution">
                          <strong>{{ $errors->first('childminder_status') }}</strong>
                          </span>
                      @endif
                    </td>
                  </tr>
                  <tr id="childminder-number-section" 
                                    style="display: 
                                    @if(old('childminder_status') != '保育士番号あり') 
                                        none
                                    @endif ">
                    <th class="th-w25prc required">保育士番号</th>
                    <td>
                      <select id="childminder_number_pref" 
                      class="select form-control{{ $errors->has('childminder_number_pref') ? ' is-invalid' : '' }}" 
                      name="childminder_number_pref" style="margin-bottom:5px">
                          <option value="0">都道府県を選択</option>
                          <option value="兵庫県" @if(old('childminder_number_pref') == "兵庫県") selected @endif>兵庫県</option>
                          @foreach ($pref as $item)
                              <option value="{{ $item }}"
                                      @if(old('childminder_number_pref') == $item) selected @endif>{{ $item }}</option>
                          @endforeach
                      </select>
                      @if ($errors->has('childminder_number_pref'))
                      <br /><span class="invalid-feedback caution">
                          <strong>{{ $errors->first('childminder_number_pref') }}</strong>
                      </span>
                      @endif
                      <input
                          id="childminder_number_only" type="text"
                          class="form-textbox form-control{{ $errors->has('childminder_number_only') ? ' is-invalid' : '' }}"
                          name="childminder_number_only" value="{{ old('childminder_number_only') }}" 
                          placeholder="6桁の数字（半角）">

                      @if ($errors->has('childminder_number_only'))
                      <span class="invalid-feedback caution">
                          <strong>{{ $errors->first('childminder_number_only') }}</strong>
                      </span>
                      @endif
                    </td>
                  </tr>
                </table>
                </div>
              </div>

              </div>


              <div class="form-submit-btn-box">
                <button type="submit" class="form-submit-btn">
                  入力内容を確認する
                </button>
              </div>
            </div>
          </article>
        </form>
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
<script src="{{ asset('js/contact-form-event.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/i18n/ja.js"></script>
<script src="{{ asset('js/select-search.js') }}" ></script>
<script src="{{ asset('js/user-form-event.js') }}" ></script>

</body>
</html>