@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">ユーザ本登録完了</div>

                    <div class="card-body">
                        <p>本会員登録が完了しました。</p>
                        <a href="{{route('login')}}" class="sg-btn">ログイン</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection