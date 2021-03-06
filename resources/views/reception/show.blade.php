@extends('layouts.app')
@section('title', '受付・受講証明管理')

@section('each-head')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.20/r-2.2.3/sp-1.0.1/datatables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.20/r-2.2.3/sp-1.0.1/datatables.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">受付・受講証明管理</div>
                    
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

                        <div class="mb-4 py-3">
                            <a href="{{ route('reception.index') }}" class="btn btn-sm btn-info">受付管理（開催間近の研修）</a>
                            <a href="{{ route('reception.finished') }}" class="btn btn-sm btn-info">受付管理（終了した研修）</a>
                        </div>

                        <div class="h6 ">@php echo date('Y年m月d日', strtotime($event_date->event_date)); @endphp</div>
                        <h2 class="h4 mb-4">【{{ $general_or_carrerup }}】{{ $event->title }}</h2>


                        <div class="row p-3">
                            <h3 class="h5 col-md-4">受付完了者 {{ $reception_cnt }}名 / 参加予定者 {{ count($entrys_view) }}名</h3>
                            <div class="col-md-8">
                                <button type="button" class="csv-confirm btn btn-sm btn-primary"
                                data-toggle="modal" data-target="#confirm-csv">CSVダウンロード</button>
                                
                                @can('system-only')
                                <button type="button" class="btn btn-sm btn-success"
                                data-toggle="modal" data-target="#confirm-attendance-pdf">受講証明書一括ダウンロード</button>

                                <button type="button" class="btn btn-sm btn-danger"
                                data-toggle="modal" data-target="#confirm-attendance">受講証明書一括発行</button>
                                @endcan
                            </div>
                        </div>

                        @can('area-higher')
                        <div class="modal fade" id="confirm-csv" tabindex="-1">
                            <div class="modal-dialog" role="document">
                                <form role="form" class="form-inline" method="POST" action="{{ route('reception.reception_csv') }}">
                                {{ csrf_field() }}

                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">CSVダウンロード</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    ユーザ一覧をCSVでダウンロードしますか？
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

                        <div class="modal fade" id="confirm-attendance-pdf" tabindex="-1">
                            <div class="modal-dialog" role="document">
                                <form role="form" class="form-inline" method="POST" action="{{ route('reception.all_attendance_pdf') }}">
                                {{ csrf_field() }}

                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">受講証明書一括ダウンロード</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    参加ユーザ全てのの受講証明書をダウンロードしますか？<br /><br />
                                    <span class="text-danger">※参加ユーザが多い場合ダウンロードに時間がかかる事がありますので、ダウンロード完了まで他の操作をされないようお願いします。</span>
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                    <button type="submit" class="btn btn-success">一括ダウンロード</button>
                                </div>
                                </div>
                                </form>
                            </div>
                        </div>

                        <div class="modal fade" id="confirm-attendance" tabindex="-1" style="min-width:600px">
                            <div class="modal-dialog" role="document">
                                <form role="form" class="form-inline" method="POST" action="{{ route('reception.finishedsendmulti') }}">
                                {{ csrf_field() }}

                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">受講証明書一括発行</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @if(count($for_finishedsend) > 0)
                                    受講証明書未発行ユーザの受講証明書を一括で発行します。<br /><br />
                                    一括発行から除外するユーザを↓の入力欄から検索して選択（複数選択可）し、「受講証明書一括発行」を押して下さい。<br />                                    
                                    <br />
                                    <select class="select-search-multiple" name="except_users[]" multiple="multiple">
                                        @foreach($for_finishedsend as $key => $item)
                                        <option value="{{ $item['user_id'] }}">{{ $item['user_name'] }}（{{ $item['user_ruby'] }}）【{{ $item['company_name'] }}】</option>
                                        @endforeach
                                    </select>
                                    <br />
                                    <br />
                                    <span class="text-danger">※すでに受講証明書発行済のユーザは選択肢から除外されています。</span><br />
                                    <span class="text-danger">※「受講証明書発行」を押す前に除外ユーザに間違いがないか確認下さい。</span>
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                    <input type="hidden" name="event_date_id" value="{{ $event_date->id }}">
                                    @else
                                    受講証明書未発行のユーザはいません。
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                    @if(count($for_finishedsend) > 0)
                                    <button type="submit" class="btn btn-danger">受講証明書一括発行</button>
                                    @endif
                                </div>
                                </div>
                                </form>
                            </div>
                        </div>                        
                        @endcan

                        <div class="px-3 py-5">
                            <div class="row">
                                <h3 class="col-md-2 h4">手動受付</h3>
                                <span><a href="{{ url('reception/qr/'.$event->id.'-'.$event_date->id) }}" class="btn btn-sm btn-info" target="_blank">QRコード受付画面を表示</a></span>
                            </div>
                        <div class="table-responsive">
                            <table class="table table-striped tbl-withheading" id="data-table">
                                <thead class="thead">
                                    <tr>
                                        <th class="text-nowrap">状態</th>
                                        <th class="text-nowrap">名前</th>
                                        <th class="text-nowrap">所属</th>
                                        <th class="text-nowrap">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($entrys_view) > 0)
                                    @foreach ($entrys_view as $entry)
                                    <tr>
                                        <td data-label="状態：">
                                            {{ $entry['status'] }}
                                            @if($entry['finished_status'])
                                            <br />
                                            {{ $entry['finished_status'] }}
                                            @endif
                                        </td>
                                        <td data-label="名前：">{{ $entry['user_name'] }}（{{ $entry['user_ruby'] }}）</td>
                                        <td data-label="所属：">{{ $entry['company_name'] }}</td>
                                        <td>
                                            @if($entry['status'] != '参加受付済')
                                            <button type="button" class="apply-confirm btn btn-sm btn-primary" 
                                                value="{{ $entry['id'] }}" 
                                                data-toggle="modal" data-target="#confirm-attend{{ $entry['id'] }}">受付完了にする</button>
                                            @else
                                            @if($entry['finished_status'] == "受講証明書未発行")
                                            <button type="button" class="apply-finished btn btn-sm btn-success" 
                                                value="{{ $entry['id'] }}" 
                                                data-toggle="modal" data-target="#confirm-finished{{ $entry['id'] }}">受講証明書発行</button>
                                            @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="4" class="text-center">参加予定者はいません</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        </div>

                        @if (count($entrys_view) > 0)
                            @foreach ($entrys_view as $entry) 
                            <!-- Modal(attend_status) -->
                            <div class="modal fade" id="confirm-attend{{ $entry['id'] }}" tabindex="-1">
                                <div class="modal-dialog" role="document">
                                    <form role="form" class="form-inline" method="POST" action="{{ route('reception.manual') }}">
                                    {{ csrf_field() }}

                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">受付完了 確認</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <strong>ユーザ：{{ $entry['user_name'] }} </strong><br><br>
                                        <p><strong>{{ $event->title }}</strong>の受付を完了しますか？<br><br></p>
                                        <input type="hidden" name="user_id" value="{{ $entry['user_id'] }}">
                                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                                        <input type="hidden" name="event_date_id" value="{{ $event_date->id }}">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                        <button type="submit" class="btn btn-primary">受付完了にする</button>
                                    </div>
                                    </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Modal(finished_status) -->
                            <div class="modal fade" id="confirm-finished{{ $entry['id'] }}" tabindex="-1">
                                <div class="modal-dialog" role="document">
                                    <form role="form" class="form-inline" method="POST" action="{{ route('reception.finishedsend') }}">
                                    {{ csrf_field() }}

                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">受講証明書発行 確認</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <strong>ユーザ：{{ $entry['user_name'] }} </strong><br><br>
                                        <p><strong>{{ $event->title }}</strong>の受講証明書発行を発行しますか？<br><br></p>
                                        <input type="hidden" name="user_id" value="{{ $entry['user_id'] }}">
                                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                                        <input type="hidden" name="event_date_id" value="{{ $event_date->id }}">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                        <button type="submit" class="btn btn-primary">受講証明書発行</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/i18n/ja.js"></script>
<script src="{{ asset('js/select-search.js') }}" ></script>
@endsection
