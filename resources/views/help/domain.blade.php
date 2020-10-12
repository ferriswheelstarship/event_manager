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
<title>公益社団法人 兵庫県保育協会 | ヘルプ（ドメイン指定受信）</title>
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
      <h1 class="second-mainvis-pagetitle"><span class="greeting-pagetitle">ヘルプ</span></h1>
    </div>


    <section class="contents-section">
      <div class="contents-section-inner fadeInUp">
        <article class="links-box">
          <header class="links-header">
            <h2 class="links-header-h2">ドメイン指定受信設定について</h2>
          </header>
          <div class="links-body">
            <p>キャリアごとに設定方法が異なります。詳細は押下してご確認ください。</p>
            <dl id="acMenu">
              <dt>Docomo</dt>
              <dd>
                より詳細な設定については<a href="https://www.nttdocomo.co.jp/info/spam_mail/" target="_blank" style="color:#00f">こちら</a>をご参照ください。<br /><br />

                <b style="color: crimson">スマートフォン (spモード) 設定手順</b>
                <ul>
                  <li style="list-style:number outside; margin-left:1em">「dメニュー」→「My docomo(お客様サポート)」→「設定」→「メール設定」</li>
                  <li style="list-style:number outside; margin-left:1em">【受信リスト設定】を押下</li>
                  <li style="list-style:number outside; margin-left:1em">【受信リスト設定】を押下</li>
                  <li style="list-style:number outside; margin-left:1em">設定を利用するを押下</li>
                  <li style="list-style:number outside; margin-left:1em">「受信するメールアドレス」の【さらに追加する】を押下</li>
                  <li style="list-style:number outside; margin-left:1em">入力欄に「hyogo-hoiku-kyokai.jp」と入力し【確認する】を押下</li>
                  <li style="list-style:number outside; margin-left:1em">設定内容をご確認のうえ、【設定を確定する】を押下</li>
                  <li style="list-style:number outside; margin-left:1em">設定完了</li>
                </ul>
                <br />
                <b style="color: crimson">3Gケータイ (iモード) 設定手順</b>
                <ul>
                  <li style="list-style:number outside; margin-left:1em">iMenu → メール設定 → 詳細設定/解除</li>
                  <li style="list-style:number outside; margin-left:1em">iモードパスワードを入力して「決定」ボタン</li>
                  <li style="list-style:number outside; margin-left:1em">指定受信/拒否設定の「設定を利用する」にチェックを入れ「次へ」ボタン</li>
                  <li style="list-style:number outside; margin-left:1em">「受信メール設定」ボタン</li>
                  <li style="list-style:number outside; margin-left:1em">入力欄に「hyogo-hoiku-kyokai.jp」と入力し「登録」ボタン</li>
                  <li style="list-style:number outside; margin-left:1em">設定完了</li>
                </ul>
                <br />
                <b>※ ドメイン指定受信設定を行なってもメールが届かない方へ</b><br /><br />
                「迷惑メールおまかせブロック」をご利用の方で仮登録時の返信メールが届かない方は迷惑メールフォルダをご確認いただくか、ドコモ電話帳(クラウド)に「noreply@hyogo-hoiku-kyokai.jp」を登録後、再度仮登録を行ってください。<br /><br />

                最新の情報・設定方法はドコモのサイトよりご確認ください。<br /><br />

                <a href="https://www.nttdocomo.co.jp/service/omakase_block/" target="_blank" style="color:#00f">ドコモ 迷惑メールおまかせブロック</a>
              </dd>
              <dt>au</dt>
              <dd>
                最新の設定方法は<a href="https://www.au.com/support/service/mobile/trouble/mail/email/filter/detail/domain/" target="_blank" style="color:#00f">こちら</a>をご確認ください。<br><br>

                <b style="color: crimson">スマートフォンの設定方法</b>
                <ul>
                  <li style="list-style:number outside; margin-left:1em">「My au」から「迷惑メールフィルター」にアクセス</li>
                  <li style="list-style:number outside; margin-left:1em">「受信リストに登録／アドレス帳受信設定をする」を選択</li>
                  <li style="list-style:number outside; margin-left:1em">入力欄に「@hyogo-hoiku-kyokai.jp」を入力し「ドメイン一致」を選択</li>
                  <li style="list-style:number outside; margin-left:1em">入力欄の左にある「必ず受信」にチェックを入れる</li>
                  <li style="list-style:number outside; margin-left:1em">「受信リスト有効・無効設定」を有効にチェックを入れ「変更する」を押下</li>
                  <li style="list-style:number outside; margin-left:1em">変更確認画面で「OK」を押下</li>
                  <li style="list-style:number outside; margin-left:1em">設定完了</li>
                </ul>
                <br />
                <b style="color: crimson">3Gケータイの設定方法</b>
                <ul>
                  <li style="list-style:number outside; margin-left:1em">「トップメニュー・検索』から「My au」を選択</li>
                  <li style="list-style:number outside; margin-left:1em">「ケータイに、あんしんを。」を選択</li>
                  <li style="list-style:number outside; margin-left:1em">「迷惑メールでお困りの方はこちら」を選択</li>
                  <li style="list-style:number outside; margin-left:1em">「迷惑メールフィルター設定へ」を選択</li>
                  <li style="list-style:number outside; margin-left:1em">「迷惑メールフィルターの設定・確認へ」を選択</li>
                  <li style="list-style:number outside; margin-left:1em">「暗証番号を入力」→「送信」</li>
                  <li style="list-style:number outside; margin-left:1em">詳細設定の「受信リストを登録する」を選択</li>
                  <li style="list-style:number outside; margin-left:1em">「全て有効」を選択</li>
                  <li style="list-style:number outside; margin-left:1em">「@hyogo-hoiku-kyokai.jp」を入力し「ドメ」を選択して「登録」を押下</li>
                  <li style="list-style:number outside; margin-left:1em">設定確認で「登録」を押下</li>                  
                  <li style="list-style:number outside; margin-left:1em">設定完了</li>
                </ul>
              </dd>
              <dt>Softbank</dt>
              <dd>                
                最新の設定方法は<a href="https://www.softbank.jp/mobile/support/mail/antispam/email-i/white/" target="_blank" style="color:#00f">こちら</a>でご確認ください。<br><br>

                <b style="color: crimson">スマートフォン設定手順 (Android・iPhone共通)</b>
                <ul>
                  <li style="list-style:number outside; margin-left:1em">My SoftBank へアクセスし、「メール設定」を押下</li>
                  <li style="list-style:number outside; margin-left:1em">「迷惑メール対策」を押下</li>
                  <li style="list-style:number outside; margin-left:1em">「許可するメールの登録」の「登録する」を押下</li>
                  <li style="list-style:number outside; margin-left:1em">アドレス入力欄に「hyogo-hoiku-kyokai.jp」と入力し「後方一致」の項目をチェック/li>
                  <li style="list-style:number outside; margin-left:1em">「次へ」を押下</li>
                  <li style="list-style:number outside; margin-left:1em">「登録する」を押下</li>
                  <li style="list-style:number outside; margin-left:1em">設定完了</li>
                </ul>
                <br />
                <b style="color: crimson">3Gケータイ設定手順</b>
                <ul>
                  <li style="list-style:number outside; margin-left:1em">メール → 設定 → メール・アドレス設定 → 迷惑メールブロック設定</li>
                  <li style="list-style:number outside; margin-left:1em">「個別設定」にチェックし、「次へ」を押下</li>
                  <li style="list-style:number outside; margin-left:1em">「5. 受信許可・拒否設定」を押下</li>
                  <li style="list-style:number outside; margin-left:1em">「受信許可リスト設定」を押下</li>
                  <li style="list-style:number outside; margin-left:1em">利用設定「設定する」にチェック</li>
                  <li style="list-style:number outside; margin-left:1em">下にあるアドレス入力欄に「hyogo-hoiku-kyokai.jp」と入力し「後」の項目をチェック</li>
                  <li style="list-style:number outside; margin-left:1em">ページ下にある「設定する」ボタンを押下</li>
                  <li style="list-style:number outside; margin-left:1em">設定完了</li>
                </ul>

              </dd>
              <dt>Y!mobile</dt>
              <dd>
                <b style="color: crimson">スマートフォンの設定方法</b>
                <ul>
                  <li style="list-style:number outside; margin-left:1em">「My Y!mobile」にアクセス</li>
                  <li style="list-style:number outside; margin-left:1em">「設定・サポート」を選択</li>
                  <li style="list-style:number outside; margin-left:1em">「迷惑メール対策 SMS/MMS（ymobile.ne.jp）」を選択</li>
                  <li style="list-style:number outside; margin-left:1em">「許可するメールの登録」の「登録する」を選択</li>
                  <li style="list-style:number outside; margin-left:1em">「hyogo-hoiku-kyokai.jp」を入力し、一致条件の「後方一致」を選択したのち「次へ」を選択</li>
                  <li style="list-style:number outside; margin-left:1em">「登録する」を選択</li>
                  <li style="list-style:number outside; margin-left:1em">設定完了</li>
                </ul>                
              </dd>
              <dt>Gmail（スマートフォンでGmailをお使いの方）</dt>
              <dd>
                <b style="color: crimson">設定方法</b>
                <ul>
                  <li style="list-style:number outside; margin-left:1em"><a href="http://gmail.com/">http://gmail.com/</a> にアクセスしてログイン</li>
                  <li style="list-style:number outside; margin-left:1em">「迷惑メール」をクリックして一覧を表示</li>
                  <li style="list-style:number outside; margin-left:1em">noreply@hyogo-hoiku-kyokai.jpからのメールにチェック</li>
                  <li style="list-style:number outside; margin-left:1em">「迷惑メールではない」をクリック</li>
                </ul>
              </dd>
            </dl>
            <div class="form-submit-btn-box">
              <a href="/help" class="form-submit-btn">ヘルプ一覧</a>
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
<script>
$(function(){
  $("#acMenu dt").on("click", function() {
    $(this).next().slideToggle();
  });
});
</script>

</body>
</html>