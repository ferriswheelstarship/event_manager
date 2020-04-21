@extends('layouts.app')
@section('title', '修了証管理')

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
                                <a href="#tab1" class="nav-link active" data-toggle="tab">キャリアアップ研修受講状況</a>
                            </li>
                            <li class="nav-item">
                                <a href="#tab2" class="nav-link" data-toggle="tab">受講済の一般研修</a>
                            </li>
                        </ul>
                        <div class="tab-content p-3 border border-top-0">

                        <div id="tab1" class="tab-pane px-2 py-3 active">
                        <h2 class="h4 mb-3">キャリアアップ研修受講状況</h2>
                        @if (count($carrerup_view_data) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-nowrap text-center align-middle" rowspan="2">分野</th>
                                        <th class="text-nowrap text-center align-middle" colspan="4">受講済研修</th>
                                        <th class="text-nowrap text-center align-middle" rowspan="2">受講時間合計</th>
                                        <th class="text-nowrap text-center align-middle" rowspan="2">操作</th>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap text-center align-middle">内容</th>
                                        <th class="text-nowrap text-center align-middle">受講した研修</th>
                                        <th class="text-nowrap text-center align-middle">受講時間</th>
                                        <th class="text-nowrap text-center align-middle">受講証明書</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($carrerup_view_data as $key => $item)
                                    <tr>
                                        <td rowspan="{{ $item['rowspan'] }}" class="text-center align-middle">{{ $item['fields'] }}</td>
                                        @if($item['eventinfo'] != null)
                                        <td class="text-center align-middle">{{ $item['eventinfo']['content'][0]->child_curriculum }}</td>
                                        <td class="text-center align-middle">{{ $item['eventinfo']['event']->title }} </td>
                                        <td class="text-center align-middle">{{ $item['eventinfo']['content'][0]->training_minute }}分</td>
                                        <td class="text-nowrap text-center align-middle">
                                            <a href="{{ route('history.attendance_pdf',['id' => $user->id.'-'.$item['eventinfo']['event']->id]) }}" target="_blank" class="btn btn-info">受講証明書</a>
                                        </td>
                                        @else
                                        <td colspan="4"></td>
                                        @endif
                                        <td rowspan="{{ $item['rowspan'] }}" class="text-center align-middle">{{ $item['training_minute'] }}分</td>
                                        <td rowspan="{{ $item['rowspan'] }}" class="text-center align-middle">
                                            @if($item['training_minute'] >= 900)
                                            @if(isset($item['carrerup_certificates']) && $item['carrerup_certificates']->certificate_status == 'Y')
                                            修了証発行済<br />
                                            @else
                                            修了証未発行<br />
                                            @endif
                                            <button class="btn btn-sm btn-primary">修了証発行</button>
                                            @else
                                            受講時間15時間未満<br />
                                            <button class="btn btn-sm btn-primary disabled">修了証発行</button>
                                            @endif
                                        </td>
                                    </tr>
                                    @if($item['content_cnt'] > 1) 
                                    @foreach($item['eventinfo']['content'] as $i => $val)
                                    @if (!$loop->first)
                                    <tr>
                                        <td class="text-center align-middle">{{ $item['eventinfo']['content'][$i]->child_curriculum }}</td>
                                        <td class="text-center align-middle">{{ $item['eventinfo']['event']->title }} </td>
                                        <td class="text-center align-middle">{{ $item['eventinfo']['content'][$i]->training_minute }}分</td>
                                        <td class="text-nowrap text-center align-middle">
                                            <a href="{{ route('history.attendance_pdf',['id' => $user->id.'-'.$item['eventinfo']['event']->id]) }}" target="_blank" class="btn btn-info">受講証明書</a>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endif
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
                            <table class="table table-striped" id="data-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-nowrap">開催日</th>
                                        <th class="text-nowrap">研修タイトル</th>
                                        <th class="text-nowrap">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($general_data as $key => $item)
                                    <tr>
                                        <td>
                                            @foreach ($item['event_dates'] as $key => $edate)
                                            @php
                                            echo date('Y年m月d日', strtotime($edate->event_date));
                                            @endphp
                                            @if(!$loop->last),@endif
                                            @endforeach
                                        </td>
                                        <td>{{ $item['event']->title }}</td>
                                        <td>
                                            <a href="{{ route('history.attendance_pdf',['id' => $user->id.'-'.$item['event']->id]) }}" target="_blank" class="btn btn-info">受講証明書</a>
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
