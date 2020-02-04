@if (count($errors) > 0)
    <ul class="alert alert-danger" role="alert">
        @foreach ($errors->all() as $error)
            <li class="ml-4">{{ $error }}</li>
        @endforeach
    </ul>
@endif

@if (Session::has('status'))
     <!-- フラッシュメッセージ -->
     <div class="flash_message bg-success">
        {{ session('status') }}
    </div>
@endif