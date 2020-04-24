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
                    <div class="card-header">研修一覧</div>
                    
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
                    <th class="text-nowrap">研修タイトル</th>
                    <th class="text-nowrap">申込数 / 定員</th>
                    <th class="text-nowrap">申込受付状況</th>
                    @can('user-only')
                    <th class="text-nowrap">申込状態</th>
                    @endcan
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
                    <td data-label="研修名：">{{ $event['title'] }}</td>
                    <td data-label="申込数/定員：">
                        <span>{{ $event['entrys_cnt'] }} / {{ $event['capacity'] }}</span>
                    </td>
                    <td data-label="申込受付状況：">
                        <span>{{ $event['status']}}</span>
                    </td>
                    @can('user-only')
                    <td data-label="申込状態：">
                        {{ $event['entry_status']}} 
                        @if($event['entry_status'] == '申込済')
                        <br>
                        <a href="{{ route('ticket_pdf',['id' => Auth::id().'-'.$event['id']]) }}" target="_blank" class="btn btn-sm btn-info">受講券</a>
                        @endif
                    </td>
                    @endcan
                    <td data-lavel="操作：">
                    @can('area-higher')
                        @if($event['deleted_at'])

                        <button type="button" class="retsore-confirm btn-sm btn-primary" value="{{ $event['id'] }}" data-toggle="modal" data-target="#confirm-restore{{ $event['id'] }}">復元</button>
                        <!-- Modal -->
                        <div class="modal fade" id="confirm-restore{{ $event['id'] }}" tabindex="-1">
                            <div class="modal-dialog" role="document">
                                <form role="form" class="form-inline" method="POST" action="{{ route('event.restore', $event['id']) }}">
                                {{ csrf_field() }}

                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">復元</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <strong>{{ $event['title'] }}</strong>を復元してよろしいですか？
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                    <button type="submit" class="btn btn-danger">復元</button>
                                </div>
                                </div>
                                </form>
                            </div>
                        </div>

                        <button type="button" class="forcedelete-confirm btn-sm btn-danger" value="{{ $event['id'] }}" 
                        data-toggle="modal" data-target="#confirm-forcedelete{{ $event['id'] }}">削除</button>
                        <!-- Modal -->
                        <div class="modal fade" id="confirm-forcedelete{{ $event['id'] }}" tabindex="-1">
                            <div class="modal-dialog" role="document">
                                <form role="form" class="form-inline" method="POST" action="{{ route('event.forceDelete', $event['id']) }}">
                                {{ csrf_field() }}
                                <input name="_method" type="hidden" value="DELETE">

                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">削除確認</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <strong>{{ $event['title'] }}</strong>を本当に削除してよろしいですか？<br>
                                    削除を実行すると該当研修のデータが完全に削除され、申込データ等の閲覧ができなくなりますのでご注意下さい。
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                    <button type="submit" class="btn btn-danger">削除</button>
                                </div>
                                </div>
                                </form>
                            </div>
                        </div>

                        @else
                        <a href="{{ url('event/'.$event['id']) }}" class="btn btn-info btn-sm">詳細</a>
                        <a href="{{ url('event/'.$event['id'] .'/edit') }}" class="btn btn-primary btn-sm">編集</a>
                        <button type="button" class="delete-confirm btn-sm btn-danger" value="{{ $event['id'] }}" data-toggle="modal" data-target="#confirm-delete{{ $event['id'] }}">削除</button>
                        <!-- Modal -->
                        <div class="modal fade" id="confirm-delete{{ $event['id'] }}" tabindex="-1">
                            <div class="modal-dialog" role="document">
                                <form role="form" class="form-inline" method="POST" action="{{ route('event.destroy', $event['id']) }}">
                                {{ csrf_field() }}
                                <input name="_method" type="hidden" value="DELETE">

                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">削除確認</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <strong>{{ $event['title'] }}</strong>を本当に削除してよろしいですか？
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                    <button type="submit" class="btn btn-danger">削除</button>
                                </div>
                                </div>
                                </form>
                            </div>
                        </div>
                        @endif
                    @else
                        <a href="{{ url('event/'.$event['id']) }}" class="btn btn-primary btn-sm">詳細</a>
                    @endcan
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
