@extends('layouts.app')

@push('script-head')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
@endpush

@section('content')
    <div class="content mt-3">
        <div class="animated fadeIn">

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="col-sm-10 offset-sm-1">
                {{-- Question Location --}}
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <strong>Question Details</strong>
                        </div>
                        <div class="float-right">
                            <a href="{{ url('question') }}" class="btn btn-danger btn-sm">
                                Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body table-responsive">

                        <h1>{{ $question->judul }}</h1>
                        <h5>Author : {{ $question->author->name }}</h5>
                        <p>{!! $question->isi !!}</p>
                        <div>
                            Tags :
                            @foreach ($question->tags as $tag)
                                <button class="btn btn-primary btn-sm">
                                    {{ $tag->tag }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>


                {{-- Answer Location --}}
                <div class="card">
                    <div class="card-header border-dark">
                        <div class="float-left">
                            <strong>Answers</strong>
                        </div>
                    </div>

                    {{-- Looping card-body --}}
                    @foreach ($question->answer as $item)
                        <div class="card-body">
                            <p>{!! $item->isi !!}</p>
                            <div class="float-right">
                                {{ $item->author->name }}
                            </div>
                        </div>
                    @endforeach
                    {{-- End Looping --}}
                </div>

                {{-- Your Answer Location --}}
                @if ($question->user_id != Auth::id())
                    <div class="card">
                        <div class="card-header border-dark">
                            <div class="float-left">
                                <strong>Your Answer</strong>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('answer') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $question->id }}">
                                <div class="form-group">
                                    <textarea name="isi" class="form-control my-editor">
                                                                {!!  old('isi', '') !!}
                                                            </textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Post your answer</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var editor_config = {
            path_absolute: "/",
            selector: "textarea.my-editor",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            relative_urls: false,
            file_browser_callback: function(field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
                    'body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document
                    .getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no"
                });
            }
        };

        tinymce.init(editor_config);

    </script>

@endpush
