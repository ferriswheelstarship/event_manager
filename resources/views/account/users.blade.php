@if (count($users) > 0)
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>名前</th>
                    <th>メールアドレス</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ url('account/'.$user->id) }}" class="btn btn-primary btn-sm">詳細</a>
                        <a href="{{ url('account/edit/'.$user->id) }}" class="btn btn-primary btn-sm">編集</a>
                        <a href="{{ url('account/delete/'.$user->id) }}" class="btn btn-danger btn-sm">削除</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $users->links('pagination::bootstrap-4') }}
@endif