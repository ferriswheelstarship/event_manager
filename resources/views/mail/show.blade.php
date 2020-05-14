@extends('layouts.app')

@section('title', 'メール詳細')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">メール詳細</div>

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
                            <a href="{{ route('mail.index') }}" class="btn btn-sm btn-info">メール一覧</a>
                            <!-- <a href="{{ route('mailgroup.index') }}" class="btn btn-sm btn-info">グループ一覧</a>
                            <a href="{{ route('mailgroup.create') }}" class="btn btn-sm btn-info">グループ作成</a> -->
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped tbl-2column">
                                <tbody>
                                    <tr>
                                        <th>送信日時</th>
                                        <td>{{ $email->updated_at }}</td>
                                    </tr>
                                    <tr>
                                        <th>送信先</th>
                                        <td>{{ $email->default_group }}</td>
                                    </tr>
                                    <tr>
                                        <th>件名</th>
                                        <td>{{ $email->title }}</td>
                                    </tr>
                                    <tr>
                                        <th>本文</th>
                                        <td>{!! nl2br($email->comment) !!}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
