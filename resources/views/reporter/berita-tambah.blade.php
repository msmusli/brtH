@extends('reporter.reporter-template')
@section('css')

@endsection
@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1>{{env("APP_NAME")}}</h1>
            <p>Tambah Berita</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
			<div class="tile">
			  <div class="tile-body">
                <form class="form-horizontal" id="submit-form" enctype="multipart/form-data" method="post" action="{{route('reporter.berita.store')}}">
                {{ csrf_field() }}

                    <div class="row">
                        <div class="col-md-9 col-sm-12">
                           <div class="form-group row">
                                <label for="judul" class="col-sm-2 col-form-label">Judul Berita</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="judul" id="judul" placeholder="Judul Berita" value="{{old('judul')}}">
                                    @if ($errors->has('judul'))
                                        <small class="form-text text-muted">{{ $errors->first('judul') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kategori" class="col-sm-2 col-form-label">Kategori Berita</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="kategori" id="kategori" placeholder="Kategori Berita" value="{{old('kategori')}}">
                                    @if ($errors->has('kategori'))
                                        <small class="form-text text-muted">{{ $errors->first('kategori') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="gambar" class="col-sm-2 col-form-label">Gambar</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" onchange="fotoURl(this)" name="gambar" id="staticEmail" >
                                    @if ($errors->has('gambar'))
                                        <small class="form-text text-muted">{{ $errors->first('gambar') }}</small>
                                    @endif
                                </div>

                            </div>
                            <div class="form-group row">
                                    <label for="caption" class="col-sm-2 col-form-label">Caption Gambar</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="caption" id="caption" placeholder="Caption Gambar" value="{{old('caption')}}">
                                        @if ($errors->has('caption'))
                                            <small class="form-text text-muted">{{ $errors->first('caption') }}</small>
                                        @endif
                                    </div>
                                </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <img src="{{asset('images/thumbnail.svg')}}" style="max-height: 130px" class="rounded" alt="thumbnail" id="gambar">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                        <textarea id="summernote" name="berita">{{old('berita')}}</textarea>
                    </div>
                    </div>

				</form>

			  </div>
			  <div class="tile-footer">
				<div class="row">
				  <div class="col-md-8 col-md-offset-3">
					<button class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('submit-form').submit();"><i class="fa fa-fw fa-lg fa-check-circle"></i>Tambah</button>
					<a class="btn btn-secondary" href="{{url()->previous()}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Batal</a>
					{{-- <small class="form-text text-muted" id="jadwalhelp">Foto galeri diinputkan setelah nama gunung dan deskripsi gunung sudah ditambah</small> --}}
				</div>
				</div>
			  </div>
			</div>
		  </div>

    </div>
</main>

@endsection

@section('script')
<!-- include summernote css/js -->

<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.js"></script>
<script src="{{asset('vendor/summernote/summernote-image-captionit.js')}}"></script>
<script>
$(document).ready(function() {
    $("#summernote").summernote({
    placeholder: 'Isi Berita',
    height: 300,
    fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '24', '36', '48' , '64', '82', '150'],
    toolbar: [
        // [groupName, [list of button]]
        ['undoredo', ['undo', 'redo']],
        ['style', ['bold', 'italic', 'underline','strikethrough', 'clear']],
        ['font', ['fontname', 'fontsize', 'superscript', 'subscript']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['image',['picture']],
        ['link', ['link']],
        ['video', ['video']],
        ['table', ['table']],
        ['help', ['fullscreen','codeview','help']]
    ],
    callbacks: {
        onImageUpload : function(files, editor, welEditable) {

                for(var i = files.length - 1; i >= 0; i--) {
                        sendFile(files[i], this);
            }
        }
    },
    popover: {
        image: [
                ['custom', ['captionIt']],
                ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                ['float', ['floatLeft', 'floatRight', 'floatNone']],
                ['remove', ['removeMedia']]
            ],
        },
        captionIt:{
            figureClass:'{figure-class/es}',
            figcaptionClass:'{figcapture-class/es}',
            captionText:'{Default Caption Editable Placeholder Text if Title or Alt are empty}'
        }
    });
});

function sendFile(file, el) {
var form_data = new FormData();
form_data.append('file', file);
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$.ajax({
    data: form_data,
    type: "POST",
    url: '{{route('upload.gambar')}}',
    cache: false,
    contentType: false,
    processData: false,
    success: function(response) {
        console.log(response.image);
        $(el).summernote('editor.insertImage', response.image);
    }
});
}

function fotoURl(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#gambar').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

</script>
@endsection
