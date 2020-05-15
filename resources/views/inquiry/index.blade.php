@extends('layouts.app')
@section('title', 'お問い合わせ')

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
                                    @foreach ($inquirys as $inquiry)
                                    <tr>
                                        <td data-label="送信日時：">
                                            @php
                                            echo date('Y年m月d日H時i分', strtotime($inquiry['created_at']));
                                            @endphp
                                        </td>
                                        <td data-label="施設名または会社／組織名：">{{ $inquiry['cname'] }}</td>
                                        <td data-label="氏名：">{{ $inquiry['name'] }}</td>
                                        <td data-lavel="操作：">
                                            <a href="{{ url('inquiry/'.$inquiry['id']) }}" class="btn btn-info btn-sm">詳細</a>
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
@endsection                    

@section('each-js')
    <script src="{{ asset('js/datatables_base.js') }}" ></script>
@endsection
