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

                    <div class="card-body">
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
