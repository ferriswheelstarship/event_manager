@if (count($users) > 0)
    <div class="table-responsive">
        <table class="table table-striped tbl-withheading data-table-no-order">
            <thead class="thead">
                <tr>
                    <!-- <th>ID</th> -->
                    <th class="text-nowrap">名前</th>
                    <th class="text-nowrap">メールアドレス</th>
                    <th class="text-nowrap">権限</th>
                    <th class="text-nowrap">アカウント</th>
                    <th class="text-nowrap">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $chunk)
                @foreach ($chunk as $user)

                @php
                    $account_status_val = is_null($user->deleted_at) ? 1 : 2;
                @endphp
                <tr>
                    <!-- <td>{{ $user->id }}</td> -->
                    <td data-label="名前：">{{ $user->name }}</td>
                    <td data-label="メールアドレス：">{{ $user->email }}</td>
                    <td data-label="権限：">
                    @if($user->role_id)
                    {{ $role_array[$user->role_id] }}
                    @endif</td>
                    <td data-label="アカウント：">{{ $account_status[$account_status_val]}}</td>
                    <td>
                    @can('system-only')
                        @if( $user->deleted_at )
                        <button type="button" class="restore-confirm btn-sm btn-primary" value="{{ $user->id }}" data-toggle="modal" data-target="#confirm-restore{{ $user->id }}">復元</button>
                        <!-- {{ Form::open(['route' => ['account.restore', $user->id], 'method' => 'post']) }}
                            {{ Form::hidden('id', $user->id) }}
                            {{ Form::submit('アカウント復元', ['class' => 'btn btn-sm btn-primary']) }}
                        {{ Form::close() }} -->
                        <div class="modal fade" id="confirm-restore{{ $user->id }}" tabindex="-1">
                            <div class="modal-dialog" role="document">
                                <form role="form" class="form-inline" method="POST" action="{{ route('account.restore', $user->id) }}">
                                {{ csrf_field() }}
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">アカウント復元確認</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <strong>{{ $user->name }}</strong>を復元してよろしいですか？
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                    <button type="submit" class="btn btn-primary">復元</button>
                                </div>
                                </div>
                                </form>
                            </div>
                        </div>
                        <button type="button" class="forcedelete-confirm btn-sm btn-danger" value="{{ $user->id }}" data-toggle="modal" data-target="#confirm-forcedelete{{ $user->id }}">削除</button>
                        <!-- {{ Form::open(['route' => ['account.forceDelete', $user->id], 'method' => 'delete']) }}
                            {{ Form::hidden('id', $user->id) }}
                            {{ Form::submit('アカウント削除', ['class' => 'btn btn-sm btn-danger']) }}
                        {{ Form::close() }} -->
                        <!-- Modal -->
                        <div class="modal fade" id="confirm-forcedelete{{ $user->id }}" tabindex="-1">
                            <div class="modal-dialog" role="document">
                                <form role="form" class="form-inline" method="POST" action="{{ route('account.forceDelete', $user->id) }}">
                                {{ csrf_field() }}
                                <input name="_method" type="hidden" value="DELETE">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">削除確認</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <strong>{{ $user->name }}</strong>を本当に削除してよろしいですか？<br>
                                    削除した場合復元できませんのでご注意下さい。
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                    <button type="submit" class="btn btn-danger">削除</button>
                                </div>
                                </div>
                                </form>
                            </div>
                        </div>

                        @else
                        <a href="{{ url('account/'.$user->id) }}" class="btn btn-info btn-sm">詳細</a>
                        <a href="{{ url('account/edit/'.$user->id) }}" class="btn btn-primary btn-sm">変更</a>
                        <button type="button" class="delete-confirm btn-sm btn-danger" value="{{ $user->id }}" data-toggle="modal" data-target="#confirm-delete{{ $user->id }}">退会</button>
                        <!-- {{ Form::open(['route' => ['account.softDelete', $user->id], 'method' => 'delete']) }}
                            {{ Form::hidden('id', $user->id) }}
                            {{ Form::submit('アカウント休止', ['class' => 'btn btn-sm btn-danger']) }}
                        {{ Form::close() }} -->

                        <!-- Modal -->
                        <div class="modal fade" id="confirm-delete{{ $user->id }}" tabindex="-1">
                            <div class="modal-dialog" role="document">
                                <form role="form" class="form-inline" method="POST" action="{{ route('account.softDelete', $user->id) }}">
                                {{ csrf_field() }}
                                <input name="_method" type="hidden" value="DELETE">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">退会確認</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <strong>{{ $user->name }}</strong>を本当に退会にしてよろしいですか？
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                    <button type="submit" class="btn btn-danger">退会</button>
                                </div>
                                </div>
                                </form>
                            </div>
                        </div>
                        @endif

                    @elsecan('admin-only')
                        <button type="button" class="trimcompany-confirm btn-sm btn-danger" value="{{ $user->id }}" data-toggle="modal" data-target="#confirm-trimcompany{{ $user->id }}">所属解除</button>

                        <!-- Modal -->
                        <div class="modal fade" id="confirm-trimcompany{{ $user->id }}" tabindex="-1">
                            <div class="modal-dialog" role="document">
                                <form role="form" class="form-inline" method="POST" action="{{ route('account.trimcompany', $user->id) }}">
                                {{ csrf_field() }}
                                <input name="_method" type="hidden" value="PUT">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">所属解除確認</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <strong>{{ $user->name }}</strong>の施設所属を本当に解除してよろしいですか？<br>
                                    解除した場合、施設側より復元できませんのでご注意下さい。
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                    <button type="submit" class="btn btn-danger">所属解除</button>
                                </div>
                                </div>
                                </form>
                            </div>
                        </div>
                        
                    @endcan
                    </td>
                </tr>
                @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
@endif