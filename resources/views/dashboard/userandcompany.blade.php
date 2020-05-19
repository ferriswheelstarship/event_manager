        <div class="row mb-3">
            <div class="col-md-12 mx-auto">
                <div class="card">
                    <div class="card-header">インフォメーション（最新5件まで）</div>
                    <div class="card-body">
                        @if (count($data['infos']) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped tbl-withheading data-table-no-order">
                                <thead class="thead">
                                    <tr>
                                        <!-- <th>ID</th> -->
                                        <th class="text-nowrap">タイトル</th>
                                        <th class="text-nowrap">日付</th>
                                        <th class="text-nowrap">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['infos'] as $info)
                                    <tr>
                                        <td data-label="タイトル：">{{ $info->title }}</td>
                                        <td data-label="日付：">
                                            @php
                                            echo date('Y年m月d日', strtotime($info->article_date));
                                            @endphp
                                        </td>
                                        <td data-lavel="操作：">
                                            <a href="{{ url('information/'.$info->id) }}" class="btn btn-info btn-sm">詳細</a>
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

        @can('user-only')
            @include('dashboard.user')
        @elsecan('admin-only')
            @include('dashboard.company')
        @endcan
