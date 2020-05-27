@extends('layouts.app')

@section('title', '研修詳細'.$event->title)

@section('each-head')
<script src="{{ asset('js/jquery.datetimepicker.full.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/jquery.datetimepicker.min.css') }}">
<script>
$(function(){
    $('.datetimepicker').datetimepicker({
        format:'Y-m-d H:i',
        lang:'ja'
    });
    $('#event_date1').datetimepicker({
        format:'Y-m-d',
        lang:'ja'
    });
});
</script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">研修 修正</div>

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
                        <form method="POST" action="{{ url('event/'.$event->id) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                            <div class="form-group row ">
                                <label for="general_or_carrerup" class="col-md-4 col-form-label text-md-right">研修種別</label>
                                <div class="col-md-6">
                                    <select id="general_or_carrerup" 
                                        class="form-control{{ $errors->has('general_or_carrerup') ? ' is-invalid' : '' }}" 
                                        name="general_or_carrerup"
                                        onchange="changeEventCarrerup(this.value)">
                                        @foreach ($general_or_carrerup as $key => $val)
                                            <option value="{{ $key }}"
                                                @if(old('general_or_carrerup',$event->general_or_carrerup) == $key) selected @endif>{{ $val }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('general_or_carrerup'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('general_or_carrerup') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div 
                                id="carrerup"
                                style="display: 
                                @if(old('general_or_carrerup',$event->general_or_carrerup) !='carrerup') 
                                    none
                                @endif ">

                            <div class="form-group row">
                                <label for="comment" class="col-md-4 col-form-label text-md-right">キャリアアップ研修詳細</label>
                                <div class="col-md-6">
                                    @if(count($careerup_curriculums) > 0)
                                    @foreach($careerup_curriculums as $key => $item)
                                    <div class="border-bottom mt-2">
                                    親カテゴリ<br>
                                    <select id="parent_curriculum" 
                                        class="mb-2 form-control{{ $errors->has('carrerup.parent_curriculum.*') ? ' is-invalid' : '' }}" 
                                        name="carrerup[parent_curriculum][]">
                                        <option value="">----</option>
                                        @foreach ($parent_curriculum as $val)
                                            <option value="{{ $val }}"
                                                @if(old('carrerup.parent_curriculum'.$key,$item->parent_curriculum) == $val) selected @endif>{{ $val }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('carrerup.parent_curriculum.*'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('carrerup.parent_curriculum.*') }}</strong>
                                        </span>
                                    @endif

                                    子カテゴリ<br>
                                    <select id="child_curriculum" 
                                        class="mb-2 form-control{{ $errors->has('carrerup.child_curriculum.*') ? ' is-invalid' : '' }}" 
                                        name="carrerup[child_curriculum][]">
                                        <option value="">----</option>
                                        @foreach($parent_curriculum as $i => $value)
                                        <optgroup label="{{ $value }}">
                                        @foreach($child_curriculum as $j => $val)
                                            @if($i+1 > $j / 5 && $j / 5 >= $i)
                                            <option value="{{ $val }}"
                                                @if(old('carrerup.child_curriculum'.$key,$item->child_curriculum) == $val) selected @endif>{{ $val }}</option>
                                            @endif
                                        @endforeach
                                        </optgroup>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('carrerup.child_curriculum.*'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('carrerup.child_curriculum.*') }}</strong>
                                        </span>
                                    @endif

                                    受講時間（分）<br>
                                    <input
                                        id="training_minute" type="number" min="0" max="900" step="10" style=" width:80px"
                                        class="mb-3 form-control{{ $errors->has('carrerup.training_minute.*') ? ' is-invalid' : '' }}"
                                        name="carrerup[training_minute][]" value="{{ old('carrerup.training_minute.'.$key,$item->training_minute) }}">
                                    @if ($errors->has('carrerup.training_minute.*'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('carrerup.training_minute.*') }}</strong>
                                        </span>
                                    @endif

                                    <input type="button" value="＋" class="col-md-2 add pluralBtn mb-2">
                                    <input type="button" value="－" class="col-md-2 del pluralBtn mb-2">
                                    </div>
                                    @endforeach

                                    @else
                                    <div class="border-bottom mt-2">
                                    親カテゴリ<br>
                                    <select id="parent_curriculum" 
                                        class="mb-2 form-control{{ $errors->has('carrerup.parent_curriculum.*') ? ' is-invalid' : '' }}" 
                                        name="carrerup[parent_curriculum][]">
                                        <option value="">----</option>
                                        @foreach ($parent_curriculum as $val)
                                            <option value="{{ $val }}"
                                                @if(old('carrerup.parent_curriculum.0') == $val) selected @endif>{{ $val }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('carrerup.parent_curriculum.*'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('carrerup.parent_curriculum.*') }}</strong>
                                        </span>
                                    @endif

                                    子カテゴリ<br>
                                    <select id="child_curriculum" 
                                        class="mb-2 form-control{{ $errors->has('carrerup.child_curriculum.*') ? ' is-invalid' : '' }}" 
                                        name="carrerup[child_curriculum][]">
                                        <option value="">----</option>
                                        @foreach($parent_curriculum as $i => $value)
                                        <optgroup label="{{ $value }}">
                                        @foreach ($child_curriculum as $j => $val)
                                            @if($i+1 > $j/5 && $j/5 >= $i)
                                            <option value="{{ $val }}"
                                                @if(old('carrerup.child_curriculum.0') == $val) selected @endif>{{ $val }}</option>
                                            @endif
                                        @endforeach
                                        </optgroup>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('carrerup.child_curriculum.*'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('carrerup.child_curriculum.*') }}</strong>
                                        </span>
                                    @endif

                                    受講時間（分）<br>
                                    <input
                                        id="training_minute" type="number" min="0" max="900" step="10" style=" width:80px"
                                        class="mb-3 form-control{{ $errors->has('carrerup.training_minute.*') ? ' is-invalid' : '' }}"
                                        name="carrerup[training_minute][]" value="{{ old('carrerup.training_minute.0') }}">
                                    @if ($errors->has('carrerup.training_minute.*'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('carrerup.training_minute.*') }}</strong>
                                        </span>
                                    @endif

                                    <input type="button" value="＋" class="col-md-2 add pluralBtn mb-2">
                                    <input type="button" value="－" class="col-md-2 del pluralBtn mb-2">
                                    </div>

                                    @endif
                                </div>
                            </div>
                            </div>

                            <div 
                                id="general"
                                style="display: 
                                @if(old('general_or_carrerup',$event->general_or_carrerup) != 'general') 
                                    none
                                @endif ">
                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">受講時間（分）</label>
                                <div class="col-md-6">
                                    <input
                                        id="training_minute" type="number" min="10" max="900" step="10" style=" width:100px"
                                        class="mb-3 form-control{{ $errors->has('training_minute') ? ' is-invalid' : '' }}"
                                        name="training_minute" value="{{ old('training_minute',$event->training_minute) }}">
                                    @if ($errors->has('training_minute'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('training_minute') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            </div>

                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">タイトル</label>
                                <div class="col-md-6">
                                    <input id="title" type="text" 
                                        class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" 
                                        name="title" value="{{ old('title',$event->title) }}" required>
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="comment" class="col-md-4 col-form-label text-md-right">内容詳細</label>
                                <div class="col-md-6">
                                    <textarea 
                                        id="comment" class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}" 
                                        name="comment" required>{{ old('comment',$event->comment) }}</textarea>

                                    @if ($errors->has('comment'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('comment') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="event_dates" class="col-md-4 col-form-label text-md-right">研修開催日</label>
                                <div class="col-md-6">
                                    @if(count($event->event_dates) > 0)
                                    @foreach($event_dates as $key => $val)
                                    @php
                                        $edate = date('Y-m-d', strtotime($val->event_date));
                                    @endphp
                                    <div class="row" id="event_dates_wrapper{{ $key+1 }}">
                                    <div class="col-md-8 mb-2">
                                    <input
                                        type="text" id="event_date{{ $key+1 }}"
                                        class="event_date form-control{{ $errors->has('event_dates.*') ? ' is-invalid' : '' }}"
                                        name="event_dates[]" value="{{ old('event_dates.0',$edate) }}">
                                    @if ($errors->has('event_dates.*'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('event_dates.*') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                    <input type="button" value="＋" class="col-md-2 add_date pluralBtn mb-2">
                                    <input type="button" value="－" class="col-md-2 del pluralBtn mb-2">
                                    </div>
                                    @endforeach
                                    @endif
                                </div>                                
                            </div>

                            <div class="form-group row">
                                <label for="comment" class="col-md-4 col-form-label text-md-right">申込期間</label>
                                <div class="col-md-6">
                                    <div class="row">
                                    <div class="col-md-5">
                                        @php
                                            $esdate = date('Y-m-d H:i', strtotime($event->entry_start_date));
                                        @endphp
                                        <input
                                        id="entry_start_date" type="text"
                                        class="datetimepicker form-control{{ $errors->has('entry_start_date') ? ' is-invalid' : '' }}"
                                        name="entry_start_date" value="{{ old('entry_start_date',$esdate) }}" required>
                                        @if ($errors->has('entry_start_date'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('entry_start_date') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <span class="col-md-1">~</span>
                                    <div class="col-md-5">
                                        @php
                                            $eedate = date('Y-m-d H:i', strtotime($event->entry_end_date));
                                        @endphp
                                        <input
                                        id="entry_end_date" type="text" 
                                        class="datetimepicker form-control{{ $errors->has('entry_end_date') ? ' is-invalid' : '' }}"
                                        name="entry_end_date" value="{{ old('entry_end_date',$eedate) }}" required>
                                        @if ($errors->has('entry_end_date'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('entry_end_date') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="comment" class="col-md-4 col-form-label text-md-right">表示期間</label>
                                <div class="col-md-6">
                                    <div class="row">
                                    <div class="col-md-5">
                                        @php
                                            $vsdate = date('Y-m-d H:i', strtotime($event->view_start_date));
                                        @endphp
                                        <input
                                        id="view_start_date" type="text"
                                        class="datetimepicker form-control{{ $errors->has('view_start_date') ? ' is-invalid' : '' }}"
                                        name="view_start_date" value="{{ old('view_start_date',$vsdate) }}" required>
                                        @if ($errors->has('view_start_date'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('view_start_date') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <span class="col-md-1">~</span>
                                    <div class="col-md-5">
                                        @php
                                            $vedate = date('Y-m-d H:i', strtotime($event->view_end_date));
                                        @endphp
                                        <input
                                        id="view_end_date" type="text" 
                                        class="datetimepicker form-control{{ $errors->has('view_end_date') ? ' is-invalid' : '' }}"
                                        name="view_end_date" value="{{ old('view_end_date',$vedate) }}" required>
                                        @if ($errors->has('view_end_date'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('view_end_date') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="capacity" class="col-md-4 col-form-label text-md-right">定員</label>
                                <div class="col-md-6">
                                    <input
                                        id="capacity" type="number" min="1" max="500" style=" width:80px"
                                        class="form-control{{ $errors->has('capacity') ? ' is-invalid' : '' }}"
                                        name="capacity" value="{{ old('capacity',$event->capacity) }}" required>

                                    @if ($errors->has('capacity'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('capacity') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="name_pronunciation"
                                        class="col-md-4 col-form-label text-md-right">開催場所</label>

                                <div class="col-md-6">
                                    <input
                                        id="place" type="text"
                                        class="form-control{{ $errors->has('place') ? ' is-invalid' : '' }}"
                                        name="place" value="{{ old('place',$event->place) }}" required>

                                    @if ($errors->has('place'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('place') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">注意事項</label>
                                <div class="col-md-6">
                                    <textarea id="notice" 
                                        class="form-control{{ $errors->has('notice') ? ' is-invalid' : '' }}" 
                                        name="notice">{{ old('notice',$event->notice) }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row mb-5">
                                <label for="name_pronunciation"
                                        class="col-md-4 col-form-label text-md-right">ファイルアップロード（PDF）</label>

                                <div class="col-md-6">
                                    @if(count($event_uploads) > 0)
                                    <div class="mb-3">
                                        <div class="pt-2 pb-1">【登録済】</div>                                        
                                        @foreach($event_uploads as $key => $val)
                                        <div class="row border-bottom pl-3 pr-1 pt-1 pb-1">
                                            <a href="{{ asset('/storage/event/'.$val->path) }}" target="_blank" class="btn btn-info btn-sm">PDFを表示</a>　
                                            <button type="button" class="btn-sm btn-danger" value="{{ $val['id'] }}" 
                                            data-toggle="modal" data-target="#confirm-filedelete{{ $val['id'] }}">削除</button>
                                        </div>                                        
                                        @endforeach
                                    </div>
                                    @endif

                                    <div class="pt-2 pb-1">【追加】</div>
                                    <input
                                        id="files" type="file"
                                        class="form-control-file{{ $errors->has('files.*') ? ' is-invalid' : '' }}"
                                        name="files[]" multiple>

                                    @if ($errors->has('files.*'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('files.*') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        送信
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


                                        @foreach($event_uploads as $key => $val)
                                        <!-- Modal -->
                                        <div class="modal fade" id="confirm-filedelete{{ $val['id'] }}" tabindex="-1">
                                            <div class="modal-dialog" role="document">
                                                <form role="form" class="form-inline" method="POST" action="{{ route('event.fileDelete', $val['id']) }}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}

                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">削除確認</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    こちらのPDFを削除してよろしいですか？
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                                    <button type="submit" class="btn btn-danger">削除</button>
                                                </div>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                        @endforeach

@endsection

@section('each-js')
<script src="{{ asset('js/training-form-event.js') }}" ></script>
<script>
$(document).on("click", ".add", function() {
    $(this).parent().clone(true).insertAfter($(this).parent());
});
$(document).on("click", ".del", function() {
    var target = $(this).parent();
    if (target.parent().children().length > 1) {
        target.remove();
    }
});

var copy_block = function(i) {
    var increament_id = function(name,id) {
        $("#event_dates_wrapper"+id+" ."+name).attr("id", name+id);
    };
            
    var target = $("#event_dates_wrapper"+(i-1));
    target.clone().insertAfter(target).attr("id","event_dates_wrapper"+i);
    
    increament_id("event_date",i);
};
var init_vals = function(i) {
    $("#event_date"+i+" :text").val('');
};
    
$(document).on("click", ".add_date", function(i) {
    var i=1;
    while($("#event_dates_wrapper"+i).length != 0) {
        i++;
    }
    copy_block(i);    
    init_vals(i);
    $('#event_date'+i).datetimepicker({
        format:'Y-m-d',
        lang:'ja'
    });
});

</script>
@endsection