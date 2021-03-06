@extends('layouts.app')
@section('title', '受講履歴')

@section('each-head')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.20/r-2.2.3/sp-1.0.1/datatables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.20/r-2.2.3/sp-1.0.1/datatables.min.js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">受講履歴</div>
                    
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

                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a href="#tab1" class="nav-link active" data-toggle="tab">キャリアアップ</a>
                            </li>
                            <li class="nav-item">
                                <a href="#tab2" class="nav-link" data-toggle="tab">一般研修</a>
                            </li>
                        </ul>
                        <div class="tab-content p-3 border border-top-0">

                        <div id="tab1" class="tab-pane px-2 py-3 active">
                        <h2 class="h4 mb-3">キャリアアップ研修受講状況</h2>
                        @if (count($carrerup_view_data) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered tbl-carrerup">
                                <thead class="thead-light thead">
                                    <tr>
                                        <th class="text-nowrap text-center align-middle">分野</th>
                                        <th class="text-nowrap text-center align-middle">受講済内容・受講時間</th>
                                        <th class="text-nowrap text-center align-middle">受講時間合計</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($carrerup_view_data as $key => $item)
                                    <tr>
                                        <td class="text-center align-middle">{{ $item['fields'] }}</td>
                                        <td class="text-center align-middle">
                                        @if($item['eventinfo'] != null)
                                            <table class="table mb-0 tbl-carrerup-inner">
                                                <thead class="thead-light thead">
                                                    <tr>
                                                        <th class="text-nowrap text-center align-middle">内容</th>
                                                        <th class="text-nowrap text-center align-middle">受講済研修</th>
                                                        <th class="text-nowrap text-center align-middle">受講時間</th>
                                                        <th class="text-nowrap text-center align-middle">受講証明書</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($item['eventinfo'] as $key => $vals)                                            
                                                    @foreach($vals['content'] as $i => $val)                                            
                                                    <tr>
                                                        <td class="text-center align-middle">{{ $val->child_curriculum }}</td>
                                                        <td data-label="受講済研修：" class="text-center align-middle">{{ $vals['event']->title }} </td>
                                                        <td data-label="受講時間：" class="text-center align-middle">{{ $val->training_minute }}分</td>
                                                        <td data-label="受講証明書：" class="text-nowrap text-center align-middle">
                                                            @if($vals['finished_status'] === 'Y')
                                                            <a href="{{ route('history.attendance_pdf',['id' => $user->id.'-'.$vals['event']->id]) }}" 
                                                            target="_blank" class="btn btn-sm btn-info">受講証明書</a>
                                                            @else
                                                            <span class="text-danger">未発行</span>                                                            
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            受講履歴なし
                                        @endif
                                        </td>
                                        <td data-label="受講時間合計：" class="text-center align-middle">{{ $item['training_minute'] }}分</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                        </div>

                        <div id="tab2" class="tab-pane px-2 py-3">
                        <h2 class="h4 mb-3">受講済の一般研修</h2>
                        @if (count($general_data) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped tbl-withheading" id="data-table">
                                <thead class="thead-light thead">
                                    <tr>
                                        <th class="text-nowrap">開催日</th>
                                        <th class="text-nowrap">研修タイトル</th>
                                        <th class="text-nowrap">受講証明書</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($general_data as $key => $item)
                                    <tr>
                                        <td data-label="開催日：">
                                            @foreach ($item['event_dates'] as $key => $edate)
                                            @php
                                            echo date('Y年m月d日', strtotime($edate->event_date));
                                            @endphp
                                            @if(!$loop->last),@endif
                                            @endforeach
                                        </td>
                                        <td data-label="研修名：">{{ $item['event']->title }}</td>
                                        <td data-label="受講証明書：">
                                            @if($item['finished_status'] === 'Y')
                                            <a href="{{ route('history.attendance_pdf',['id' => $user->id.'-'.$item['event']->id]) }}" 
                                            target="_blank" class="btn btn-sm btn-info">受講証明書</a>
                                            @else
                                            <span class="text-danger">未発行</span>
                                            @can('area-higher')
                                            <br />
                                            <button class="btn btn-sm btn-success certificate-confirm btn-sm" value="{{ $key }}" 
                                            data-toggle="modal" data-target="#gconfirm-certificate{{ $key }}">受講証明書発行</button>
                                            @endcan
                                            @endif

                                            <div class="modal fade" id="gconfirm-certificate{{ $key }}" tabindex="-1">
                                                <div class="modal-dialog" role="document">
                                                    <form role="form" class="form-inline" method="POST" 
                                                    action="{{ route('history.finishedsend') }}">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                    <input type="hidden" name="event_id" value="{{ $item['event']->id }}">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">受講証明書 発行</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-left">
                                                        <strong>{{ $user->name }}</strong>へ<strong>【{{ $item['event']->title  }}】</strong>の受講証明書を<br>
                                                        発行してよろしいですか？<br>
                                                        ユーザにも受講証明書が発行された旨メールが送信されます。
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                                        <button type="submit" class="btn btn-success">受講証明書発行</button>
                                                    </div>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                        </div>


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
