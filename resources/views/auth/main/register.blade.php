@extends('layouts.app')

@section('each-head')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
@endsection

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
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input
                                                    id="firstname" type="text"
                                                    class="form-control{{ $errors->has('firstname') ? ' is-invalid' : '' }}"
                                                    name="firstname" value="{{ old('firstname') }}" placeholder="兵庫" required>

                                                @if ($errors->has('firstname'))
                                                    <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('firstname') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <input
                                                    id="lastname" type="text"
                                                    class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}"
                                                    name="lastname" value="{{ old('lastname') }}" placeholder="太郎" required>

                                                @if ($errors->has('lastname'))
                                                    <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('lastname') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name_pronunciation"
                                           class="col-md-4 col-form-label text-md-right">フリガナ</label>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input id="firstruby" type="text"
                                                    class="form-control{{ $errors->has('firstruby') ? ' is-invalid' : '' }}"
                                                    name="firstruby" value="{{ old('firstruby') }}" placeholder="ヒョウゴ"
                                                    required>

                                                @if ($errors->has('firstruby'))
                                                    <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('firstruby') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <input id="lastruby" type="text"
                                                    class="form-control{{ $errors->has('lastruby') ? ' is-invalid' : '' }}"
                                                    name="lastruby" value="{{ old('lastruby') }}" placeholder="タロウ"
                                                    required>

                                                @if ($errors->has('lastruby'))
                                                    <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('lastruby') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="name_pronunciation"
                                           class="col-md-4 col-form-label text-md-right">電話番号</label>

                                    <div class="col-md-6">
                                        <input id="phone" type="text"
                                               class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                               name="phone" value="{{ old('phone') }}"
                                               required>

                                        @if ($errors->has('phone'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name_pronunciation"
                                           class="col-md-4 col-form-label text-md-right">住所</label>

                                    <div class="col-md-6">
                                        <input id="zip" type="text"
                                               class="form-control{{ $errors->has('zip') ? ' is-invalid' : '' }}"
                                               name="zip" value="{{ old('zip') }}"
                                               placeholder="651-0062"
                                               required>

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
                                        <input id="address" type="text"
                                               class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                               name="address" value="{{ old('address') }}"
                                               placeholder="神戸市中央区坂口通2丁目1番1号"
                                               required>

                                        @if ($errors->has('address'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('address') }}</strong>
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
                                                <select id="birth_year" 
                                                class="form-control{{ $errors->has('birth_year') ? ' is-invalid' : '' }}" 
                                                name="birth_year">
                                                    <option value="0">----</option>
                                                    @for ($i = 1930; $i <= 2005; $i++)
                                                        <option value="{{ $i }}"
                                                                @if(old('birth_year') == $i) selected @endif>{{ $i }}年</option>
                                                    @endfor
                                                </select>
                                                @if ($errors->has('birth_year'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('birth_year') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <div class="col-md-4">
                                                <select id="birth_month" 
                                                class="form-control{{ $errors->has('birth_month') ? ' is-invalid' : '' }}"                                                 
                                                name="birth_month">
                                                    <option value="0">--</option>
                                                    @for ($i = 1; $i <= 12; $i++)
                                                        <option value="{{ $i }}"
                                                            @if(old('birth_month') == $i) selected @endif>{{ $i }}月</option>
                                                    @endfor
                                                </select>
                                                @if ($errors->has('birth_month'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('birth_month') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <div class="col-md-4">
                                                <select id="birth_day" 
                                                class="form-control{{ $errors->has('birth_day') ? ' is-invalid' : '' }}" 
                                                name="birth_day">
                                                    <option value="0">--</option>
                                                    @for ($i = 1; $i <= 31; $i++)
                                                        <option value="{{ $i }}"
                                                            @if(old('birth_day') == $i) selected @endif>{{ $i }}日</option>
                                                    @endfor
                                                </select>
                                                @if ($errors->has('birth_day'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('birth_day') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="company_profile_id" class="col-md-4 col-form-label text-md-right">所属施設</label>
                                    <div class="col-md-6">
                                        <select 
                                        id="company_profile_id" 
                                        class="select-search form-control{{ $errors->has('company_profile_id') ? ' is-invalid' : '' }}" 
                                        name="company_profile_id"
                                        onchange="changeEventFacility(this.value)">
                                            <option value="0">----</option>
                                            <option value="なし" @if(old('company_profile_id') === "なし") selected @endif>兵庫県保育協会の会員施設以外（所属なし）</option>
                                            @foreach ($facilites as $key => $val)
                                            <option value="{{ $val['company_profile_id'] }}"
                                                @if(old('company_profile_id') == $val['company_profile_id']) selected @endif>【{{ $val['city'] }}】{{ $val['name'] }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('company_profile_id'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('company_profile_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>


                                <div 
                                    id="only-indivisual-user"
                                    style="display: 
                                    @if(old('company_profile_id') != 'なし') 
                                        none
                                    @endif ">
                                <div class="form-group row">
                                    <label for="other_facility_name" class="col-md-4 col-form-label text-md-right">所属施設名</label>
                                    <div class="col-md-6">
                                        <input
                                            id="other_facility_name" type="text"
                                            class="form-control{{ $errors->has('other_facility_name') ? ' is-invalid' : '' }}"
                                            name="other_facility_name" value="{{ old('other_facility_name') }}" >

                                        @if ($errors->has('other_facility_name'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('other_facility_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="other_facility_zip" class="col-md-4 col-form-label text-md-right">所属施設所在地</label>
                                    <div class="col-md-6">
                                        <select 
                                        id="other_facility_pref" 
                                        class="select-search form-control{{ $errors->has('other_facility_pref') ? ' is-invalid' : '' }}" 
                                        name="other_facility_pref">
                                            <option value="0">------------</option>
                                            @foreach ($pref_all as $key => $val)
                                            <option value="{{ $val }}"
                                                @if(old('other_facility_pref') == $val) selected @endif>{{ $val }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('other_facility_pref'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('other_facility_pref') }}</strong>
                                            </span>
                                        @endif

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4 col-form-label text-md-right"></div>
                                    <div class="col-md-6">
                                        <input
                                            id="other_facility_address" type="text"
                                            class="form-control{{ $errors->has('other_facility_address') ? ' is-invalid' : '' }}"
                                            name="other_facility_address" value="{{ old('other_facility_address') }}" 
                                            placeholder="市町村を入力してください">

                                        @if ($errors->has('other_facility_address'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('other_facility_address') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                </div>

                                <div class="form-group row">
                                    <label for="company_profile_id" class="col-md-4 col-form-label text-md-right">職種</label>
                                    <div class="col-md-6">
                                        <select 
                                        id="job" 
                                        class="form-control{{ $errors->has('job') ? ' is-invalid' : '' }}" 
                                        name="job"
                                        onchange="changeEventJob(this.value)">
                                            <option value="0">----</option>
                                            @foreach ($job as $key => $val)
                                            <option value="{{ $val }}"
                                                @if(old('job') == $val) selected @endif>{{ $val }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('job'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('job') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div id="only-nursery" 
                                    style="display: 
                                    @if(old('job') != '保育士・保育教諭') none 
                                    @endif">
                                <div class="form-group row">
                                    <label for="childminder_status" class="col-md-4 col-form-label text-md-right">保育士番号所持状況</label>
                                    <div class="col-md-6">
                                        <select id="childminder_status" 
                                            class="form-control{{ $errors->has('childminder_status') ? ' is-invalid' : '' }}" 
                                            name="childminder_status"
                                            onchange="changeEventChildminder(this.value)">
                                            <option value="0">----</option>
                                            @foreach ($childminder_status as $key => $val)
                                            <option value="{{ $val }}"
                                                @if(old('childminder_status') == $val) selected @endif>{{ $val }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('childminder_status'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('childminder_status') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div 
                                    class="form-group row" 
                                    id="childminder-number-section" 
                                    style="display: 
                                    @if(old('childminder_status') != '保育士番号あり') 
                                        none
                                    @endif ">
                                    <label for="childminder_number" class="col-md-4 col-form-label text-md-right">保育士番号</label>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <select id="childminder_number_pref" 
                                                class="form-control{{ $errors->has('childminder_number_pref') ? ' is-invalid' : '' }}" 
                                                name="childminder_number_pref">
                                                    <option value="0">都道府県を選択</option>
                                                    <option value="兵庫県" @if(old('childminder_number_pref') == "兵庫県") selected @endif>兵庫県</option>
                                                    @foreach ($pref as $item)
                                                        <option value="{{ $item }}"
                                                                @if(old('childminder_number_pref') == $item) selected @endif>{{ $item }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('childminder_number_pref'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('childminder_number_pref') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <div class="col-md-8">
                                                <input
                                                    id="childminder_number_only" type="text"
                                                    class="form-control{{ $errors->has('childminder_number_only') ? ' is-invalid' : '' }}"
                                                    name="childminder_number_only" value="{{ old('childminder_number_only') }}" 
                                                    placeholder="6桁の数字（半角）">

                                                @if ($errors->has('childminder_number_only'))
                                                    <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('childminder_number_only') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
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

@section('each-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/i18n/ja.js"></script>
<script src="{{ asset('js/select-search.js') }}" ></script>
<script src="{{ asset('js/user-form-event.js') }}" ></script>
@endsection
