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
                    @if ($question->author->name == Auth::user()->name)
                    <div class="float-right">
                        <a href="{{ url('question') }}" class="btn btn-danger btn-sm">
                            Back
                        </a>
                    </div>
                    @endif
                </div>
                <div class="card-body table-responsive">

                    <h1>{{ $question->judul }}</h1>
                    <h5>Author : {{ $question->author->name }}</h5>
                    <p>{!! $question->isi !!}</p>
                    <div>
                        <div class="float-left">
                            Tags :
                            @foreach ($question->tags as $tag)
                            <button class="btn btn-primary btn-sm">
                                {{ $tag->tag }}
                            </button>
                            @endforeach
                        </div>
                        @if ($question->user_id != Auth::id())

                        <div class="float-right">
                            {{-- upVote --}}
                            <form action="{{ url('upVoteQue') }}" method="POST" class='d-inline'>
                                @csrf
                                <input type="hidden" name="id" value="{{ $question->id }}">
                                <input type="hidden" name="user_id" value="{{ $question->author->id }}">
                                <button class="btn btn-white btn-lg">
                                    <i class="fa fa-thumbs-up"></i>
                                </button>
                            </form>

                            <label for="point"> {{ $question->voteQuestions->sum('poin') }} </label>

                            {{-- downVote --}}
                            @if (Auth::user()->reputasi >= 15)
                            <form action="{{ url('downVoteQue') }}" method="POST" class='d-inline'>
                                @csrf
                                <input type="hidden" name="id" value="{{ $question->id }}">
                                <input type="hidden" name="user_id" value="{{ $question->author->id }}">
                                <button class="btn btn-white btn-lg">
                                    <i class="fa fa-thumbs-down"></i>
                                </button>
                            </form>
                            @else
                            <button class="btn btn-white btn-lg" disabled>
                                <i class="fa fa-thumbs-down"></i>
                            </button>
                            @endif

                        </div>
                        @endif
                    </div>
                </div>
                <div class="row ml-3">
                    <p class=" text-muted">Created Date: {{ $question->created_at->format('d-F-Y H:i') }}</p>
                    <p class=" text-muted">&nbspUpdated Date: {{ $question->updated_at->format('d-F-Y H:i') }}</p>
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

                    @if ($item->correctAnswer != '')
                    <div>
                        <i class="fa fa-trophy bg"></i>
                        Jawaban Terbaik
                        <i class="fa fa-trophy"></i>
                    </div>
                    @endif

                    {{-- Button Vote Jawaban --}}
                    @if ($item->user_id != Auth::id())
                    <div class="float-right">

                        {{-- upVote --}}
                        {{-- @if ()
                                        
                                    @endif --}}
                        <form action="{{ url('upVoteAns/' . $question->id) }}" method="POST" class='d-inline'>
                            @csrf
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <input type="hidden" name="user_id" value="{{ $item->author->id }}">
                            <button class="btn btn-white btn-lg">
                                <i class="fa fa-thumbs-up"></i>
                            </button>
                        </form>

                        <label for="point"> {{ $item->voteAnswers->sum('poin') }} </label>

                        {{-- downVote --}}
                        @if (Auth::user()->reputasi >= 15)
                        <form action="{{ url('downVoteAns/' . $question->id) }}" method="POST" class='d-inline'>
                            @csrf
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <input type="hidden" name="user_id" value="{{ $item->author->id }}">
                            <button class="btn btn-white btn-lg">
                                <i class="fa fa-thumbs-down"></i>
                            </button>
                        </form>

                        @else
                        <button class="btn btn-white btn-lg" disabled>
                            <i class="fa fa-thumbs-down"></i>
                        </button>
                        @endif

                    </div>
                    @else
                    <div class="float-right">
                        <form action="{{ url('upVoteAns/' . $question->id) }}" method="POST" class='d-inline'>
                            @csrf
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <button class="btn btn-white btn-lg" disabled>
                                <i class="fa fa-thumbs-up"></i>
                            </button>
                        </form>

                        <label for="point"> {{ $item->voteAnswers->sum('poin') }} </label>

                        <form action="{{ url('downVoteAns/' . $question->id) }}" method="POST" class='d-inline'>
                            @csrf
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <button class="btn btn-white btn-lg" disabled>
                                <i class="fa fa-thumbs-down"></i>
                            </button>
                        </form>
                    </div>
                    @endif

                    {{-- isi Jawaban --}}
                    <p>{!! $item->isi !!}</p>

                    {{-- Button Edit dan Update Jawaban--}}
                    @if ($item->user_id == Auth::id())
                    <div class="float-left">
                        <form action="{{ url('answer/' . $item->id . '/edit') }}" class='d-inline'>
                            <input type="hidden" name="id" value="{{ $question->id }}">
                            <button class="btn btn-warning btn-sm">
                                Edit
                            </button>
                        </form>

                        <form action="{{ url('answer/' . $item->id) }}" method='POST' class='d-inline' onsubmit="return confirm('Are you sure to Delete this Question ?')">
                            @method('delete')
                            @csrf
                            <input type="hidden" name="id" value="{{ $question->id }}">
                            <button class="btn btn-danger btn-sm">
                                Delete
                            </button>
                        </form>
                    </div>

                    @elseif ($question->user_id == Auth::id() && $item->correctAnswer == '' )
                    {{-- Button Jawaban Terbaik --}}
                    <form action="{{ url('correctAnswer/' . $item->id) }}" method='POST' class='d-inline'>
                        @csrf
                        <input type="hidden" name="id" value="{{ $question->id }}">
                        <input type="hidden" name="user_id" value="{{ $item->author->id }}">
                        <button class="btn btn-success btn-sm float-left">
                            Jadikan Jawaban Terbaik
                        </button>
                    </form>
                    @endif

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