@extends('layouts.app')
@section('title', 'ユーザ一覧')
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
</div>
@endsection