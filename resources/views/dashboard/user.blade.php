        <div class="row mb-3">
            <div class="col-md-12 mx-auto">
                <div class="card">
                    <div class="card-header border-top">参加予定の研修（開催日まであと2週間以内）</div>
                    <div class="card-body">
                        <h3 class="h5">受講券発行済</h3>
                        <h3 class="h5"></h3>
                        <div class="table-responsive mb-2">
                            <table class="table table-striped tbl-withheading data-table">
                                <thead class="thead">
                                    <tr>
                                        <!-- <th>ID</th> -->
                                        <th class="text-nowrap">開催日</th>
                                        <th class="text-nowrap">研修タイトル</th>
                                        <th class="text-nowrap">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data['event_ticket_sended']) > 0)
                                    @foreach ($data['event_ticket_sended'] as $event)
                                    <tr>
                                        <td data-label="開催日：">
                                            @php
                                            echo date('Y年m月d日', strtotime($event['event_date']));
                                            @endphp                                            
                                        </td>
                                        <td data-label="研修タイトル：">{{ $event['title'] }}</td>
                                        <td>
                                            <a href="{{ url('event/'.$event['event_id']) }}" class="btn btn-info btn-sm">詳細</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="3" class="text-center">データはありません。</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <h3 class="h5">受講券未発行</h3>
                        <h3 class="h5"></h3>
                        <div class="table-responsive">
                            <table class="table table-striped tbl-withheading data-table">
                                <thead class="thead">
                                    <tr>
                                        <!-- <th>ID</th> -->
                                        <th class="text-nowrap">開催日</th>
                                        <th class="text-nowrap">研修タイトル</th>
                                        <th class="text-nowrap">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data['event_ticket_none']) > 0)
                                    @foreach ($data['event_ticket_none'] as $event)
                                    <tr>
                                        <td data-label="開催日：">
                                            @php
                                            echo date('Y年m月d日', strtotime($event['event_date']));
                                            @endphp                                            
                                        </td>
                                        <td data-label="研修タイトル：">{{ $event['title'] }}</td>
                                        <td>
                                            <a href="{{ url('event/'.$event['event_id']) }}" class="btn btn-info btn-sm">詳細</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="3" class="text-center">データはありません。</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
