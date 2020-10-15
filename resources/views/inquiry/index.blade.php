@extends('layouts.app')
@section('title', 'お問い合わせ 一覧')

@section('each-head')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.20/r-2.2.3/sp-1.0.1/datatables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.20/r-2.2.3/sp-1.0.1/datatables.min.js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">お問い合わせ 一覧</div>
                    
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

                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a href="#tab1" class="nav-link active" data-toggle="tab">一般お問い合わせ</a>
                            </li>
                            <li class="nav-item">
                                <a href="#tab2" class="nav-link" data-toggle="tab">ユーザ登録代行依頼</a>
                            </li>
                        </ul>
                        <div class="tab-content p-3 border border-top-0">

                        <div id="tab1" class="tab-pane active">

                        @if (count($inquirys) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped tbl-withheading data-table-no-order">
                                <thead class="thead">
                                    <tr>
                                        <th class="text-nowrap">送信日時</th>
                                        <th class="text-nowrap">施設名または会社／組織名</th>
                                        <th class="text-nowrap">氏名</th>
                                        <th class="text-nowrap">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inquirys as $chunk)
                                    @foreach ($chunk as $inquiry)
                                    <tr>
                                        <td data-label="送信日時：">
                                            @php
                                            echo date('Y年m月d日H時i分', strtotime($inquiry->created_at));
                                            @endphp
                                        </td>
                                        <td data-label="施設名または会社／組織名：">{{ $inquiry->cname }}</td>
                                        <td data-label="氏名：">{{ $inquiry->name }}</td>
                                        <td data-lavel="操作：">
                                            <a href="{{ url('inquiry/'.$inquiry->id) }}" class="btn btn-info btn-sm">詳細</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif

                        </div>

                        <div id="tab2" class="tab-pane">
                        @if (count($registration_requests) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped tbl-withheading data-table-no-order">
                                <thead class="thead">
                                    <tr>
                                        <th class="text-nowrap">送信日時</th>
                                        <th class="text-nowrap">氏名</th>
                                        <th class="text-nowrap">電話番号</th>
                                        <th class="text-nowrap">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($registration_requests as $chunk)
                                    @foreach ($chunk as $registration_request)
                                    <tr>
                                        <td data-label="送信日時：">
                                            @php
                                            echo date('Y年m月d日H時i分', strtotime($registration_request->created_at));
                                            @endphp
                                        </td>
                                        <td data-label="氏名：">{{ $registration_request->firstname."　".$registration_request->lastname }}<br />
                                        {{ "（".$registration_request->firstruby."　".$registration_request->lastruby."）" }}</td>
                                        <td data-label="電話番号">{{ $registration_request->phone }}</td>
                                        <td data-lavel="操作：">
                                            <a href="{{ url('registration_request/'.$registration_request->id) }}" class="btn btn-info btn-sm">詳細</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection                    

@section('each-js')
    <script src="{{ asset('js/datatables_base.js') }}" ></script>
@endsection
