@extends('layouts.app')

@section('title', '退会')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 ">
                <div class="card">
                    <div class="card-header">退会</div>

                    <div class="card-body">

                        @if (count($errors) > 0)
                        <div class="mb-3">
                            <div class="alert alert-danger" role="alert">入力エラーがあります。</div>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('account.withdrawal') }}">
                            {{ csrf_field() }}

                            <input type="hidden" name="id" value="{{ $user_self->id }}">

                            <div class="form-group row">
                                <label for="withdrawalreason" class="col-md-12 col-form-label">退会理由</label>
                                <div class="col-md-12">
                                    <textarea name="withdrawalreason" 
                                    class="form-control{{ $errors->has('withdrawalreason') ? ' is-invalid' : '' }}"
                                    id="" cols="30" rows="10">{{ old('withdrawalreason') }}</textarea>

                                    @if ($errors->has('withdrawalreason'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('withdrawalreason') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-danger">
                                        退会する
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
