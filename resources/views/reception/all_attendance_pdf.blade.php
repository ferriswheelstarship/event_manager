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
        .header,
        .footer {
            width: 90%;
            padding: 15px 0;
            margin: 0px auto;
        }
        .header_first {      
        }
        .header_second {
        }
        .header_heading {
            font-size: 28px;
            padding: 30px 0;
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
        .page-break {
            page-break-after: always;
        }
        .seal_img {
          position:relative;
          width:92px;
        }
    </style>
  </head>
  <body>
    @foreach($datas as $data)
    <div 
    @if (!$loop->last)
    class="page-break"
    @endif
    >
      <div class="header">
        <p class="tar header_first">{{ $data['user']->name }}</p>
        <h1 class="header_heading tac" >
          @if(isset($data['careerup_data']))
          保育士等キャリアアップ研修一部受講証明書          
          @else
          「{{ $data['event']->title }}」 受講証明書
          @endif
        </h1>
      </div>
      <div class="content">
        <div style=" padding:15px 0;">
          <table style=" width: 100%;" class="apptbl">
            <tr>
              <th>勤務先施設名</th>
              <td>{{ $data['company_name'] }}</td>
            </tr>
            <tr>
              <th>受講者氏名</th>
              <td>{{ $data['user']->name.' ('.$data['user']->ruby.')' }}</td>
            </tr>
            <tr>
              <th>生年月日</th>
              <td>{{ $data['profile']->birth_year }}年{{ $data['profile']->birth_month }}月{{ $data['profile']->birth_day }}日</td>
            </tr>
            <tr>
              <th>登録番号</th>
              <td>
                @if($data['profile']->childminder_status == '保育士番号あり')
                {{ $data['profile']->childminder_number }}
                @endif
              </td>
            </tr>
          </table>
        </div>
        <div style=" padding-bottom:20px;">
          <table style=" width: 100%;" class="apptbl">
            <tr>
              <th>受講年月日（A）</th>
              <td>
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
                </td>
            </tr>
            @if(isset($data['careerup_data']))
            <tr>
              <th>【受講分野】 科目：時間数（B）</th>
              <td>
                @if(isset($data['careerup_data']) && count($data['careerup_data']) > 0)
                @foreach($data['careerup_data'] as $item)
                <div>【{{ $item['parent'] }}】 {{ $item['child'] }}：{{ $item['training_minutes'] }}時間</div>
                @endforeach
                @endif
              </td>
            </tr>
            @else
            <tr>
              <th>受講時間数（B）</th>
              <td>
                @if($data['event']->training_minute % 60 == 0) 
                  @php
                    $training_hours = floor($data['event']->training_minute / 60);
                  @endphp
                @else 
                    @if($data['event']->training_minute % 60 >= 30) 
                      @php
                        $training_hours = floor($data['event']->training_minute / 60).'.5';
                      @endphp
                    @else
                      @php
                        $training_hours = floor($data['event']->training_minute / 60);
                      @endphp
                    @endif
                @endif
                <b>{{ $training_hours }}時間</b>
              </td>
            </tr>
            @endif
            <tr>
              <th>研修名（C）</th>
              <td>
                <b>{{ $data['event']->title }}</b>
              </td>
            </tr>
            <tr>
              <th>研修実施機関名（D）</th>
              <td>
                <b>公益社団法人 兵庫県保育協会</b>
              </td>
            </tr>
            <tr>
              <th>会場名</th>
              <td>
                <b>{{ $data['event']->place }}</b>
              </td>
            </tr>
          </table>
          @if(!isset($data['careerup_data']))
          <p style=" margin:0; padding-top:0; text-align:right; font-size:12px">※この研修会は兵庫県保育士等キャリアアップ研修には該当いたしません。</p>
          @endif
        </div>
      </div>
      <div class="footer">
        @if(isset($data['careerup_data']))
        <p>上記のとおり、保育士等キャリアアップ研修の一部を受講したことを証明します。</p>
        @else
        <p>上記のとおり、研修会を受講したことを証明します。</p>
        @endif
        <p>
        @foreach($data['event_dates'] as $key => $val)
        @if($loop->last)
        @php
        echo date('Y年m月d日', strtotime($val->event_date));
        @endphp
        @endif
        @endforeach
        </p>
        <p style=" text-align:right; ">〒651-0062　神戸市中央区坂口通2-1-1（078-242-4623）</p>
        <p style=" text-align:right; font-size:1.2em; margin-right:4.5em">
        　　　　　　　　公益社団法人　兵庫県保育協会<br>
        　　　　　　　　　　　　　　会長　小林　公正</p>
        <div style=" text-align:right; margin-top:-5em">
        {!! $data['seal_img'] !!}
        </div>
      </div>
    </div>
    @endforeach
  </body>

</html>