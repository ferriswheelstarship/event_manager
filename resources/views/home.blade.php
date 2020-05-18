@extends('layouts.app')

@section('title', 'ダッシュボード')

@section('content')
    <div class="container">
        <!-- <div class="row">
            <div class="col-md-12 mx-auto">
                <div class="card">
                    <div class="card-header">ダッシュボード</div>

                    <div class="card-body">                    
                        @can('system-only') {{-- 特権ユーザ権限に表示される --}}
                        あなたは特権管理者です。
                        @elsecan('area-only')　{{-- 支部ユーザ権限に表示される --}}
                        あなたは支部権限です。
                        @elsecan('admin-only')　{{-- 法人ユーザ権限に表示される --}}
                        あなたは法人権限です。
                        @elsecan('user-higher')　{{-- 個人ユーザに表示される --}}
                        あなたは個人ユーザです。
                        @endcan
                    </div>
                </div>
            </div>
        </div> -->
        @can('area-higher')
            @include('dashboard.areahigher')
        @else
            @include('dashboard.userandcompany')
        @endcan
    </div>
@endsection
