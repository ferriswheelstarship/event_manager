@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">ユーザ本登録確認</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register.main.registered') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="email_token" value="{{ $email_token }}">

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">パスワード</label>
                            <div class="col-md-6">
                                <span class="">{{$password_mask}}</span>
                                <input type="hidden" name="password" value="{{$user->password}}">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">名前</label>
                            <div class="col-md-6">
                                <span class="">{{$user->name}}</span>
                                <input type="hidden" name="name" value="{{$user->name}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ruby" class="col-md-4 col-form-label text-md-right">フリガナ</label>
                            <div class="col-md-6">
                                <span class="">{{$user->ruby}}</span>
                                <input type="hidden" name="ruby" value="{{$user->ruby}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="birth" class="col-md-4 col-form-label text-md-right">生年月日</label>
                            <div class="col-md-6">
                                <span class="">{{$user->birth_year}}年</span>
                                <input type="hidden" name="birth_year" value="{{$user->birth_year}}">
                                <span class="">{{$user->birth_month}}月</span>
                                <input type="hidden" name="birth_month" value="{{$user->birth_month}}">
                                <span class="">{{$user->birth_day}}日</span>
                                <input type="hidden" name="birth_day" value="{{$user->birth_day}}">
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-2 offset-md-4">
                                <input type="submit" name="action" value="本登録" class="btn btn-primary" />
                            </div>
                            <div class="col-md-2">
                                <input type="submit" name="action" value="入力へ戻る" class="btn btn-primary" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection