@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">ユーザ登録</div>

                    @isset($message)
                    <div class="card-body">
                        <div class="alert alert-danger">
                        {{$message}}
                        </div>                        
                    </div>
                    @endisset

                    @if (count($errors) > 0)
                    <div class="card-body">
                        <div class="alert alert-danger" role="alert">入力エラーがあります。</div>
                    </div>
                    @endif

                    @if (Session::has('status'))
                    <div class="card-body">
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>                        
                    </div>
                    @endif

                    @empty($message)
                        <div class="card-body">
                            <form method="POST" action="{{ route('account.firstPost') }}">
                                {{ csrf_field() }}

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">権限</label>
                                    <div class="col-md-6">
                                        <select id="role_id" class="form-control{{ $errors->has('role_id') ? ' is-invalid' : '' }}" name="role_id">
                                            <option value="0">----</option>
                                            @foreach ($role_array as $key => $val)
                                                <option value="{{ $key }}"
                                                    @if(old('role_id') == $key) selected @endif>{{ $val }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('role_id'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('role_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">パスワード</label>
                                    <div class="col-md-6">
                                        <input 
                                            id="password" type="password" 
                                            class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" 
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
                                    <label for="name" class="col-md-4 col-form-label text-md-right">電話番号</label>
                                    <div class="col-md-6">
                                        <input
                                            id="phone" type="text"
                                            class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                            name="phone" value="{{ old('phone') }}" required>

                                        @if ($errors->has('phone'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">住所</label>
                                    <div class="col-md-3">
                                        <input
                                            id="zip" type="text"
                                            class="form-control{{ $errors->has('zip') ? ' is-invalid' : '' }}"
                                            name="zip" value="{{ old('zip') }}" required >

                                        @if ($errors->has('zip'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('zip') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-6">
                                        <input
                                            id="address" type="text"
                                            class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                            name="address" value="{{ old('address') }}" required>

                                        @if ($errors->has('address'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            次へ
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