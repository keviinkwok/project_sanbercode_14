@extends('layouts.app')

@push('script-head')
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
@endpush

@section('content')
<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="card">
            <div class="card-header">
                <div class="float-left">
                    <strong>Update Question</strong>
                </div>
                <div class="float-right">
                    <a href="{{ url('question') }}"
                        class="btn btn-danger btn-sm">
                        Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ url('question/'.$question->id) }}" method="POST">
                            @method('put')
                            @csrf
                            <div class="form-group">
                                <label>Question ID</label>
                                <input type="text" name="id" class="form-control @error('id') 
                                 is-invalid @enderror" value="{{ $question->id }}" readonly>

                                @error('id')
                                    <div class="invalid-feedback"> {{$message}} </div>
                                @enderror
                                
                            </div>

                            <div class="form-group">
                                <label>Judul</label>
                                <input type="text" name="judul" class="form-control @error('judul') 
                                 is-invalid @enderror" value="{{ old('judul',$question->judul) }}" autofocus autocomplete="off">

                                @error('judul')
                                    <div class="invalid-feedback"> {{$message}} </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Isi</label>
                                
                                <textarea name="isi" class="form-control my-editor">
                                    {!! old('isi', $question->isi) !!}
                                </textarea>
                            </div>

                            <div class="form-group">
                              <label>Tags</label>
                              <input type="text" class="form-control" id="tags" name="tags" 
                              value="{{ old('tags', $stringTag) }}" placeholder="Input Tags">
                            </div>
                            
                            <button type="submit" class="btn btn-success">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div><!-- .content -->
@endsection


@push('scripts')
<script>
    var editor_config = {
      path_absolute : "/",
      selector: "textarea.my-editor",
      plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
      relative_urls: false,
      file_browser_callback : function(field_name, url, type, win) {
        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
        var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
  
        var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
        if (type == 'image') {
          cmsURL = cmsURL + "&type=Images";
        } else {
          cmsURL = cmsURL + "&type=Files";
        }
  
        tinyMCE.activeEditor.windowManager.open({
          file : cmsURL,
          title : 'Filemanager',
          width : x * 0.8,
          height : y * 0.8,
          resizable : "yes",
          close_previous : "no"
        });
      }
    };
  
    tinymce.init(editor_config);
  </script>

@endpush