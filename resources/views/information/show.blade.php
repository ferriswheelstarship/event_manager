@extends('layouts.app')

@section('title', '記事詳細'.$information->title)

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">インフォメーション 記事詳細</div>

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
                            <a href="{{ route('information.index') }}" class="btn btn-sm btn-info">記事一覧</a>
                            <a href="{{ route('information.edit',['id' => $information->id]) }}" class="btn btn-sm btn-primary">変更</a>
                        </div>
                        @else
                        <div class="mb-4">
                            @can('user-only')
                            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-info">ダッシュボード</a>
                            @elsecan('admin-only')
                            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-info">ダッシュボード</a>
                            @endcan
                        </div>
                        @endcan
                        <table class="table table-striped tbl-2column">
                            <tbody>
                                <tr>
                                    <th>タイトル</th>
                                    <td>{{ $information->title }}</td>
                                </tr>
                                <tr>
                                    <th>日付</th>
                                    <td>@php echo date('Y年m月d日H時i分', strtotime($information->article_date)); @endphp</td>
                                </tr>
                                <tr>
                                    <th>内容詳細</th>
                                    <td>{!! nl2br($information->comment) !!}</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
