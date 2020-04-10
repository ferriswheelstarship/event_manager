{{ $username }} 様

平素より大変お世話になっています。

この度は、研修会にお申し込み頂きありがとうございます。
下記の研修会の{{ $entrystatus }}が完了いたしました。

＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
研修名：{{ $eventtitle }}
開催日：@foreach($eventdates as $key => $val)
@php
echo date('Y年m月d日', strtotime($val['event_date']));
@endphp
@if(!$loop->last)
,
@endif
@endforeach

受講者名：{{ $username }} 様
＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝

@if($entrystatus === '申し込み登録')
研修への参加費用を以下口座へお振込下さい。
＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
〇〇銀行 〇〇支店 普通 123456
＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
ご入金を確認次第、受講券を発行、ご案内いたします。
@else

@endif

兵庫県保育協会　事務局