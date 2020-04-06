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
                            <div class="col-md-6 pt-2">
                                <span class="">{{$password_mask}}</span>
                                <input type="hidden" name="password" value="{{$user->password}}">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">名前</label>
                            <div class="col-md-6 pt-1">
                                <span class="pt-1">{{$user->name}}</span>
                                <input type="hidden" name="name" value="{{$user->name}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ruby" class="col-md-4 col-form-label text-md-right">フリガナ</label>
                            <div class="col-md-6 pt-1">
                                <span class="">{{$user->ruby}}</span>
                                <input type="hidden" name="ruby" value="{{$user->ruby}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ruby" class="col-md-4 col-form-label text-md-right">電話番号</label>
                            <div class="col-md-6 pt-1">
                                <span class="">{{$user->phone}}</span>
                                <input type="hidden" name="phone" value="{{$user->phone}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">住所</label>
                            <div class="col-md-6 pt-1">
                                <span class="">〒{{$user->zip}}　{{$user->address}}</span>
                                <input type="hidden" name="zip" value="{{$user->zip}}">
                                <input type="hidden" name="address" value="{{$user->address}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="birth" class="col-md-4 col-form-label text-md-right">生年月日</label>
                            <div class="col-md-6 pt-1">
                                <span class="">{{$user->birth_year}}年</span>
                                <input type="hidden" name="birth_year" value="{{$user->birth_year}}">
                                <span class="">{{$user->birth_month}}月</span>
                                <input type="hidden" name="birth_month" value="{{$user->birth_month}}">
                                <span class="">{{$user->birth_day}}日</span>
                                <input type="hidden" name="birth_day" value="{{$user->birth_day}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="company_profile_id" class="col-md-4 col-form-label text-md-right">所属施設</label>
                            <div class="col-md-6 pt-1">
                                <span class="">{{$user->company_profile_name}}</span>
                                <input type="hidden" name="company_profile_id" value="{{$user->company_profile_id}}">
                            </div>
                        </div>
                        @if($user->company_profile_name == "兵庫県下に所属なし")
                        <div class="form-group row">
                            <label for="other_facility_name" class="col-md-4 col-form-label text-md-right">所属施設名(他府県下)</label>
                            <div class="col-md-6 pt-2">
                                <span class="">{{$profile->other_facility_name}}</span>
                                <input type="hidden" name="other_facility_name" value="{{$profile->other_facility_name}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="other_facility_address" class="col-md-4 col-form-label text-md-right">所属施設所在地(他府県下)</label>
                            <div class="col-md-6 pt-2">
                                <span class="">{{$profile->other_facility_pref}} {{$profile->other_facility_address}}</span>
                                <input type="hidden" name="other_facility_pref" value="{{$profile->other_facility_pref}}">
                                <input type="hidden" name="other_facility_address" value="{{$profile->other_facility_address}}">
                            </div>
                        </div>
                        @endif

                        <div class="form-group row">
                            <label for="job" class="col-md-4 col-form-label text-md-right">職種</label>
                            <div class="col-md-6 pt-2">
                                <span class="">{{$profile->job}}</span>
                                <input type="hidden" name="job" value="{{$profile->job}}">
                            </div>
                        </div>
                        @if($profile->job == config('const.JOB.0'))
                        <div class="form-group row">
                            <label for="childminder_status" class="col-md-4 col-form-label text-md-right">保育士番号所持状況</label>
                            <div class="col-md-6 pt-1">
                                <span class="">{{$profile->childminder_status}}</span>
                                <input type="hidden" name="childminder_status" value="{{$profile->childminder_status}}">
                            </div>
                        </div>
                        @if($profile->childminder_status == config('const.CHILDMINDER_STATUS.0'))
                        <div class="form-group row">
                            <label for="childminder_number" class="col-md-4 col-form-label text-md-right">保育士番号</label>
                            <div class="col-md-6 pt-1">
                                <span class="">{{$profile->childminder_number}}</span>
                                <input type="hidden" name="childminder_number" value="{{$profile->childminder_number}}">
                            </div>
                        </div>
                        @endif
                        @endif

                        <div class="form-group row mb-0">
                            <div class="col-md-2 offset-md-4">
                                <input type="submit" name="action" value="本登録" class="btn btn-primary" />
                            </div>
                            <div class="col-md-2">
                                <input type="submit" name="action" value="入力へ戻る" class="btn btn-primary" />
                                <input type="hidden" name="firstname" value="{{ $request->firstname }}">
                                <input type="hidden" name="lastname" value="{{ $request->lastname }}">
                                <input type="hidden" name="firstruby" value="{{ $request->firstruby }}">
                                <input type="hidden" name="lastruby" value="{{ $request->lastruby }}">
                                <input type="hidden" name="childminder_number_pref" value="{{ $request->childminder_number_pref }}">
                                <input type="hidden" name="childminder_number_only" value="{{ $request->childminder_number_only }}">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
