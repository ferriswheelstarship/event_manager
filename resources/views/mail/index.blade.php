@extends('layouts.app')
@section('title', 'メール一覧')

@section('each-head')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.20/r-2.2.3/sp-1.0.1/datatables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.20/r-2.2.3/sp-1.0.1/datatables.min.js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">メール一覧</div>

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
                            <a href="{{ route('mail.create') }}" class="btn btn-sm btn-info">メール作成</a>
                            <!-- <a href="{{ route('mailgroup.index') }}" class="btn btn-sm btn-info">グループ一覧</a>
                            <a href="{{ route('mailgroup.create') }}" class="btn btn-sm btn-info">グループ作成</a> -->
                        </div>

                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a href="#tab1" class="nav-link active" data-toggle="tab">下書き</a>
                            </li>
                            <li class="nav-item">
                                <a href="#tab2" class="nav-link" data-toggle="tab">送信済</a>
                            </li>
                        </ul>

                        <div class="tab-content p-3 border border-top-0">

                        <div id="tab1" class="tab-pane active">
                            <div class="row p-3">
                                <h3 class="h5 col-md-4">下書き</h3>
                            </div>
                            @if (count($email_drafts) > 0)
                            <div class="table-responsive">
                                <table class="table table-striped tbl-withheading" id="data-table1">
                                    <thead class="thead">
                                        <tr>
                                            <!-- <th>ID</th> -->
                                            <th class="text-nowrap">作成日時</th>
                                            <th class="text-nowrap">件名</th>
                                            <th class="text-nowrap">送信先</th>
                                            <th class="text-nowrap">操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($email_drafts as $item)
                                        <tr>
                                            <td data-label="作成日時">
                                                <span>{{ $item['created_at'] }}</span>
                                            </td>
                                            <td data-label="件名：">
                                                <span>{{ $item['title'] }}</span>
                                            </td>
                                            <td data-label="送信先：">
                                                <span>{{ $item['default_group'] }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('mail.edit',['id' => $item['id']]) }}" 
                                                class="btn btn-sm btn-primary">編集 / メール送信</a>
                                                <button type="button" class="delete-confirm btn btn-sm btn-danger"
                                                    value="{{ $item['id'] }}" 
                                                    data-toggle="modal" 
                                                    data-target="#confirm-delete{{ $item['user_id'] }}">削除</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>

                        <div id="tab2" class="tab-pane">
                            <div class="row p-3">
                                <h3 class="h5 col-md-4">送信済</h3>
                            </div>
                            @if (count($email_finished) > 0)
                            <div class="table-responsive">
                                <table class="table table-striped tbl-withheading" id="data-table2">
                                    <thead class="thead">
                                        <tr>
                                            <!-- <th>ID</th> -->
                                            <th class="text-nowrap">送信日時</th>
                                            <th class="text-nowrap">件名</th>
                                            <th class="text-nowrap">送信先</th>
                                            <th class="text-nowrap">操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($email_finished as $item)
                                        <tr>
                                            <td data-label="作成日時">
                                                <span>{{ $item['updated_at'] }}</span>
                                            </td>
                                            <td data-label="件名：">
                                                <span>{{ $item['title'] }}</span>
                                            </td>
                                            <td data-label="送信先：">
                                                <span>{{ $item['default_group'] }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('mail.show',['id' => $item['id']]) }}" 
                                                class="btn btn-sm btn-info">詳細</a>
                                            </td>
                                        </tr>
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
