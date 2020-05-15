@extends('layouts.app')
@section('title', 'ユーザ一覧')

@section('each-head')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.20/r-2.2.3/sp-1.0.1/datatables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.20/r-2.2.3/sp-1.0.1/datatables.min.js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">受講履歴（ユーザ一覧）</div>
                    
                    @if (Session::has('status'))
                    <div class="card-body">
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>                        
                    </div>
                    @endif

                    <div class="card-body">
                    @if (count($datas) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped tbl-withheading data-table-no-order">
                                <thead class="thead">
                                    <tr>
                                        <th class="text-nowrap">名前</th>
                                        <th class="text-nowrap">所属</th>
                                        <th class="text-nowrap">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $user)
                                    <tr>
                                        <td data-label="名前：">{{ $user['name'] }}（{{ $user['ruby'] }}）</td>
                                        <td data-label="所属：">{{ $user['companyname'] }}（{{ $user['city'] }}）</td>
                                        <td data-label="操作：">
                                            <a href="{{ url('history/user/'.$user['id']) }}" class="btn btn-info btn-sm">受講状況詳細</a>
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

@endsection

@section('each-js')
    <script src="{{ asset('js/datatables_base.js') }}" ></script>
@endsection
