<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Film extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'film';
    protected $primaryKey = 'idFilm';

    protected $with=['files','videos'];
    
    protected $fillable = [
        'idFilm',
        'idCategoria',
        'idGenere',
        'titolo',
        'trama',
        'durataMin',
        'annoUscita',
        'regista',
        'attori',
        'visualizzato',
        'idFile',
        'idVideo'

    ];
    public function files(){
        return $this->hasMany(Files::class,'idFile', 'idFile');
    }
    public function videos(){
        return $this->hasMany(Files::class,'idFile', 'idVideo');
    }
    public function genere(){
        return $this->belongsToMany(Genere::class,'idGenere', 'idGenere');
    }
}
