@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    {{ $authlevel }}<br />                    

                    @can('system-only') {{-- 特権ユーザ権限のみに表示される --}}
                    <p>あなたは特権管理者です。</p>
                    @elsecan('admin-higher')　{{-- 法人ユーザ権限以上に表示される --}}
                    <p>あなたは法人権限です。</p>
                    @elsecan('user-higher')　{{-- 個人ユーザ権限以上（全ユーザ）に表示される --}}
                    <p>あなたは個人ユーザです。</p>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
