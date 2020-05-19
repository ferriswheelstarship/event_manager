@extends('layouts.app')

@section('title', 'お問い合わせ 詳細')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">お問い合わせ詳細</div>

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
                            <a href="{{ route('inquiry.index') }}" class="btn btn-sm btn-info">お問い合わせ一覧</a>
                        </div>
                        <table class="table table-striped tbl-2column">
                            <tbody>
                                <tr>
                                    <th>送信日時</th>
                                    <td>@php echo date('Y年m月d日H時i分', strtotime($inquiry->created_at)); @endphp</td>
                                </tr>
                                <tr>
                                    <th>施設名または会社／組織名</th>
                                    <td>{{ $inquiry->cname }}</td>
                                </tr>
                                <tr>
                                    <th>氏名</th>
                                    <td>{{ $inquiry->name }}</td>
                                </tr>
                                <tr>
                                    <th>メールアドレス</th>
                                    <td>{{ $inquiry->email }}</td>
                                </tr>
                                <tr>
                                    <th>内容詳細</th>
                                    <td>{!! nl2br($inquiry->comment) !!}</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
