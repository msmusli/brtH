<?php

namespace App\Http\Controllers\Reporter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use File;
use App\Models\Berita;

class BeritaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:reporter');
    }
    public function index()
    {
        $beritas = Berita::where('reporter_id', Auth::user()->id)->orderBy('id', 'DESC')->paginate(20);
    	return view('reporter.berita', compact('beritas'));
    }

    public function create()
    {
        return view('reporter.berita-tambah');
    }
    public function show($id)
    {
        $berita = Berita::find($id);
        return view('reporter.berita-show', compact('berita'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'judul' => 'required|string|max:255',
            'berita' => 'required|string',
            'gambar' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'caption' => 'required|string|max:255',
        ]);

        $berita = new Berita();
        $berita->fill($request->all());
        $berita['dilihat'] = '0';
        $berita['reporter_id'] = Auth::user()->id;
        if($request->hasFile('gambar')){
            $upload = app('App\Helper\Images')->upload($request->file('gambar'), 'berita');
            $berita['gambar'] = $upload['url'];
            $berita['thumbnails'] = $upload['thumbnails'];
        }
        $berita['slug'] = str_slug($request->judul, '-');
        $berita->save();

        if($berita){
            return redirect(route('reporter.berita.show',['id'=> $berita->id]))
            ->with(['alert'=> "'title':'Berhasil','text':'Data Berhasil Disimpan', 'icon':'success','buttons': false, 'timer': 1200"]);
        }else{
            return back()
            ->with(['alert'=> "'title':'Gagal Menyimpan','text':'Data gagal disimpan, periksa kembali data inputan', 'icon':'error'"])
            ->withInput($request->all());
        }
    }
    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        return view('reporter.berita-edit', compact('berita'));
    }
    public function publish()
    {
        $berita = Berita::find($_GET['id']);
        if ($berita->publish == 'Public') {
            $berita['publish'] = 'Private';
        }else{
            $berita['publish'] = 'Public';
        }
        $berita->save();
        return response(['kode'=> '00', 'publish' => $berita->publish]);
    }
    public function update(Request $request)
    {
        $this->validate($request, [
            'judul' => 'required|string|max:255',
            'berita' => 'required|string',
            'gambar' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'caption' => 'required|string|max:255',
        ]);

        $berita =Berita::findOrFail($request->id);
        $berita->fill($request->all());
        if($request->hasFile('gambar')){
            $beritad =Berita::findOrFail($request->id);
            File::delete($beritad->gambar);
            File::delete($beritad->thumbnails);

            $upload = app('App\Helper\Images')->upload($request->file('gambar'), 'berita');
            $berita['gambar'] = $upload['url'];
            $berita['thumbnails'] = $upload['thumbnails'];
        }
        $berita['slug'] = str_slug($request->judul, '-');
        $berita->save();

        if($berita){
            return redirect($request->redirect)
            ->with(['alert'=> "'title':'Berhasil','text':'Data Berhasil Disimpan', 'icon':'success','buttons': false, 'timer': 1200"]);
        }else{
            return back()
            ->with(['alert'=> "'title':'Gagal Menyimpan','text':'Data gagal disimpan, periksa kembali data inputan', 'icon':'error'"])
            ->withInput($request->all());
        }
    }
    public function delete($id)
    {
        $berita = Berita::findOrFail($id);
        if (!empty($berita)) {
            File::delete($berita->gambar);
            $berita->delete();
            return response()->json(['kode'=>'00'], 200);
        }else{
            return response()->json(['kode'=>'01'], 200);
        }
    }
}
