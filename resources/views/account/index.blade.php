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
                    <div class="card-header">ユーザ一覧</div>


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
                        @can('system-only')
                        <div class="mb-4">
                            <button type="button" class="csv-confirm btn btn-sm btn-primary"
                                data-toggle="modal" data-target="#confirm-csv">CSVダウンロード</button>                                        
                        </div>
                        <div class="modal fade" id="confirm-csv" tabindex="-1">
                            <div class="modal-dialog" role="document">
                                <form role="form" class="form-inline" method="POST" action="{{ route('account.user_csv') }}">
                                {{ csrf_field() }}

                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">CSVダウンロード</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-2">権限を選択してダウンロードして下さい。</div>
                                    <select name="role_id" id="" class="form-control">
                                        @foreach($role_array as $key => $item)
                                        @if(!$loop->first)
                                        <option value="{{ $key }}"
                                        @if(old('role_id') == $key) selected @endif>{{ $item }}ユーザ</option>
                                        @endif
                                        @endforeach                                        
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                    <button type="submit" class="btn btn-primary">CSVダウンロード</button>
                                </div>
                                </div>
                                </form>
                            </div>
                        </div>                    
                        @endcan

                        @include('account.users', ['users' => $users])
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('each-js')
    <script src="{{ asset('js/datatables_base.js') }}" ></script>
@endsection
