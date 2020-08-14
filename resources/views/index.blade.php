@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <strong>Question</strong>
                        </div>
                        @if (Auth::id() != '')
                            <div class="float-right">
                                <a href="{{ url('question/create') }}" class="btn btn-success btn-sm">
                                    Create Question
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="card-body">
                        @foreach ($question as $item)
                            <div class="card">
                                <div class="card-body">
                                    <h4>
                                        <a href="{{ url('question/' . $item->id) }}">
                                            {{ $item->judul }}
                                        </a>
                                        </h3>

                                        @foreach ($item->tags as $tag)
                                            <button class="btn btn-primary btn-sm">
                                                {{ $tag->tag }}
                                            </button>
                                        @endforeach

                                        <div class="float-right">
                                            {{ $item->author->name }}
                                        </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
