@extends('layouts.app')

@section('each-head')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">ユーザ登録 - </div>

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
                                                <select id="birth_year" class="form-control{{ $errors->has('birth_year') ? ' is-invalid' : '' }}" name="birth_year">
                                                    <option value="0">----</option>
                                                    @for ($i = 1930; $i <= 2005; $i++)
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
                                                <select id="birth_month" class="form-control{{ $errors->has('birth_month') ? ' is-invalid' : '' }}" name="birth_month">
                                                    <option value="0">--</option>
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
                                                <select id="birth_day" class="form-control{{ $errors->has('birth_day') ? ' is-invalid' : '' }}" name="birth_day">
                                                    <option value="0">--</option>
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
                                            <option value="なし" @if(old('company_profile_id') === "なし") selected @endif>兵庫県下に所属なし</option>
                                            @foreach ($company as $key => $val)
                                            <option value="{{ $val->company_profile_id }}"
                                                @if(old('company_profile_id') == $val->company_profile_id) selected @endif>{{ $val->name }}</option>
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
                                    <label for="other_facility_name" class="col-md-4 col-form-label text-md-right">所属施設名(他府県下)</label>
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
                                    <label for="other_facility_zip" class="col-md-4 col-form-label text-md-right">所属施設所在地(他府県下)</label>
                                    <div class="col-md-6">
                                        <select 
                                        id="other_facility_pref" 
                                        class="select-search form-control{{ $errors->has('other_facility_pref') ? ' is-invalid' : '' }}" 
                                        name="other_facility_pref">
                                            <option value="0">------------</option>
                                            @foreach ($pref as $key => $val)
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
                                    @if(old('job') != '保育士') none 
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
                                        <input
                                            id="childminder_number" type="text"
                                            class="form-control{{ $errors->has('childminder_number') ? ' is-invalid' : '' }}"
                                            name="childminder_number" value="{{ old('childminder_number') }}" >

                                        @if ($errors->has('childminder_number'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('childminder_number') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                @elseif ($postdata["role_id"] == 3)
                                <!-- 法人ユーザ登録情報 -->
                                <div class="form-group row">
                                    <label for="area_name" class="col-md-4 col-form-label text-md-right">地区名</label>
                                    <div class="col-md-6">
                                        <select id="area_name" class="form-control{{ $errors->has('area_name') ? ' is-invalid' : '' }}" name="area_name">
                                            <option value="0">----</option>
                                            @foreach ($area_name as $key => $val)
                                            <option value="{{ $val }}"
                                                @if(old('area_name') == $val) selected @endif>{{ $val }}</option>
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
                                        <select id="branch_name" class="form-control{{ $errors->has('branch_name') ? ' is-invalid' : '' }}" name="branch_name">
                                            <option value="0">----</option>
                                            @foreach ($branch_name as $key => $val)
                                            <option value="{{ $val }}"
                                                @if(old('branch_name') == $val) selected @endif>{{ $val }}</option>
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
                                                @if(old('company_variation') == $val) selected @endif>{{ $val }}</option>
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
                                                @if(old('category') == $val) selected @endif>{{ $val }}</option>
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
                                            name="fax" value="{{ old('fax') }}" required>

                                        @if ($errors->has('fax'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('fax') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kyokai_number" class="col-md-4 col-form-label text-md-right">協会NO</label>
                                    <div class="col-md-6">
                                        <input
                                            id="kyokai_number" type="text"
                                            class="form-control{{ $errors->has('kyokai_number') ? ' is-invalid' : '' }}"
                                            name="kyokai_number" value="{{ old('kyokai_number') }}" required>

                                        @if ($errors->has('kyokai_number'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('kyokai_number') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
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
                                <input type="hidden" name="ruby" value="{{ $postdata['ruby'] }}">
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

@section('each-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/i18n/ja.js"></script>
<script src="{{ asset('js/select-search.js') }}" ></script>
<script src="{{ asset('js/user-form-event.js') }}" ></script>
@endsection
