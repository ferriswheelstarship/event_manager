@extends('layouts.app')

@section('title', '研修詳細'.$event->title)

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">研修詳細</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <a href="{{ route('event.index') }}" class="btn btn-sm btn-info">研修一覧へ戻る</a>
                        </div>
                        <table class="table table-striped table-hover">
                            <tbody>
                                <tr>
                                    <th>研修種別</th>
                                    <td>{{ $general_or_carrerup[$event->general_or_carrerup] }}</td>
                                </tr>
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
                                        @if(count($event_dates) > 0)
                                        @foreach($event_dates as $key => $val)                                        
                                        {{ $val->event_date->format('Y年m月d日') }}
                                        @if(!$loop->last)
                                        ,
                                        @endif
                                        @endforeach
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>申込期間</th>
                                    <td>{{ $event->entry_start_date->format('Y年m月d日H時i分') }} ~ {{ $event->entry_end_date->format('Y年m月d日H時i分') }}</td>
                                </tr>
                                <tr>
                                    <th>表示期間</th>
                                    <td>{{ $event->view_start_date->format('Y年m月d日H時i分') }} ~ {{ $event->view_end_date->format('Y年m月d日H時i分') }}</td>
                                </tr>
                                <tr>
                                    <th>定員</th>
                                    <td>{{ $event->capacity }}名</td>
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
                                    <th>ファイルアップロード（PDF）</th>
                                    <td>
                                        @if(count($event_uploads) > 0)
                                        <ul>
                                            @foreach($event_uploads as $key => $val)
                                            <li><a href="{{ asset('/storage/event/'.$val->path) }}" target="_blank">PDFを表示</a></li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
