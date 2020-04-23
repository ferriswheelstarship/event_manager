<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="robots" content="noindex,nofollow"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>受付管理 - バーコード読取</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
  <link href="{{ asset('css/navbar-fixed-left.min.css') }}" rel="stylesheet">
  <style>
    .footer {
      position:absolute;
      bottom:0;
      width:100%;
      display:block;
      height:40px;
      line-height:40px;
      padding:0 .5em;

    }
  </style>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
</head>
<body style="min-height: 100vh; position:relative; margin-left:0 !important">
<div style="min-height: calc(100% + 40px); padding-bottom:40px">
  <div class="pt-3">
    <div id="content">
    <!-- @include('commons.error_messages') -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">受付管理</div>
                        
                        @if (Session::has('status'))
                        <div class="card-body">
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>                        
                        </div>
                        @endif
                        @if (Session::has('attention'))
                        <div class="card-body">
                            <div class="alert alert-danger">
                                {{ session('attention') }}
                            </div>                        
                        </div>
                        @endif

                        <div class="card-body">

                            <div class="h6 ">@php echo date('Y年m月d日', strtotime($event_date->event_date)); @endphp</div>
                            <h2 class="h4 mb-4">【{{ $general_or_carrerup }}】{{ $event->title }}</h2>

                            <div class="mx-3 p-3 alert alert-danger">
                                <h3 class="h5 mb-3"><b>QRコード読取時のご注意</b></h3>
                                <p>バーコードリーダをUSBで接続し、こちらの画面を最上部に表示する事でQRコード読取が可能になります。<br />
                                読取が上手くいかない場合は、以下を確認し再読取を実行してください。<br />
                                ・バーコードリーダを接続しているデバイスの入力モードを「半角」にしてください。「全角」だと読み取れない場合があります。<br />
                                ・キーボードで何らかの文字を入力した場合は、手動受付のページから再度QRコード受付画面を表示させてください。<br />
                                ・他のアプリケーションを一度でも最上部へ表示するとQRコードの読取りができなくなりますので、<br>
                                その場合はページの再読みを行ってください。</p>
                            </div>
                                                          
                            <div class="px-3 py-5">
                                <div class="row">
                                    <h3 class="col-md-3 h4">QRコード受付</h3>
                                    <span>受付完了者 {{ $reception_cnt }}名 / 参加予定者 {{ $entrys_cnt }}名</span>
                                </div>
                                <p class="text-danger">※ QRコード受付（当画面）では受付完了者のみが表示されます。</p>
                            <div class="table-responsive">
                                <table class="table table-striped tbl-withheading">
                                    <thead class="thead">
                                        <tr>
                                            <th class="text-nowrap">状態</th>
                                            <th class="text-nowrap">氏名</th>
                                            <th class="text-nowrap">所属</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($entrys_view) > 0)
                                        @foreach ($entrys_view as $entry)
                                        <tr>
                                            <td>{{ $entry['status'] }}</td>
                                            <td>{{ $entry['user_name'] }}（{{ $entry['user_ruby'] }}）</td>
                                            <td>{{ $entry['company_name'] }}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="3" class="text-center">受付完了者はいません</td>
                                        </tr>
                                        @endif
                                    </tbody>

                                </table>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
<form name="attend" action="{{ route('reception.auto') }}" method="post">
    {{ csrf_field() }}
    <input type="text" name="qrread" id="qrread" maxlength="14" value="" 
    style="position: fixed; bottom:-100px; left:-500px;ime-mode:disabled">
    <input type="hidden" name="event_date_id" value="{{ $event_date->id }}">
</form>

</body>
<script>
$(document).ready( function(){
    $('#qrread').focus();
});
$('#qrread').blur( function(){
    location.reload();
});

var words = '';
$(document).keypress(function(e) {
  var key = String.fromCharCode(e.charCode);
  words = words + key;
});
</script>
</html>