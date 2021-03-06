<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $fillable = [
        'reporter_id', 'album_id','foto','kategori','publish', 'status','deskripsi'
    ];

    public function reporter(){
        return $this->belongsTo(Reporter::class, 'reporter_id', 'id');
    }
    
    public function album(){
        return $this->belongsTo(Album::class, 'album_id', 'id');
    }

}
