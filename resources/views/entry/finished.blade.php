@extends('layouts.app')
@section('title', '申込管理（受付終了した研修）')

@section('each-head')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.20/r-2.2.3/sp-1.0.1/datatables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.20/r-2.2.3/sp-1.0.1/datatables.min.js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">申込管理（受付終了した研修）</div>
                    
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

                    @if (count($events) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped tbl-withheading" id="data-table">
                                <thead class="thead">
                                    <tr>
                                        <th class="text-nowrap">開催日</th>
                                        <th class="text-nowrap">申込数 / 定員</th>
                                        <th class="text-nowrap">研修タイトル</th>
                                        <th class="text-nowrap">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $event)
                                    <tr>
                                        <td data-label="開催日：">
                                            @foreach ($event['event_dates'] as $key => $edate)
                                            @php
                                            echo date('Y年m月d日', strtotime($edate->event_date));
                                            @endphp
                                            @if(!$loop->last) <br> @endif
                                            @endforeach
                                        </td>
                                        <td data-label="申込数/定員：">
                                            <span>{{ $event['entrys_cnt'] }} / {{ $event['capacity'] }}</span>
                                        </td>
                                        <td data-label="開催日：">{{ $event['title'] }}</td>
                                        <td  data-label="操作：">
                                            <a href="{{ url('entry/'.$event['id']) }}" class="btn btn-info btn-sm">申込者一覧</a>
                                            <a href="{{ url('event/'.$event['id']) }}" class="btn btn-primary btn-sm">研修詳細</a>
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
