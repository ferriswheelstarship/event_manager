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
    </style>
  </head>
  <body>
      {{ $emes }}
  </body>
</html>