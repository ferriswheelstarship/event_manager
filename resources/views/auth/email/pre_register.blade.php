@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      サイトへのアカウント仮登録が完了しました。<br />
      <br />
      以下のURLからログインして、本登録を完了させてください。<br />
      {{url('register/verify/'.$token)}}
    </div>
</div>
@endsection