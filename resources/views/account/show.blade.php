@extends('layouts.app')

@section('title', 'ユーザ詳細')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">ユーザ詳細（{{ $user->name }}）</div>
                    <div class="card-body">
                        @can('system-only')
                        <div class="mb-3">
                            <a href="{{ route('account.edit',['user_id' => $user->id]) }}" class="btn btn-sm btn-primary">変更</a>
                        </div>
                        @endcan
                        <div class="table-responsive">
                            <table class="table table-striped tbl-2column">
                                <tbody>
                                    <tr>
                                        <th>メールアドレス</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>名前</th>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>フリガナ</th>
                                        <td>{{ $user->ruby }}</td>
                                    </tr>
                                    <tr>
                                        <th>電話番号</th>
                                        <td>{{ $user->phone }}</td>
                                    </tr>
                                    @if ($user->role_id == 3)
                                    <tr>
                                        <th>FAX番号</th>
                                        <td>{{ $profile->fax }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th>住所</th>
                                        <td>〒{{ $user->zip }}<br />
                                        {{ $user->address }}</td>
                                    </tr>

                                    @if ($user->role_id == 4)
                                    <tr>
                                        <th>生年月日</th>
                                        <td>{{ $profile->birth_year }}年{{ $profile->birth_month }}月{{ $profile->birth_day }}日</td>
                                    </tr>
                                    <tr>
                                        <th>職種</th>
                                        <td>{{ $profile->job }}</td>
                                    </tr>
                                    <tr>
                                        <th>保育士番号所持状況</th>
                                        <td>{{ $profile->childminder_status }}</td>
                                    </tr>
                                    <tr>
                                        <th>保育士番号</th>
                                        <td>{{ $profile->childminder_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>所属施設</th>
                                        <td>{{ $companyUser }}</td>
                                    </tr>
                                    @endif

                                    @if ($user->role_id == 4 && $profile->other_facility_address)
                                    <tr>
                                        <th>所属施設所在地</th>
                                        <td>{{ $profile->other_facility_pref }}{{ $profile->other_facility_address }}</td>
                                    </tr>
                                    @endif
                                
                                    @if ($user->role_id == 3)
                                    <tr>
                                        <th>地区名</th>
                                        <td>{{ $profile->area_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>支部名</th>
                                        <td>{{ $profile->branch_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>設置主体（公・私）</th>
                                        <td>{{ $profile->company_variation }}（{{ $profile->public_or_private }}）</td>
                                    </tr>
                                    <tr>
                                        <th>こども園類型</th>
                                        <td>{{ $profile->category }}</td>
                                    </tr>
                                    <tr>
                                        <th>協会NO</th>
                                        <td>{{ $profile->kyokai_number }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection