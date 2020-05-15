@extends('layouts.app')
@section('title', 'インフォメーション一覧')

@section('each-head')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.20/r-2.2.3/sp-1.0.1/datatables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.20/r-2.2.3/sp-1.0.1/datatables.min.js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">インフォメーション 一覧</div>
                    
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
                            <a href="{{ route('information.create') }}" class="btn btn-sm btn-primary">記事登録</a>                            
                        </div>

                        @if (count($infos) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped tbl-withheading data-table-no-order">
                                <thead class="thead">
                                    <tr>
                                        <!-- <th>ID</th> -->
                                        <th class="text-nowrap">日時</th>
                                        <th class="text-nowrap">タイトル</th>
                                        <th class="text-nowrap">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($infos as $info)
                                    <tr>
                                        <td data-label="開催日：">
                                            @php
                                            echo date('Y年m月d日', strtotime($info['article_date']));
                                            @endphp
                                        </td>
                                        <td data-label="タイトル：">{{ $info['title'] }}</td>
                                        <td data-lavel="操作：">

                                            <button type="button" class="forcedelete-confirm btn-sm btn-danger" value="{{ $info['id'] }}" 
                                            data-toggle="modal" data-target="#confirm-forcedelete{{ $info['id'] }}">削除</button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="confirm-forcedelete{{ $info['id'] }}" tabindex="-1">
                                                <div class="modal-dialog" role="document">
                                                    <form role="form" class="form-inline" method="POST" action="{{ route('information.destroy', $info['id']) }}">
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
                                                        <strong>{{ $info['title'] }}</strong>を本当に削除してよろしいですか？<br>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                                        <button type="submit" class="btn btn-danger">削除</button>
                                                    </div>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <a href="{{ url('information/'.$info['id']) }}" class="btn btn-info btn-sm">詳細</a>
                                            <a href="{{ url('information/'.$info['id'] .'/edit') }}" class="btn btn-primary btn-sm">編集</a>
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
