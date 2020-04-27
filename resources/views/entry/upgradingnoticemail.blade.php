{{ $username }} 様

平素より大変お世話になっています。

この度は、研修会にお申し込み頂きありがとうございます。
下記の研修会に欠員が発生したため、繰り上げ申込となりました。

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

受講券のご案内まで今しばらくお待ち下さい。


兵庫県保育協会　事務局