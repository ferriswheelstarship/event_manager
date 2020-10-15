@extends('layouts.app')

@section('title', 'お問い合わせ 詳細')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">お問い合わせ詳細</div>

                    @if (Session::has('status'))
                    <div class="card-body">
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>                        
                    </div>
                    @endif
                    @if (Session::has('attention'))
                    <div class="card-body">
                        <div class="alert alert-danger">
                            {{ session('attention') }}
                        </div>                        
                    </div>
                    @endif

                    <div class="card-body">
                        <div class="mb-4">
                            <a href="{{ route('inquiry.index') }}" class="btn btn-sm btn-info">お問い合わせ一覧</a>
                        </div>

                        @if($inquiry)
                        <table class="table table-striped tbl-2column">
                            <tbody>
                                <tr>
                                    <th>送信日時</th>
                                    <td>@php echo date('Y年m月d日H時i分', strtotime($inquiry->created_at)); @endphp</td>
                                </tr>
                                <tr>
                                    <th>施設名または会社／組織名</th>
                                    <td>{{ $inquiry->cname }}</td>
                                </tr>
                                <tr>
                                    <th>氏名</th>
                                    <td>{{ $inquiry->name }}</td>
                                </tr>
                                <tr>
                                    <th>メールアドレス</th>
                                    <td>{{ $inquiry->email }}</td>
                                </tr>
                                <tr>
                                    <th>内容詳細</th>
                                    <td>{!! nl2br($inquiry->comment) !!}</td>
                                </tr>
                            </tbody>
                        </table>
                        @elseif($registration_request)
                        <table class="table table-striped tbl-2column">
                            <tbody>
                                <tr>
                                    <th>送信日時</th>
                                    <td>@php echo date('Y年m月d日H時i分', strtotime($registration_request->created_at)); @endphp</td>
                                </tr>
                                <tr>
                                    <th>発生している問題</th>
                                    <td>{{ $registration_request->registration_type }}</td>
                                </tr>
                                <tr>
                                    <th>メールアドレス</th>
                                    <td>{{ $registration_request->reg_email }}</td>
                                </tr>
                                <tr>
                                    <th>パスワード</th>
                                    <td>{{ $registration_request->password }}</td>
                                </tr>
                                <tr>
                                    <th>名前</th>
                                    <td>{{ $registration_request->firstname.'　'.$registration_request->lastname.'（'.$registration_request->firstruby.'　'.$registration_request->lastruby.'）' }}</td>
                                </tr>
                                <tr>
                                    <th>電話番号</th>
                                    <td>{{ $registration_request->phone }}</td>
                                </tr>
                                <tr>
                                    <th>住所</th>
                                    <td>
                                        {{ $registration_request->zip }}<br />
                                        {{ $registration_request->address }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>生年月日</th>
                                    <td>{{ $registration_request->birth_year }}年{{ $registration_request->birth_month }}月{{ $registration_request->birth_day }}日</td>
                                </tr>
                                <tr>
                                    <th>所属施設</th>
                                    <td>{{ $registration_request->facility }}</td>
                                </tr>
                                @if($registration_request->company_profile_id == "なし")
                                <tr>
                                    <th>所属施設所在地</th>
                                    <td>{{ $registration_request->other_facility_pref.$registration_request->other_facility_address }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>職種</th>
                                    <td>{{ $registration_request->job }}</td>
                                </tr>
                                @if($registration_request->job == "保育士・保育教諭")
                                <tr>
                                    <th>保育士番号所持状況</th>
                                    <td>{{ $registration_request->childminder_status }}</td>
                                </tr>
                                @if($registration_request->childminder_status == "保育士番号あり")
                                <tr>
                                    <th>保育士番号</th>
                                    <td>{{ $registration_request->childminder_number_pref }}{{ $registration_request->childminder_number_only }}</td>
                                </tr>
                                @endif
                                @endif
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
