@extends('layouts.app')

@section('title', '記事作成')

@section('each-head')
<script src="{{ asset('js/jquery.datetimepicker.full.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/jquery.datetimepicker.min.css') }}">
<script>
$(function(){
    $('#article_date').datetimepicker({
        format:'Y-m-d',
        lang:'ja'
    });
});
</script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">インフォメーション記事登録</div>

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

                        <div class="mb4">
                            <a href="{{ route('information.index') }}" class="btn btn-sm btn-info">記事一覧</a>                            
                        </div>
                    
                        <form method="POST" action="{{ route('information.store') }}" >
                            {{ csrf_field() }}

                            <div class="form-group row">
                                <label for="comment" class="col-md-4 col-form-label text-md-right">掲載日</label>
                                <div class="col-md-6">
                                    <input
                                        id="article_date" type="text"
                                        class="datetimepicker form-control{{ $errors->has('article_date') ? ' is-invalid' : '' }}"
                                        name="article_date" value="{{ old('article_date') }}" required>
                                    @if ($errors->has('article_date'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('article_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">タイトル</label>
                                <div class="col-md-6">
                                    <input id="title" type="text" 
                                        class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" 
                                        name="title" value="{{ old('title') }}" required>
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="comment" class="col-md-4 col-form-label text-md-right">内容詳細</label>
                                <div class="col-md-6">
                                    <textarea 
                                        id="comment" class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}" 
                                        name="comment" rows="10" required>{{ old('comment') }}</textarea>

                                    @if ($errors->has('comment'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('comment') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        送信
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
