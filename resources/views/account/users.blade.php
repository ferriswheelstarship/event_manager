@if (count($users) > 0)
    <div class="table-responsive">
        <table class="table table-striped table-hover" id="data-table">
            <thead>
                <tr>
                    <!-- <th>ID</th> -->
                    <th>名前</th>
                    <th>メールアドレス</th>
                    <th>権限</th>
                    <th>アカウント</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)

                @php
                    $account_status_val = is_null($user->deleted_at) ? 1 : 2;
                @endphp
                <tr>
                    <!-- <td>{{ $user->id }}</td> -->
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                    @if($user->role_id)
                    {{ $role_array[$user->role_id] }}
                    @endif</td>
                    <td>{{ $account_status[$account_status_val]}}</td>
                    <td>
                    @can('system-only')
                        @if( $user->deleted_at )
                        {{ Form::open(['route' => ['account.restore', $user->id], 'method' => 'post']) }}
                            {{ Form::hidden('id', $user->id) }}
                            {{ Form::submit('アカウント復元', ['class' => 'btn btn-sm btn-primary']) }}
                        {{ Form::close() }}
                        {{ Form::open(['route' => ['account.forceDelete', $user->id], 'method' => 'delete']) }}
                            {{ Form::hidden('id', $user->id) }}
                            {{ Form::submit('アカウント削除', ['class' => 'btn btn-sm btn-danger']) }}
                        {{ Form::close() }}
                        @else
                        <a href="{{ url('account/'.$user->id) }}" class="btn btn-info btn-sm">詳細</a>
                        <a href="{{ url('account/edit/'.$user->id) }}" class="btn btn-primary btn-sm">編集</a>
                        <a>
                        {{ Form::open(['route' => ['account.softDelete', $user->id], 'method' => 'delete']) }}
                            {{ Form::hidden('id', $user->id) }}
                            {{ Form::submit('アカウント休止', ['class' => 'btn btn-sm btn-danger']) }}
                        {{ Form::close() }}
                        </a>
                        @endif

                    @elsecan('admin-only')
                        <a href="{{ url('account/trimcompany/'.$user->id) }}" class="btn btn-danger btn-sm">所属解除</a>
                    @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif