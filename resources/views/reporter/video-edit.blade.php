@extends('reporter.reporter-template')
@section('css')

@endsection
@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1>{{env('APP_NAME')}}</h1>
            <p>Update Video</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
			<div class="tile">
			  <div class="tile-body">
				<form class="form-horizontal" id="submit-form" method="post" action="{{route('reporter.video.update')}}">
                {{ csrf_field() }} @method('PUT')
                <input type="hidden" name="id"  value="{{$video->id}}">
                    <div class="row">
                        <input type="hidden" name="penulis_id" value="0">

                        <div class="col-sm-12">
                           <div class="form-group row">
                                <label for="judul" class="col-sm-2 col-form-label">Judul Video</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="judul" id="judul" placeholder="Judul Video" value="{{(empty(old('judul')))? $video->judul: old('judul')}}">
                                    @if ($errors->has('judul'))
                                        <small class="form-text text-muted">{{ $errors->first('judul') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="url" class="col-sm-2 col-form-label">URL Youtube</label>
                                <div class="col-sm-10">
                                <textarea class="form-control" name="url" id="url" placeholder="URL Video">{{(empty(old('url')))? $video->url: old('url')}}</textarea>
                                    @if ($errors->has('url'))
                                        <small class="form-text text-muted">{{ $errors->first('url') }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="redirect" value="{{url()->previous()}}">
				</form>

			  </div>
			  <div class="tile-footer">
				<div class="row">
				  <div class="col-md-8 col-md-offset-3">
					<button class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('submit-form').submit();"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
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
@endsection