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

@if($entrystatus == '申し込み登録')
受講券のご案内まで今しばらくお待ち下さい。
@else
上記研修に欠員が発生し、繰り上げとなった場合は改めてご案内致します。
@endif

兵庫県保育協会　事務局