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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
