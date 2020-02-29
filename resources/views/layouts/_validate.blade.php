@if (count($errors) > 0)
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        @foreach ($errors->all() as $k => $error)
        <strong>警告</strong> {{ $k + 1 }} : {{ $error }}<br>
        @endforeach
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

