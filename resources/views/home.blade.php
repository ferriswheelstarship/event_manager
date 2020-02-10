@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mx-auto">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">                    
                        @can('system-only') {{-- 特権ユーザ権限に表示される --}}
                        <p>あなたは特権管理者です。</p>
                        @elsecan('area-only')　{{-- 支部ユーザ権限に表示される --}}
                        <p>あなたは支部権限です。</p>
                        @elsecan('admin-only')　{{-- 法人ユーザ権限に表示される --}}
                        <p>あなたは法人権限です。</p>
                        @elsecan('user-higher')　{{-- 個人ユーザに表示される --}}
                        <p>あなたは個人ユーザです。</p>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
