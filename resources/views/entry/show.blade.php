@extends('layouts.app')
@section('title', '申込者一覧')

@section('each-head')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.20/r-2.2.3/sp-1.0.1/datatables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.20/r-2.2.3/sp-1.0.1/datatables.min.js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">申込者一覧</div>
                    
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

                        <h2 class="h4 mb-5">【{{ $general_or_carrerup }}】{{ $event->title }}</h2>

                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a href="#tab1" class="nav-link active" data-toggle="tab">申込者</a>
                            </li>
                            <li class="nav-item">
                                <a href="#tab2" class="nav-link" data-toggle="tab">申込後キャンセル</a>
                            </li>
                            <li class="nav-item">
                                <a href="#tab3" class="nav-link" data-toggle="tab">キャンセル待ち申込者</a>
                            </li>
                        </ul>
                        <div class="tab-content p-3 border border-top-0">

                        <div id="tab1" class="tab-pane active">
                        <h3 class="h5">申込者 {{ count($entrys_y_view) }} / {{ $event->capacity }}名</h3>
                        @if (count($entrys_y_view) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped" id="data-table">
                                <thead>
                                    <tr>
                                        <!-- <th>ID</th> -->
                                        <th class="text-nowrap">氏名</th>
                                        <th class="text-nowrap">所属</th>
                                        <th class="text-nowrap">申込日時</th>
                                        <th class="text-nowrap">状況</th>
                                        <th class="text-nowrap">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($entrys_y_view as $entry)
                                    <tr>
                                        <td>
                                            <span>{{ $entry['user_name'] }}（{{ $entry['user_ruby'] }}）</span>
                                        </td>
                                        <td>
                                            <span>{{ $entry['company_name'] }}</span>
                                        </td>
                                        <td>{{ $entry['created'] }}</td>
                                        <td>{{ $entry['status'] }}</td>
                                        <td>
                                            <a href="" class="btn btn-sm btn-primary">受講券送信</a>
                                            @if($entry['status'] === '受講券発行済')
                                            <a href="" class="btn btn-sm btn-info">受講券確認</a>
                                            @endif
                                            <a href="" class="btn btn-sm btn-danger">キャンセル</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                        </div>

                        <div id="tab2" class="tab-pane">
                        <h3 class="h5">申込後キャンセル {{ count($entrys_yc_view) }}名</h3>
                        @if (count($entrys_yc_view) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped" id="data-table">
                                <thead>
                                    <tr>
                                        <!-- <th>ID</th> -->
                                        <th class="text-nowrap">氏名</th>
                                        <th class="text-nowrap">所属</th>
                                        <th class="text-nowrap">申込日時</th>
                                        <th class="text-nowrap">状況</th>
                                        <th class="text-nowrap">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($entrys_yc_view as $entry)
                                    <tr>
                                        <td>
                                            <span>{{ $entry['user_name'] }}（{{ $entry['user_ruby'] }}）</span>
                                        </td>
                                        <td>
                                            <span>{{ $entry['company_name'] }}</span>
                                        </td>
                                        <td>{{ $entry['created'] }}</td>
                                        <td>{{ $entry['status'] }}</td>
                                        <td>
                                            @if($entry['status'] != '受講券発行済')
                                            <a href="" class="btn btn-sm btn-danger">削除</a>
                                            @else
                                            受講券発行済（入金済）のため削除不可
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                        </div>

                        <div id="tab3" class="tab-pane">
                        <h3 class="h5">キャンセル待ち申込者 {{ count($entrys_cw_view )}}名</h3>
                        @if (count($entrys_cw_view) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped" id="data-table">
                                <thead>
                                    <tr>
                                        <!-- <th>ID</th> -->
                                        <th class="text-nowrap">氏名</th>
                                        <th class="text-nowrap">所属</th>
                                        <th class="text-nowrap">申込日時</th>
                                        <th class="text-nowrap">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($entrys_cw_view as $entry)
                                    <tr>
                                        <td>
                                            <span>{{ $entry['user_name'] }}（{{ $entry['user_ruby'] }}）</span>
                                        </td>
                                        <td>
                                            <span>{{ $entry['company_name'] }}</span>
                                        </td>
                                        <td>{{ $entry['created'] }}</td>
                                        <td>
                                            <a href="" class="btn btn-sm btn-primary">申込者へ繰り上げ</a>
                                            <a href="" class="btn btn-sm btn-danger">削除</a>
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
</div>
@endsection                    

