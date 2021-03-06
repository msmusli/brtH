@extends('reporter.reporter-template')
@section('css')

@endsection
@section('content')
<main class="app-content">
    <div class="app-title">
        <h4>{{$berita->judul}}</h4>
    </div>

    <div class="row justify-content-md-center">
        <div class="col-md-9 col-sm-12">
			<div class="tile">
                    <div class="text-center" style="padding-bottom: 20px">
                        <h3>{{$berita->judul}} 
                            @if ($berita->reporter_id != 0  && $berita->reporter)
                            <br><small style="font-size: 14px">Reporter : <a href="{{url('/admin/reporter/show/'.$berita->reporter_id)}}">{{$berita->reporter->nama}}</a></small>
                            @endif
                        </h3>
                        <br>
                        <figure class="figure">
                    <img src="{{asset($berita->gambar)}}" class="figure-img img-fluid rounded" alt="{{$berita->caption}}">
                                <figcaption class="figure-caption text-left">{{$berita->caption}}</figcaption>
                              </figure>
                    </div>

                    {!!$berita->berita!!}
            <div class="tile-footer row">
                <div class="col-sm-9" style="padding-bottom: 10px">
                        Terakhir update {{hari_tanggal_waktu($berita->updated_at, true)}} 
                </div>
               
                <div class="col-sm-3">
                <div class="btn-group " role="group" aria-label="Basic example">
                    <a class="btn btn-secondary mr-1 mb-1 btn-sm" href="{{route('admin.berita.edit', ['id'=> $berita->id])}}">
                    <i class="fa fa-edit"></i>Edit</a>
                    <button class="btn btn-danger mr-1 mb-1 btn-sm" data-pesan="Apakah kamu yakin ingin menghapus deskripsi berita {{$berita->judul}}" data-url="{{route('admin.berita.delete', ['id'=> $berita->id])}}" data-redirect="{{route('admin.berita')}}" id="hapus">
                    <i class="fa fa-fire"></i>Hapus</button>
                </div>
            </div>
            </div>
            </div>
        </div>

    </div>
</main>

@endsection

@section('script')
<script src="{{asset('js/hapus.js')}}"></script>
@endsection
