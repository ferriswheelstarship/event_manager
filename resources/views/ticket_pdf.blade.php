<!doctype html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @font-face {
            font-family: ipag;
            font-style: normal;
            font-weight: normal;
            src: url('{{ storage_path('fonts/ipag.ttf') }}') format('truetype');
        }
        body {
            font-family: ipag !important;
            padding: 10px 15px;
            font-size: 14px;
            line-height: 1.5;
        }
        table {
            border-collapse: collapse;
        }
        th,td {
            padding: 0;
            word-wrap:break-word;
        }
        .tar {
            text-align: right;
        }
        .tac {
            text-align: center;
        }
        .fwb {
            font-weight: bold;
        }
        .tdud {
            text-decoration: underline;
        }
        .header {
            width: 90%;
            padding: 0 0 15px;
            margin: 0px auto;
        }
        .header_first {      
        }
        .header_second {
        }
        .header_heading {
            font-size: 24px;
            padding: 10px 0;
            max-width:100%;
            word-wrap:break-word;
        }
        .header_comment {
            width: 95%;
            margin: 20px auto;
        }
        .content {
            width: 85%;
            padding: 0 15px;
            margin: 0px auto;
            border: 3px solid #000;
        }
        .content h2 {
            background-color: #000;
            color: #fff;
            padding: 8px;
            font-weight: normal;
        }
        .ticket {
            background-color: #999;
            color: #fff;
            padding: 5px 0px;
            width: 90%;
            border: 1px solid #999;
            font-size: 24px;
        }
        .ticket-num {
            margin: 0 3px;
            padding: 4px;
            border: 1px solid #000;
            font-size: 24px;
        }
        .apptbl {
            width: 100%;
            border-top: 1px solid #000;
            border-left: 1px solid #000;
        }
        .apptbl th,
        .apptbl td {
            border-bottom: 1px solid #000;
            border-right: 1px solid #000;
            padding: 5px;
        }    
        .apptbl th {
            width: 30%;
            font-weight: bold;
            background-color: #ededed;
        }
        .apptbl td {
            text-align:left;
            padding:5px 10px;
        }
        .uketsuke {
            font-size: 22px;
            font-weight: bold;
        }
    </style>
  </head>
  <body>
    <div class="header">
      <!-- <p class="tar header_first"><br />
        公益社団法人 兵庫県保育協会<br>
        事務局</p>
      <p class="header_second">関係各位</p> -->
      <h1 class="header_heading tac" >「{{ $data['event']->title }}」受講券</h1>
      <!-- <div class="header_comment">　時下ますますご清栄のこととお慶び申し上げます。<br />
      この度は{{ $data['event']->title }}へお申込み頂き、ありがとうございました。<br />
      受講券内のQRコードで受付を行いますので、<br />
      印刷した紙面または現在ご覧の画面を受付でご提示ください。 -->
      </div>
    </div>
    <div class="content">
      <h2 class="tac" style="word-wrap:break-word; font-size:18px">@if($data['careerup_curriculums'] && $data['careerup_curriculums'] == 'carrerup')【キャリアアップ研修】@endif {{ $data['event']->title }}</h2>
      <div style=" padding-bottom:15px;">
      <table style=" width: 100%;">
        <tr>
          <td style=" width: 30%;"><div class="ticket tac">受講券</div></td>
          <td style=" width: 60%; ">
            <div class="ticket-num tac">受付番号：{{ $data['app_num'] }}</div>
          </td>
        </tr>
      </table>
      </div>
      <div style=" padding-bottom:15px;">
        <table style=" width: 100%;" class="apptbl">
          <tr>
            <th>所属施設名</th>
            <td>{{ $data['company_name'] }}</td>
          </tr>
          <tr>
            <th>氏名</th>
            <td>{{ $data['user']->name.' ('.$data['user']->ruby.')' }}</td>
          </tr>
        </table>
      </div>
      <div style=" padding-bottom:20px;">
        <table style=" width: 100%;">
          <tr>
            <td style=" width: 80%;">
              <table class="apptbl" style="table-layout: fixed; width: 450px;">
                <tr>
                  <th>開催日</th>
                  <td style="width:350px">
                    @if(count($data['event_dates']) > 0)
                    @foreach($data['event_dates'] as $key => $val)
                    @php
                    echo date('Y年m月d日', strtotime($val->event_date));
                    @endphp
                    @if(!$loop->last)
                    ,
                    @endif
                    @endforeach
                    @endif
                    @if(count($data['event_dates']) > 1)
                    <br>
                    ※この受講券は全開催日で有効です。
                    @endif
                    </td>
                </tr>
                <tr>
                  <th>場所</th>
                  <td style="width:350px">
                    <b>{{ $data['event']->place }}</b>
                  </td>
                </tr>
                <tr>
                  <th>注意事項</th>
                  <td style="width:350px;word-wrap:break-word;">
                    {!! nl2br($data['event']->notice) !!}
                  </td>
                </tr>
              </table>
            </td>
            <td class="tac">{!! $data['qrcode'] !!}</td>
          </tr>
        </table>
        <p class="h6 mb-0"><small>※研修当日の受付は受講券内のQRコードで行いますので、
        紙面へ印刷したもの、または受講券が表示された画面をご提示ください。</small></p>
      </div>
    </div>
  </body>

</html>