        <div class="row mb-3">
            <div class="col-md-12 mx-auto">
                <div class="card">
                    <div class="card-header border-top">開催間近の研修</div>
                    <div class="card-body">
                        @if (count($data['event']) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped tbl-withheading data-table">
                                <thead class="thead">
                                    <tr>
                                        <!-- <th>ID</th> -->
                                        <th class="text-nowrap">開催日</th>
                                        <th class="text-nowrap">受付数 / 受講券発行者数</th>
                                        <th class="text-nowrap">研修タイトル</th>
                                        <th class="text-nowrap">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['event'] as $event)
                                    <tr>
                                        <td data-label="開催日：">
                                            @php
                                            echo date('Y年m月d日', strtotime($event['event_date']));
                                            @endphp                                            
                                        </td>
                                        <td data-label="受付数/受講券発行者数：">{{ $event['reception_cnt'] }} / {{ $event['entrys_cnt'] }}</td>
                                        <td data-label="研修タイトル：">{{ $event['title'] }}</td>
                                        <td>
                                            <a href="{{ url('reception/'.$event['event_id'].'-'.$event['event_date_id']) }}" class="btn btn-info btn-sm">受付管理</a>
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
        <div class="row mb-3">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header">法人ユーザ 登録数</div>
                    <div class="card-body">
                        <div class="h2">{{ $data['company_users_cnt'] }}</div>
                    </div>
                    @can('system-only')
                    <div class="card-header border-top">最近登録した法人ユーザ</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped tbl-withheading mb-0">
                                <!-- <thead class="thead">
                                    <tr>
                                        <th>名前</th>
                                        <th>操作</th>
                                    </tr>
                                </thead> -->
                                @if(count($data['company_users_later']) > 0)
                                <tbody>
                                @foreach($data['company_users_later'] as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>
                                            <a href="{{ url('account/'.$user->id) }}" class="btn btn-info btn-sm">詳細</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                    @endcan
                </div>
            </div>
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header">個人ユーザ 登録数</div>
                    <div class="card-body">
                        <div class="h2">{{ $data['general_users_cnt'] }}</div>
                    </div>
                    @can('system-only')
                    <div class="card-header border-top">最近登録した個人ユーザ</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped tbl-withheading mb-0">
                                <!-- <thead class="thead">
                                    <tr>
                                        <th>名前</th>
                                        <th>操作</th>
                                    </tr>
                                </thead> -->
                                @if(count($data['general_users_later']) > 0)
                                <tbody>
                                @foreach($data['general_users_later'] as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>
                                            <a href="{{ url('account/'.$user->id) }}" class="btn btn-info btn-sm">詳細</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                    @endcan
                </div>
            </div>
        </div>
        @can('system-only')
        <div class="row mb-3">
            <div class="col-md-12 mx-auto">
                <div class="card">
                    <div class="card-header border-top">更新履歴（法人ユーザ情報）</div>
                    <div class="card-body">
                        @if (isset($data['updated_history']) && count($data['updated_history']) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped tbl-withheading data-table">
                                <thead class="thead">
                                    <tr>
                                        <th class="text-nowrap">更新日時</th>
                                        <th class="text-nowrap">更新したユーザ</th>
                                        <th class="text-nowrap">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['updated_history'] as $updated_history)
                                    <tr>
                                        <td data-label="更新日時：">
                                            @php
                                            echo date('Y年m月d日 H時i分s秒', strtotime($updated_history['created_at']));
                                            @endphp                                            
                                        </td>
                                        <td data-label="更新したユーザ：">{{ $updated_history->user->name }}</td>
                                        <td data-label="操作：">
                                            <button type="button" class="history-confirm btn-sm btn-info" 
                                            value="{{ $updated_history['history_group_id'] }}" 
                                            data-toggle="modal" data-target="#history-confirm{{ $updated_history['history_group_id'] }}">詳細</button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="history-confirm{{ $updated_history['history_group_id'] }}" tabindex="-1">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">更新履歴詳細（{{ $updated_history->user->name }}）</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @if(isset($updated_history['mixed_history']) && count($updated_history['mixed_history']) > 0)
                                                        <table class="table table-striped tbl-withheading data-table">
                                                            <thead class="thead">
                                                                <tr>
                                                                    <th class="text-nowrap">変更した項目</th>
                                                                    <th class="text-nowrap">変更前の内容</th>
                                                                    <th class="text-nowrap">変更後の内容</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($updated_history['mixed_history'] as $history)
                                                                <tr>
                                                                    <td>{{ $updated_item_arr[$history['item_name']] }}</td>
                                                                    <td>{{ $history['before']}}</td>
                                                                    <td>{{ $history['after']}}</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                                    </div>
                                                    </div>
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
        @endif

