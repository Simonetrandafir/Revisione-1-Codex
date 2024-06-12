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

    protected $with=['categoria','genere','files'];
    
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

    ];

    public function categoria(){
        return $this->hasOne(Categorie::class,'idCategoria','idCategoria');
    }
    public function genere(){
        return $this->belongsToMany(Genere::class,'idGenere', 'idGenere');
    }
    public function files()
    {
        return $this->morphMany(Files::class, 'record');
    }
}
