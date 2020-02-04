@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">ユーザ登録</div>

                    @isset($message)
                        <div class="card-body">
                            {{$message}}
                        </div>
                    @endisset

                    @empty($message)
                        <div class="card-body">
                            <form method="POST" action="{{ route('account.create') }}">
                                {{ csrf_field() }}

                                @if ($postdata["role_id"] == 4)
                                <!-- 個人ユーザ登録情報 -->
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
                                                    <span class="invalid-feedback">
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
                                                    <span class="invalid-feedback">
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
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('birth_day') }}</strong>
                                                    </span>
                                                @endif
                                            </div>日
                                        </div>

                                        <div class="row col-md-6 col-md-offset-4">
                                            @if ($errors->has('birth'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('birth') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">所属施設</label>
                                    <div class="col-md-6">
                                        <select id="company_profile_id" class="form-control" name="company_profile_id">
                                            <option value="">----</option>
                                            <option value="所属なし">兵庫県下に所属なし</option>
                                        </select>

                                        @if ($errors->has('phone'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">保育士番号</label>
                                    <div class="col-md-6">
                                        <input
                                            id="serial_number" type="text"
                                            class="form-control{{ $errors->has('serial_number') ? ' is-invalid' : '' }}"
                                            name="serial_number" value="{{ old('serial_number') }}">

                                        @if ($errors->has('serial_number'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('serial_number') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                
                                @elseif ($postdata["role_id"] == 3)
                                <!-- 法人ユーザ登録情報 -->
                                @endif

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            次へ
                                        </button>
                                    </div>
                                </div>

                                <input type="hidden" name="email" value="{{ $postdata['email'] }}">
                                <input type="hidden" name="password" value="{{ $postdata['password'] }}">
                                <input type="hidden" name="name" value="{{ $postdata['name'] }}">
                                <input type="hidden" name="role_id" value="{{ $postdata['role_id'] }}">
                                <input type="hidden" name="phone" value="{{ $postdata['phone'] }}">
                                <input type="hidden" name="zip" value="{{ $postdata['zip'] }}">
                                <input type="hidden" name="address" value="{{ $postdata['address'] }}">

                            </form>
                </div>
                @endempty
            </div>
        </div>
    </div>
    </div>
@endsection