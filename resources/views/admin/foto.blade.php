@extends('admin.admin-template')
@section('css')

<link href="{{ asset('css/dropzone.css') }}" rel="stylesheet">
<script src="{{ asset('js/dropzone.js') }}"></script>
@endsection
@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1>{{env("APP_NAME")}}</h1>
            <p>Manajemen Foto</p>
        </div>
    </div>

    {{-- <div class="row justify-content-md-center">
        <div class="col-sm-12">
                <div class="tile">
                <form action="{{ route('admin.foto.store') }}" class="dropzone" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                </form>
                </div>
        </div>
    </div> --}}

    <div class="row">
            <div class="col-md-12">
                <div class="tile">
                  <div class="tile-body">
                    <form class="form-horizontal" id="submit-form" enctype="multipart/form-data" method="post" action="{{route('admin.foto.store')}}">
                    {{ csrf_field() }}
    
                        <div class="row">
                            <div class="col-md-9 col-sm-12">
                               <div class="form-group row">
                                    <label for="judul" class="col-sm-2 col-form-label">Judul Foto</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="judul" id="judul" placeholder="Judul Literasi" value="{{old('judul')}}">
                                        @if ($errors->has('judul'))
                                            <small class="form-text text-muted">{{ $errors->first('judul') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kategori" class="col-sm-2 col-form-label">Kategori Foto</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="kategori" id="kategori" placeholder="Kategori literasi" value="{{old('kategori')}}">
                                        @if ($errors->has('kategori'))
                                            <small class="form-text text-muted">{{ $errors->first('kategori') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="foto" class="col-sm-2 col-form-label">Foto</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" onchange="fotoURl(this)" name="foto" id="staticEmail" >
                                        @if ($errors->has('foto'))
                                            <small class="form-text text-muted">{{ $errors->first('foto') }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <img src="{{asset('images/thumbnail.svg')}}" style="max-height: 130px" class="rounded" alt="thumbnail" id="gambar">
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


    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                    <div class="card-columns">
                        @foreach ($fotos as $foto)
                            <div class="card">
                                <a href="{{asset($foto->foto)}}" target="_blank"><img src="{{asset($foto->foto)}}" class=" card-img-top"></a>
                                <div class="card-body">

                                    <button onClick="hapus('{{route('admin.foto.delete', ['id'=> $foto->id])}}', 'Foto yakin ingin dihapus')" class="btn btn-danger btn-sm float-right">Hapus</button>
                                    <div class="toggle-flip float-right">
                                        <label>
                                            <input type="checkbox"  onchange="status('{{$foto->id}}')" {{($foto->status == 'Verifikasi')? 'checked' : '' }}  ><span id="ketstatus" class="flip-indecator" data-toggle-on="Verifikasi" data-toggle-off="{{$foto->status == 'Verifikasi' ? 'Block': $foto->status}}" style="width: 100px"></span>
                                        </label>
                                        <label>
                                            <input type="checkbox"  onchange="publish('{{$foto->id}}')" {{($foto->publish == 'Public')? 'checked' : '' }}  ><span class="flip-indecator" data-toggle-on="Public" data-toggle-off="Hidden"></span>
                                        </label>
                                        </div>
                                </div>
                            </div>
                            @endforeach
                    </div>

            </div>
            <div class="text-center">{{$fotos->links()}}</div>
        </div>
    </div>
</main>


@endsection

@section('script')
<script src="{{asset('js/hapus.js')}}"></script>
<script src="{{asset('js/hapusfunc.js')}}"></script>
<script>
    function publish(no) {
        $.get('{{ route('admin.foto.publish')}}?id='+no, function(response){
            console.log(response);
        });
    }
    function status(no) {
        $.get('{{ route('admin.foto.verifikasi')}}?id='+no, function(response){
            // console.log(response.status);
        });
    }
</script>
@endsection
