@extends('layouts.app')

@section('title', '研修詳細'.$event->title)

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">研修詳細</div>

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
                        <div class="mb-3">
                            <a href="{{ route('event.index') }}" class="btn btn-sm btn-info">研修一覧へ戻る</a>
                            @can('area-higher')
                            <a href="{{ route('event.edit',['id' => $event->id]) }}" class="btn btn-sm btn-primary">変更</a>
                            @endcan
                        </div>
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>研修種別</th>
                                    <td>{{ $general_or_carrerup[$event->general_or_carrerup] }}</td>
                                </tr>
                                @if($event->general_or_carrerup == 'carrerup')
                                <tr>
                                    <th>キャリアアップ研修詳細</th>
                                    <td>
                                        @if(count($careerup_curriculums) > 0)
                                            @foreach($careerup_curriculums as $key => $val)
                                            親カテゴリ：{{ $val->parent_curriculum }} <br>
                                            子カテゴリ：{{ $val->child_curriculum }} <br>
                                            受講時間（分）：{{ $val->training_minute }}
                                            @if(!$loop->last)
                                            <hr>
                                            @endif
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>                                
                                @else
                                <tr>
                                    <th>受講時間（分）</th>
                                    <td>{{ $event->training_minute }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>タイトル</th>
                                    <td>{{ $event->title }}</td>
                                </tr>
                                <tr>
                                    <th>内容詳細</th>
                                    <td>{{ $event->comment }}</td>
                                </tr>
                                <tr>
                                    <th>研修開催日</th>
                                    <td>
                                        @if(count($event->event_dates) > 0)
                                        @foreach($event_dates as $key => $val)
                                        @php
                                        echo date('Y年m月d日', strtotime($val->event_date));
                                        @endphp
                                        @if(!$loop->last)
                                        ,
                                        @endif
                                        @endforeach
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>申込期間</th>
                                    <td>@php echo date('Y年m月d日H時i分', strtotime($event->entry_start_date)); @endphp
                                    ~ 
                                    @php echo date('Y年m月d日H時i分', strtotime($event->entry_end_date)); @endphp</td>
                                </tr>
                                <tr>
                                    <th>表示期間</th>
                                    <td>@php echo date('Y年m月d日H時i分', strtotime($event->view_start_date)); @endphp
                                    ~ 
                                    @php echo date('Y年m月d日H時i分', strtotime($event->view_end_date)); @endphp</td>
                                </tr>
                                <tr>
                                    <th>申込数 / 定員</th>
                                    <td>{{ $entrys_cnt}}名 / {{ $event->capacity }}名</td>
                                </tr>
                                <tr>
                                    <th>開催場所</th>
                                    <td>{{ $event->place }}</td>
                                </tr>
                                <tr>
                                    <th>注意事項</th>
                                    <td>{{ $event->notice }}</td>
                                </tr>
                                <tr>
                                    <th>
                                    @can('area-higher')    
                                    ファイルアップロード（PDF）
                                    @else
                                    参考ファイル
                                    @endcan
                                    </th>
                                    <td>
                                        @if(count($event_uploads) > 0)
                                        <div class="row">
                                            @foreach($event_uploads as $key => $val)
                                            <div class="border-bottom pl-3 pr-1 pt-1 pb-1">
                                                <a href="{{ asset('/storage/event/'.$val->path) }}" target="_blank" class="btn btn-info btn-sm">PDFを表示</a>　
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @cannot('area-higher')
                        @if($applyfrag == true)
                        @isset($capacity_status)
                        <div class="alert alert-danger">
                            {{ capacity_status }}
                        </div>
                        @endisset
                        @if($entrys_self)
                        @if($entrys_self->ticket_status != 'Y')
                        <div class="alert alert-danger">
                        現在、こちらの研修に申込み中です。メールで入金のご案内をお送りしておりますのでご入金後、こちらで受講券の発券、確認ができます。
                        </div>
                        <button type="button" class="apply-cancel btn-sm btn-danger" 
                        value="{{ $event->id }}" 
                        data-toggle="modal" data-target="#confirm-cancel">申込みキャンセル</button>
                        @else
                        <div class="alert alert-danger">
                        現在、こちらの研修への申し込みは完了しております。<br>
                        チケット発券（ダウンロード）はお忘れのないようにし、研修当日の受付時チケット内のバーコードのご提示をお願い致します。
                        </div>
                        <button type="button" class="ticket-confirm btn-sm btn-info" 
                        value="{{ $event->id }}" 
                        data-toggle="modal" data-target="#confirm-ticket">受講券を表示</button>
                        @endif
                        @elseif($entrys_self_YC)
                        <div class="alert alert-danger">
                        こちらの研修へは申込み後キャンセルをされています。
                        </div>
                        @else
                        <button type="button" class="apply-confirm btn-sm btn-primary" 
                        value="{{ $event->id }}" 
                        data-toggle="modal" data-target="#confirm-apply">参加申込</button>
                        @endif

                        <!-- Modal(apply) -->
                        <div class="modal fade" id="confirm-apply" tabindex="-1">
                            <div class="modal-dialog" role="document">
                                <form role="form" class="form-inline" method="POST" action="{{ route('event.apply') }}">
                                {{ csrf_field() }}

                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">参加申込</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @can('user-only')
                                    <strong>{{ $event->title }}</strong>へ参加申込みしますか？
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    @endcan
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                    <button type="submit" class="btn btn-primary">申し込む</button>
                                </div>
                                </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal(cancel) -->
                        <div class="modal fade" id="confirm-cancel" tabindex="-1">
                            <div class="modal-dialog" role="document">
                                <form role="form" class="form-inline" method="POST" action="{{ route('event.cancel') }}">
                                {{ csrf_field() }}

                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">参加キャンセル</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @can('user-only')
                                    <strong>{{ $event->title }}</strong>の参加をキャンセルしますか？
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    @endcan
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                    <button type="submit" class="btn btn-danger">キャンセル</button>
                                </div>
                                </div>
                                </form>
                            </div>
                        </div>

                        @else
                        <div class="alert alert-danger">
                            {{ $status_mes }}
                        </div>
                        @endif
                        @endcannot

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
