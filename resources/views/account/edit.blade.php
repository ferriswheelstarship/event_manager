@extends('layouts.app')

@section('title', 'ユーザ情報変更')

@section('each-head')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">ユーザ情報変更（{{ $user->name }}）</div>

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

                        <form method="POST" action="{{ url('account/edit/'.$user->id) }}">
                            {{ csrf_field() }}

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>
                                <div class="col-md-6">
                                    <input id="email" 
                                        type="email" 
                                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" 
                                        name="email" 
                                        value="{{ old('email',$user->email) }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">名前</label>
                                <div class="col-md-6">
                                    @if ($user->role_id == 4)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input
                                                id="firstname" type="text"
                                                class="form-control{{ $errors->has('firstname') ? ' is-invalid' : '' }}"
                                                name="firstname" value="{{ old('firstname',$user->firstname) }}" placeholder="兵庫" required>

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
                                                name="lastname" value="{{ old('lastname',$user->lastname) }}" placeholder="太郎" required>

                                            @if ($errors->has('lastname'))
                                                <span class="invalid-feedback">
                                                <strong>{{ $errors->first('lastname') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    @else

                                    <input
                                        id="name" type="text"
                                        class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                        name="name" value="{{ old('name',$user->name) }}" required>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif

                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="name_pronunciation"
                                        class="col-md-4 col-form-label text-md-right">フリガナ</label>

                                <div class="col-md-6">
                                    @if ($user->role_id == 4)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input id="firstruby" type="text"
                                                class="form-control{{ $errors->has('firstruby') ? ' is-invalid' : '' }}"
                                                name="firstruby" value="{{ old('firstruby',$user->firstruby) }}" placeholder="ヒョウゴ"
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
                                                name="lastruby" value="{{ old('lastruby',$user->lastruby) }}" placeholder="タロウ"
                                                required>

                                            @if ($errors->has('lastruby'))
                                                <span class="invalid-feedback">
                                                <strong>{{ $errors->first('lastruby') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    @else

                                    <input
                                        id="ruby" type="text"
                                        class="form-control{{ $errors->has('ruby') ? ' is-invalid' : '' }}"
                                        name="ruby" value="{{ old('ruby',$user->ruby) }}" required>

                                    @if ($errors->has('ruby'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('ruby') }}</strong>
                                        </span>
                                    @endif

                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">電話番号</label>
                                <div class="col-md-6">
                                    <input
                                        id="phone" type="text"
                                        class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                        name="phone" value="{{ old('phone',$user->phone) }}" required>

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
                                        name="zip" value="{{ old('zip',$user->zip) }}" required >

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
                                        name="address" value="{{ old('address',$user->address) }}" required>

                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @if ($user->role_id == 4)                            
                            <div class="form-group row">
                                <label for="birthday"
                                        class="col-md-4 col-form-label text-md-right">生年月日</label>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select 
                                                id="birth_year" 
                                                class="form-control{{ $errors->has('birth_year') ? ' is-invalid' : '' }}" 
                                                name="birth_year">
                                                <option value="0">----</option>
                                                @for ($i = 1930; $i <= 2005; $i++)
                                                    <option value="{{ $i }}"
                                                            @if(old('birth_year',$profile->birth_year) == $i ) selected @endif>{{ $i }}年</option>
                                                @endfor
                                            </select>
                                            @if ($errors->has('birth_year'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('birth_year') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="col-md-4">
                                            <select 
                                                id="birth_month" 
                                                class="form-control{{ $errors->has('birth_month') ? ' is-invalid' : '' }}" 
                                                name="birth_month">
                                                <option value="0">--</option>
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}"
                                                        @if(old('birth_month',$profile->birth_month) == $i) selected @endif>{{ $i }}月</option>
                                                @endfor
                                            </select>
                                            @if ($errors->has('birth_month'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('birth_month') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="col-md-4">
                                            <select 
                                                id="birth_day" 
                                                class="form-control{{ $errors->has('birth_day') ? ' is-invalid' : '' }}" 
                                                name="birth_day">
                                                <option value="0">--</option>
                                                @for ($i = 1; $i <= 31; $i++)
                                                    <option value="{{ $i }}"
                                                        @if(old('birth_day',$profile->birth_day) == $i) selected @endif>{{ $i }}日</option>
                                                @endfor
                                            </select>

                                            @if ($errors->has('birth_day'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('birth_day') }}</strong>
                                                </span>
                                            @endif
                                        </div>
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
                                <label for="company_profile_id" class="col-md-4 col-form-label text-md-right">所属施設</label>
                                <div class="col-md-6">
                                    <select 
                                    id="company_profile_id" 
                                    class="select-search form-control{{ $errors->has('company_profile_id') ? ' is-invalid' : '' }}" name="company_profile_id"
                                    onchange="changeEventFacility(this.value)">
                                        <option value="なし" 
                                        @if(old('company_profile_id') == "なし" || $user->company_profile_id == null) selected @endif >兵庫県下に所属なし</option>
                                        @foreach ($facilites as $key => $val)
                                        <option value="{{ $val['company_profile_id'] }}"
                                            @if(old('company_profile_id',$user->company_profile_id) == $val['company_profile_id']) selected @endif>【{{ $val['city'] }}】{{ $val['name'] }}</option>
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
                                @if(old('company_profile_id') != 'なし' && $user->company_profile_id > 0) 
                                    none
                                @endif ">
                            <div class="form-group row">
                                <label for="other_facility_name" class="col-md-4 col-form-label text-md-right">所属施設名(他府県下)</label>
                                <div class="col-md-6">
                                    <input
                                        id="other_facility_name" type="text"
                                        class="form-control{{ $errors->has('other_facility_name') ? ' is-invalid' : '' }}"
                                        name="other_facility_name" value="{{ old('other_facility_name',$profile->other_facility_name) }}" >

                                    @if ($errors->has('other_facility_name'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('other_facility_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="other_facility_name" class="col-md-4 col-form-label text-md-right">所属施設所在地(他府県下)</label>
                                <div class="col-md-3">
                                    <select 
                                    id="other_facility_pref" 
                                    class="select-search form-control{{ $errors->has('other_facility_pref') ? ' is-invalid' : '' }}" 
                                    name="other_facility_pref">
                                        <option value="0">------------</option>
                                        @foreach ($pref as $key => $val)
                                        <option value="{{ $val }}"
                                            @if(old('other_facility_pref',$profile->other_facility_pref) == $val) selected @endif>{{ $val }}</option>
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
                                        name="other_facility_address" value="{{ old('other_facility_address',$profile->other_facility_address) }}" 
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
                                        @foreach ($job as $key => $val)
                                        <option value="{{ $val }}"
                                            @if(old('job',$profile->job) == $val) selected @endif>{{ $val }}</option>
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
                                    @if(old('job',$profile->job) != '保育士・保育教諭') none 
                                    @endif">
                            <div class="form-group row">
                                <label for="childminder_status" class="col-md-4 col-form-label text-md-right">保育士番号所持状況</label>
                                <div class="col-md-6">
                                    <select id="childminder_status" 
                                        class="form-control{{ $errors->has('childminder_status') ? ' is-invalid' : '' }}" 
                                        name="childminder_status"
                                        onchange="changeEventChildminder(this.value)">
                                        @foreach ($childminder_status as $key => $val)
                                        <option value="{{ $val }}"
                                            @if(old('childminder_status',$profile->childminder_status) == $val) selected @endif>{{ $val }}</option>
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
                                @if(old('childminder_status',$profile->childminder_status) != '保育士番号あり') 
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
                                                <option value="兵庫県" @if(old('childminder_number_pref',$profile->childminder_number_pref) == "兵庫県") selected @endif>兵庫県</option>
                                                @foreach ($pref as $item)
                                                    <option value="{{ $item }}"
                                                            @if(old('childminder_number_pref',$profile->childminder_number_pref) == $item) selected @endif>{{ $item }}</option>
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
                                                name="childminder_number_only" value="{{ old('childminder_number_only',$profile->childminder_number_only) }}" >

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
                            
                            @elseif($user->role_id == 3)
                            <div class="form-group row">
                                <label for="area_name" class="col-md-4 col-form-label text-md-right">地区名</label>
                                <div class="col-md-6">
                                    <select 
                                        id="area_name"
                                        class="form-control{{ $errors->has('area_name') ? ' is-invalid' : '' }}"
                                        name="area_name">
                                        <option value="0">----</option>
                                        @foreach ($area_name as $key => $val)
                                        <option value="{{ $val }}"
                                            @if($profile->area_name == $val) selected @endif>{{ $val }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('area_name'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('area_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="branch_name" class="col-md-4 col-form-label text-md-right">支部名</label>
                                <div class="col-md-6">
                                    <select id="branch_name" class="select-search form-control{{ $errors->has('branch_name') ? ' is-invalid' : '' }}" name="branch_name">
                                        <option value="0">----</option>
                                        @foreach ($branch_name as $key => $val)
                                        <option value="{{ $val }}"
                                            @if(old('branch_name',$profile->branch_name) == $val) selected @endif>{{ $val }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('branch_name'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('branch_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>                                
                            <div class="form-group row">
                                <label for="company_variation" class="col-md-4 col-form-label text-md-right">設置主体</label>
                                <div class="col-md-6">
                                    <select id="company_variation" class="form-control{{ $errors->has('area_company_variationname') ? ' is-invalid' : '' }}" name="company_variation">
                                        <option value="0">----</option>
                                        @foreach ($company_variation as $key => $val)
                                        <option value="{{ $val }}"
                                            @if(old('company_variation',$profile->company_variation) == $val) selected @endif>{{ $val }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('company_variation'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('company_variation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="category" class="col-md-4 col-form-label text-md-right">こども園類型</label>
                                <div class="col-md-6">
                                    <select id="category" class="form-control{{ $errors->has('category') ? ' is-invalid' : '' }}" name="category">
                                        <option value="0">----</option>
                                        <option value="" @if(old('category') == '') selected @endif>区分なし</option>
                                        @foreach ($category as $key => $val)
                                        <option value="{{ $val }}"
                                            @if(old('category',$profile->category) == $val) selected @endif>{{ $val }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('category'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('category') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fax" class="col-md-4 col-form-label text-md-right">FAX番号</label>
                                <div class="col-md-6">
                                    <input
                                        id="fax" type="text"
                                        class="form-control{{ $errors->has('fax') ? ' is-invalid' : '' }}"
                                        name="fax" value="{{ old('fax',$profile->fax) }}" required>

                                    @if ($errors->has('fax'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('fax') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @can('system-only')
                            <div class="form-group row">
                                <label for="kyokai_number" class="col-md-4 col-form-label text-md-right">協会NO</label>
                                <div class="col-md-6">
                                    <input
                                        id="kyokai_number" type="text"
                                        class="form-control{{ $errors->has('kyokai_number') ? ' is-invalid' : '' }}"
                                        name="kyokai_number" value="{{ old('kyokai_number',$profile->kyokai_number) }}" required>

                                    @if ($errors->has('kyokai_number'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('kyokai_number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @endcan

                            @endif

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        変更する
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
