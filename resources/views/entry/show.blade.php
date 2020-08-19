@extends('layouts.app')
@section('title', '申込者一覧')

@section('each-head')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.20/r-2.2.3/sp-1.0.1/datatables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.20/r-2.2.3/sp-1.0.1/datatables.min.js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">申込者一覧</div>
                    
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

                        <h2 class="h4 mb-4">【{{ $general_or_carrerup }}】{{ $event->title }}</h2>

                        <div class="mb-4">
                            <a href="{{ route('entry.index') }}" class="btn btn-sm btn-info">一覧へ戻る</a>
                        </div>

                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a href="#tab1" class="nav-link active" data-toggle="tab">申込者</a>
                            </li>
                            <li class="nav-item">
                                <a href="#tab2" class="nav-link" data-toggle="tab">申込後キャンセル</a>
                            </li>
                            <li class="nav-item">
                                <a href="#tab3" class="nav-link" data-toggle="tab">キャンセル待ち</a>
                            </li>
                        </ul>
                        <div class="tab-content p-3 border border-top-0">

                        <div id="tab1" class="tab-pane active">
                        <div class="row p-3">
                            <h3 class="h5 col-md-4">申込者 {{ count($entrys_y_view) }}名/ 定員 {{ $event->capacity }}名</h3>
                            <div class="col-md-8">
                                <button type="button" class="allticketsend-confirm btn btn-sm btn-primary"
                                data-toggle="modal" data-target="#confirm-allticketsend">受講券一斉発行</button>

                                <button type="button" class="csv-confirm btn btn-sm btn-primary"
                                data-toggle="modal" data-target="#confirm-csv">CSVダウンロード</button>                                        

                                <a href="{{ route('ticket_pdf',['id' => Auth::id().'-'.$event->id]) }}" target="_blank" class="btn btn-sm btn-info">受講券プレビュー</a>
                            </div>
                        </div>

                        @can('area-higher')
                        <div class="modal fade" id="confirm-allticketsend" tabindex="-1">
                            <div class="modal-dialog" role="document">
                                <form role="form" class="form-inline" method="POST" action="{{ route('entry.allticketsend') }}">
                                {{ csrf_field() }}

                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">CSVダウンロード</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    受講券未発行のユーザ全てに一斉に受講券を発券しますがよろしいですか？<br />
                                    (メール通知も届きます)
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                    <button type="submit" class="btn btn-primary">受講券一斉発行</button>
                                </div>
                                </div>
                                </form>
                            </div>
                        </div>
                        
                        <div class="modal fade" id="confirm-csv" tabindex="-1">
                            <div class="modal-dialog" role="document">
                                <form role="form" class="form-inline" method="POST" action="{{ route('entry.entry_csv') }}">
                                {{ csrf_field() }}

                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">CSVダウンロード</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    申込完了ユーザの一覧をCSVでダウンロードしますか？
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                    <button type="submit" class="btn btn-primary">CSVダウンロード</button>
                                </div>
                                </div>
                                </form>
                            </div>
                        </div>                    
                        @endcan

                        @if (count($entrys_y_view) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped tbl-withheading data-table-no-order">
                                <thead class="thead">
                                    <tr>
                                        <!-- <th>ID</th> -->
                                        <th class="text-nowrap">氏名</th>
                                        <th class="text-nowrap">所属</th>
                                        <th class="text-nowrap">申込日時</th>
                                        <th class="text-nowrap">状況</th>
                                        <th class="text-nowrap">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($entrys_y_view as $entry)
                                    <tr>
                                        <td data-label="氏名：">
                                            <span>{{ $entry['user_name'] }}<br/>
                                            （{{ $entry['user_ruby'] }}）</span>
                                        </td>
                                        <td data-label="所属：">
                                            <span>{{ $entry['company_name'] }}</span>
                                        </td>
                                        <td data-label="申込日時：">{{ $entry['created'] }}</td>
                                        <td data-label="状況：">{{ $entry['status'] }}</td>
                                        <td>
                                            @if($entry['user_deleted_at'])
                                                ユーザ退会済のため受講券の操作不可<br>
                                                <button type="button" class="cancel-confirm btn btn-sm btn-danger"
                                                    value="{{ $entry['user_id'] }}" 
                                                    data-toggle="modal" data-target="#confirm-cancel{{ $entry['user_id'] }}">キャンセル</button>
                                            @else
                                                @if($entry['status'] === '受講券発行済')
                                                <a href="{{ route('ticket_pdf',['id' => $entry['user_id'].'-'.$event->id]) }}" target="_blank" class="btn btn-sm btn-info">受講券表示</a>
                                                @endif
                                                <button type="button" class="apply-confirm btn btn-sm btn-primary" 
                                                    value="{{ $entry['user_id'] }}" 
                                                    data-toggle="modal" data-target="#confirm-ticketsend{{ $entry['user_id'] }}">受講券送信</button>
                                                <button type="button" class="cancel-confirm btn btn-sm btn-danger"
                                                    value="{{ $entry['user_id'] }}" 
                                                    data-toggle="modal" data-target="#confirm-cancel{{ $entry['user_id'] }}">キャンセル</button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                        </div>

                        <div id="tab2" class="tab-pane">
                        <div class="row p-3">
                            <h3 class="h5 col-md-3 mb-4">申込後キャンセル {{ count($entrys_yc_view) }}名</h3>
                            <p class="px-3 text-danger h6">※申込数の合計は<strong>申込者数</strong>と<strong>申込後キャンセル数</strong>を合算してユーザへは表示されます。<br>
                            定員に達した場合でキャンセル待ちの繰り上げを行う際、こちらから削除を行う事で繰り上げが可能になります。</p>
                        </div>
                        @if (count($entrys_yc_view) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped tbl-withheading data-table-no-order">
                                <thead class="thead">
                                    <tr>
                                        <!-- <th>ID</th> -->
                                        <th class="text-nowrap">氏名</th>
                                        <th class="text-nowrap">所属</th>
                                        <th class="text-nowrap">申込日時</th>
                                        <th class="text-nowrap">状況</th>
                                        <th class="text-nowrap">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($entrys_yc_view as $entry)
                                    <tr>
                                        <td data-label="氏名：">
                                            <span>{{ $entry['user_name'] }}<br/>
                                            （{{ $entry['user_ruby'] }}）</span>
                                        </td>
                                        <td data-label="所属：">
                                            <span>{{ $entry['company_name'] }}</span>
                                        </td>
                                        <td data-label="申込日時：">{{ $entry['created'] }}</td>
                                        <td data-label="状況：">{{ $entry['status'] }}</td>
                                        <td>
                                            @if($entry['user_deleted_at'])
                                                ユーザ退会済<br />
                                            @endif
                                            @if($entry['status'] != '受講券発行済')                                            
                                            <button type="button" class="delete-confirm btn btn-sm btn-danger"
                                                value="{{ $entry['user_id'] }}" 
                                                data-toggle="modal" data-target="#confirm-delete{{ $entry['user_id'] }}">削除</button>
                                            @else
                                            削除不可<br>（受講券発行済）
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                        </div>

                        <div id="tab3" class="tab-pane">
                        <div class="row p-3">
                            <h3 class="h5 col-md-3">キャンセル待ち {{ count($entrys_cw_view )}}名</h3>
                        </div>
                        @if (count($entrys_cw_view) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped tbl-withheading data-table-no-order">
                                <thead class="thead">
                                    <tr>
                                        <!-- <th>ID</th> -->
                                        <th class="text-nowrap">氏名</th>
                                        <th class="text-nowrap">所属</th>
                                        <th class="text-nowrap">申込日時</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($entrys_cw_view as $entry)
                                    <tr>
                                        <td data-label="氏名：">
                                            <span>{{ $entry['user_name'] }}（{{ $entry['user_ruby'] }}）</span>
                                        </td>
                                        <td data-label="所属：">
                                            <span>{{ $entry['company_name'] }}</span>
                                        </td>
                                        <td data-label="申込日時：">{{ $entry['created'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                        </div>

                        </div>

                        @if (count($entrys_y_view) > 0)
                            @foreach ($entrys_y_view as $entry) 
                            <!-- Modal(ticketsend) -->
                            <div class="modal fade" id="confirm-ticketsend{{ $entry['user_id'] }}" tabindex="-1">
                                <div class="modal-dialog" role="document">
                                    <form role="form" class="form-inline" method="POST" action="{{ route('entry.ticketsend') }}">
                                    {{ csrf_field() }}

                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">受講券送信 確認</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <strong>ユーザ：{{ $entry['user_name'] }} </strong><br><br>
                                        <p><strong>{{ $event->title }}</strong>の受講券を発行しますか？<br><br>
                                        @if($entry['status'] === '受講券未')
                                        <span class="text-danger">一度受講券を発行するとステータスが<strong>{{ $entry['status'] }}</strong>となります。<br>
                                        受講券を案内して問題ないかご確認ください。</span>
                                        @else
                                        <span class="text-danger">当ユーザへは<strong>{{ $entry['status'] }}</strong>です。<br>
                                        再度メールを案内することになりますが本当によろしいですか？</span>
                                        @endif
                                        </p>
                                        <input type="hidden" name="user_id" value="{{ $entry['user_id'] }}">
                                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                        <button type="submit" class="btn btn-primary">受講券をメールで案内</button>
                                    </div>
                                    </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Modal(cancel) -->
                            <div class="modal fade" id="confirm-cancel{{ $entry['user_id'] }}" tabindex="-1">
                                <div class="modal-dialog" role="document">
                                    <form role="form" class="form-inline" method="POST" action="{{ route('entry.cancel') }}">
                                    {{ csrf_field() }}

                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">受講キャンセル 確認</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <strong>ユーザ：{{ $entry['user_name'] }} </strong><br><br>
                                        <p><strong>{{ $event->title }}</strong>の受講をキャンセルしますか？<br><br>
                                        @if($entry['status'] === '受講券未')
                                        <span class="text-danger">当ユーザはステータスが<strong>{{ $entry['status'] }}</strong>です。<br>
                                        キャンセル後は「申込後キャンセル」タブでデータが残ります。<br>
                                        必要に応じて「削除」、「キャンセル待ち繰り上げ」を行って下さい。</span>
                                        @else
                                        <span class="text-danger">当ユーザへは<strong>受講券発行済</strong>です。<br>
                                        キャンセル後は「申込後キャンセル」タブでデータが残りますが、すでに受講券発行しているため削除することが出来ませんので予めご注意下さい。</span>
                                        @endif
                                        </p>
                                        <input type="hidden" name="user_id" value="{{ $entry['user_id'] }}">
                                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                        <button type="submit" class="btn btn-danger">受講キャンセル</button>
                                    </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        @endif

                        @if (count($entrys_yc_view) > 0)
                            @foreach ($entrys_yc_view as $entry) 
                            <!-- Modal(delete) -->
                            <div class="modal fade" id="confirm-delete{{ $entry['user_id'] }}" tabindex="-1">
                                <div class="modal-dialog" role="document">
                                    <form role="form" class="form-inline" method="POST" action="{{ route('entry.delete') }}">
                                    {{ csrf_field() }}

                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">申込削除 確認</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <strong>ユーザ：{{ $entry['user_name'] }} </strong><br><br>
                                        <p><strong>{{ $event->title }}</strong>のデータを削除しますか？<br><br>
                                        <span class="text-danger">当ユーザは<strong>{{ $entry['status'] }}</strong>です。<br>                                        
                                        削除したデータは復元できませんのでご注意ください。</span></p>

                                        @if($max_frag == true && count($entrys_cw_view) > 0)
                                        <p><span class="text-danger">また、現在定員数最大まで申込があります。<br>
                                        削除後は申込数が1枠減少しますので、↓の「キャンセル待ちユーザ」から「申込者」へ繰り上げを行って下さい。<br>
                                        繰り上げをしたユーザへはその旨メールが送信されます。</span></p>

                                        <div class="mb-2"><strong>繰り上げユーザの選択</strong></div>
                                        <select name="upgrade_user_id" class="form-control mb-2">
                                            @foreach ($entrys_cw_view as $entry_cw)
                                            <option value="{{ $entry_cw['user_id'] }}">【申込日時：{{ $entry_cw['created'] }}】{{ $entry_cw['user_name'] }}</option>
                                            @endforeach
                                        </select>
                                        @else
                                        <input type="hidden" name="upgrade_user_id" value="">
                                        @endif

                                        <input type="hidden" name="delete_user_id" value="{{ $entry['user_id'] }}">
                                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                        <button type="submit" class="btn btn-danger">
                                            @if($max_frag == true && count($entrys_cw_view) > 0)
                                            削除＋繰り上げ
                                            @else
                                            削除
                                            @endif
                                        </button>
                                    </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection                    

@section('each-js')
    <script src="{{ asset('js/datatables_base.js') }}" ></script>
@endsection
