<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="robots" content="noindex,nofollow"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
  <link href="{{ asset('css/navbar-fixed-left.min.css') }}" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" href="style.css">
  <link href="{{ asset('css/system/custom.css') }}" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>  
  @yield('each-head')
</head>
<body style="min-height: 100vh; position:relative">
 
@include('layouts.partials.header')
 
<div style="min-height: calc(100% + 40px); padding-bottom:40px">
  <div class="pt-3">
    <div id="content">
    <!-- @include('commons.error_messages') -->
    @yield('content')
    </div>
  </div>
  @include('layouts.partials.footer')
</div>

@yield('each-js')

</body>
</html>