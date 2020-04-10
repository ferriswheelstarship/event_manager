@extends('layouts.app')
@section('title', '研修一覧')

@section('each-head')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.20/r-2.2.3/sp-1.0.1/datatables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.20/r-2.2.3/sp-1.0.1/datatables.min.js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">申込一覧（研修から）</div>
                    
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
                            <table class="table table-striped" id="data-table">
                                <thead>
                                    <tr>
                                        <!-- <th>ID</th> -->
                                        <th class="text-nowrap">状態</th>
                                        <th class="text-nowrap">申込数 / 定員</th>
                                        <th class="text-nowrap">開催日</th>
                                        <th class="text-nowrap">研修タイトル</th>
                                        <th class="text-nowrap">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $event)
                                    <tr>
                                        <td>
                                            <span>{{ $event['status']}}</span>
                                        </td>
                                        <td>
                                            <span>{{ $event['entrys_cnt'] }} / {{ $event['capacity'] }}</span>
                                        </td>
                                        <td>
                                            @foreach ($event['event_dates'] as $key => $edate)
                                            @php
                                            echo date('Y年m月d日', strtotime($edate->event_date));
                                            @endphp
                                            @if(!$loop->last),@endif
                                            @endforeach
                                        </td>
                                        <td>{{ $event['title'] }}</td>
                                        <td>
                                            <a href="{{ url('entry/'.$event['id']) }}" class="btn btn-info btn-sm">申込者一覧</a>
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
