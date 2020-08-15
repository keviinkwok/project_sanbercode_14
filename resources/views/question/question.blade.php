@extends('layouts.app')

@section('content')

<div class="content mt-3">
    <div class="animated fadeIn">

        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <strong>Question</strong>
                        </div>
                        <div class="float-right">
                            <a href="{{ url('question/create') }}" class="btn btn-success btn-sm">
                                Create
                            </a>
                        </div>

                    </div>
                    <div class="card-body table-responsive">
                        <table id="tablecust" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <!-- <th>Question ID</th> -->
                                    <th>Judul</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($questions as $item)
                                <tr>
                                    <!-- <td>{{ $item->id }}</td> -->
                                    <td>{{ $item->judul }}</td>
                                    <td class="text-center">
                                        <a href="{{ url('question/' . $item->id) }}" class="btn btn-warning btn-sm">
                                            Detail
                                        </a>
                                        <a href="{{ url('question/' . $item->id . '/edit') }}" class="btn btn-primary btn-sm">
                                            Update
                                        </a>
                                        <form action="{{ url('question/' . $item->id) }}" method='POST' class='d-inline' onsubmit="return confirm('Are you sure to Delete this Question ?')">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger btn-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection