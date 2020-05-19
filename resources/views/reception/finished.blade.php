@extends('layouts.app')
@section('title', '受付管理（終了した研修）')

@section('each-head')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.20/r-2.2.3/sp-1.0.1/datatables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.20/r-2.2.3/sp-1.0.1/datatables.min.js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">受付管理（終了した研修）</div>
                    
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
                                        <!-- <th>ID</th> -->
                                        <th class="text-nowrap">開催日</th>
                                        <th class="text-nowrap">受付数 / 受講券発行者数</th>
                                        <th class="text-nowrap">研修タイトル</th>
                                        <th class="text-nowrap">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $event)
                                    <tr>
                                        <td data-label="開催日：">
                                            @php
                                            echo date('Y年m月d日', strtotime($event['event_date']));
                                            @endphp                                            
                                        </td>
                                        <td data-label="受付数/受講券発行者数：">{{ $event['reception_cnt'] }} / {{ $event['entrys_cnt'] }}</td>
                                        <td data-label="研修タイトル：">{{ $event['title'] }}</td>
                                        <td>
                                            <a href="{{ url('reception/'.$event['event_id'].'-'.$event['event_date_id']) }}" class="btn btn-info btn-sm">受付者一覧</a>
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
