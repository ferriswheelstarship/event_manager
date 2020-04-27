{{ $username }} 様

平素より大変お世話になっています。

この度は、研修会にお申し込み頂きありがとうございます。
下記研修への参加受講券を案内いたします。

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

受講券は↓よりご確認ください。
{{url('/ticket_pdf/'.$ticketid)}}

研修当日の受付は受講券内のQRコードで行いますので、
紙面へ印刷したもの、または受講券が表示された画面をご提示ください。


兵庫県保育協会　事務局