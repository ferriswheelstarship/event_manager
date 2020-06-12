@extends('layouts.app')

@section('title', 'メール編集')

@section('each-head')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">メール編集</div>

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

                        <form method="POST" action="{{ route('mail.update',['id' => $email->id]) }}" >
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="PUT">

                            <div class="form-group row">
                                <label for="default_group" class="col-md-4 col-form-label text-md-right">送信先</label>
                                <div class="col-md-6">
                                    <select id="default_group" 
                                        class="form-control{{ $errors->has('default_group') ? ' is-invalid' : '' }}" 
                                        name="default_group"
                                        onchange="changeEmailGroup(this.value)">
                                        <option value="">----</option>
                                        @foreach ($group as $key => $val)
                                            <option value="{{ $val }}"
                                                @if(old('default_group',$email->default_group) == $val) selected @endif>{{ $val }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('default_group'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('default_group') }}</strong>
                                        </span>
                                    @endif

                                    <div
                                    id="event_group"
                                    style="display: 
                                    @if(old('default_group',$email->default_group) != '研修ごとの参加（予定）者') 
                                    none
                                    @endif "
                                    class="my-1">
                                        <select id="event_group" 
                                            class="select-search-resolve form-control{{ $errors->has('event_group') ? ' is-invalid' : '' }}" 
                                            name="event_group"
                                            style="width:100%">
                                            <option value="">研修を選択して下さい</option>
                                            @foreach ($events as $key => $event)
                                                <option value="{{ $event->id }}"
                                                    @if(old('event_group',$email->event_group) == $event->title) selected @endif>{{ $event->title }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('event_group'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('event_group') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="text-danger mx-1">※選択した権限を持つユーザ全てに送信されます。</div>
                                </div>                                
                            </div>

                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">件名</label>
                                <div class="col-md-6">
                                    <input id="title" type="text" 
                                        class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" 
                                        name="title" value="{{ old('title',$email->title) }}" required>
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="comment" class="col-md-4 col-form-label text-md-right">本文</label>
                                <div class="col-md-6">
                                    <textarea 
                                        id="comment" class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}" 
                                        name="comment" rows="10" required>{{ old('comment',$email->comment) }}</textarea>

                                    @if ($errors->has('comment'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('comment') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <input type="submit" name="action" value="下書き保存" class="btn btn-primary" />
                                    <input type="submit" name="action" value="メール送信" class="btn btn-primary" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('each-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/i18n/ja.js"></script>
<script src="{{ asset('js/email-form-event.js') }}" ></script>
<script src="{{ asset('js/select-search.js') }}" ></script>
@endsection
