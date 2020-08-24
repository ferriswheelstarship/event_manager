-username- 様<br/ ><br/ >

平素より大変お世話になっています。<br/ ><br/ >

この度は、研修会にお申し込み頂きありがとうございます。<br/ >
下記研修への参加受講券を案内いたします。<br/ ><br/ >

＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝<br/ >
研修名：{{ $eventtitle }} <br/ >
開催日：@foreach($eventdates as $key => $val)
@php 
echo date('Y年m月d日', strtotime($val['event_date']));
@endphp
@if(!$loop->last)
,
@endif
@endforeach
<br/ ><br/ >

受講者名：-username- 様<br/ ><br/ >

注意事項：<br/ >
{{ $eventnotice }}<br/ ><br/ >

＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝<br/ ><br/ >

受講券は↓よりご確認ください。<br/ >
{{url('/ticket_pdf/')}}/-ticketid- <br/ ><br/ >

研修当日の受付は受講券内のQRコードで行いますので、<br/ >
紙面へ印刷したもの、または受講券が表示された画面をご提示ください。<br/ ><br/ ><br/ >


兵庫県保育協会　事務局