@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">ユーザ本登録</div>

                    @isset($message)
                        <div class="card-body">
                            {{$message}}
                        </div>
                    @endisset

                    @empty($message)
                        <div class="card-body">
                            <form method="POST" action="{{ route('register.main.check') }}">
                                {{ csrf_field() }}

                                <input type="hidden" name="email_token" value="{{ $email_token }}">

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">パスワード</label>
                                    <div class="col-md-6">
                                        <input 
                                            id="password" type="password" 
                                            class="form-control" 
                                            name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">パスワード確認</label>
                                    <div class="col-md-6">
                                        <input 
                                            id="password-confirm" type="password" 
                                            class="form-control" 
                                            name="password_confirmation" required>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">名前</label>
                                    <div class="col-md-6">
                                        <input
                                            id="name" type="text"
                                            class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                            name="name" value="{{ old('name') }}" required>

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="name_pronunciation"
                                           class="col-md-4 col-form-label text-md-right">フリガナ</label>

                                    <div class="col-md-6">
                                        <input id="ruby" type="text"
                                               class="form-control{{ $errors->has('ruby') ? ' is-invalid' : '' }}"
                                               name="ruby" value="{{ old('ruby') }}"
                                               required>

                                        @if ($errors->has('ruby'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('ruby') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="birthday"
                                           class="col-md-4 col-form-label text-md-right">生年月日</label>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <select id="birth_year" class="form-control" name="birth_year">
                                                    <option value="">----</option>
                                                    @for ($i = 1980; $i <= 2005; $i++)
                                                        <option value="{{ $i }}"
                                                                @if(old('birth_year') == $i) selected @endif>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                                @if ($errors->has('birth_year'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('birth_year') }}</strong>
                                                    </span>
                                                @endif
                                            </div>年

                                            <div class="col-md-3">
                                                <select id="birth_month" class="form-control" name="birth_month">
                                                    <option value="">--</option>
                                                    @for ($i = 1; $i <= 12; $i++)
                                                        <option value="{{ $i }}"
                                                            @if(old('birth_month') == $i) selected @endif>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                                @if ($errors->has('birth_month'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('birth_month') }}</strong>
                                                    </span>
                                                @endif
                                            </div>月

                                            <div class="col-md-3">
                                                <select id="birth_day" class="form-control" name="birth_day">
                                                    <option value="">--</option>
                                                    @for ($i = 1; $i <= 31; $i++)
                                                        <option value="{{ $i }}"
                                                            @if(old('birth_day') == $i) selected @endif>{{ $i }}</option>
                                                    @endfor
                                                </select>

                                                @if ($errors->has('birth_day'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('birth_day') }}</strong>
                                                    </span>
                                                @endif
                                            </div>日
                                        </div>

                                        <div class="row col-md-6 col-md-offset-4">
                                            @if ($errors->has('birth'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('birth') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            確認画面へ
                                        </button>
                                    </div>
                                </div>
                            </form>
                </div>
                @endempty
            </div>
        </div>
    </div>
    </div>
@endsection