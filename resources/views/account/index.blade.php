@extends('layouts.app')
@section('title', 'ユーザ一覧')
@section('content')
<div class="">
    @include('account.users', ['users' => $users])
</div>
@endsection