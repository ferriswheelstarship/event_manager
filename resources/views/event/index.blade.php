@extends('layouts.app')
@section('title', '研修一覧')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">研修一覧</div>
                    
                    @if (Session::has('status'))
                    <div class="card-body">
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>                        
                    </div>
                    @endif
                    <div class="card-body">

@if (count($events) > 0)
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <!-- <th>ID</th> -->
                    <th>研修タイトル</th>
                    <th>ステータス</th>
                    <th>開催日</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $event)
                <tr>
                    <td>{{ $event['title'] }}</td>
                    <td>
                        <span>{{ $event['status']}}</span>
                    </td>
                    <td>
                        @foreach ($event['event_dates'] as $key => $edate)
                        {{ $edate->event_date }}
                        @if(!$loop->last),@endif
                        @endforeach
                    </td>
                    <td>
                    @can('area-higher')
                        <a href="{{ url('event/'.$event['id']) }}" class="btn btn-info btn-sm">詳細</a>
                        <a href="{{ url('event/'.$event['id'] .'/edit') }}" class="btn btn-primary btn-sm">編集</a>
                        <a href="{{ url('event/'.$event['id']) }}" class="btn btn-danger btn-sm">削除</a>
                    @else
                        <a href="{{ url('event/'.$event['id']) }}" class="btn btn-danger btn-sm">詳細・申込</a>
                    @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $events->links('pagination::bootstrap-4') }}
@endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection                    
